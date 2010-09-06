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
		$data['js_files'] = array("/syner/system/application/views/topic/tagmodule.js","/syner/system/application/views/topic/search.js");
		$data['content'] = $this->load->view("topic/search",'',TRUE);	
		$this->load->view("layout",$data);
	}

	/**
	* This function displays the popular view.
	*/
	function popular() 
	{
		$data['content'] = $this->load->view("topic/popular",'',TRUE);	
		$this->load->view("layout",$data);
	}
	/**
	* This function displays the recent view.
	* @todo handle tag filters
	*/
	function recent() 
	{
		$this->load->model("Topics",'',TRUE);
		
		if($this->user_session->get_privilege() != 0 ) {
			$this->load->model("Users",'',TRUE);
			$tags = $this->Users->retrieve_tags($this->user_session->get_user_id());
			$results = $this->Topics->get_recent_topics($tags);
		}
		else {
			$results = $this->Topics->get_recent_topics();
		}
			

		foreach($results as $topic) {
			//cut off around 90-100 characters.
			$content_length = mb_strlen($topic['content']);
			if($content_length > 100) {
				//find a space in the string
				
				$space_index=90;
				//after 10 letters just cut it off, must be a long word.
				for($space_index=90;$space_index < 100;$space_index++) {
					if($topic['content'][$space_index] == " ") {
						break;
					}
				}
				
				//just cut it off at 100th character if no space is found.
				if($space_index == 100) {
					$space_index = 99;
				}

				$topic['content'] = mb_substr($topic['content'],0,$space_index + 1) . '...';

			}
		}
		$recent_view_data['topics'] = $results; 
		$data['js_files'] = array("/syner/system/application/views/topic/tagmodule.js");
		$data['content'] = $this->load->view("topic/recent",$recent_view_data,TRUE);	
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
	* @todo set max tag lenth
	*/
	function new_topic_ajax() {
		$this->load->library("simple_json");
		$invalid = false;
		$json = new Simple_Json();
		$this->load->library('form_validation');
		$tags = array();
		
		//validate form input, we got to do tags manually.
		$this->form_validation->set_rules('problem_title','problem title','required|trim|main_length[10],max_length[100]');
		$this->form_validation->set_rules('problem_description','problem description','required|trim|min_length[10]');
		if($this->form_validation->run() === FALSE) 
		{
			//for each error response add it to the json response
			foreach ($this->form_validation->_error_array as $error) {
				$json->add_error_response($error[0],$error[1]);
				$invalid = true;
			}
		} else { // If the validation succeeds, check the tags
	
			$tags = explode(' ', $this->input->post('problem_tags'));
			
			//if we don't have atleast 3 tags
			if(count($tags) < 3) {
				$json->add_error_response('problem_tags',$json->error_codes['invalid'],'tag');
				$invalid = true;
			} 
			else {
				foreach($tags as $key => $tag) {
					$tag = trim($tag);
					
					// Remove empty tags
					if(empty($tag)) {
						unset($tags[$key]);
						continue;
					}
					
					//if the tag has more then 30 characters or less then 4, notify them it's invalid
					if(strlen($tag) < 4 || strlen($tag) > 30) {
						$json->add_error_response('problem_tags',$json->error_codes['invalid'],'tag '.$tag);
						$invalid = true;
					}
				}
			}
		
			if(!$invalid) {
				
				$this->load->model("topics",'',TRUE);
				$this->load->model("tags",'',TRUE);

				//check to see if the topic title already exists
				if( $this->topics->topic_exists($this->input->post('problem_title'))) {
					$json->add_error_response("problem_title",$json->error_codes['duplicate']);
				}
				else {	//Lets add the topic to the database.
					try {
						$topic_id = $this->topics->add_entry(	$this->user_session->get_user_id(),
											$this->input->post('problem_title'),
											date('Y-m-d H:i:s', time()), 
											"global");

						$this->topics->set_topic_content($topic_id,
										$this->input->post('problem_description'),
										$this->user_session->get_user_id());
						
						$this->tags->add_tags($tags);		
						$tag_ids = $this->tags->get_tag_ids($tags);
						$this->tags->tag_topic($topic_id,$tag_ids);

						$json->add_error_response('success',$json->error_codes['success']);
					}
					catch (Exception $e) {
						//althought get_user_id may throw a exception, just consider it a db error.
						$json->add_error_response("js",$json->error_codes['db_error']);
					}
				}
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
			$this->load->model("topics",'',TRUE);
			if(!isset($uri['topic_id']) || !ctype_digit($uri['topic_id']) 
				  || $uri['topic_id'] < 0 || !$this->topics->topic_id_exists($uri['topic_id'])) {
				throw new Exception("A invalid topic ID has been supplied.");
			}
			//retreive topic title and content
			$result = $this->topics->get_topic_data($uri['topic_id'],Topics::TOPIC_TITLE | Topics::TOPIC_CONTENT);
			$topic_title = $result['title'];
			$topic_content = $result['content'];

			//retrieve topic tags
			$this->load->model("tags",'',TRUE);
			$tags = $this->tags->get_topic_tag_names($uri['topic_id']);

		}
		
		catch (Exception $e) {
			$data['general_message'] = $e->getMessage();
			$data['content'] = $this->load->view("general",$data,TRUE);
			$valid = FALSE;
		}
		if($valid) {

			$data['js_files'] = array(SY_SITEPATH . "system/application/views/tiny_mce/tiny_mce.js");
			$data['topic_id'] = $uri['topic_id'];
			$data['topic_title'] = $topic_title;
			$data['problem_content'] = $topic_content;
			$data['topic_tags'] = $tags;
			$data['content'] = $this->load->view("topic/view",$data,TRUE);	
		}
		$this->load->view("layout",$data);
	}
	
	/**
	* Used to retrieve topic data for editing. Returns a json response.
	*/
	function edit_load_topic_ajax() 
	{
		$this->load->library('simple_json');
		$this->load->model('topics','',TRUE);
		$this->load->model('tags','',TRUE);
		
		$json = new Simple_Json();
		try {
			$data = $this->topics->get_topic_data($this->input->post("topic_id"),Topics::TOPIC_TITLE|Topics::TOPIC_CONTENT);
			$tag_names = $this->tags->get_topic_tag_names($this->input->post("topic_id"));
			$data['tags'] = $tag_names;


			$json->add_data("topic",$data);
			echo $json->format_response();
		}

		catch (Exception $e) {
			$json->add_error_response("js",$json->error_codes['db_error']);		
			echo $json->format_response();
		}

		
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
			if(!isset($uri['topic_id']) || !ctype_digit($uri['topic_id']) || $uri['topic_id'] <= 0) {
				throw new Exception("A invalid topic ID has been supplied.");

			}
			
			$this->load->model("topics",'',TRUE);
			//check to make sure topic exists
			if($this->topics->topic_id_exists($uri['topic_id']) === FALSE) {
				throw new Exception("A invalid topic ID has ben supplied.");
			}
		}
		
		catch (Exception $e) {
			$data['general_message'] = $e->getMessage();
			$data['content'] = $this->load->view("general",$data,TRUE);
			$valid = FALSE;
		}
		if($valid) {
			$data['js_files'] = array(SY_SITEPATH . "system/application/views/tiny_mce/tiny_mce.js",SY_SITEPATH . "system/application/views/topic/edit.js");
			$data['topic_id'] = $uri['topic_id'];
			$data['content'] = $this->load->view("topic/edit",$data,TRUE);	
		}
		$this->load->view("layout",$data);
	}


	/**
	* This function handles request for searching a topic.
	*/
	function search_json()
	{
		$this->load->library("form_validation");
		$this->load->library("simple_json");
		$json = new Simple_Json();

		$this->form_validation->set_rules("txt_search","Text search field","required|min_length[4]");

		//Input was not valid.
		if($this->form_validation->run() == FALSE) {
			//for each error add it to the response
			foreach ($this->form_validation->_error_array as $error) {
				$json->add_error_response($error[0],$error[1]);
			}
		}

		//Input was valid
		else {
			$this->load->model("topics",'',TRUE);
			$result = $this->topics->search_for_topic(NULL,$this->input->post("txt_search"));	
			foreach ($result as $row) {
				//remove tags from text
				$row['content'] = preg_replace('/<[^>]*>/',"", $row['content']);

				//after 100 characters truncate and and ...
				if(mb_strlen($row['content']) > 100) {
					$row['content'] = mb_substr($row['content'],100);
				}

				$json->add_data("topics",array($row));
			}


			//Respond with matching topics
		}
		echo $json->format_response();
	}

	/**
	* This function checks to see if the tag sent is valid.
	* If it is a json response containing the tag id is sent back.
	* normal simple_json error response is generated if problem occured.
	* Otherwise a json variable tag_id contains -1 if invalid or a number >= 0 if valid.
	*/
	function validate_tag_json()
	{
		$this->load->library("form_validation");
		$this->load->library("simple_json");
		$json = new Simple_Json();
		$this->form_validation->set_rules("addtag","addtag","required|min_length[4]");

		//If input failed to validate...
		if($this->form_validation->run() == FALSE) {
			foreach($this->form_validation->_error_array as $error) {
				$json->add_error_response($error[0],$error[1]);
			}
		}

		//input was valid
		else {
			$this->load->model("tags",'',TRUE);
			$result = $this->tags->get_tag_ids(array($this->input->post("addtag")));

			$tag_id = -1;
			if(sizeof($result) == 1) { 
				$tag_id = $result[0];

			} 
			$json->add_data("tag_id",$tag_id);
		}
		echo $json->format_response();
	}
}
?>
