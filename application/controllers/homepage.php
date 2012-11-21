<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Homepage extends MY_Controller {
	
	
	public function index()
	{
		$this->load->view('homepage');
	}
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */