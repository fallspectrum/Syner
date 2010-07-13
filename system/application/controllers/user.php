<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class User extends Controller {

	function User() 
	{
		parent::Controller();
		
	}
	
	function index() 
	{
		echo 'hello world!';
	}
	
	

	/**
	* This function is used to activate a users account
	*/
	function account_activation()
	{
		
		
		$valid = true;
		
		//variable below is used for view data.
		$data = "";
		
		//skip to 3rd element in the uri. This will create the key/value pair.
		$uri_array = $this->uri->uri_to_assoc(3);

		try {
			
			if(isset($uri_array['username']))
				$username = $uri_array['username'];
			else
				throw new Exception('No username was supplied.');

			if(isset($uri_array['activation_id']))
				$activation_id = $uri_array['activation_id'];
			else
				throw new Exception('No activation identifier was supplied.');
		
			//When a user registers the username was convertited to htmlentities. Must do same here
			$username  = htmlentities($username);

		
			//min and max length for username			
			if(strlen($username) < 1 && strlen($username) > 16) {
				throw new Exception('Username is not valid.');
			}

			if(!ctype_alnum($activation_id) || strlen($activation_id) != 64) {
				throw new Exception('Invalid activation id.');
			}
			
			$this->load->model('Pending_users','',TRUE);
			$query = $this->Pending_users->get_user($username,'',$activation_id);
			
			//Message displayed to the user.
			$activation_message="";

			if($query->num_rows() > 0 ) {
				//get move user into new table
				$this->load->model("Users");
				$row = $query->result_array();
				
				//get the first result (should be only result)
				$row = $row[0];
				
				//get rid of activation id
				unset($row['activation_id']);
				$this->Users->add_user($row);
				
				//delete old entry
				$this->Pending_users->delete_user($row['username'],$row['email'],'');

				$activation_message="Thank you for for activating your account! Feel free to log in and use the site.";
			}
			else {
				$activation_message =  "I'm sorry, we were unable to activate your account. Please try again. If problem persists contact the site adminsitrator.";
			}
			
			$activation_data = array('result_msg' => $activation_message);
			$layout_data['content']= $this->load->view('user/account_activation',$activation_data,true);

		}
		catch (Exception $e) {
				
			$data['general_message'] = $e->getMessage();
			$data['content'] = $this->load->view("general",$data,true);
		}
			$this->load->view('layout', $layout_data);
	}


	/**
	* This function is used to display the register page.
	*/
	
	function register()
	{
		$data['js_files'] = array($this->config->item("base_url") . "system/application/views/user/register.js");
		$data['content'] = $this->load->view('user/register.php', '', true);
		$this->load->view('layout', $data);
	}
	

	/**
	* This function handles a register user request. It responseds with a json response.
	* -1 response for malformed input. -2 for input used already. -3 for database error.
	* -4 for sendmail error. 1 for success. 
	* Sends email with instructions on how to activate the account.
	* @check if users exists in validated user account table
	* @todo Add a check to prevent users from submitting the form multiple times (Make the existing captcha invald)
	* @todo Localize error and email messages, and add site name to config
	*/
	function registerajax() {
		$this->load->library("simple_json");
		$invalid = false;
		$json = new Simple_Json();
	
		$this->load->library('form_validation');

		//note max_length is 15 here. Technically they can have a username longer then 15 characters do to
		//expanding html characters to there co-entities and by using unicode characters.
		$this->form_validation->set_rules('username','username','required|trim|min_length[1]|max_length[15]|htmlentities');
		$this->form_validation->set_rules('email','email','required|trim|email|valid_email');
		$this->form_validation->set_rules('password','password','required','min_length[6]');
		
		if($this->form_validation->run() === FALSE) 
		{
			foreach ($this->form_validation->_error_array as $error)  {
				$json->add_error_response($error[0],$error[1]);
				$invalid = true;
			}
		}
		else
		{
			$username = $this->input->post('username');
			$email = $this->input->post('email');
			$password_hash = hash("sha256",$this->config->item('encryption_salt') . $this->input->post('password'));
			//check if username exists already in pending_users table
			# Ryan - Catch an exception if the database query fails
			$this->load->model('Pending_users','',TRUE);
			$this->load->model('Users','',TRUE);
			try {
				$query_pending = $this->Pending_users->get_user($username,'','');
				$query_users = $this->Users->get_user(array('username'=>$username));
				if($query_pending->num_rows() > 0 || $query_users->num_rows() > 0 ) {
					$json->add_error_response('username', -2);
					$invalid = true;
				}
			} catch (Exception $e) {
				$json->add_error_response('username', -3);
				$invalid = true;
			}
		
			//check for the email now...
			# Ryan - Catch an exception if the database query fails
			try {
				$query_pending = $this->Pending_users->get_user('',$email,'');
				$query_users = $this->Users->get_user(array('email'=>$email)); 
				if($query_pending->num_rows() > 0 || $query_users->num_rows() > 0 ) {
					$json->add_error_response('email', -2);
					$invalid = true;
				}
				
			} catch (Exception $e) {
				$json->add_error_response('email', -3);
				$invalid = true;
			}
			
			//generate an activation hash
			$char_pool='0123456789abcdefghijklmnopqrstuvwxyzABZCDEFGIJKLMNOPQRSTUVWXYZ';
			$random_string = "";
			for($p=0; $p<64; $p++)
			 	$random_string.=$char_pool[mt_rand(0,strlen($char_pool)-1)];
			
			//create user account
			if (!$invalid) {
				$this->Pending_users->insert_entry($username,$email,$password_hash,$random_string);
				
				// Send confirmation email
				$title = "Syner Account Activation";
				$url = $this->config->item('base_url')."index.php/user/account_activation/username/".$username."/activation_id/".$random_string;
				$this->load->library('email');
				$this->email->subject('Syner Account Activation');
				$this->email->to($email);
				$this->email->from('noreply@onesynergy.org', 'Syner Project');
				
				$data['url'] = $url;
				$text = $this->load->view('user/activation_email.php', $data, true);
                
				$this->email->message($text);
				if(!$this->email->send()) {
					$json->add_error_response("sendmail", -4);
					$invalid = true;
				}
				
			}
			
			if (! $invalid)	{
				//if all is good 
				$json->add_error_response("success",1);
			}
			
		}
		echo $json->format_response();
	}

	//log in function
	function login()
	{
		if($this->user_session->get_privilege() == 0) {
			$data['js_files'] = array(SY_SITEPATH . "system/application/views/user/login.js");
			$data['content'] = $this->load->view('user/login.php', '', true);
		}
		else {
			$data['general_message']= "Hey, you are already logged in.";
			$data['content'] = $this->load->view("general",$data,true);
		}
		$this->load->view('layout', $data);
	}

	function logout()
	{
		if($this->user_session->get_privilege() != 0 ) {
			//Justin - bit of a hack. seems like sessions aren't destroyed
			//destroyed until connection is closed is done loading. Set privilege to 0
			//so right links will show.
			$this->user_session->set_privilege(0);
			$this->user_session->logout();
			$data['general_message'] = "You've logged out successfully.";

					}
		else {
			$data['general_message'] = "Hey, you aren't logged in.";
		}
		$data['content'] = $this->load->view('general',$data,true);
		$this->load->view('layout',$data);
	}
	function login_ajax() 
	{
		
		$this->load->library("simple_json");
		$invalid = false;
		$json = new Simple_Json();
	
		$this->load->library('form_validation');

		//note max_length is 15 here. Technically they can have a username longer then 15 characters do to
		//expanding html characters to there co-entities and by using unicode characters.
		$this->form_validation->set_rules('username','username','required|trim|min_length[1]|max_length[15]|htmlentities');
		$this->form_validation->set_rules('password','password','required','min_length[6]');
		
		if($this->form_validation->run() === FALSE) 
		{
			foreach ($this->form_validation->_error_array as $error)  {
				$json->add_error_response($error[0],$error[1]);
				$invalid = true;
			}
		}
		else
		{
			$username = $this->input->post('username');
			$password = $this->input->post('password');

			try {
				if($this->user_session->login($username,$password) != 0) {
					$json->add_error_response('js',-5);
					$invalid = true;
				}
			}
			catch (Exception $e) {
				$json->add_error_response('js',-3);
				$invalid= TRUE;
			}

			if (! $invalid)	{
				//if all is good 
				$json->add_error_response("success",0);
			}
			
		}
		echo $json->format_response();
	}

	function home() 
	{
                $privilege = $this->user_session->get_privilege(); 
                if($privilege != 0) { 
                        $data['username'] = $this->user_session->get_username(); 
                        $data['content'] = $this->load->view("user/home",$data,true); 
 
                } 
                else { 
                        $data['general_message'] = "Hey you aren't logged in yet. Click the login button to login."; 
                        $data['content'] = $this->load->view("general",$data,true); 
 
                } 
                $this->load->view("layout",$data);
	
	}
	
	function settings()
	{
		if($this->user_session->get_privilege() != 0) {
			$data['content'] = $this->load->view('user/settings', '', true);
		}
		else {
			$data['general_message']= "You need to be logged in to check your account settings.";
			$data['content'] = $this->load->view("general",$data,true);
		}
		$this->load->view('layout', $data);
	}
	
}
