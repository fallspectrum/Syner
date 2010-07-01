<?
/**
* The class Pending_users is use to preform queries on the pending_users table.
*/

class Pending_users extends Model {
	
	function Pending_users ()
	{
		parent::Model();
	}

	
	/**
	*This function 
	* @param $alias a user name
	* @param @email a email
	* @return TRUE if entry exists, FALSE otherwise
	* @todo - add error checking if query failed
	*/
	function entry_exists($alias='',$email='')
	{
	
		$where ='';
		if($alias !== '') {
			$where .= "alias ='" . $alias ."'";
		}
		if($email !== '') {
			if($where !== '') {
				$where .= " OR ";
			}
			$where .= "email = '" . $email ."'";
		}
		
		//get the email and ignore the value. we don't any data really.
		$this->db->select('email');
		$this->db->where($where);
		$this->db->limit(1);
		$query = $this->db->get('pending_users');

		# Ryan - Throw an exception if the database query failed
		if(!$query) {
			log_message('debug', 'Failed to check if a user entry exists');
			throw new Exception('Failed to check if a user entry exists');
		}
		
		if($query->num_rows() > 0) {
			return TRUE;
		}

		else {
			return FALSE;
		}
	}
	
	/**
	* This function adds a entry into the pending_users table.
	* The function relies on correct data on the post variables.
	* @todo insert error checking
	*/
	
	function insert_entry($alias,$email,$auth_identifier)
	{
		$data = array(
			'alias' => $alias,
			'email' => $email,
			'auth_identifier' => $auth_identifier
			);
		$this->db->insert('pending_users',$data);
	}
}
