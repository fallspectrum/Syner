<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Admin extends Controller {

	function Admin() 
	{
		parent::Controller();
		
	}
	
	function index() 
	{
		echo 'hello world!';
	}
	/**
	ANB = Admin Notification Board
	*/
	function anb()
	{
		  $privilege = $this->user_session->get_privilege(); 
                if($privilege == 2) { 
                        $data['username'] = $this->user_session->get_username(); 
                        $data['content'] = $this->load->view("admin/anb",$data,true); 
 
                } 
                else { 
                        $data['general_message'] = "Hey you're not an admin. Get out of here!"; 
                        $data['content'] = $this->load->view("general",$data,true); 
 
                } 
                $this->load->view("layout",$data);
	}
	

	
}
