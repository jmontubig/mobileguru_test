<?php 

/**
 * Homepage Model
 *
 * This model handles read and write functions for Homepage Object
 *
 */
class Homepages extends MY_Model
{
	var $table_name = 'homepages';
	var $alias = 'Homepages';
	
	function __construct()
	{		 
		parent::__construct();
		//set class scope variables
		$this->display_field = 'small_text';
		

	}
}