<?php 

/**
 * Extending the CI Model
 *
 * This parent model is responsible for custom functions that are added by Jonathan Montubig.
 * These functions includes, the Event Tracking Systems, and upload Functionality for a certain model.
 * To use these functions, just extends your model with MY_Model, so declaring your model like these:
 *      class Docs extends MY_Model {
 *          //your functions and variables here....
 *       }
 * To use Event Tracking functionality, on your model just set:
 * 
 *      $this->track_mo_ko = true;
 * 
 * Or in your controller's __contruct function set:
 * 
 *       $this->{model_name}->track_mo_ko = true;
 * 
 * where model_name will be replaced with your model name that extends MY_Model
 * 
 * To use the Upload Functionality, on your model's __construct function  just set:
 * 
 *      $this->upload_mo_ko = true;
 * 
 * Or in your controller's __contruct function set:
 * 
 *       $this->{model_name}->upload_mo_ko = true;
 * 
 * where model_name will be replaced with your model name that extends MY_Model
 * Just make sure that you have Upload model created and a table named 'uploads' by default.
 * To configure the upload table, you can set these at your __construct function in either controller or model:
 *  
 *      $this->{model_name}->upload_table = 'upload_table_name'; // set on controller
 *      $this->upload_table = 'upload_table_name'; // set on model
 * 
 *  For other configurations, just set the $upload_config variable:
 * 
 *      $this->upload_config['allowed_types'] = 'gif|jpg|png|zip|rar|pdf'; // accepted file types, defaults to gif,jpg,png,zip,rar,pdf
 *      $this->upload_config['max_size']	= '100000'; //maximum size, defaults to 100mb			
 *      $this->upload_config['upload_path'] = './uploads/'; //upload directory
 * 
 *  NOTE: There will be some edits on the controller and view, to make this works. 
 *  This also uses jQuery File Uploader, google it and see example on how it works in CI. Same idea was also used in here.
 *  Or if you do not have net, just see my source code here, the major files I've edit here are the upload controller and the upload view file for doc.
 * 
 * @copyright January 2012
 * @author Jonathan Montubig
 * 
 */
class MY_Model extends CI_Model
{
	//var $track_mo_ko = false;
	var $event_data = null;	
	var $data = null;
	
	var $old_data = null;
	var $event_id = null;
	var $user;
	var $id = null;
	var $dateFormat = 'Y-m-d H:i:s';
	
	//configs for upload functionality
	var $upload_mo_ko = false;
	var $track_mo_ko = false;
	var $upload_config = array();
	var $upload_table = 'uploads';
	
	var $display_field = 'name';
	var $display_fields = array();
	

	function __construct(){
		parent::__construct();
		//change this line to get the user id of the logged user
		$this->user = $this->jm->get_logged_user();	
			
		if($this->input->post(null, TRUE)) {
			$this->data = $this->input->post(null, TRUE); 			
		}

		//INITIALIZE UPLOAD VARIABLES
		$this->upload_config['allowed_types'] = 'gif|jpg|png|zip|rar|pdf';
		$this->upload_config['max_size']	= '100000';			
		$this->upload_config['upload_path'] = './uploads/';
	}
	
	/**
	 * 	Function to insert an element on a $table parameter or the calling Model
	 * 	@param array $data Data to be saved can be multiple or just a simple array
	 * 			DONT MIX multidimensional array with normal arrays will result to false
	 *			string $table name of the table to be save, if not specified will save 
	 *			to the calling model, provided that the name of the model is the same to table name
	 *	@param String $table name of the table where to insert the data,
	 *	By default, if not $table parameter is set, it will set it to the calling model, like:
	 *		$this->Doc->edit($data);
	 *	This line will automatically set the $table param to docs table.
	 *	
	 *	@note AS FOR NOW MULTIPLE CREATE IS DISABLED
	 *	@return boolean 
	 */
	function create($data, $table = null, $stripHTML = true) {	
		$this->data = $data;
		$this->event_id =0;
				
		if(empty($table)) {
			$table = strtolower(get_class($this));	
		}
		
		//check if a pure array
		if(!$this->is_valid_array($data)) { return false; } 
		
		//Saving single data
		if(count($data) && !$this->is_multi($data) ) {
			$data['created'] = date('Y-m-d H:i:s');
			$data['modified'] = $data['created'];
                        
                        //strip HTML tags
                        if($stripHTML) {
                            foreach($data as $e => $d){
                                $data[$e] = $this->jm->clean_string($d);                            
                             }

                        }

			if($this->db->insert($table, $data)) {
				$this->id = $this->db->insert_id();
				//kpag gustong magpatrack e di i-track mo				
                               ($this->track_mo_ko && $table == $this->get_model_name()) ? $this->__log_event() : null;	                                 				
				return true;
			} else {
				return false;
			}
			
		}
		
		//saving multiple data
		/*  DISABLED MUNA ANG MULTIPLE SAVES KASI DI NAMAN KELANGAN TO! */
		if(count($data) && $this->is_multi($data) ) {
			
			foreach($data as $key=>$row) {
				$data[$key]['created'] = date('Y-m-d H:i:s');
				$data[$key]['modified'] = $data[$key]['created'];
			}	
			
			//return $this->db->insert_batch($table, $data);
                        foreach($data as $savedData) {
                            if(!$this->create($savedData, $table)) return false; 
                        }
                        
                        return true;
		}	
				
	}
	
        /**
	 * 
	 * Function to edit an element on a $table parameter or the calling Model
	 * @param array $data Data to be saved can be multiple or just a simple array
	 * 			DONT MIX multidimensional array with normal arrays will result to false
	 *			string $table name of the table to be save, if not specified will save 
	 *			to the calling model, provided that the name of the model is the same to table name
	 *	@param String $table name of the table where to insert the data,
	 *	By default, if not $table parameter is set, it will set it to the calling model, like:
	 *		$this->Doc->edit($data);
	 *	This line will automatically set the $table param to docs table.
	 * 
	 * @note AS FOR NOW MULTIPLE CREATE IS DISABLED
	 * @return boolean 
	 * 
	 */
	function edit($data, $table = null, $stripHTML=true) {	
		$this->data = $data;//set the data
		$this->event_id =1;//set event to edit mode
		
		
		if(empty($table)) {
			$table = strtolower(get_class($this));	
		}
		
		//check if a pure array
		if(!$this->is_valid_array($data)) { return false; } 
		
		//Saving single data
		if(count($data) && !$this->is_multi($data) ) {
                        if($this->jm->check_field_exists('modified', $table)){
                            $data['modified'] = date('Y-m-d H:i:s');
                        }
			
                        $this->id = $data['id'];			
			unset($data['id']);
                        
			$this->old_data = $this->get($this->id, true);//set event to edit mode
			
                        //strip HTML tags
                        if($stripHTML) {
                            foreach($data as $e => $d){
                                $data[$e] = $this->jm->clean_string($d);                            
                             }

                        }
                        
                       
			//$this->db->where('id', $id);
			if($this->db->update($table, $data, array('id' => $this->id) )){
				//set log events                            
				($this->track_mo_ko && $table == $this->get_model_name()) ? $this->__log_event() : null;	                            
				return true;
			} else { return false; }
							
		}	
		
				
	}
        /**
         * Function to delete a record, note that when you have a deleted column on your table, 
         * It will do an update and set the deleted column to 1, setting a soft delete
         * If it doesnt find a deleted column, it will automatically delete the record.
         * 
         * FOR MULTIPLE DELETE, just set the $id to an array value like
         * 
         *     $tobeDeleted = array(1,,2,3,4,5,6);
         *     $this->Docs->delete($tobeDeleted);
         * 
         * Note that this can only input on the same table
         * 
         * @param Integer/Array $id 
         * @param String $table
         * @return type 
         */
        function delete($id, $table = null) {	
            $this->id = $id;//set the data
            $this->event_id =3;//set event to delete mode
            
           if(empty($table)) { $table = $this->get_model_name(); }
            
            //construct $data to be passed
            $data = array('deleted' => 1);
            
            //recursive multiple deletes
            if(is_array($id)){
                $output = true;
                foreach($id as $key => $did){
                    $this->db->where($key, $did);
                    if(!$this->db->delete($did, $table)) $output = false; 
                }                
                return $output;
            }
            
		
  
            
            //check if deleted column exists on the column, do update
            if($this->jm->check_field_exists('deleted', $table) && isset($this->soft_delete) && $this->soft_delete) {
                if($this->db->update($table, $data, array('id' => $this->id) )){ return true; } //no tracking on delete
                else { return false; }
            } else {
                //just delete the record                
                if($this->db->delete($table, array('id' => $this->id) )) { return true; }
                else { return false; }
            }
  
        }
        
         /**
         * Function to update and create multiple tables
         * @param Array $data
         *  You $data array should be formatted like these:
         *      $data = Array(
         *          [<table_name>] => array(
         *              .... fields .... 
         *          ),
         *           [<table_name>] => array(
         *              .... fields .... 
         *          ).....
         *      ) 
         */
        function process($data){
            $tmp = array();
            $return = true;
           
            foreach($data as $table => $fields){
                //if($table != $this->get_model_name() ) { $this->track_mo_ko = false; }
                //else {$this->track_mo_ko = true; } 
                if(is_array($fields)) {   
                    if(isset($data[$table]['id'])){                    
                        //update
                        if(!$this->edit($fields, $table)) $return = false;
                    } else {
                        //create
                         if(!$this->create($fields, $table))  $return = false;
                    }
                } else {
                     if(isset($data[$table]['id'])){                    
                        //update
                        if($this->edit($fields, $table)) return true;
                    } else {
                        //create
                         if($this->create($fields, $table))  return true;
                    }
                    
                    return false;
                }
            }
            
            return $return;
            
        }
    

	/** 
     * Function to get all docs for pagination purposes.
     * @param Integer $num
     * @param Integer $offset
     * @param string $order_by
     * @param Array $where
     * @return Object  
     */
	function get_data($table, $num=null, $offset=null, $order_by = null, $where = null, $like=null ){
	   
	   if(empty($order_by)) { $order_by = 'modified desc'; } 
	 
	   $this->db->select('*');
	   
	   if(!empty($where)) { $this->db->where($where); }
	   if(!empty($like)) {
		foreach($like as $index => $text){
			$this->db->or_like($index, $text);
		}
	   }
	   $this->db->from($table);
	   $this->db->order_by($order_by);
	   if(!empty($num) || !empty($offset) )$this->db->limit($num, $offset);
	   $query = $this->db->get()->result_array();
	   
	   //pr($this->db->last_query());
	   return $query;
	}
    
	/**
	 * Function get a single row in a table
	 * @param Integer $id
	 * @param String $table
	 * @return Array $results;
	 */
	function get($id, $array=false, $field='id', $table = null) {
		if(empty($table)) {
			$table = strtolower(get_class($this));	
		}
                
                $where = array($table.'.'.$field => $id);
                if(isset($this->soft_delete) && $this->soft_delete){                    
                    if($this->jm->check_field_exists('deleted', $table)) {
                        $where = array_merge($where, array('deleted' => 0) );
                    }  
                }
                
                //handle deleted documents                                
		$this->db->select('*');
                $this->db->from($table);
                $this->db->where($where);
                //->join('users', 'users.id ='. $table.'.id')
                $results= $this->db->get();	

		
		$result_obj = $results->result();
	
		//var_dump($results);die();
		if($array) { return $results->row_array();}
		return (isset($result_obj[0]) ) ? $result_obj[0] : $result_obj;	
	}
        
        /** 
         * Function to get all record in a table.
         * The output by default is an array and with a reverse format as with using get_lists, 
         * sample format can be:
         *    Array
                (
                    [Invitation] => 1
                    [Correspondence] => 2
                    [Greivances] => 3
                )   
         * where the name of the 
         * @param Boolean $reverse_format 
         * @param Boolean $array
         * @param String $table
         */
        function get_all($field=null, $reverse_format=true, $array=true, $table=null){
            //pr($this->get_model_name());
            //pr($this->display_fields);
            if(empty($field)) $field = $this->display_field;
            if(empty($table)) { $table = $this->get_model_name();}
            
            $where = array();
            if(isset($this->soft_delete) && $this->soft_delete){                    
                if($this->jm->check_field_exists('deleted', $table)) {
                    $where = array_merge($where, array('deleted' => 0) );
                }  
            }
            $this->db->select('*');
            $this->db->where($where);
            $this->db->from($table);                        
            $objects= $this->db->get();
            
            //$objects = $this->db->get($table);
            
            if(!$array) return $objects;
            
            $objects = $objects->result_array();
            $tmp = array();
            
            if($reverse_format) {               
                 foreach($objects as $obj){
                     $tmp[$obj[$field]] = $obj['id'];
                 }
                 return $tmp;
            } else {
                return $objects;
            }
             
             
        }
	
	/**
	 * Get lists of objects from given table and reference table
	 */ 
	function get_lists($ref_table=null, $display=array(), $table=null, $where = array()){
		
		if(empty($table)) { $table = $this->get_model_name(); }
		
                $where = array();
                if(isset($this->soft_delete) && $this->soft_delete){                    
                    if($this->jm->check_field_exists('deleted', $table)) {
                        $where = array_merge($where, array('deleted' => 0) );
                    }  
                }
                
                $this->db->select('*');
                $this->db->where($where);
                $this->db->from($table);                                            
		$table_obj = $this->db->get();
		//prd($table_obj->result_array());
		$results = array();
		$table_obj = $table_obj->result();
		if(!empty($ref_table)){
			$obj_ref = $this->db->get($ref_table);
			$obj_ref = $obj_ref->result();
		}
		//$users = (array)$users;
		
		//var_dump($obj_ref);die();
		foreach($table_obj as $obj) {
			
			$id = $obj->id;
			if(!empty($ref_table)){
				foreach($obj_ref as $ref) {
					//$d[] = $obj;
					//var_dump($id);
					
						
						$ref_id = singular($table) . '_id';
						if($ref->$ref_id == $id){
							$results[$id] = "";
							if(count($display) > 0){
								//will just be appended
								foreach($display as $ob) {
									//var_dump($ob);
									$results[$id] .= $ref->{$ob} . " ";
								}
								
							} else {
								unset($results[$id]);
							}						
						}
	
				}
			} else {
				$results[$id] = "";
				if(count($display) > 0){
					foreach($display as $ob) {
						$results[$id] .= $obj->{$ob} . " ";
					}
				} else {
					unset($results[$id]);
				}
			}
			
		}
		
               
		return $results;
		
	}
        /** 
         * Function to get a record by its $field, and $value
         * @param String $field
         * @param Mixed $value
         * @param Boolean $return
         * @param String $table
         * @return Boolean 
         */
        function get_by($field, $value, $return = null, $table=null, $array= false){
            if(empty($table)) { $table = $this->get_model_name(); }
		
            $where = array($field => $value);
            if(isset($this->soft_delete) && $this->soft_delete){                    
                if($this->jm->check_field_exists('deleted', $table)) {
                    $where = array_merge($where, array('deleted' => 0) );
                }  
            }
            
            $this->db->select();
            $this->db->where($where);
            $this->db->from($table);
            
            $results = $this->db->get();	

            
            $results = $results->row_array();
            //prd($results);
            if(!empty($return) && isset($results[$return] )){ return $results[$return]; }            
            else { return $results; }
        }
        
        function get_field($field_out, $field_in, $value_in, $table=null){
            if(empty($table)) { $table = $this->get_model_name(); }
		
            $where = array($field_in => $value_in);
            if(isset($this->soft_delete) && $this->soft_delete){                    
                if($this->jm->check_field_exists('deleted', $table)) {
                    $where = array_merge($where, array('deleted' => 0) );
                }  
            }
            
            if(isset($field_out) && !empty($field_out)) {
                if(isset($field_in) && !empty($field_in)) {
                    if(isset($value_in) && !empty($value_in)) {
                          
                        $this->db->select($field_out);
                        $this->db->from($table);
                        $this->db->where($where);
                        $results = $this->db->get();
                        $results = $results->row_array();
                         
                        return $results[$field_out];
                    }
                }
            }
           return false;
        }
        
        /**
         * Function to format post data in an array fashion.
         * One good example is post data like:
         *      array(
         *          [id] => 1
         *          [name] => jen
         *          [doc_details/name] => Invitaion
         *       
         *      )
         * 
         * will be converted to 
         *      array(
         *          [doc] => array(
         *              [id] => 1
         *              [name] => jen
         *          )
         *          [doc_details] => array(
         *              [name] => Invitation
         *          )
         *      )
         * 
         * @param type $data
         * @param type $main_table
         * @return type 
         */
        function format_post_data($data, $main_table=null){
            $tmp = array();
            if(empty($main_table)) { $main_table = strtolower(get_class($this)); }
            foreach($data as $key => $val){
                 if(strpos($key, '/')){
                    $t = explode('/', $key);
                    $table_name = $t[0];
                    $field_name = $t[1];
                    $tmp[$table_name][$field_name] = $val; 
                 } else {
                     $tmp[$main_table][$key] = $val;
                 }
            }
            //prd($tmp);
            return $tmp;
        }
        
       

	/**
	 * +++++++++++++++++++++++++++++++++++++++++++++++++++++
	 *          FUNCTIONS FOR EVENT TRACKING
	 * +++++++++++++++++++++++++++++++++++++++++++++++++++++
	 */	 
	
	/**
	 * Function to create a log event on logs table. 
	 * It first sets the $this->event_data, populating it with its respective values
	 * $event_data should look like this:
	 * $event_data => array(
					model => <model_name>
					model_id => <id>
					event_type => 0
					date => <date created>
					user_id => <user_id>
					changed => <json_converted model_obj array>
				)
	 * @param Array $options 
	 * 		An array you can fill out with the same format as the array demonstrated above.
	 * @return void
	 * 
	 */ 			
	function __log_event($options = array(
							'model'=> null, 
							'model_id'=> null, 
							'event_type' => 0,
							'user_id' => null,
							'changed' => null) ){
		$tmp_options = array(
                                        'model'=> null, 
                                        'model_id'=> null, 
                                        'event_type' => 0,
                                        'user_id' => null,
                                        'changed' => null 
                );
                
                $options = array_merge($tmp_options, $options);
		//set and prepare the $this->event_data to be save to logs table
		foreach($options as $field => $value) {
			if(!isset($options[$field]) || empty($options[$field]) ) {				
				if($field == 'model') { $this->event_data[$field] = $this->get_model_name(); }
				if($field == 'model_id') { $this->event_data[$field] = $this->id; }
				if($field == 'event_type') { $this->event_data[$field] = $this->event_id; }
				if($field == 'user_id') { 
					$this->event_data[$field] = $this->user; 
				}
				//this is for updated objects only, check if in edit mode
				if(($field == 'changed')) { 
					$this->event_data[$field] = $this->__set_changed_array(); 
				}
			} else {
				$this->event_data[$field] = $value;
                                if(($field == 'changed')) { 
					$this->event_data[$field] = $this->__set_changed_array($this->event_data[$field]); 
				}
			}
		}
		
		//JSONIZED the $changed array
		$this->event_data['changed'] = json_encode($this->event_data['changed']);
		
		//set the creation date
		$this->event_data['created'] = date($this->dateFormat);
		//pr($this->event_data);
		//save to logs table
		$this->db->insert('logs', $this->event_data);
	}
	
	function __set_changed_array($current_data=null){
		$changed = array(); //tmp array
		
		if($this->event_id == 1) {
			//get the old object data
			$changed['prev'] = $this->old_data;
			$changed['changed'] = array();
			$changed['field'] = array();
			
			if(!empty($this->old_data) ){
				$fields = $this->get_fields_array();
				
				foreach ($this->data as $key => $value) {	
					//pr($key);
					//pr($fields);
					if(in_array($key, $fields) ) {
						//pr($this->old_data[$key] != $value);
						if ($this->old_data[$key] != $value) {
							$changed['changed'][$key] = $value;
							$changed['field'][] = $key;					
						}
					}
						
				}//end foreach
			}
		} 
		if($this->event_id == 0 || $this->event_id == 3) {
                        if(!empty($current_data)){
                            $changed['current'] = $current_data;
                        } else {
                           $changed['current'] = $this->get($this->db->insert_id());  
                        }
		}
                              
		
		//prd($changed);
		return $changed;
		
		
	}
	
	
	function humanize_log($log, $fieldname, $output=0){
		
		$model = singular($log['model']);
                $date = singular($log['created']);
		$obj = $this->get($log['model_id'], true);
		$author = $this->db->get_where('user_details', array('user_id' => $log['user_id']) )->result_array();
		if(empty($author)){ $auhor =''; }
		else {
			$author = $author[0]['first_name'] . ' '. $author[0]['last_name'];
		}
		
		
		//set the title
		$title = '<strong>' . $obj[$fieldname]. '</strong>';
		
		if($model == 'doc') $model = 'Document';
		if($log['event_type'] == 1) { //EDIT	
                        $msg = '<div class="log">';
                        $msg .= '<strong class="cap bold black">['.$model . ' Updated]</strong>';
			if($output){
                             $msg .=  ' by ' . $author . ' on ' . '<span class="italic bold">' . $this->jm->format_date($date, false) . '</span>';
                        } else {
                            $msg = '<strong class="cap bold">['.$model . ' Updated]</strong>' . $author . ' edited ' . $title.'.';			
                        }
                        $msg .= '</div>';
                        
			return $msg;
		}
		
		if($log['event_type'] == 0) { //CREATE  
                        $msg = '<div class="log">';
                        $msg .= '<strong class="cap bold">['.$model . ' Created]</strong>';
			if($output){
                            $msg .=  ' by ' . $author . ' on ' . '<span class="italic bold">' . $this->jm->format_date($date, false) . '</span>';                           	
                        } else {
                            $msg = 'New '.ucfirst($model) .' Added: '.$title.' by '.$author;	
                        }
			$msg .= '</div>';		
			return $msg;
		}
                
                if($log['event_type'] == 3) { //UPLOADS 
                        $msg = '<div class="log">';
                        $msg .= '<strong class="cap bold">[File Uploaded]</strong>';
			if($output){
                            $msg .=  ' by ' . $author . ' on ' . '<span class="italic bold">' . $this->jm->format_date($date, false) . '</span>';                           	
                        } else {
                            $msg = 'New '.ucfirst($model) .' Added: '.$title.' by '.$author;	
                        }
			$msg .= '</div>';		
			return $msg;
		}

	}
	
	function format_log($logs){
		//check if single log
		if(isset($logs['changed'])) {
			$logs['changed'] = $this->jm->object_to_array(json_decode($logs['changed']));
			return $logs;
		} else { // log is multi dimensional
			foreach($logs as $key => $log){
				$logs[$key]['changed'] = $this->jm->object_to_array(json_decode($log['changed']));
			}
			return $logs;
		}
		
		return false;
	}
	
	/**
	 * +++++++++++++++++++++++++++++++++++++++++++++++++++++
	 * 			FUNCTIONS FOR UPLOAD FUNCTIONALITY
	 * =====================================================
	 * For the Upload functionality to work, on your model that
	 * that extends this model, set the $upload_mo_ko variable to:
	 * 
	 * 	$this->upload_mo_ko = true;
	 * 
	 * to enable upload functionality. Of course, for this to work
	 * you will need an uploads table, and set:
	 * 
	 * 	$this->upload_table = <name of the table>
	 * 
	 * to know the model where to save the uploads data in your db. 
	 * The default table is 'uploads' table, so if you have an uploads
	 * table you dont need to set this variable.
	 * +++++++++++++++++++++++++++++++++++++++++++++++++++++
	 */	 
	
	
	/**
	 * Set the Upload configurations
	 * @param Mixed $post_data optional variable to set, to get additional data to where
	 * 	the data will be stored. $post_data should have this form:
	 * 	
	 * 			$post_data => array(
	 * 				'model' => <model name>,
	 * 				'model_id => <model_id>
	 * 			)
	 * 	At least the $post_data array should these keys for it to work.
	 * 	The  default path to store the files is /uploads/ folder
	 * 
	 * @return Array $this->upload_config The set upload configuration for the model
	 * 
	 */
	function set_upload_config($post_data=null){
		
		if(count($post_data)) {
			$post = array_merge($this->data, $post_data); //get post data	
		} else {
			$post = $this->data;
		}
                
		//set the allowed types here
		if(isset($post_data['allowed_types'])) {
			$this->upload_config['allowed_types'] = $post_data['allowed_types'];
		}
		
		//set max size
		if(isset($post_data['max_size'])) {
			$this->upload_config['max_size'] =  $post_data['max_size'];
		} 
		
				
		if(isset($post['model']) && isset($post['model_id']) ){
			//set the upload path format is /upload/<model>/<model id> 
			$this->upload_config['upload_path'] = './uploads'. '/' .$post['model'] .'/'. $post['model_id'];	
			if(isset($post['dir']) ){
				$this->data['dirname'] = $post['dir'];
				$this->upload_config['upload_path'] = './uploads'. '/' .$post['model'] .'/'. $post['dir'];	
			}
			//check if upload path exists
			if(!file_exists($this->upload_config['upload_path']) ) {
				//$this->upload_config['upload_path'] = '/var/www/dts'. $this->upload_config['upload_path'];
				mkdir($this->upload_config['upload_path'], 0777, true);
				//pr(is_dir($this->upload_config['upload_path']));
				//prd(is_writable($this->upload_config['upload_path']));	
			}
		}			
		//prd($this->upload_config);
		return $this->upload_config;
	}
	
	/**
	 *  Function to save uploaded data
	 */
	function save_upload_data($data=null) {
                
		if(empty($data) || (count($data) < 1)){
			$data = $this->data;
		}
                
                if(empty($table)) {
			$table = strtolower(get_class($this));	
		}
                
		//set upload info
		if(is_object($this->upload)){
			$udata = $this->upload->data();
			//fill in the more data to save 			
			$data['basename'] = strval($udata['file_name']);
			$data['full_path'] = strval($udata['full_path']);	
			$data['info'] = json_encode($udata);			
		}
		$data['created'] = date('Y-m-d H:i:s');
		$data['modified'] = $data['created'];
		
		if($this->upload_mo_ko){
			if(isset($data['model']) && isset($data['model_id']) ){
				//prd($data);
				//save file details to upload table
                                $this->event_id =3;
				$this->db->insert($this->upload_table, $data);
                                $data['id'] = $this->db->insert_id();
                                $this->id = $data['model_id'];
                                $upload_event_data = array(
							'event_type' => 3, //upload							
							'changed' => $data
                                    );
                                
                                ($this->track_mo_ko && $table == $this->get_model_name()) ? $this->__log_event($upload_event_data) : null;	 
				//prd($this->db->last_query());				
			} else {
					log_message('error', 'Upload is not saved to events because model or either model id is missing');	  
			}
		} else {
			log_message('error', 'Upload is not saved to events because events are disabled for this model(' . $this->get_model_name() . ')' );
		}
	}

	/**
	 * +++++++++++++++++++++++++++++++++++++++++++++++++++++
	 * 		MISC FUNCTIONS FOR THE MODEL
	 * +++++++++++++++++++++++++++++++++++++++++++++++++++++
	 */	 
	
	/**
	 * Get the current model name
	 * @param Boolean $plural determine if outputs model name in plural form
	 * @return $result
	 */
	function get_model_name($plural=true){
		$model_name = strtolower(get_class($this));
		return $plural ? $model_name : singular($model_name);
	}
	
	/**
	 * Function to get a lists of fields from table or model 
	 * @param String $table name of the model get fields
	 * @return Array $tmp_fields
	 */
	function get_fields_array($table=null){
		$table = (empty($table)) ? $this->get_model_name() : $table;
		$fields = $this->db->field_data($table);
		$tmp_fields = array();
		
		foreach($fields as $field){
			array_push($tmp_fields, $field->name);
		}
		
		return $tmp_fields;
	}
	
	/**
	 * 	A function to check if an array is multidimensional or not
	 * 	Useful when using create function with multidimensional array to save multiple copies
	 */
	function is_multi($a) {
		foreach ($a as $v) {
			if (is_array($v)) return true;
		}
		
		return false;
	}
	
	/**
	 * 	Array checking function if an array is purely a single array or 
	 * 	mixed of multidimensional array and single arrays
	 * 	@param array $a
	 * 	@return bool
	 */ 
	
	function is_valid_array($a) {
		$single = 0;
		$multi = 0;
		
		foreach ($a as $key => $v) {
			if (is_array($v)) { $multi = 1; } 
			else { $single = 1;}
		}		
		
		if($single && $multi) return false;
		else return true;
	}

}
