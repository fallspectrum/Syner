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
	* This function checks if a user exists based on the input. 
	* @param $alias a user name
	* @param $email a email
	* @param $activation_id a activation identifier
	* @return TRUE if entry exists, FALSE otherwise
	* @todo - add error checking if query failed
	*/
	function entry_exists($alias='',$email='',$activation_id='')
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
	
		if($activation_id !== '' ) {
			if($where !== '') {
				$where .= " OR";
			}
			$where .= "activation_id = '" . $activation_id . "'";
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
	* @param $alias alias used by the user (username)
	* @param $email email address of the user
	* @param $password_hash sha-256 password hash (not raw, but hex encoded to string)
	* @param $auth_identifier 64 character string used for validation link
	* @todo insert error checking
	*/
	
	function insert_entry($alias,$email,$password_hash,$auth_identifier)
	{
		$data = array(
			'alias' => $alias,
			'email' => $email,
			'password_hash' => $password_hash,
			'activation_id' => $auth_identifier
			);
		$this->db->insert('pending_users',$data);
	}
}
