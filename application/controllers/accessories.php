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
			array('img' => 'acc-casemate.jpg', 'alt' => 'Case Mate', 'url' => '#'),
			array('img' => 'acc-incipio.jpg', 'alt' => 'Incipio', 'url' => '#'),
			array('img' => 'acc-lifeproof.jpg', 'alt' => 'Puregear', 'url' => '#'),
			array('img' => 'acc-puregear.jpg', 'alt' => 'Puregear', 'url' => '#'),
			array('img' => 'acc-iluv.jpg', 'alt' => 'iLuv', 'url' => '#'),
			array('img' => 'acc-belkin.jpg', 'alt' => 'Belkin', 'url' => '#'),
			array('img' => 'acc-griffin.jpg', 'alt' => 'Griffin', 'url' => '#'),
			array('img' => 'acc-shield.jpg', 'alt' => 'Zagg', 'url' => '#')
	);
	
	/** IMAGES FOR DISPLAY PROTECTION **/
	var $display_images = array(
			array('img' => 'acc-speck.jpg', 'alt' => 'Speck', 'url' => '#'),
			array('img' => 'acc-incase.jpg', 'alt' => 'Incase', 'url' => '#'),
			array('img' => 'acc-body-glove.jpg', 'alt' => 'Body Glove', 'url' => '#'),
			array('img' => 'acc-jabra.jpg', 'alt' => 'Jabra', 'url' => '#'),
			array('img' => 'acc-plantronics.jpg', 'alt' => 'Plantronics', 'url' => '#'),
			array('img' => 'acc-kingston.jpg', 'alt' => 'Kingston', 'url' => '#'),
			array('img' => 'acc-sandisk.jpg', 'alt' => 'Zagg', 'url' => '#'),
			array('img' => 'acc-skullcandy.jpg', 'alt' => 'Zagg', 'url' => '#')
	);
	
	/** IMAGES FOR HEADSETS **/
	var $headsets_images = array(
			array('img' => 'acc-speck.jpg', 'alt' => 'Speck', 'url' => '#'),
			array('img' => 'acc-incase.jpg', 'alt' => 'Incase', 'url' => '#'),
			array('img' => 'acc-body-glove.jpg', 'alt' => 'Body Glove', 'url' => '#'),
			array('img' => 'acc-jabra.jpg', 'alt' => 'Jabra', 'url' => '#'),
			array('img' => 'acc-plantronics.jpg', 'alt' => 'Plantronics', 'url' => '#'),
			array('img' => 'acc-kingston.jpg', 'alt' => 'Kingston', 'url' => '#'),
			array('img' => 'acc-sandisk.jpg', 'alt' => 'Zagg', 'url' => '#'),
			array('img' => 'acc-skullcandy.jpg', 'alt' => 'Zagg', 'url' => '#')
	);
	
	/** IMAGES FOR CHARGERS AND CABLES **/
	var $cables_images = array(
			array('img' => 'acc-speck.jpg', 'alt' => 'Speck', 'url' => '#'),
			array('img' => 'acc-incase.jpg', 'alt' => 'Incase', 'url' => '#'),
			array('img' => 'acc-body-glove.jpg', 'alt' => 'Body Glove', 'url' => '#'),
			array('img' => 'acc-jabra.jpg', 'alt' => 'Jabra', 'url' => '#'),
			array('img' => 'acc-plantronics.jpg', 'alt' => 'Plantronics', 'url' => '#'),
			array('img' => 'acc-kingston.jpg', 'alt' => 'Kingston', 'url' => '#'),
			array('img' => 'acc-sandisk.jpg', 'alt' => 'Zagg', 'url' => '#'),
			array('img' => 'acc-skullcandy.jpg', 'alt' => 'Zagg', 'url' => '#')
	);
	
	
	public function index($view='cases-covers-and-holsters')
	{
		if(array_key_exists($view, $this->accessories_cat)) {
			if($view == 'cases-covers-and-holsters') $this->data['images'] = $this->cases_images;
			else if($view == 'display-protection') $this->data['images'] = $this->display_images;
			else if($view == 'headsets') $this->data['images'] = $this->headsets_images;
			else if($view == 'chargers-and-cables') $this->data['images'] = $this->cables_images;
			else $this->data['images'] = array();
		} else {
			redirect('accessories');
		}
				
		$this->data['accessories_cat'] = $this->accessories_cat;
		$this->data['cat'] = $view;
		$this->load->view('accessories', $this->data);
	}
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */