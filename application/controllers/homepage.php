<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Homepage extends MY_Controller {
	
	
	public function index()
	{
		
		$this->data['banners'] = $this->Homepages->get_all(null, false);	
		$this->load->view('homepage', $this->data);
	}
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */