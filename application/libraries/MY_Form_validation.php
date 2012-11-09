<?php

class MY_Form_validation extends CI_Form_validation {
	
	var $upload_config = array(
		'upload_path' => './uploads/',
		'allowed_types' => 'gif|jpg|png',
		'max_size' => '2000',
		'max_width' => '1024',
		'max_height' => '768'
	);
	
	/**
	 *  Type of Image
		1 = GIF	5 = PSD	9 = JPC	13 = SWC
		2 = JPG	6 = BMP	10 = JP2	14 = IFF
		3 = PNG	7 = TIFF(intel byte order)	11 = JPX	15 = WBMP
		4 = SWF	8 = TIFF(motorola byte order)	 12 = JB2	16 = XBM
	 * 
	 */ 
	var $allowed_types = array(1,2,3);//gif|jpg|png
	//If needed a different file types, re-assigned new values to 
	//$this->form_validation->allowed_types = array(....new lists of allowed types...);
	//before running any validation or using the callback functions
	
/**
  * Numeric
  *
  * @access    public
  * @param    int
  * @return    bool
  */    
  function numeric_unsigned($str)
  {
    // original code..
    // return ( ! ereg("^[0-9\.]+$", $str)) ? FALSE : TRUE;
   
    return ( ! ereg("^\-*[0-9\.]+$", $str)) ? FALSE : TRUE;
  }
  
  function check_file_size($str, $name){
	$config = $this->upload_config;
	
	if(isset($_FILES[$name]['size']) && $_FILES[$name]['size']>0)
    {
		if($_FILES[$name]['size'] > $config['max_size'] ) { return false; }
		else return true;
	}
	
	return false;
  }
  
  function check_file_format($str, $name){
	$config = $this->upload_config;
		
	if(isset($_FILES[$name]['size']) && $_FILES[$name]['size']>0)
    {
		list($width, $height, $type, $attr) = getimagesize($_FILES[$name]['tmp_name']);
		if($width > $config['max_width'] ) { return false; }
		if($height > $config['max_height'] ) { return false; }
		if(!in_array($type, $this->allowed_types) ) { return false; }
		return true;
	}
  }
  
  /**
	 * Function to check header size if valid
	 * Will only check $_FILES['headerfile'] index
	 *  [headerfile] => Array
        (
            [name] => product-pic.jpg
            [type] => image/jpeg
            [tmp_name] => C:\xampp\tmp\phpD98E.tmp
            [error] => 0
            [size] => 12037
        )
	 */
	function check_header_size($str){
		$config=array(
			'upload_path' => './uploads/',
			'allowed_types' => 'gif|jpg|png',
			'max_size'	=> '800000',
			'max_width'  => '3024',
			'max_height'  => '3768'
		);
		
		if( isset($_FILES['headerfile']) && !empty($_FILES['headerfile']) ) {
			list($width, $height, $type, $attr) = getimagesize($_FILES['headerfile']['tmp_name']);
			if($width < $config['max_width']) return FALSE;
			if($height < $config['max_height']) return FALSE;
			if($_FILES['headerfile']['size'] > $config['max_size']) return FALSE;			
			
			return TRUE;
		}
		
		return FALSE;
		
		
	}
  

}