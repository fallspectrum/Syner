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


	/**
	* Bitwise mask to retreive subscription count
	*/
	const TOPIC_SUBSCRIPTION_COUNT = 3;

	/**
	* Bitwise mask to retreive for count
	*/
	const TOPIC_FOR_COUNT = 4;

	/**
	* Bitwise mask to retreive against count
	*/
	const TOPIC_AGAINST_COUNT = 5;

	const USER_FOR = 0;
	const USER_AGAINST = 1;
	const USER_UNDECIDED = 2;
	const USER_UNSUSCRIBE = 3;
	const USER_NOT_SUBSCRIBED = 4;
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
	* Subscribes or unsubscribes user to/from topic.
	* @param int $user_id id of user
	* @param int|const $siding stance of user (for,against,etc.). Check constants in this class.
	* @param string $comment comment of user (if there is one).
	* @param $update equals 0 if updating, anything else if creating new entry.
	* @todo add error checks
	*/
	function subscribe_user($topic_id,$user_id,$new_siding, $comment,$update=0) 
	{
		//make sure we have a valid siding
		if(	$new_siding != Topics::USER_UNSUSCRIBE && $new_siding != Topics::USER_FOR &&
			$new_siding != Topics::USER_AGAINST && $new_siding != Topics::USER_UNDECIDED ) {
				throw new Exception("Provided siding value is invalid.");
			}


		//we are updating our stance on a topic
		if($update == 0) {
			$topic_data = $this->get_topic_data($topic_id,Topics::TOPIC_SUBSCRIPTION_COUNT &
								      Topics::TOPIC_FOR_COUNT &
								      Topics::TOPIC_AGAINST_COUNT);


			$new_for = $topic_data['for_count'];
			$new_against = $topic_data['against_count'];
			$new_subscriptions = $topic_data['subscription_count'];
			//get the saved user stance
			$saved_stance = $this->get_user_stance($topic_id,$user_id);
			
			//just return if our current stance is the same as the saved stance.
			if($new_siding == $saved_stance) {
				return;
			}

			//Do we need to suscribe?
			if( $saved_stance == Topics::USER_NOT_SUBSCRIBED) {

				if($new_siding != Topics::USER_UNSUSCRIBE) {
							$this->subscribe_user($topic_id,$user_id,$new_siding,$comment,1);
							$new_subscriptions++;
						}	
			}

			//we are already subscribed
			else {
				
				//Are we unsuscribing?
				if($new_siding == Topics::USER_UNSUSCRIBE) {
					$this->db->from('topic_subscriptions');
					$this->db->where('user_id',$user_id);
					$this->db->where('topic_id',$topic_id);
					$this->db->delete();
					if($this->db->_error_number()) {
						throw new Exception("Error while unsuscribing user from topic.");
					}
					$new_subscriptions -= 1;
				}

				//We are updating if not unsuscribing
				else {
					$data = array (	"siding" => $new_siding);
					
					$this->db->where('topic_id', $topic_id);
					$this->db->where('user_id', $user_id);
					$this->db->update('topic_subscriptions',$data);
					if($this->db->_error_number()) {
						throw new Exception("Error while updating subscription.");
					}
				}
			}
			
			//calculate new siding values				
			switch($new_siding) {
				case Topics::USER_FOR:
					$new_for +=1;
					$new_against -=1;
					break;
				case Topics::USER_AGAINST:
					$new_for -=1;
					$new_against +=1;
					break;
				case Topics::USER_UNDECIDED:
				case Topics::USER_UNSUSCRIBE:
					if($saved_stance == Topics::USER_FOR) {
						$new_for -=1;
					}
					else if($saved_stance == Topics::USER_AGAINST) {
						$new_against -=1;
					}
					break;
			}

			//and finally update the counts in the database
			$new_data = array(  'for_count' => $new_for,
					'against_count' => $new_against,
					'subscription_count' => $new_subscriptions);
			$this->db->where('id',$topic_id);
			$this->db->where('user_id', $user_id);
			$this->db->update('topics',$new_data);
			if($this->db->_error_number()) {
				echo $this->db->last_query();
				throw new Exception("Error while updating subscription counts.");
			}
		
		}
		//we are inserting a new entry
		else {
			//we want to subscribe
			if($new_siding != Topics::USER_UNSUSCRIBE) {
				$data = array(  'topic_id' => $topic_id,
						'date' => date('Y-m-d H:i:s', time()),
						'user_id' => $user_id,
						'siding' => $new_siding,
						'comment' => $comment);
				$query = $this->db->insert('topic_subscriptions',$data);
				if(!$query) {
					throw new Exception('Failed to subscribe user to topic!');
				}
			}
		}
	}

	/**
	* Retreives a user stance on a topic. Returns a constant.
	* @throws an execption if user is not assigned to topic.
	* @throws an exception if query ran into error.
	*/
	function get_user_stance($topic_id,$user_id) {
		$this->db->from('topic_subscriptions');
		$this->db->select('siding');
		$this->db->where('topic_id',$topic_id);
		$this->db->where('user_id',$user_id);
		$this->db->limit(1);
		$result = $this->db->get();
		if($this->db->_error_number()) {
			throw new Exception("Error while retreiving user stance from database.");
		}

		//Assume user is not subscribed to topic.
		if($result->num_rows() != 1) {
			return Topics::USER_NOT_SUBSCRIBED;	
		}
		
		$row = $result->row();
		return $row->siding;	
		
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
	
		if($flags & Topics::TOPIC_SUBSCRIPTION_COUNT) {
			$this->db->select('topics.subscription_count');
		}

		if($flags & Topics::TOPIC_FOR_COUNT) {
			$this->db->select('topics.for_count');
		}

		if($flags & Topics::TOPIC_AGAINST_COUNT) {
			$this->db->select('topics.against_count');
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
