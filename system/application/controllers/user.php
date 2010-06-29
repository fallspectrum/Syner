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
		
		
		$this->load->library('form_validation');
		$this->form_validation->set_rules('username','username','required|trim|valid_email');
		$this->form_validation->set_rules('email','email','required|trim|email|valid_email');
		
		if($this->form_validation->run() === FALSE) 
		{
			foreach ($this->form_validation->_error_array as $error)  {
				$json->add_simple_response($error[0],$error[1]);
			}
		}
		else
		{

			//check if username exists already

			//check if email exists already

			//create user account
			
			//if all is good...
				$json->add_response("success",1,"");
		}
		echo $json->format_response();
	}
}
