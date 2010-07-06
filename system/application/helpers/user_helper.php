<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

if( ! function_exists('get_user_privilege'))
{
	function get_user_privilege()
	{
		$CI =& get_instance();
		return $CI->user_session->get_privilege();
	}
}
