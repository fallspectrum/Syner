<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Home extends Controller 
{
	function Home()
	{
		parent::Controller();
	}

	function Index()
	{
		$this->load->library('user_session');
		$privilege = $this->user_session->get_privilege();
		if($privilege != 0) {
			$data['username'] = $this->user_session->get_username();
			$data['content'] = $this->load->view("home",$data,true);
		}
		else {
			$data['general_message'] = "Hey you aren't logged in yet. Click the login button to login.";
			$data['content'] = $this->load->view("general",$data,true);

		}
		$this->load->view("layout",$data);
	}
}
