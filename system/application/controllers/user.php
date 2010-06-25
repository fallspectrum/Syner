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
		$data['content'] = $this->load->view('user/register.php', '', true);
		$this->load->view('layout', $data);
	
	}
	
}
