<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
* This Topic controller is used to handle anything topic related.
*/
class Topic extends Controller 
{

	function Topic()
	{
		parent::Controller();
	}

	/**
	* This function will simply display the search view.
	*/
	function index()
	{
		$this->search();
	}

	/**
	* This function displays the search view.
	*/
	function search() 
	{
		$data['content'] = $this->load->view("topic/search",'',TRUE);	
		$this->load->view("layout",$data);
	}


	/**
	* This function is for editing the topic.
	*/
	function edit() 
	{
		$valid = TRUE;
		$data="";
		$uri = $this->uri->uri_to_assoc(3);
		try {
			//make sure a valid topic_id has been given
			if(!isset($uri['topic_id']) || !ctype_digit($uri['topic_id']) || $uri['topic_id'] < 0) {
				throw new Exception("A invalid topic ID has been supplied.");
			}
		}
		
		catch (Exception $e) {
			$data['general_message'] = $e->getMessage();
			$data['content'] = $this->load->view("general",$data,TRUE);
			$valid = FALSE;
		}
		if($valid) {
			$data['js_files'] = array(SY_SITEPATH . "system/application/views/tiny_mce/tiny_mce.js");
			$data['topic_id'] = $uri['topic_id'];
			$data['content'] = $this->load->view("topic/edit",$data,TRUE);	
		}
		$this->load->view("layout",$data);
	}

	/**
	* This function will display the submission form for a problem.
	* @todo verify group. Remove global group constant. 
	*/
	function submit() 
	{
		$privilege = $this->user_session->get_privilege();
		if($privilege ==0 )
		{
			$data['general_message'] = "You must login before submitting a topic.";
			$data['content'] = $this->load->view("general",$data,TRUE);
		}
		else 
		{
			$data['js_files'] = array(SY_SITEPATH . "system/application/views/tiny_mce/tiny_mce.js",SY_SITEPATH . "system/application/views/topic/submit.js");
			$data['content'] = $this->load->view("topic/submit",'',TRUE);	
		}
		$this->load->view("layout",$data);
	}
	
	/**
	* This function handles submition of a new topic 
	*/
	function new_topic_ajax() {
		$this->load->library("simple_json");
		$invalid = false;
		$json = new Simple_Json();
		$this->load->library('form_validation');
	
		//validate form input, we got to do tags manually.
		$this->form_validation->set_rules('problem_title','problem title','required|trim|main_length[10],max_length[100]');
		$this->form_validation->set_rules('problem_description','problem description','required|trim|min_length[10]');
		if($this->form_validation->run() === FALSE) 
		{
			foreach ($this->form_validation->_error_array as $error) {
				$json->add_error_response($error[0],$error[1]);
				$invalid = true;
			}
		}
		else {
			//look for tags. Must be at least 3 of them.
			$tags = array();
			for($i=0; $i<3; $i++)
			{
				$tag_element = "tag" . $i;
				$tag_name = $this->input->post($tag_element);
				$tag_name = trim($tag_name);
				
				//tag must contain atleast 4 characters.
				if($tag_name === FALSE || strlen($tag_name) < 4) {
					$json->add_error_response($tag_element,$json->error_codes['invalid'],'tag');
					$invalid = true;
				}
			}
			if(!$invalid) {
				$json->add_error_response('success',$json->error_codes['success']);
			}
		}
		echo $json->format_response();
	}
	
	/**
	* This function will display the topic to be viewed.
	*/
	function view()
	{
		$valid = TRUE;
		$data="";
		$uri = $this->uri->uri_to_assoc(3);
		try {
			//make sure a valid topic_id has been given
			if(!isset($uri['topic_id']) || !ctype_digit($uri['topic_id']) || $uri['topic_id'] < 0) {
				throw new Exception("A invalid topic ID has been supplied.");
			}
		}
		
		catch (Exception $e) {
			$data['general_message'] = $e->getMessage();
			$data['content'] = $this->load->view("general",$data,TRUE);
			$valid = FALSE;
		}
		if($valid) {
			$data['js_files'] = array(SY_SITEPATH . "system/application/views/tiny_mce/tiny_mce.js");
			$data['topic_id'] = $uri['topic_id'];
			$data['content'] = $this->load->view("topic/view",$data,TRUE);	
		}
		$this->load->view("layout",$data);
	}
}
?>
