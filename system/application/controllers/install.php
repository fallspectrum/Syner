<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
* This file is used to describe the Install class.
*/

class Install extends Controller
{
	function _ci_initialize() 
	{
		// Assign all the class objects that were instantiated by the
		// front controller to local class variables so that CI can be
		// run as one big super object.
		$classes = array(
				    'config'    => 'Config',
				    'input'     => 'Input',
				    'benchmark' => 'Benchmark',
				    'uri'       => 'URI',
				    'output'    => 'Output',
				    'lang'      => 'Language',
				    'router'    => 'Router'
				    );
		
		foreach ($classes as $var => $class)
		{
		    $this->$var =& load_class($class);
		}

		// In PHP 5 the Loader class is run as a discreet
		// class.  In PHP 4 it extends the Controller
		if (floor(phpversion()) >= 5)
		{
		    $this->load =& load_class('Loader');
		}
		else
		{
		    // sync up the objects since PHP4 was working from a copy
		    foreach (array_keys(get_object_vars($this)) as $attribute)
		    {
			if (is_object($this->$attribute))
			{
			    $this->load->$attribute =& $this->$attribute;
			}
		    }
		}

	}
	
	function Install() 
	{
		parent::Controller();
	}

	function index() 
	{
		echo "Dropping old tables...<br>";
		$this->_drop_old_tables();
		echo "Creating new tables... <br>";
		$this->_create_tables();
		echo "Database creation is done.";
		echo "Please delete the installation controller, located at " . $this->config->item('SY_SITEPATH') . "system/application/controllers/install.php, so the wizard can't be run again.";
	}

	/**
	* This function is used to drop the old tables from the database described in database.php
	*/
	function _drop_old_tables() 
	{
		$this->load->dbforge();
		$this->dbforge->drop_table("pending_users");
		$this->dbforge->drop_table("users");
		$this->dbforge->drop_table("tag_names");
		$this->dbforge->drop_table("tagged_topics");
		$this->dbforge->drop_table("locations");
		$this->dbforge->drop_table("topics");
		$this->dbforge->drop_table("topic_subscriptions");
		$this->dbforge->drop_table("solutions");
		$this->dbforge->drop_table("solution_votes");
		$this->dbforge->drop_table("topic_contents");
		$this->dbforge->drop_table("topic_content_revisions");
		$this->dbforge->drop_table("solution_content_revisions");
		$this->dbforge->drop_table("ci_sessions");
	}
	
	/*
	* This function creates the necessary tables used by the program.
	*/
	function _create_tables() 
	{
	
		$filename = APPPATH.'models/dbinstall.sql';
		$file = fopen($filename, "r");
		$sql = fread($file, filesize($filename));
		$queries = explode(";", $sql);
		
		foreach($queries as $query)
		{
			if(!empty($query)) 
			{
				$this->db->simple_query($query) or die('<br /><h3>Error</h3><b>Query:</b> '.$query.'<br /><b>Error:</b> '.$this->db->_error_message()."<br />");
			}
		}
	}
}
?>
