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
	*/
	function registerajax() {

		$this->load->library("simple_json");
		$json = new Simple_Json();
		
		//change invalid to true if input is not to be accepted.
		$invalid = false;
		
		if(isset($_POST['username']))
		{
			//remove html characters from username
			$s_username = htmlentities($_POST['username']);
			if($s_username !== $_POST['username']) {
				$json->add_response("username",-1,"");
				$invalid = true;
			}
			
		}	

		if(isset($_POST['email'])) {
			$s_email = htmlentities($_POST['email']);
			if($s_email !== $_POST['email'])
			{
				$json->add_response("email",-1,"");
				$invalid = true;
			}
		}

		//check if username exists already

		//check if email exists already

		//create user account
		
		//if all is good...
		if(!$invalid) {
			$json->add_response("success",1,"");
		}
		echo $json->format_response();
	}

	function login()
	{
		$data['content'] = $this->load->view('user/login.php', '', true);
		$this->load->view('layout', $data);
	}
	
}
