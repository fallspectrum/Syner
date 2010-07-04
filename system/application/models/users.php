<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
* This fie describe the User model class.
*/

class Users extends Model 
{
	function User()
	{
		parrent::Model();
	}

	/**
	* This function gets a user to the database
	* @param $row_data a associtave array. Each key represents a column name.
	*/
	
	function get_user($row_data)
	{
		$query = $this->db->get_where('users',$row_data,1);
		if(!$query) {
			throw new Exception('Failed to get user from user table.');
		}
		return $query;
	}
	
	/**
	* This function adds a user to the database
	* @param $row_data a associtave array. Each key represents a column name.
	* @todo throw exception on fail
	*/
	
	function add_user($row_data)
	{
		$this->db->insert('users',$row_data);
	}
}

?>
