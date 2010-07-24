<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * This file describes the topic model
 */
 
class Topics extends Model 
{
	/**
	* Constants used for flags in topic_get_data
	*/
	const TOPIC_TITLE = 1;
	const TOPIC_CONTENT =  2;

	function Topics()
	{
		parent::Model();
	}
	
	/**
	* Add a topic entry into the database
	* @exception Throws an exception on failure
	* @return integer Returns the id of the inserted row
	*/
	function add_entry($user_id, $title, $date_created, $location_id) 
	{	
		$topicData['user_id'] = $user_id;
		$topicData['title'] = $title;
		$topicData['date_created'] = $date_created;
		$topicData['location_id'] = $location_id;
		
		$query = $this->db->insert('topics', $topicData);
		if(!$query) {
			throw new Exception('Failed to add topic entry');
		}
		
		return $this->db->insert_id();
	}

	/**
	* Check if a topic exists by name.  
	* @returns number of topics with matching title.
	*/
	function topic_exists($title)
	{
		$this->db->from('topics');
		$this->db->where('title',$title);
		return $this->db->count_all_results();	
	}

	/**
	* Check if a topic exists by id.
	* @returns true if exists, false otherwise 
	*/

	function topic_id_exists($topic_id)
	{

		$this->db->from('topics');
		$this->db->where('id',$topic_id);
		if ($this->db->count_all_results() === 1) {
			return TRUE;
		}
		return FALSE;
	}

	/**
	 * This method sets the topic's content.
	 * If an entry with the given topic exists,
	 * then it will update that entry. Otherwise,
	 * it will create a new entry
	 * @todo No support for revisions yet
	 */
	function set_topic_content($topic, $content, $user)
	{
		$row_data['topic_id'] = $topic;
		$query = $this->db->get_where('topic_contents', $row_data, 1);
		
		// If there is no existing entry
		if($query->num_rows() <= 0) {
			$data['topic_id'] = $topic;
			$data['content'] = $content;
			$data['user_id'] = $user;
			
			$query = $this->db->insert('topic_contents', $data);
			if(!$query) {
				throw new Exception('Unable to insert new topic content');
			}
		
		} 
		// We found an existing entry
		else {
			$data['content'] = $content;
			$data['user_id'] = $id;
			
			$this->db->where('topic_id', $topic);
			$query = $this->db->update('topic_contents', $data);
			
			if(!$query) {
				throw new Exception('Unable to update topic content');
			}
		}
		
		return $query;
	}

	/**
	* This function retrives data related to the topic id. 
	* @throws exception when no columns are selected
	* @return a associtave array for selected column data.
	*/
	function get_topic_data($topic_id, $flags) {

		$need_join = FALSE;
		
		
		$this->db->from("topics");

		//check to see if we need to preform a join. This should only occur when
		//a table besides 'topic' is  needed in the queue.
		if (Topics::TOPIC_CONTENT) {
			$need_join = true;
		}
		

		if($flags & Topics::TOPIC_TITLE) {
			$this->db->select('topics.title');
		}
		if($flags & Topics::TOPIC_CONTENT) {
			$this->db->select('topic_contents.content');
			if($need_join) {
				$this->db->join('topic_contents', 'topics.id = topic_contents.topic_id');
			}
		}

		$this->db->where("topics.id", $topic_id);
		$query = $this->db->get();
		//nothing in the query
		if($query->num_rows() <= 0) {
			throw new Exception("Failed to get topic data.");
		}
		$result = $query->result_array();
		return $result[0];
	}
	
}
