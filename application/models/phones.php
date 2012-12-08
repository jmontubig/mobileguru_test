<?php 

/**
 * Phones Model
 *
 * This model handles read and write functions for Phones Object
 *
 */
class Phones extends MY_Model
{
	var $table_name = 'phones';
	var $alias = 'Phones';
	
	
	var $types = array(
		1 => array('name'=>'smartphones', 'label'=>'Smartphones'),
		2 => array('name'=>'tablets', 'label'=>'Tablets'),
		3 => array('name'=>'hotspots', 'label'=>'Hotspots'),
		4 => array('name'=>'basic-phones', 'label'=>'Basic Phones'),
		5 => array('name'=>'home-phones', 'label'=>'Home Phone'),
	);
	
	var $brands = array(
		1 => array('name'=>'android', 'label'=>'Android'),
		2 => array('name'=>'apple', 'label'=>'Apple'),
		3 => array('name'=>'blackberry', 'label'=>'Blackberry'),
		4 => array('name'=>'htc', 'label'=>'HTC'),
		5 => array('name'=>'lg', 'label'=>'LG'),
		6 => array('name'=>'motorola', 'label'=>'Motorola'),
		7 => array('name'=>'pantech', 'label'=>'Pantech'),
		8 => array('name'=>'samsung', 'label'=>'Samsung'),
		9 => array('name'=>'windows-phone', 'label'=>'Windows Phone') 
	);
	
	var $display_fields = array(
			'image' => 'Phone Image',
			'name' => 'Name',
			'brand_id' => 'Brand',
			'type_id' => 'Type',
			'descp' => 'Description',
			'price' => 'Price',
			'duration' => 'Duration'
			
	);
	
	function __construct()
	{		 
		parent::__construct();
		$this->set_field_rules();
		$this->set_rule_message();
		

	}
	
	/** 
     * Function to get all docs for pagination purposes.
     * @param Integer $num
     * @param Integer $offset
     * @param string $order_by
     * @param Array $where
     * @return Object  
     */
	function get_data($table, $num=null, $offset=null, $order_by = null, $where = null, $like=null){
	   
	   if(empty($order_by)) { $order_by = 'modified desc'; } 
	   
	   //$table = $this->table_name; 
	   $qtext = '';
	   $this->db->select($table.'.*,');
	   
	   if(!empty($where)) { $this->db->where($where); }
	   if(!empty($like)) {
		foreach($like as $index => $text){
			$this->db->or_like($index, $text);
			$qtext = $text;
		}		
	   }

	   $this->db->group_by($this->table_name.'.id');
	   $this->db->from($table);
	   $this->db->order_by($order_by);
	   
	   
	   
	   if(!empty($num) || !empty($offset) )$this->db->limit($num, $offset);
	   
	   
		   
	   $query = $this->db->get()->result_array();
	   
	   //pr($this->db->last_query());
	   return $this->convertBrandsTypes($query);
	}
	
	function convertBrandsTypes($phones){
		if(!is_array($phones)) return array();
		$out = $phones;
		foreach($phones as $i => $phone) {
			$out[$i]['brand_id'] =  array( 
				'id' => $phone['brand_id'],
				'name' => $this->brands[$phone['brand_id']]['name'],
				'label' => $this->brands[$phone['brand_id']]['label']
			);
			
			$out[$i]['type_id'] =  array( 
				'id' => $phone['type_id'],
				'name' => $this->types[$phone['type_id']]['name'],
				'label' => $this->types[$phone['type_id']]['label']
			);
		}
		
		return $out;
	}
	
	function getBrandList(){
		$out = array();
		foreach($this->brands as $id => $brand){
			$out[$id] = $brand['label'];
		}
		
		return $out;
	}
	
	function getTypeList(){
		$out = array();
		foreach($this->types as $id => $type){
			$out[$id] = $type['label'];
		}
		
		return $out;
	}
	
	
	/** VALIDATION FUNCTIONS **/
	/**
     * Function to set the required fields for the object
     * @param type $fields 
     */
    function set_required_fields($fields = array()) {
        if(empty($fields)){
            $this->required_fields = array(
                'image' => 'Phone Image',
				'name' => 'Name',
				'brand_id' => 'Brand',
				'type_id' => 'Type',
				'descp' => 'Description',
				'price' => 'Price',
				'duration' => 'Duration'
            );
        }
    }
    
    /**
     * Function to set main field rules for form validation.
     * @param array $rules 
     */
    function set_field_rules($rules=null){
        if(empty($rules)){               
             $this->field_rules['name'] = array('required','max_length[100]', 'min_length[2]');
			 $this->field_rules['descp'] = array('required','max_length[600]', 'min_length[2]');
			 $this->field_rules['price'] = array('required','max_length[20]', 'min_length[1]');
             $this->field_rules['image'] = array('required');
             $this->field_rules['duration'] = array('required');
             $this->field_rules['brand_id'] = array('required');
			 $this->field_rules['type_id'] = array('required');
             
        } else {
            $this->field_rules = $rules;
        }
    }
    
    /**
     * Function to set up rule messages used for form validation
     * @param array $messages 
     */
    function set_rule_message($messages=null){
        if(empty($messages)){                                
             $this->rule_messages['name'] = array(
                    'required' => $this->display_fields['name'] . ' is required.',
                    'max_length[100]' => 'The maximum character is 100 characters only.',
                    'min_length[2]' => 'The minimum character is 2 characters only.'
                );
			$this->rule_messages['descp'] = array(
                    'required' => $this->display_fields['descp'] . ' is required.',
                    'max_length[100]' => 'The maximum character is 100 characters only.',
                    'min_length[2]' => 'The minimum character is 2 characters only.'
                );
			$this->rule_messages['price'] = array(
                    'required' => $this->display_fields['price'] . ' is required.',
                    'max_length[20]' => 'The maximum character is 20 characters only.',
                    'min_length[1]' => 'The minimum character is 1 characters only.'
                );
             $this->rule_messages['descp'] = array(
                    'required' => $this->display_fields['descp'] .' is required.'
             );
             $this->rule_messages['image'] = array(
                    'required' => $this->display_fields['image'] .' is required.'
             );
             $this->rule_messages['duration'] = array(
                    'required' => $this->display_fields['duration'] .' is required.'
             );
             $this->rule_messages['brand_id'] = array(
                    'required' => $this->display_fields['brand_id'] .' is required.'   
             );
			  $this->rule_messages['type_id'] = array(
                    'required' => $this->display_fields['type_id'] .' is required.'   
             );
        } else {
            $this->rule_messages = $messages;
        }
    }
    
    /**
     * Prototype Function for adding callbacks to model's form validation array. try this when needed.
     * But, in any case, if you dont want to mess up your controller for callback functions, just extend form_validation class
     * and declare your functions there, and call them like a normal function in setting rules. 
     * @param Array $callbacks 
     */
    function set_field_callback($callbacks=null){
          if(empty($callbacks)){                  
             //$this->field_callbacks['name'] = 'test_callback';
             //$this->field_callbacks['document_ref_number'] = 'is_unique[document_ref_number]';
          } else {
            $this->field_callbacks = $callbacks;
        }
     }
	 
	 
	/**
      * Function to set up form validation rules used for an existing instance of $form_validation 
      * which is reference to a form_validation class declared somewhere in controller
	  * In order for this to work, setup the ff variables:
	  * 	$field_rules 
	  * 
      * @param Object $form_validation
      * @param Array $ignore_lists 
      */
    function set_form_validation(&$form_validation, $ignore_lists = array() ){
        //$this->set_field_callback();
        foreach($this->required_fields as $field => $field_label){            
            $form_rules ='';
            $form_callbacks = '';
             $ra_count = 0;
            
            /** SETUP FORM RULES HERE **/
            foreach($this->field_rules[$field] as $rule){
                $form_rules .= $rule;
                //pr(count($rule_array));
                //pr('cnt=' . $ra_count);
                if($ra_count < count($this->field_rules[$field])-1){  $form_rules .= '|'; }
                $ra_count++;                    
            }
            
            /** SETUP CALLBACKS HERE **/
            if(isset($this->field_callbacks[$field])){
                 $form_rules .= '|' . $this->field_callbacks[$field];
            }
            
            if(!in_array($field, $ignore_lists)){
                /** SET FORM VALIDATION RULES HERE **/                        
                $form_validation->set_rules($field, $field_label, $form_rules);
                //pr( 'RULES : ' . $field . ' => ' .$form_rules);
            }
            
           
            
            
            /** SETUP FORM ERROR MESSAGES HERE  
            foreach($this->rule_messages[$field] as $rule => $msg){
                $form_validation->set_message($rule, $msg);
                //pr( 'MESSAGE : ' . $field .' : '. $rule .' => ' .$msg);             
            }
            **/
            
            //echo '=============================';
        }
        
        //prd($this->form_validation->_field_data);
        //die();
    }
}