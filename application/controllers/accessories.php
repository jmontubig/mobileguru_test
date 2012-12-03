<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Accessories extends MY_Controller {
	
	var $accessories_cat = array(
		'cases-covers-and-holsters' => 'Cases, Covers and Holsters',
		'display-protection' => 'Display Protection',
		'headsets' => 'Headsets',
		'chargers-and-cables' => 'Chargers and Cables'
	);
	
	/** IMAGES FOR CASES **/
	var $cases_images = array(
			'first' => array('img' => 'acc-casemate.jpg', 'alt' => 'Case Mate', 'url' => '#', 'type' => 'cases-covers-and-holsters'),
			array('img' => 'acc-incipio.jpg', 'alt' => 'Incipio', 'url' => '#', 'type' => 'cases-covers-and-holsters'),
			array('img' => 'acc-lifeproof.jpg', 'alt' => 'Puregear', 'url' => '#', 'type' => 'cases-covers-and-holsters'),
			array('img' => 'acc-puregear.jpg', 'alt' => 'Puregear', 'url' => '#', 'type' => 'cases-covers-and-holsters'),
			array('img' => 'acc-iluv.jpg', 'alt' => 'iLuv', 'url' => '#', 'type' => 'cases-covers-and-holsters'),
			array('img' => 'acc-belkin.jpg', 'alt' => 'Belkin', 'url' => '#', 'type' => 'cases-covers-and-holsters'),
			array('img' => 'acc-griffin.jpg', 'alt' => 'Griffin', 'url' => '#', 'type' => 'cases-covers-and-holsters'),
			array('img' => 'acc-shield.jpg', 'alt' => 'Zagg', 'url' => '#', 'type' => 'cases-covers-and-holsters')
	);
	
	/** IMAGES FOR DISPLAY PROTECTION **/
	var $display_images = array(
			'first' => array('img' => 'acc-speck.jpg', 'alt' => 'Speck', 'url' => '#', 'type' => 'display-protection'),
			array('img' => 'acc-incase.jpg', 'alt' => 'Incase', 'url' => '#', 'type' => 'display-protection'),
			array('img' => 'acc-body-glove.jpg', 'alt' => 'Body Glove', 'url' => '#', 'type' => 'display-protection'),
			array('img' => 'acc-jabra.jpg', 'alt' => 'Jabra', 'url' => '#', 'type' => 'display-protection'),
			array('img' => 'acc-plantronics.jpg', 'alt' => 'Plantronics', 'url' => '#', 'type' => 'display-protection'),
			array('img' => 'acc-kingston.jpg', 'alt' => 'Kingston', 'url' => '#', 'type' => 'display-protection'),
			array('img' => 'acc-sandisk.jpg', 'alt' => 'Zagg', 'url' => '#', 'type' => 'display-protection'),
			array('img' => 'acc-skullcandy.jpg', 'alt' => 'Zagg', 'url' => '#', 'type' => 'display-protection')
	);
	
	/** IMAGES FOR HEADSETS **/
	var $headsets_images = array(
			'first' => array('img' => 'acc-speck.jpg', 'alt' => 'Speck', 'url' => '#', 'type' => 'headsets'),
			array('img' => 'acc-incase.jpg', 'alt' => 'Incase', 'url' => '#', 'type' => 'headsets'),
			array('img' => 'acc-body-glove.jpg', 'alt' => 'Body Glove', 'url' => '#', 'type' => 'headsets'),
			array('img' => 'acc-jabra.jpg', 'alt' => 'Jabra', 'url' => '#', 'type' => 'headsets'),
			array('img' => 'acc-plantronics.jpg', 'alt' => 'Plantronics', 'url' => '#', 'type' => 'headsets'),
			array('img' => 'acc-kingston.jpg', 'alt' => 'Kingston', 'url' => '#', 'type' => 'headsets'),
			array('img' => 'acc-sandisk.jpg', 'alt' => 'Zagg', 'url' => '#', 'type' => 'headsets'),
			array('img' => 'acc-skullcandy.jpg', 'alt' => 'Zagg', 'url' => '#', 'type' => 'headsets')
	);
	
	/** IMAGES FOR CHARGERS AND CABLES **/
	var $cables_images = array(
			'first' => array('img' => 'acc-speck.jpg', 'alt' => 'Speck', 'url' => '#', 'type' => 'chargers-and-cables'),
			array('img' => 'acc-incase.jpg', 'alt' => 'Incase', 'url' => '#', 'type' => 'chargers-and-cables'),
			array('img' => 'acc-body-glove.jpg', 'alt' => 'Body Glove', 'url' => '#', 'type' => 'chargers-and-cables'),
			array('img' => 'acc-jabra.jpg', 'alt' => 'Jabra', 'url' => '#', 'type' => 'chargers-and-cables'),
			array('img' => 'acc-plantronics.jpg', 'alt' => 'Plantronics', 'url' => '#', 'type' => 'chargers-and-cables'),
			array('img' => 'acc-kingston.jpg', 'alt' => 'Kingston', 'url' => '#', 'type' => 'chargers-and-cables'),
			array('img' => 'acc-sandisk.jpg', 'alt' => 'Zagg', 'url' => '#', 'type' => 'chargers-and-cables'),
			array('img' => 'acc-skullcandy.jpg', 'alt' => 'Zagg', 'url' => '#', 'type' => 'chargers-and-cables')
	);
	
	
	public function index($view='cases-covers-and-holsters')
	{
		if(!array_key_exists($view, $this->accessories_cat)) {
			$this->session->set_flashdata('error', 'Categories is not valid or does not exists.'); 			
			redirect('accessories');		
		}
		
		$this->data['images']['cases_images'] = $this->cases_images;
		$this->data['images']['display_images'] = $this->display_images;
		$this->data['images']['headsets'] = $this->headsets_images;
		$this->data['images']['cables_images'] = $this->cables_images;
		
		
		$this->data['accessories_cat'] = $this->accessories_cat;
		$this->data['cat'] = $view;
		$this->load->view('accessories', $this->data);
	}
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */