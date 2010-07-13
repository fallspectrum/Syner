<?
/**
* This library is used for making a simple JSON response. Simply create a JSON_Response 
* instance and use the proper methods.
*/

if ( ! defined('BASEPATH')) exit('No direct script access allowed');


class Simple_JSON {
	var $responses;
	var $error_codes = array(	'success' => 1,
					'invalid' => -1,
					'duplicate' => -2,
					'db_error' => -3,
					'email_error' => -4
				);
				
	function __construct()
	{
		$this->responses=array();
	}

	/*
	* @param $reference_id is the id of the bad element on the page.
	* @param $return_val a return val for the paticular response
	*/
	function add_error_response($reference_id,$return_val,$formal_name='') 
	{
		//Got to escape quotes so no malformed jquery responses are
		//made
		$response['reference_id']= str_replace('"','\"',$reference_id);
		$response['return_val'] = str_replace('"','\"',$return_val);
		array_push($this->responses,$response);
	}

	/**
	* @return string returns a valid json response 
	*/
	function format_response()
	{
		$i;
		$return_val = '{ "error_responses" : [ ';
		foreach ($this->responses as $response) {
				$return_val .= ' { "reference_id": "' . $response['reference_id'] . '",' . 
						  '"return_val": "' . $response['return_val'] . '"},' ;
		}
		
		//remove the last comma and replace with ]}
		$return_val = substr($return_val,0,-1) . " ] }";
		
		return $return_val;
	}
}
?>
