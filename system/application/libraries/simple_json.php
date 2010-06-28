<?
/**
* This library is used for making a simple JSON response. Simply create a JSON_Response 
* instance and use the proper methods.
*/

if ( ! defined('BASEPATH')) exit('No direct script access allowed');


class Simple_JSON {
	var $responses;
	function __construct()
	{
		$this->responses=array();
	}

	/*
	* @param $reference_id easy way to refrence a paticular return value.
	         may be null
	  @param $return_val a return val for the paticular response
	  @param $return_text text assoicated with the response
	*/
	function add_response($reference_id,$return_val,$return_text) 
	{
		//Got to escape quotes so no malformed jquery responses are
		//made
		$response['reference_id']= str_replace('"','\"',$reference_id);
		$response['return_val'] = str_replace('"','\"',$return_val);
		$response['return_text']=str_replace('"','\"',$return_text);
		array_push($this->responses,$response);
	}

	/**
	* @return string returns a valid json response 
	*/
	function format_response()
	{
		$i;
		if(sizeof($this->responses)>0) {
			$return_val = '{ "responses" : [ ';
			for ($i=0;$i<sizeof($this->responses)-1;$i++) {
				$response = $this->responses[$i];
				$return_val .= ' { "reference_id": "' . $response['reference_id'] . '",' . 
						  '"return_val": "' . $response['return_val'] . '",' .
						  '"return_text": "' . $response['return_text'] . '" },';
			}
			//$i should be at the last element now...
			$return_val .= ' { "reference_id": "' . $this->responses[$i]['reference_id'] . '",' . 
					  '"return_val": "' . $this->responses[$i]['return_val'] . '",' .
					  '"return_text": "' . $this->responses[$i]['return_text'] . '" } ] }';
		return $return_val;
		}
	}
}
?>
