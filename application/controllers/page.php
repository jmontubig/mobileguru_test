<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Page extends MY_Controller {
		
	public function index($view='cases-covers-and-holsters')
	{

		
		$this->load->view($view, $this->data);
	}
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */