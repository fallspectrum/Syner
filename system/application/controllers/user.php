<?php

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

		$uri_array = $this->uri->uri_to_assoc(3);

		//Check if username is less then 6 characters
		try {
			
			if(isset($uri_array['username']))
				$username = $uri_array['username'];
			else
				throw new Exception('No username was supplied.');

			if(isset($uri_array['activation_id']))
				$activation_id = $uri_array['activation_id'];
			else
				throw new Exception('No activation_id was supplied.');
		
			//When a user registers the username was convertited to htmlentities. Must do same here
			$username  = htmlentities($username);

		
			if(strlen($username) < 6) {
				throw new Exception('Username is not long enough.');
			}

			if(!ctype_alnum($activation_id) || strlen($activation_id) != 64) {
				throw new Exception('Invalid activation id.');
			}
			
			$this->load->model('Pending_users','',TRUE);
			if($this->Pending_users->entry_exists($username,'',$activation_id)) {
				echo "Account exists.";
			}
			else {
				echo "Account does not exist.";
			}

		}
		catch (Exception $e) {
			echo $e;
		}
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
	* -1 response for malformed input. -2 for input used already. 1 for success. Sends email
	* with instructions on how to activate the account.
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
		$this->form_validation->set_rules('username','username','required|trim|max_length[15]|htmlentities');
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
			try {
				if($this->Pending_users->entry_exists($username,'','')) {
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
				if($this->Pending_users->entry_exists('',$email,'')) {
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
				$url = $this->config->item('base_url')."/user/account_activation/username/".$username."/activation_id/".$random_string;
				$data['url'] = $url;
				$text = $this->load->view('user/activation_email.php', $data, true);
                            
				mail($email, $title, $text, "From: noreply@onesynergy.org");
				
			}
			
			if (! $invalid)	{
				//if all is good 
				$json->add_error_response("success",1,"");
			}
			
		}
		echo $json->format_response();
	}

	function login()
	{
		$data['content'] = $this->load->view('user/login.php', '', true);
		$this->load->view('layout', $data);
	}
	
}
