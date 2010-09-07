<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
* Model used for topic releated data
*/
 
class Topics extends Model 
{
	/**
	* Bitwise mask to retrieve topic title
	*/
	const TOPIC_TITLE = 1;

	/**
	* Bitwise mask to retreive topic content
	*/
	const TOPIC_CONTENT =  2;

	const USER_FOR = 0;
	const USER_AGAINST = 1;
	const USER_UNDECIDED = 2;

	/**
	* Constructor for topics class
	*/
	function Topics()
	{
		parent::Model();
	}
	
	/**
	* Add a topic entry into the database
	* @exception Throws an exception on failure
	* @param int $user_id 
	* @param string $title
	* @param string $date_created
	* @param string $location_id
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
	* Subscribes user to topic.
	* @param int $user_id id of user
	* @param int|const $siding stance of user (for,against,etc.). Check constants in this class.
	* @param string $comment comment of user (if there is one).
	* @todo update subscription count
	*/
	function subscribe_user($topic_id,$user_id,$siding, $comment) 
	{
		$data = array(  'topic_id' => $topic_id,
				'date' => date('Y-m-d H:i:s', time()),
				'user_id' => $user_id,
				'siding' => $siding,
				'comment' => $comment);
		$query = $this->db->insert('topic_subscriptions',$data);
		if(!$query) {
			throw new Exception('Failed to subscribe user to topic!');
		}

		//add code to update topic subscripction count here!
	}

	/**
	* Updates subscription count for topic	
	*/

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
		if ($this->db->count_all_results() == 1) {
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
	* @param int $topic_id Id of topic
	* @param int $flags bitwise mask to request data. Constats located in Topics model
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

	/**
	* This function searches for a topic based on given tags or text.
	* The text search is done by a MySQL's boolean raw text search.
	* @param tags an array of tags
	* @text a string to search for
	* @returns the ressult array of query.
	* @todo implement tag portion for search.
	*/
	function search_for_topic($tags,$text)
	{
		$text = $this->db->escape($text);
		$sql = "SELECT T.id,T.title,C.content FROM topics AS T, topic_contents AS C WHERE T.id = C.topic_id AND ( MATCH(T.title) AGAINST (" . $text . "IN BOOLEAN MODE) OR MATCH(C.content) AGAINST ( " . $text . "IN BOOLEAN MODE))";
		$query = $this->db->query($sql);
		return($query->result_array());
	}
	
	/**
	* This function retrieves the last 11 created topics.
	* @param optional|array $tags optional array of Save_Tag_Descriptors
	* @return returns the query result array.
	*/
	function get_recent_topics($tags = "") {

		if(is_array($tags)) {
			//first we must get 11 topics
			$this->db->select("tagged_topics.topic_id");
			$this->db->distinct();
			$this->db->from("tagged_topics");
			if(is_array($tags)) {
				foreach($tags as $tag) {
					//Ignore ignore tags
					if($tag->operator != Saved_Tag_Descriptor::IGNORE_OP) {
						$this->db->or_where("tagged_topics.tag_id =" , $tag->id);
					}
				}
			}
			$this->db->limit(11);
			$topic_ids = $this->db->get();


			//now we must get all tag id's and topic id's assoicated with the tag id.
			$this->db->select("tagged_topics.tag_id,tagged_topics.topic_id");
			$this->db->from("tagged_topics");
			foreach($topic_ids->result() as $topic_id) {
				$this->db->or_where("topic_id",$topic_id->topic_id);
			}
			$tag_topic_ids = $this->db->get();
			

			//now we decide which topics to return based on tag operation
			$good_topics = array();
			$cur_topic_id=-1;
			$good_topic_index = -2;


			foreach($tag_topic_ids->result() as $ttid) {
				
				//if we are on a new topic id then create a new variable to preform operations on
				if($cur_topic_id != $ttid->topic_id ) {
					$good_topic_index+=2;
					$good_topics[$good_topic_index] = 1;
					$good_topics[$good_topic_index +1] = $ttid->topic_id; 
					$cur_topic_id=$ttid->topic_id;
				}

				//generate a lookup table for tags for this topic.
				$tag_lookup = array();
				foreach($tag_topic_ids->result() as $atopic) {
					if($atopic->topic_id == $cur_topic_id) {
						$tag_lookup[$atopic->tag_id] = TRUE;
					}
				}
				
				//foreach of the user's tags...
				foreach($tags as $tag) {

					//make sure we ignore those excludes!
					if($good_topics[$good_topic_index] == 1 || $good_topics[$good_topic_index] == 0) {
						switch($tag->operator) {
							case Saved_Tag_Descriptor::AND_OP:
								
								//If the current topic dosen't include a tag with the OR operator
								//we set exclude it from result...unless a OR operator resets it.
								if(! array_key_exists($tag->id,$tag_lookup)) {
									$good_topics[$good_topic_index] = 0;
								}
								break;
							case Saved_Tag_Descriptor::OR_OP:
								//topic will always be included if it matches a OR tag
								if( array_key_exists($tag->id,$tag_lookup)) {
									$good_topics[$good_topic_index] = 1;
								}
								break;
							case Saved_Tag_Descriptor::EXCLUDE_OP:
								//exclude topic if topic has a id to be excluded.
								if( array_key_exists($tag->id,$tag_lookup)) {
									$good_topics[$good_topic_index] = -1;
								}
								break;
						}
					}
				}
			}
			$match = FALSE;

			if(is_array($tags)) {
				//do we have ANY matches?
				for($i=0;$i<count($good_topics);$i+=2) {
					if($good_topics[$i] != 0 && $good_topics[$i] != -1) {
						$match = TRUE;
						break;
					}
				}
			} 
				
			if($match == TRUE) {

				//Finally retrieve the relevant topics	
				$this->db->select("id,title,content");
				for($i=0;$i<count($good_topics);$i+=2) {
					if($good_topics[$i] == 1 || $good_topics[$i]==2) {
						$this->db->or_where('topics.id =', $good_topics[$i+1]);
					}
				}
				$this->db->distinct();
				$this->db->from("topics");
				$this->db->join("topic_contents", 'topics.id = topic_contents.topic_id');
				$this->db->limit(11);
				$query = $this->db->get();
				return $query->result_array();
			}
			//no matches, return blank array.
			else {
				return array();
			}

		}
		//since we got no tags then just return the last 11 topics
		else {
			$this->db->select('id,title,content');
			$this->db->from("topics");
			$this->db->join("topic_contents", 'id = topic_contents.topic_id');
			$this->db->limit(11);
			$result = $this->db->get();
			return $result->result_array();
		}
	}
	
}
