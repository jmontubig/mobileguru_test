<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Plans extends MY_Controller {
	
	
	public function index()
	{
				
		
		$this->load->view('plans', $this->data);
	}
}

/* End of file plans.php */
/* Location: ./application/controllers/plans.php */