<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Devices extends MY_Controller {
	
	var $categories = array(
		'smartphones' => 'Smartphones',
		'tablets' => 'Tablets',
		'hotspots' => 'Hotspots',
		'basic-phones' => 'Basic Phones',
		'home-phones' => 'Home Phone'
	);
	
	var $brands = array(
		'android' => 'Android',
		'apple' => 'Apple',
		'blackberry' => 'Blackberry',
		'htc' => 'HTC',
		'lg' => 'LG',
		'motorola' => 'Motorola',
		'pantech' => 'Pantech',
		'samsung' => 'Samsung',
		'windows-phone' => 'Windows Phone' 
	);
	
	public function index($cat='smartphones', $brand='android')
	{				
		if(!array_key_exists($cat, $this->categories)) {
			$this->session->set_flashdata('error', 'Categories is not valid or does not exists.'); 			
			redirect('devices');
		}
		
		if(!array_key_exists($brand, $this->brands)) {
			$this->session->set_flashdata('error', 'Brand is not valid or does not exists.'); 
			redirect('devices');
		}
		/*
		$this->data['phones'] = array(
		
			0 => array(
				'name' => 'Samsung Galaxy SIII',
				'img' => 'galaxy-large.png',
				'type' => 'android',
				'price' => '$199.99',
				'duration' => 'w 2yr. contract',
				'desc' => 'Whether it\'s handling many tasks at once, playing your favorite games smoothly, loading apps in a flash or quickly capturing photos and HD video, the Samsung Galaxy S III has the strength to make every action seem effortless.'
				
			),
			
			1 => array(
				'name' => 'Samsung Galaxy Stellar',
				'img' => 'stellar-large.png',
				'type' => 'android',
				'price' => '$129.99',
				'duration' => 'w 2yr. contract',
				'desc' => 'Whether it\'s handling many tasks at once, playing your favorite games smoothly, loading apps in a flash or quickly capturing photos and HD video, the Samsung Galaxy S III has the strength to make every action seem effortless.'
				
			),
			
			2 => array(
				'name' => 'Samsung Galaxy Nexus',
				'img' => 'nexus-large.png',
				'type' => 'android',
				'price' => '$229.99',
				'duration' => 'w 4yr. contract',
				'desc' => 'Whether it\'s handling many tasks at once, playing your favorite games smoothly, loading apps in a flash or quickly capturing photos and HD video, the Samsung Galaxy S III has the strength to make every action seem effortless.'
				
			),
			
			3 => array(
				'name' => 'Samsung Stratosphere',
				'img' => 'stratosphere-large.png',
				'type' => 'android',
				'price' => '$329.99',
				'duration' => 'w 5yr. contract',
				'desc' => 'Whether it\'s handling many tasks at once, playing your favorite games smoothly, loading apps in a flash or quickly capturing photos and HD video, the Samsung Galaxy S III has the strength to make every action seem effortless.'
			),
			
			4 => array(
				'name' => 'Samsung Galaxy SIII',
				'img' => 'galaxy-large.png',
				'type' => 'android',
				'price' => '$199.99',
				'duration' => 'w 2yr. contract',
				'desc' => 'Whether it\'s handling many tasks at once, playing your favorite games smoothly, loading apps in a flash or quickly capturing photos and HD video, the Samsung Galaxy S III has the strength to make every action seem effortless.'
				
			),
			
			5 => array(
				'name' => 'Samsung Galaxy Stellar',
				'img' => 'stellar-large.png',
				'type' => 'android',
				'price' => '$129.99',
				'duration' => 'w 2yr. contract',
				'desc' => 'Whether it\'s handling many tasks at once, playing your favorite games smoothly, loading apps in a flash or quickly capturing photos and HD video, the Samsung Galaxy S III has the strength to make every action seem effortless.'
				
			),
			
			6 => array(
				'name' => 'Samsung Galaxy Nexus',
				'img' => 'nexus-large.png',
				'type' => 'android',
				'price' => '$229.99',
				'duration' => 'w 4yr. contract',
				'desc' => 'Whether it\'s handling many tasks at once, playing your favorite games smoothly, loading apps in a flash or quickly capturing photos and HD video, the Samsung Galaxy S III has the strength to make every action seem effortless.'
				
			),
			
			7 => array(
				'name' => 'Samsung Stratosphere',
				'img' => 'stratosphere-large.png',
				'type' => 'android',
				'price' => '$329.99',
				'duration' => 'w 5yr. contract',
				'desc' => 'Whether it\'s handling many tasks at once, playing your favorite games smoothly, loading apps in a flash or quickly capturing photos and HD video, the Samsung Galaxy S III has the strength to make every action seem effortless.'
			),
			
			8 => array(
				'name' => 'Samsung Galaxy Nexus',
				'img' => 'nexus-large.png',
				'type' => 'apple',
				'price' => '$229.99',
				'duration' => 'w 4yr. contract',
				'desc' => 'Whether it\'s handling many tasks at once, playing your favorite games smoothly, loading apps in a flash or quickly capturing photos and HD video, the Samsung Galaxy S III has the strength to make every action seem effortless.'
				
			),
			
			9 => array(
				'name' => 'Samsung Stratosphere',
				'img' => 'stratosphere-large.png',
				'type' => 'apple',
				'price' => '$329.99',
				'duration' => 'w 5yr. contract',
				'desc' => 'Whether it\'s handling many tasks at once, playing your favorite games smoothly, loading apps in a flash or quickly capturing photos and HD video, the Samsung Galaxy S III has the strength to make every action seem effortless.'
			),
			
			10 => array(
				'name' => 'Samsung Galaxy Nexus',
				'img' => 'nexus-large.png',
				'type' => 'blackberry',
				'price' => '$229.99',
				'duration' => 'w 4yr. contract',
				'desc' => 'Whether it\'s handling many tasks at once, playing your favorite games smoothly, loading apps in a flash or quickly capturing photos and HD video, the Samsung Galaxy S III has the strength to make every action seem effortless.'
				
			),
			
			11 => array(
				'name' => 'Samsung Stratosphere',
				'img' => 'stratosphere-large.png',
				'type' => 'blackberry',
				'price' => '$329.99',
				'duration' => 'w 5yr. contract',
				'desc' => 'Whether it\'s handling many tasks at once, playing your favorite games smoothly, loading apps in a flash or quickly capturing photos and HD video, the Samsung Galaxy S III has the strength to make every action seem effortless.'
			),
			
			12 => array(
				'name' => 'Samsung Galaxy Nexus',
				'img' => 'nexus-large.png',
				'type' => 'blackberry',
				'price' => '$229.99',
				'duration' => 'w 4yr. contract',
				'desc' => 'Whether it\'s handling many tasks at once, playing your favorite games smoothly, loading apps in a flash or quickly capturing photos and HD video, the Samsung Galaxy S III has the strength to make every action seem effortless.'
				
			),
			
			13 => array(
				'name' => 'Samsung Stratosphere',
				'img' => 'stratosphere-large.png',
				'type' => 'blackberry',
				'price' => '$329.99',
				'duration' => 'w 5yr. contract',
				'desc' => 'Whether it\'s handling many tasks at once, playing your favorite games smoothly, loading apps in a flash or quickly capturing photos and HD video, the Samsung Galaxy S III has the strength to make every action seem effortless.'
			),
			
			14 => array(
				'name' => 'Samsung Galaxy Nexus',
				'img' => 'nexus-large.png',
				'type' => 'htc',
				'price' => '$229.99',
				'duration' => 'w 4yr. contract',
				'desc' => 'Whether it\'s handling many tasks at once, playing your favorite games smoothly, loading apps in a flash or quickly capturing photos and HD video, the Samsung Galaxy S III has the strength to make every action seem effortless.'
				
			),
			
			15 => array(
				'name' => 'Samsung Stratosphere',
				'img' => 'stratosphere-large.png',
				'type' => 'lg',
				'price' => '$329.99',
				'duration' => 'w 5yr. contract',
				'desc' => 'Whether it\'s handling many tasks at once, playing your favorite games smoothly, loading apps in a flash or quickly capturing photos and HD video, the Samsung Galaxy S III has the strength to make every action seem effortless.'
			),
			
			16 => array(
				'name' => 'Samsung Stratosphere',
				'img' => 'stratosphere-large.png',
				'type' => 'motorola',
				'price' => '$329.99',
				'duration' => 'w 5yr. contract',
				'desc' => 'Whether it\'s handling many tasks at once, playing your favorite games smoothly, loading apps in a flash or quickly capturing photos and HD video, the Samsung Galaxy S III has the strength to make every action seem effortless.'
			),
			
			17 => array(
				'name' => 'Samsung Stratosphere',
				'img' => 'stratosphere-large.png',
				'type' => 'motorola',
				'price' => '$329.99',
				'duration' => 'w 5yr. contract',
				'desc' => 'Whether it\'s handling many tasks at once, playing your favorite games smoothly, loading apps in a flash or quickly capturing photos and HD video, the Samsung Galaxy S III has the strength to make every action seem effortless.'
			),
			
			18 => array(
				'name' => 'Samsung Stratosphere',
				'img' => 'stratosphere-large.png',
				'type' => 'motorola',
				'price' => '$329.99',
				'duration' => 'w 5yr. contract',
				'desc' => 'Whether it\'s handling many tasks at once, playing your favorite games smoothly, loading apps in a flash or quickly capturing photos and HD video, the Samsung Galaxy S III has the strength to make every action seem effortless.'
			),
			
			19 => array(
				'name' => 'Samsung Stratosphere',
				'img' => 'stratosphere-large.png',
				'type' => 'pantech',
				'price' => '$329.99',
				'duration' => 'w 5yr. contract',
				'desc' => 'Whether it\'s handling many tasks at once, playing your favorite games smoothly, loading apps in a flash or quickly capturing photos and HD video, the Samsung Galaxy S III has the strength to make every action seem effortless.'
			),
			
			20 => array(
				'name' => 'Samsung Stratosphere',
				'img' => 'stratosphere-large.png',
				'type' => 'samsung',
				'price' => '$329.99',
				'duration' => 'w 5yr. contract',
				'desc' => 'Whether it\'s handling many tasks at once, playing your favorite games smoothly, loading apps in a flash or quickly capturing photos and HD video, the Samsung Galaxy S III has the strength to make every action seem effortless.'
			),
			
			21 => array(
				'name' => 'Samsung Stratosphere',
				'img' => 'stratosphere-large.png',
				'type' => 'samsung',
				'price' => '$329.99',
				'duration' => 'w 5yr. contract',
				'desc' => 'Whether it\'s handling many tasks at once, playing your favorite games smoothly, loading apps in a flash or quickly capturing photos and HD video, the Samsung Galaxy S III has the strength to make every action seem effortless.'
			),
			
			22 => array(
				'name' => 'Samsung Stratosphere',
				'img' => 'stratosphere-large.png',
				'type' => 'windows-phone',
				'price' => '$329.99',
				'duration' => 'w 5yr. contract',
				'desc' => 'Whether it\'s handling many tasks at once, playing your favorite games smoothly, loading apps in a flash or quickly capturing photos and HD video, the Samsung Galaxy S III has the strength to make every action seem effortless.'
			),
			
			23 => array(
				'name' => 'Samsung Stratosphere',
				'img' => 'stratosphere-large.png',
				'type' => 'windows-phone',
				'price' => '$329.99',
				'duration' => 'w 5yr. contract',
				'desc' => 'Whether it\'s handling many tasks at once, playing your favorite games smoothly, loading apps in a flash or quickly capturing photos and HD video, the Samsung Galaxy S III has the strength to make every action seem effortless.'
			)
			
		);*/
		
		foreach($this->Phones->types as $id => $type) {
			if($type['name'] == $cat) { $cat_id = $id; break;}
		}
		
		foreach($this->Phones->brands as $id => $pbrand) {
			//pr($brand['name']);
			if($pbrand['name'] == $brand) { $brand_id = $id; break;}
		}
		//pr($brand_id);
		//pr($cat_id);
		
		$this->data['id_brands'] = $this->Phones->brands;
		$this->data['id_types'] = $this->Phones->types;
		
		$this->data['phones'] = $this->db->select('*')
			->where(array('type_id' => $cat_id) )
			->from('phones')->get()->result_array();
			
		$phones = $this->data['phones'];
		
		if(issetNotEmpty($phones[0]) && !$this->uri->rsegment(4)) {
			$brand = $this->data['id_brands'][$this->data['phones'][0]['brand_id']]['name'];
			$brands = array();
			//setup $brands
			foreach($this->data['phones'] as $phone){
				$brand_name =$this->data['id_brands'][$phone['brand_id']]['name'];
				
				if(!in_array($brand_name, $brands)){
					$brands[] = $this->data['id_brands'][$phone['brand_id']]['name'];
				}
			}
		}
		//pr($brands);
		//set data to view
		//pr($this->data['phones']);
		$this->data['cat'] = $cat;
		$this->data['brand'] = $brand;
		$this->data['categories'] = $this->categories;
		$this->data['brands'] = $this->brands;
		$this->load->view('devices', $this->data);
	}
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */