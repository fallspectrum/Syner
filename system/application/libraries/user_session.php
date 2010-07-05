<?php 
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
* This class is used to aid in the process of logging in, logging out,
* and also some functions to retreive/set user session data.
* THIS CLASS ASSUMES THE SESSION LIBRARY IS ALREADY LOADED!
*/

class User_Session 
{

	/**
	* This function attempts to log a user in. It sets the appropiate 
	* sesion variables.
	* @param username a username
	* @param password a password. Not encrypted.
	* @return 0 on success, 1 if information is incorrect.
	*/
	function login($username,$password)
	{
		
		$password_hash = hash('sha256',$this->config->item('encryption_salt') . $password);
		$login_info = array(	'username'=>$username,
					'password_hash'=>$password_hash);
		$this->load->model('Users','',TRUE);
		$query = $this->users->get_user($login_info);
		if($query->num_rows() > 0 ) {
			$this->load->library('Sessions');
			$user_row = $query[0]->row_array();
			$session_data = array("user_id"=>$user_row['id'], "privilege" => $user_row['privilege']);
			$this->session->set_userdata($session_data);
			return 0;
		}
		else {
			return 1;
		}

	}

	/**
	* This function returns the current privilege of the user. 
	* @return 0 if they are not logged in, otherwise a non zero number.
	*/
	function get_privilege() 
	{
		$privilege = $this->session->userdata('user_id');
		if ($privilege === FALSE) {
			$privilege = 0;
		}
		return $privilege;
	}

	/**
	* This function is to log the user out, if logged in.
	*/
	function logout()
	{
		$this->session->sess_destroy();	
	}
}

