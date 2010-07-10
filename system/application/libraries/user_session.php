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
		$CI = & get_instance();
		$password_hash = hash('sha256',$CI->config->item('encryption_salt') . $password);
		$login_info = array(	'username'=>$username,
					'password_hash'=>$password_hash);
		$CI->load->model('Users','',TRUE);
		$query = $CI->Users->get_user($login_info);
		if($query->num_rows() > 0 ) {
			$CI->load->library('session');
			$user_row = $query->result_array();
			$user_row = $user_row[0];
			$session_data = array("user_id"=>$user_row['id'], "privilege" => $user_row['privilege'], "username" => $user_row['username']);
			$CI->session->set_userdata($session_data);
			return 0;
		}
		else {
			return 1;
		}

	}
	
	/**
	* This function returns the username of the user, if logged in.
	* @return string there username if logged in, "" if they are not.
	*/
	function get_username()
	{
		$CI = &get_instance();
		$username = $CI->session->userdata('username');
		if ($username === FALSE ) {
			$username = "";
		}
		return $username;
	}

	
	/** 
	* This function can change the privilege of a user on the fly.
	* This shouldn't be used except in rare cases where needed.
	* @param $privilege privilege number to set
	*/
	function set_privilege($privilege)
	{
		$CI =& get_instance();
		$CI->session->set_userdata('privilege',$privilege);
	}
	
	/**
	* This function returns the current privilege of the user. 
	* @return integer 0 if they are not logged in, otherwise a non zero number.
	*/
	function get_privilege() 
	{
		$CI =& get_instance();
		$privilege = $CI->session->userdata('privilege');
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
		$CI =& get_instance();
		$CI->session->sess_destroy();	
	}
}

