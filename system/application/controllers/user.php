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
		$data['javascript'] = $this->load->view('user/register.js', '', true);
		$data['content'] = $this->load->view('user/register.php', '', true);
		$this->load->view('layout', $data);
	}
	
	function registerajax() {
		
		if(isset($_POST['username']))
		{
			// Username validation
			if($_POST['username'] == "fail") 
			{
				echo "fail:Invalid username";
			} elseif($_POST['username'] == "trav") {
				echo "fail:Username already taken";
			} else {
				echo "success";
			}
		} elseif(isset($_POST['email'])) {
			// Email validation
			echo "success";
		}
	}
	
}
