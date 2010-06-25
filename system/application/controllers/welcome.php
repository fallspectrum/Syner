<?php

class Welcome extends Controller {

	function Welcome()
	{
		parent::Controller();	
	}
	
	function index()
	{
		$data['content'] = $this->load->view('welcome_message', '', true);
		$this->load->view('layout', $data);
	}
}

/* End of file welcome.php */
/* Location: ./system/application/controllers/welcome.php */