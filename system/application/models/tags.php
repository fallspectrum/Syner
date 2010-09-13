<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
* This file describes the tag model
*/
   
class Tags extends Model 
{
	function Tags()
	{
		parent::Model();
	}

	/**
	* Adds a tag to the database. It's alright if it already exists.
	* @param tags an array of tags.
	*/
	function add_tags($tags) {
		$sql = "INSERT IGNORE INTO tag_names (name) VALUES ";
		foreach ($tags as $tag) {
			$sql .= "(" . $this->db->escape($tag) . "),";
		}
		$sql = substr($sql,0,-1);
		$this->db->query($sql);
	}
	
	/**
	* Retrieves tag names based on ids.
	* @param $names array of tag names
	* @return returns array of tag names.
	*/
	function get_tag_names($ids)
	{
		$tag_names = array();
		$this->db->select('name');
		$this->db->where('id', array_shift($ids));
		foreach($ids as $id) {
			$this->db->or_where('id', $name);
		}
		$query = $this->db->get('tag_names');
		foreach( $query->result() as $row) {
			array_push($tag_names,$row->name);
		}
		return $tag_names;
	}
	
	/**
	* This function retrives a array of tag ids based on there name
	* @param $names array of tag names
	* @return tag id.
	*/
	function get_tag_ids($names)
	{
		$tag_ids = array();
		$this->db->select('id');
		$this->db->where('name', array_shift($names));
		foreach($names as $name) {
			$this->db->or_where('name', $name);
		}
		$query = $this->db->get('tag_names');
		if($this->db->_error_number()) {
			throw new Exception("Failed to retreived tag id.");
		}
		foreach( $query->result() as $row) {
			array_push($tag_ids,$row->id);
		}
		return $tag_ids;
	}
	
	/**
	* This function tags a topic with the given tag id's.
	* @param topic_id is the id of the topic to be tagged
	* @param tag_ids is an array of id's to tag the topic with.
	*/
	function tag_topic($topic_id,$tag_ids)
	{
		$sql = "INSERT INTO tagged_topics (topic_id,tag_id) VALUES " ;
		foreach ($tag_ids as $tag_id) {
			$sql .= '(' . $this->db->escape($topic_id) . ',' .
				 $this->db->escape($tag_id) . '),'; 
		}
		$sql = substr($sql,0,-1);
		$this->db->query($sql);
	}

	/**
	* Retreives tag names for a specified topic id
	* @param topic_id is the id of the topic
	* @throws Exception if no tags where found.
	* @return an array of tags.
	*/
	function get_topic_tag_names($topic_id)
	{
		$this->db->select("tag_names.name");
		$this->db->from("tagged_topics");
		$this->db->join("tag_names", "tagged_topics.tag_id = tag_names.id");

		$this->db->where("topic_id",$topic_id);
		$query = $this->db->get();
		if($query->num_rows() < 1) {
			throw new Exception("No tags found for topic.");
		}
		$tags = array();
		foreach($query->result_array() as $tag) {
			array_push($tags,$tag['name']);
		}
		return $tags;

	}
}
