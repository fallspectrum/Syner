<?
/**
* This library is used for making a simple JSON response. Simply create a JSON_Response 
* instance and use the proper methods.
*/

if ( ! defined('BASEPATH')) exit('No direct script access allowed');


class Simple_JSON {
	
	
	/**
	* @access private
	*/
	private $error_responses;

	/**
	* Error codes to use with add_error_response()
	*/
	public $error_codes = array(	'success' => 0,
					'invalid' => -1,
					'duplicate' => -2,
					'db_error' => -3,
					'email_error' => -4,
					'login_fail' => -5
				);
				
	/**
	* Associtave array containing unformatted json key/value pairs.
	* @access private
	*/
	private $additional_data;

	function __construct()
	{
		$this->error_responses=array();
		$this->additional_data = array();
	}

	
	/**
	*  Add additional data to the json response
	*  @param string $name name of variable to associate data with
	*  @param string|array $data value to associate data with. If an array is used
	*  it must be an associtave array or an array of associative arrays.
	*  @throws Exception when $additional_data[name] already exists and
	*  data type is not an array..
	*/
	function add_data($name,$data)
	{
		//cant add data to a string.
		if(isset($this->additional_data[$name])) {
			if (!is_array($this->additional_data[$name])) {
				throw new Exception("Can't modify non array response value.");	
			}
			else {
				//Check to see if we are an associatve array
				$keys = array_keys($this->additional_data[$name]);
				if(array_keys($keys) != $keys) {
					$this->additional_data[$name]  = array($this->additional_data[$name]);
					array_push($this->additional_data[$name],$data);
				}
				
				//Push sub elements of indexed array
				else {
					foreach($data as $assoc_array) {
						array_push($this->additional_data[$name], $assoc_array);
					}			
				}
			}
		}
	
		else {
		
			//TODO: Make sure this is secure
			//are we dealing with non array? (assuming string)
			if(!is_array($data)) {
				$this->additional_data[$name] = $data;	
			}

			else {	
				//Add data if we are an associative array.
				$keys = array_keys($data);
				if(array_keys($keys) != $keys) {
					$this->additional_data[$name] = $data;
				}
				
				//Else create a new array and push sub elements to array.
				else {
					$this->additional_data[$name] = array();
					foreach($data as $assoc_array) {
						array_push($this->additional_data[$name], $assoc_array);
					}
				}
			}

		
		}
			

		
	}
	
	/**
	* Add a error code with optional message to json response.
	* @param string $reference_id the id of the bad element on the page.
	* @param int $return_val return val for the paticular response
	* @param string $formal_name a formal name to be used in the error message.
	*/
	function add_error_response($reference_id,$return_val) 
	{
		//Got to escape quotes so no malformed jquery responses are
		//made
		$response['reference_id']= str_replace('"','\"',$reference_id);
		$response['return_val'] = str_replace('"','\"',$return_val);
		
		//we need an array.
		$this->add_data('error_responses',array($response));
		
	}

		
	/**
	* This function creates a valid json respone.
	* @return string returns a valid json response 
	*/
	function format_response()
	{
		$return_val = json_encode($this->additional_data);
		return $return_val;
	}
}
?>
