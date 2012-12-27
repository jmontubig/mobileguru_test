<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Homepage extends MY_Controller {
	
	
	public function index()
	{
		$this->data['id_brands'] = $this->Phones->brands;
		$this->data['id_types'] = $this->Phones->types;		
			
		//pr($this->data['phones']);
		if(issetNotEmpty($this->data['phones'][0])) {
			$brand = $this->data['id_brands'][$this->data['phones'][0]['brand_id']]['name'];
		}
		
		
		$this->data['phones'] = $this->Phones->get_all(null, false);
		$this->data['banners'] = $this->Homepages->get_all(null, false);	
		$this->load->view('homepage', $this->data);
	}
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */