<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
* This fie describe the User model class.
*/

class Users extends Model 
{
	function User()
	{
		parent::Model();
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

	/**
	* This function stores saved tags.
	* @param $user_id is the id of the user to get the tags from.
	* @param $tags is an array containing Saved_Tag_Descriptor objects.
	* @todo throw an exception on fail
	* @todo check to make sure save_value is <= 255 characters long.
	*/
	function save_tags($user_id,$tag_save_descriptors)
	{
		$save_value = "";
		foreach($tag_save_descriptors as $tag_desc) {
			$save_value .= $tag_desc->to_string() . " ";
		}
		//remove trailing whitspace
		$save_value = trim($save_value);
		$this->db->where('id', $user_id);
		$data = array('saved_tags' => $save_value);

		$this->db->update('users',$data);
	}


	/**
	* This function retreives saved tags for users.
	* @param $user_id is the user id to get the tags from.
	* @return a array of Saved_Tag_Descriptor's
	* @todo error checking
	*/
	function retrieve_tags($user_id)
	{
		$this->db->select('saved_tags');
		$this->db->from('users');
		$this->db->where('id',$user_id);
		$query = $this->db->get();
		
		//there should only be 1 result
		$result = $query->row();
		return Saved_Tag_Descriptor::from_string($result->saved_tags);
	}

}

/**
* This class is used to prepare tags before saving or after loading
*/

class Saved_Tag_Descriptor { 
	public function __construct($tag_id,$tag_name, $tag_operator) {
		$this->name = $tag_name;
		$this->id = $tag_id;
		$this->operator = $tag_operator;
	}

	public function to_string() 
	{
		return $this->id . " " . $this->name . " " . $this->operator;
	}

	/**
	* Converts a string to one or more Save_Tag_Descriptors
	* @return an array of Save_Tag_Descriptors
	* @todo error checking
	*/
	public static function from_string($string)
	{
		$return_val = array();
		$elements = explode(" " ,$string);
		$ele_count = count($elements);
		//make sure we have 3 elements
		if(strlen($string) != 0 )
		{
			if($ele_count %3 != 0) {
				throw new Exception("Invalid tag descriptor string.");
			}
			for($i = 0; $i < $ele_count; $i+=3) { 
				array_push($return_val, new Saved_Tag_Descriptor($elements[$i],$elements[$i+1],$elements[$i+2]));
			}
		}
		return $return_val;
	}

	const AND_OP = 0;
	const OR_OP = 1;
	const EXCLUDE_OP = 2;
	const IGNORE_OP = 3;
	
	//UPDATE AFTER CHANGING ANY NUMBER ABOVE!
	const LAST_OP = 3;
}

?>
