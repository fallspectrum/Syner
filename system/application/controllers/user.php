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
	
	
	function register()
	{
		$data['js_files'] = array($this->config->item("base_url") . "system/application/views/user/register.js");
		$data['content'] = $this->load->view('user/register.php', '', true);
		$this->load->view('layout', $data);
	}
	

	/**
	* This function handles a register user request. It responseds with a json response.
	* -1 response for malformed input. -2 for input used already. 1 for success.
	* @check if users exists in validated user account table
	* @todo generate a temp password
	* @todo generate validation hash
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
			//check if username exists already in pending_users table
			$this->load->model('Pending_users','',TRUE);
			if($this->Pending_users->entry_exists($username,'')) {
				$json->add_error_response('username', -2);
				$invalid = true;
			}
		
			//check for the email now...
			if($this->Pending_users->entry_exists('',$email)) {
				$json->add_error_response('email', -2);
				$invalid = true;
			}
			
			//create user account
			if (!$invalid ) {
				//generate a temp password
				//generate validation hash
				$this->Pending_users->insert_entry($username,$email,NULL);
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
