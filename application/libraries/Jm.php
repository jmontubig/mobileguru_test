<?php

/**
 *  These libraries are just a collections of functions 
 * 	@author Jonathan Montubig
 * 	@created 11/07/2011
 */ 
class Jm {
    
    var $CI;//CI Instance for use of this class
    var $pages = array();//menu pages   
    var $allowedTags = '<a><span><b><i><strong>';
    
    var $email_config = array(); //email configuration
    
    var $avatar_dir = '/images/users/';
    var $email_enabled = false;
    var $IS_AJAX = false;
	var $user_logged = null;
	
	//offline string that will be searched  on the url to determine 
	//if web app is run via testserver or localhost
	var $offline_string = array('localhost', 'testserver');
	//offline real path used for deleting files etc.
	var $offline_real_path = '/xampp/htdocs/mobileguru_test';
	
	//online string that will be searched on the url to determine 
	//if web app is online or not
	var $online_string = array('.com');
	//online real path used for deleting files etc.
	var $online_real_path = '';
	var $banner_upload_path = 'images/banners/';
	var $phones_upload_path = 'images/phones/';
	
    
    function __construct() {
        //parent::__construct();
        $this->CI =& get_instance();
         
        $this->CI->load->helper('url');
        $this->CI->load->helper('Form');
        $this->CI->load->library('session');
        
		if($this->get_logged_user()) { $this->user_logged = $this->get_logged_user(false); }
		
        //$this->email_enabled = $this->CI->config->item('email_enabled');
        $this->set_pages();

    }
    
    /**
     * Function to set pages list on the menu, useful to get the list of pages
     * @param Array $pages Optional parameter
     * @param Boolean $output False by default
     * @return Array 
     */
    function set_pages($pages=null, $output=false) {
       if(empty($pages)){
           $this-> pages = array(
               'Dashboard' => site_url('/admin'),
           );          
       } else {
           $this->pages = $pages;
       }
  
       if($output) { return $this->pages; }
    }
    
    /**
     * A function to get a user permission.
     * Will be completed as soon as the ACL is completed.
     * @param Integer $user_id 
     * @return Boolean $result
     * 
     */
    function get_permission($user_id) {

            return true;
    }
   
    /**
     * Get the currently logged in user information
     * @param Booleam $array if true will return the id ofthe logged user, if false will return an array containing logged user info.
     * @return Mixed return value based on the $array parameter, can be Integer or Array 
     */
   function get_logged_user($array=true){
       //$CI =& get_instance();
       //$this->CI->load->library('session');
       
       if($this->CI->session->userdata('users') ) {
           $user = $this->CI->session->userdata('users');
		   if(is_string($array)){//then its a field
				//get the field
				if(isset($user[$array])) {
					$split_name = explode(' ', $user['fullname']);
					if(empty($user['first_name'])){
						if($array == 'first_name') { return ucfirst($split_name[0]); }
					}
					if(empty($user['last_name'])){
						if($array == 'last_name') { return ucfirst($split_name[count($split_name)-1]); }
					}
					
					return $user[$array];
				}
		   }
           //prd($user);
           if($array) { return $user['id']; // return just the user id
           } else { return $user; } //return user array
           
       } else {
           return 0;
       }
   }
   /**
    * Function to detect if user is admin
    * @return Integer 
    */
   function is_user_admin(){
       if($this->CI->session->userdata('users') ) {
           $user = $this->CI->session->userdata('users');      
           return 1;//return user array           
       } else {
           return null;
       }
   }
   
   function auto_redirect(){
		if($this->get_logged_user()) { (($this->is_user_admin()) ? redirect('admin') : redirect('user')); }
		else redirect('login');
   }
   
   /**
     *  Function to display Session Message
     */
    function display_session_message(){

            if( $this->CI->session->flashdata('message')){
                echo '<div class="success all-caps">';
                echo $this->CI->session->flashdata('message');
                echo '</div>';
            } 
			
			if( $this->CI->session->flashdata('success')){
                echo '<div class="success all-caps">';
                echo $this->CI->session->flashdata('success');
                echo '</div>';
            } 

            if( $this->CI->session->flashdata('error')) {
                echo '<div class="error all-caps">';
                echo $this->CI->session->flashdata('error');
                echo '</div>';
            }
			
			if( $this->CI->session->flashdata('notice')) {
				//prd('test');
				echo '<div class="notice all-caps">';
                echo $this->CI->session->flashdata('notice');
                echo '</div>';
			}


    } 
   
   function update_recent_docs($id){
            if(is_array($id)){ $doc = $id; }
            else { 
              $this->CI->load->model('Docs');
              $doc = $this->CI->Docs->get($id, true);
              //prd($id);
            }
            
            $this->set_doc_session(); //set default doc session values
            $sess_doc = $this->CI->session->userdata('doc');//get doc session    
            if(!isset($sess_doc['recent_doc'])) { $sess_doc['recent_doc'] = array(); }
            
            if(array_key_exists($id, $sess_doc['recent_doc'])) {
                unset($sess_doc[$id]);                
            } 
            //pr($id);
            $sess_doc['recent_doc'] = array($id => $doc['name']) + ((isset($sess_doc['recent_doc'])) ? $sess_doc['recent_doc'] : array() ) ;
            $sess_doc['current_doc'] = $id;
            $this->CI->session->set_userdata('doc', $sess_doc);
            //pr($sess_doc);
   }
   
   function get_recent_doc($array=false){
      $sess_doc = $this->CI->session->userdata('doc');//get doc session    
      $recent = null;
      if(isset($sess_doc['recent_doc'])) { $recent = $sess_doc['recent_doc'];  }        
      if(empty($recent)) {
          if($array) return 0;
      } else {
          if($array) {
            $this->CI->load->model('Docs');
            return $this->CI->Docs->get($recent, true);   
          } 
          return $recent;
          
          
      }
      
   }
   
   function set_doc_session($defaults =  array('order_by' => 'modified', 'order' => 'desc') ){
       if(!$this->CI->session->userdata('doc')) { 
                    $this->CI->session->set_userdata('doc',$defaults );
       }
   }
   
   
   /**
     *  ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
     *               ARRAY RELATED FUNCTIONS
     *  ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++         
     */
   
   
   /**
    *
    * Convert an object to an array
    *
    * @param    object  $object The object to convert
    * @reeturn      array
    *
    */
    function object_to_array( $object )
    {
        if( !is_object( $object ) && !is_array( $object ) )
        {
            return $object;
        }
        if( is_object( $object ) )
        {
            $object = get_object_vars( $object );
        }
        return array_map( array($this,'object_to_array'), $object );
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
    /**
     * Get a Key lists of an array, useful when getting the keys of a fields array
     * @param Array $array
     * @return Array 
     */
    function create_key_list($array){
        $results = array();
        foreach($array as $key => $val){
           array_push($results, $key); 
        }

        return $results;
    }

    function array_unshift($src_array, $insert_array){
        
        return $src_array + $insert_array; 
    }

    /**
     *  ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
     *               FIELD/TABLE RELATED FUNCTIONS
     *  ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++         
     */

    /**
     * Get the field type of a certain fields from an array, 
     * this is provided that the given $field_lists is in a form
     * CI's data field array.
     * 
     * @param String $field field to find what type
     * @param Object $field_lists object array of fields
     * @param mixed $output any value can be put here, 
     * this is just to say that the output would be an array or 
     * if not set the type of the field being searched.
     * 
     * @return mixed $result can be an Object Array or a String field type
     * depending on the set value for parameter $output
     * 
     */
    function get_field_type($field, $field_lists, $output=null){
            foreach($field_lists as $field_data){			
                    if($field_data->name == $field) {
                            if(isset($output)) {
                                    return $field_data;
                            } else {
                                    return $field_data->type;
                            }
                    }
            }

    }

    /**
     * Function to determine if a $field is Foreign key
     * @param String $field
     * @param Boolean $tablename vary output, if false it'll return a boolean, else it'll return the table name to where it is related
     * @return Boolean/Array 
     */
    function isFK($field, $tablename=false ) {
        
         if(strpos($field, '/')){
                    $t2 = explode('/', $field);
                    $field = $t2[1];
         }
         
         if(strpos($field, '_') && strpos($field, 'id')){
         
            $t = explode('_id', $field);
            $list = plural($t[0]);
            if($tablename) { return $list; }
            else { return true; }

         } else {

             return false;

         }
    }

    /**
     * Function to get the form's version of a field type, this is just a basic 
     * @param String $fieldType
     * @param Array $option
     * @return String Html string containing html tags 
     */
    function get_form_field($fieldType, $option){            
        if($fieldType == 'blob' || $fieldType == 'text'){
                return form_textarea($option);
        } 
        else if($fieldType == 'int') {
            
             $option = array_merge($option, array('style' => 'width: auto;'));
             return form_checkbox($option);
        } else {
                return form_input($option);
        }

    }
    
    /**
     * Function to check if the field is on other table, or the format of the field is like:
     *  <table_name>.<field_name>
     * @param type $field
     * @param type $output
     * @return type 
     */
    function isOnOtherTable($field, $output = 'table'){
        if(strpos($field, '/')){
             $t = explode('/', $field);
             $table_name = $t[0];
             $field_name = $t[1]; 

             if($output == 'table') { return $table_name; }
             else if ($output == 'field') { return $field_name; }
             else if ($output == 'bool') { return true; }
             else { return $t; }

        } else {
            return false;
        }
    }

    /**
     * Function to check if a field exists in a table
     * @param string $field_name
     * @param string $table_name
     * @return boolean 
     */
    function check_field_exists($field_name, $table_name){
            
            if($this->CI->db->table_exists($table_name)){              
                if ($this->CI->db->field_exists($field_name, $table_name)){
                       return true;
                } else {
                    return false;
                }
            } else {
                return false;
            }
    }
    
    /**
     * Function to format a value from a certain field type
     * @param Mixed $value
     * @param String $fieldType 
     */
    function format_value($value, $fieldType){
       
        if($fieldType == 'datetime') {           
            $value = $this->format_date($value, false);
        }
        
        return $value;
    }
    
    function format_field_rule($rules){
        $all_rules = '';
        $i=0;
        foreach($rules as $rule){
            if($rule == 'required') $all_rules .= 'required: true'; 
            if(strpos($rule, 'max_length')) {
                $r = explode('[', $rule);
                $r2 = explode(']', $r[1]);
                $limit = $r2[0];
                $all_rules .= 'maxlength: ' . $limit; 
            }
             if($rule == 'email'){
                 $all_rules .= ' email: true';
             }
             
             if(++$i<count($rules)-1) {  $all_rules .= ','; }
        }
        
        return $all_rules;
        
        
    }
    
     function format_rule_message($messages){
        $all_messages = '';
        $i=0;
        foreach($messages as $rule => $message){
            if($rule == 'required') $all_messages .= 'required: "' . $message . '"' ;             
            if(strpos($rule, 'max_length')) {
                $r = explode('[', $rule);
                $r2 = explode(']', $r[1]);
                $limit = $r2[0];
                $all_messages .= 'maxlength: "' . $message . '"'; 
            }
             if($rule == 'email'){
                 $all_messages .= ' email: "' . $message . '"';
             }
             
             if(++$i<count($messages)-1) {  $all_messages .= ','; }
        }
        
        return $all_messages;
        
        
    }

    /**
     *  ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
     *               STRING/TEXT RELATED FUNCTIONS
     *  ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++         
     */
	
	/**
	 * Function to detect if in local/testserver or on online, relies its calculation on 
	 * $this->offline_string and $this->offline_string 
	 * 
	 * @return Boolean
	 * 
	 */
	function is_offline(){
		if(is_array($this->offline_string) && is_array($this->online_string)){
			foreach($this->offline_string as $str){
				if(strpos(site_url(), $str)) {
					foreach($this->online_string as $oStr){
						if(!strpos(site_url(), $oStr)) {	
							return true;
						} 
					}
				}
			}
			
			return false;
			
		} else {
			if(strpos(site_url(), $this->offline_string)) {
				if(!strpos(site_url(), $this->online_string)) {	
					return true;
				}					
			}
			
			return false; 
		}
	}
	
	/**
	 * Alternate function of is_offline..
	 * Wla lang! hahahah
	 * 
	 * @return Boolean
	 */
	function is_online(){ return !$this->is_offline(); } 
	
	/**
	 * Function to get the base root path if the app is run online or offline.
	 * This will largely vary to the class 
	 * variable $offline_string and $online_string
	 * They will be need to be set properly.
	 * 
	 * @param String $folder optional param to include additional folder to the return value
	 * @return String
	 */
	function get_base_path($folder=null) {
		if($this->is_offline()) {
			return $this->offline_real_path . ( !empty($folder) ? '/' . $folder  : '');
		} else {
			return $this->online_real_path. ( !empty($folder) ? '/' . $folder  : '');
		}
	}
    
    /**
     * Get domain
     *
     * Return the domain name only based on the "base_url" item from your config file.
     *
     * @access    public
     * @return    string
     */    

    function getDomain()
    {
        $CI =& get_instance();
        return preg_replace("/^[\w]{2,6}:\/\/([\w\d\.\-]+).*$/","$1", $CI->config->slash_item('base_url'));
    }  

    /**
     * 
     * 	Function to limit a string to a specified length specified by the parameters
     * 	@param String $string String to be change
     * 	@param Integer $word_limit Number of words to limit the text
     */ 
    function limitText($string, $word_limit) {
      $words = explode(' ', $string, ($word_limit + 1));
      $result = $string;
      if(count($words) > $word_limit){
              array_pop($words);
              $result = implode(' ', $words);		  
              $result = $result . " ... ";
      }
      return $result;
    }

    /**
     * 
     * 	Function to get the current URL
     * 
     */
    function curPageURL() {
             $pageURL = 'http';
             if(isset($_SERVER['HTTPS'])) {
                    if ($_SERVER['HTTPS'] == "on") {$pageURL .= "s";}
             }
             $pageURL .= "://";
             if ($_SERVER["SERVER_PORT"] != "80") {
              $pageURL .= $_SERVER["SERVER_NAME"].":".$_SERVER["SERVER_PORT"].$_SERVER["REQUEST_URI"];
             } else {
              $pageURL .= $_SERVER["SERVER_NAME"].$_SERVER["REQUEST_URI"];
             }
            //$this->createClassMenus('User'/*, array( 'create' => array('on' => true, 'label' => 'Edit') )*/);
            //echo Inflector::pluralize('echo');
             return $pageURL;
    }
	
	/**
	 * Function to get current client IP Address
	 * @param Boolean $name
	 * @return  String $ip
	 */
	function get_ip(){
		if ( isset($_SERVER["REMOTE_ADDR"]) )    {
			return '' . $_SERVER["REMOTE_ADDR"] . ' ';
		} else if ( isset($_SERVER["HTTP_X_FORWARDED_FOR"]) )    {
			return '' . $_SERVER["HTTP_X_FORWARDED_FOR"] . ' ';
		} else if ( isset($_SERVER["HTTP_CLIENT_IP"]) )    {
			return '' . $_SERVER["HTTP_CLIENT_IP"] . ' ';
		} 
	}

    /**
     * Function to get the difference between to dates
     * @param DateString $start 
     * @param DateString $end
     * @return String $results output format is in HH:MM:SS format
     * 
     */
    function dateDiff($start, $end, &$duration=null){
        //pr($start); pr($end);
        if($start == '0000-00-00' || $end == '0000-00-00') {  return '00:00:00';}		
        $duration = date_diff(new DateTime($end),new DateTime($start));								
        return $duration->format('%h:%i:%s');
    }
    
    /**
     * Function to convert date into DTS' standard date format
     * @param DateString $date
     * @return String 
     */
    function format_date($date, $short=true, $pamalit='Not Applicable') {
           if(($date == '0000-00-00 00:00:00') || empty($date)) { return $pamalit;}
           
           if($short) {
                return date('D m/d/Y', strtotime($date));
           } else {
               return date('D m/d/Y h:i:s a', strtotime($date));
           }
    }
    
    /**
     * Function to quickly clean a string off all html tag that can destroy the layout
     * @param String $str
     * @param Boolean $stripTags
     * @return String 
     */
    function clean_string($str, $stripTags=true){
        if($stripTags){ return strip_tags($str, $this->allowedTags); }
        else { return htmlentities($str); }        
    }
    /**
     * Function to clean tag string with a format of: tag, tag, tag, tag
     * That is comma-delimited tags. It cleans the string and depending on the $array parameter
     * will output an array or an string of clean tags.
     * @param String $string_tags
     * @return Array/String 
     */
    function clean_string_tags($string_tags, $array=true){
        $string_tags = array_filter(preg_split( "/[\s,]+/", strtolower($this->clean_string($string_tags))));
        //prd($string_tags);
        if($array){ return $string_tags; }
        else {
            $tags='';
            $i = 0;           
            foreach($string_tags as $tag){
                $tags.= $tag;
                if($i < count($string_tags)-1){ $tags .= ', '; }               
                $i++;
            }
            return $tags;
        }
       
    }
	
	function alphanumericOnly($string, $tolower=false){
		$string = preg_replace("/[^a-zA-Z ]/m", "-", $string);
		$string = preg_replace("/ /", "-", $string);
		
		return ($tolower ? $string : strtolower($string));
	}
    /**
     *  ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
     *               PLUGIN RELATED FUNCTIONS
     *  ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++         
     */

    /**
     * Function to display uploads on properly
     * uploads are shown by:
     * 	name	post date	delete button
     * @param Array $uploads containing the uploads array
     * @return	String	$results
     */
    function display_uploads($uploads, $delete = true){
            
           $model = $this->CI->session->userdata('current_doc');
           $user = $this->CI->session->userdata('users');
           $canEdit = $this->CI->Permissions->is_user_can_edit_doc($model['id'],$user['id']);
          
           $results = '<div class="uploads" style="display: inline; width: auto;">';
            if( in_array($model['status_id'], $this->CI->Docs->upload_enabled_statuses))  { 
                if( ($model['user_id'] == $this->get_logged_user()) && ($model['user_id'] == $this->get_logged_user()) ) {
                    //if endorsed use is the author
                    $delete = true;
                }
                if($this->is_user_admin()) { $delete = true; }//enable delete if user is admin                                       
            }  
            if(count($uploads) > 0){
                foreach($uploads as $upload){
                        $ulink = anchor('./uploads/'.$upload['model'] . '/' . $upload['dirname'] . '/' .  $upload['basename'],
                                                 $upload['basename'], array('target' => '_blank') );
                        $results .= '<div class="inline">' .
                                                '<span style="font-size: 9px; font-style: italic;">'.
                                                       // $upload['created'].
                                                '</span>' . '&nbsp;' 
                                                .$ulink. '&nbsp;';
                        if(isset($canEdit) && $canEdit) 
                        {
                            $results .= ($delete) ? anchor('#', img(array('src'=>'images/delete-upload.png', 'title' => 'Delete '.$upload['basename'])), array('id' => $upload['id'], 'class' =>'delete-link' )) : '';
                        }else{
                            $results .= '&nbsp;';
                        }
                         $results .= '&nbsp;</div>';						
                }
                 $results .= '<br/>';
            } else{
                $results .= 'No files uploaded.<br/>';
            }
           
            $model_url = site_url("/doc/uploads/".$model['id']);
            $model_loading = site_url('images/ajax-loader.gif');
            
            $results .= '					
                                    <script>
                                      $(document).ready(function() {
                                                    $(".uploads a.delete-link").click(function() {
														  if (confirm("Are you sure you want to delete?")) { 
                                                            id = $(this).attr("id");
                                                            $.ajax({  
                                                              type: "POST",
                                                              url: "'. site_url("/upload/delete/") .'/"+id,  			 
                                                              success: function(response) {
                                                                    $(".upload-message").html(response);
                                                                    $(".upload-message").show();
                                                                    
                                                                 $("#uploads").html(\'<img src="' .$model_loading . '" /> Loading Attachments\');
                                                                  $.ajax({  
                                                                      type: "POST",
                                                                      url: "' . $model_url . '",  			 
                                                                      success: function(response) {
                                                                            $("#uploads").html(response).css("display", "inline");							
                                                                      }
                                                                    });
                                                                    
                                                              }
                                                            });
														  }
                                                            return false;
                                                    });
                                            });
                                     
                                    
                                    </script>
                                    ';
            
            //pr($results);
            return $results;
    }
    
    /**
     * Get a single upload image or image path
     * @param Array $upload upload object array
     * @param Boolean $image a parameter to just tell the function what kind of output you want, true = <img src=''>, false = image path
     * @return type 
     */
    function get_upload($upload, $image=true){
       
        if(isset($upload['model']) && isset($upload['dirname']) && isset($upload['basename'])) {
            $img = site_url('./uploads/'.$upload['model'] . '/' . $upload['dirname'] . '/' .  $upload['basename'] );
        } else { 
            $img = 'Image Not Found';
        }
        if($image) return img($img);
        else return $img;
    }
    
    /**
     * Get the current status image based on its status id
     * @param Integer $status_id
     * @param Boolean $html
     * @param Array $options
     * @return string 
     */
    function get_status_image($status_id, $html=true, $options=array()){
       
        $this->CI->load->model('Statuses');
        $statuses = $this->CI->Statuses->get_lists(null, array('name') );        
        $image_name = str_replace(' ', '_', trim(strtolower($statuses[$status_id]))) . '.png';
        
        
        
        if($html) {  
            $img_url = site_url('/images/'.$image_name); 
            $options = array_merge($options, array('src' => $img_url, 'title' => $statuses[$status_id], 'alt' => $statuses[$status_id] ) );
        }
        if($html) { return img($options); } 
        else { return $image_name; }
    }
    
    /**
     * Function to get avatar image by its user_id
     * @param Integer $user_id
     * @param Boolean $html
     * @param Array $options
     * @return string 
     */
    function get_avatar($user_id, $html=true, $options=array(), $tip=true, $thumb=true){
        
        $this->CI->load->model('Users');
        $user = $this->CI->Users->get_by('user_id', $user_id, null, 'user_details', true);
        $rand_id = $this->crypt($user_id, 4);
        
        $thumb_dir =  $this->avatar_dir . (($thumb) ? 'thumbs/' : '/');
        $image_name = (($thumb) ? ((isset($user['face_thumb'])) ? $user['face_thumb'] : ie($user['face'], '')): ie($user['face'], '') );
        $file = $thumb_dir . $image_name;
        $full_name = ie($user['first_name'], '') . ' ' . ie($user['last_name'], '');
        //$avatar_exists = file_exists( site_url($thumb_dir .$image_name));
        //if(!$avatar_exists) { $image_name = 'default.jpg'; }        
        //$avatar_exists  = true;
        if($tip) { $options = array_merge($options, array('id' => $user_id) );}
        clearstatcache();
        //pr($file);
        //pr(site_url($file));
        //pr(file_exists($file));
                
            if($this->check_if_image_exists($image_name,$thumb_dir) && (!empty($image_name)) ) {
                $options = array_merge($options, array('src' => site_url($thumb_dir .$image_name)) );
            } else {
               $options = array_merge($options, array('src' => site_url('/images/default.jpg')) ); 
               $image_name = 'default.jpg';
            }
       
        $img = img($options) ;
        if($tip) { $img =anchor('#', img($options ), array('class'=> 'jTip', 'id' => 'image-link-'.$rand_id, 'rel' => site_url('/user/get_user_info/' . $user_id), 'name' => $full_name ) ); }
        if($html) { return $img; } 
        else { return $image_name; }
    }
    
    function get_doc_type_style($doc_type_id, $style = null){
       //get doc types in an array
        $this->CI->load->model('Doc_Types');
        $doc_types = $this->CI->Doc_Types->get_lists(null, array('type') );   
        $colors = $this->CI->Doc_Types->doc_type_colors;
        
       if(array_key_exists($doc_type_id, $doc_types) ){
           return '<div class="inline doc-type" style="color: #333' . ';' . $style.'">'. $doc_types[$doc_type_id] .'</div>';
       }
       
       else {
           return '<div class="inline doc-type" style="background: '. $colors[0] . ';' . $style.'">Not Set</div>';
       }
    }
    /**
     * Function to check if an image/avatar exists. Directory to check defaults to avatar directory
     * @param String $img_url
     * @param String $url_to_check
     * @return Boolean 
     */
    function check_if_image_exists($img, $url_to_check='images/users/'){
       
        return @file_get_contents(site_url($url_to_check . $img),0,NULL,0,1);
         //alternative===  but much slower
        //return is_array(@getimagesize(site_url($url_to_check . $img)));
    }
    function file_exists($file){        
        $file_headers = @get_headers($file);
        if($file_headers[0] == 'HTTP/1.1 404 Not Found') {
            return false;
        }
        else {
            return true;
        }
    }
    
    /**
     * +++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
     * 
     *          EMAIL  FUNCTIONS
     * 
     * +++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
     * 
     */
    
    /**
     * Function to setup email configuration
     * @param Array $data 
     */
    function set_email_config($data=array()){
        if(empty($data)){
             $this->email_config = array(
                'protocol' => 'smtp',
                'smtp_host' => 'mail.emobilize.net',
                'smtp_port' => 25,
                'smtp_user' => 'tester+emobilize.net',
                'smtp_pass' => 'P@ssword1',
                'smtp_timeout' => 30,
                'mailtype' => 'html',
                'charset' => 'iso-8859-1',
                'wordwrap' =>  TRUE
            );
        } else {
           $this->email_config = $data; 
        }
    }
    
    /**
     * Main Function to send emails
     * @param type $settings
     * @param type $action
     * @return type 
     */
    function send_email($settings=array(), $action=null){
        
        if(!$this->email_enabled) return true;
        
        $this->set_email_config();
        $this->CI->load->library('email', $this->email_config);
        $this->CI->email->set_newline("\r\n");
       
        if(!isset($settings['from'])) { return false; }
        if(!isset($settings['to'])) { return false; }
        if(!isset($settings['subject'])) { return false; }
        if(!isset($settings['message'])) { return false; }
            
        $this->CI->email->from($settings['from'], (isset($settings['from_name'])) ? $settings['from_name'] : 'DTS Admin' ); 
        $this->CI->email->to($settings['to']); 
        $this->CI->email->subject($settings['subject']);
        $this->CI->email->message($settings['message']);
        
        if(isset($settings['cc'])) { $this->CI->email->cc($settings['cc'], (isset($settings['cc_name'])) ? $settings['cc_name'] : '' ); }                
		if(isset($settings['bcc'])) { $this->CI->email->bcc($settings['bcc'], (isset($settings['bcc_name'])) ? $settings['bcc_name'] : '' ); }        
        
        if($this->CI->email->send()){
            //$this->CI->email->print_debugger();
            return true;
        } else {
            //$this->CI->email->print_debugger();
            return false;
        }
        
    }
    
    /**
     * +++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
     * 
     *          STATS FUNCTIONS
     * 
     * +++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
     * 
     */
    
    /**
     * Function to get sql stats, by following ids:
     * Array
        (
            [0] => Uptime: 38480
            [1] => Threads: 7
            [2] => Questions: 15182
            [3] => Slow queries: 0
            [4] => Opens: 224
            [5] => Flush tables: 1
            [6] => Open tables: 3
            [7] => Queries per second avg: 0.394
        )
     * @param type $id 
     */
    function get_server_stats($id=null, $name=null){
        $t = explode("  ", mysql_stat());
        //prd($t);
        if(empty($id)) return $t;
        foreach($t as $i => $v){
            if($i == $id) { 
                $i = explode(":", $v);
                if($name) return $i;
                return trim($i[1]);
            }
            
        }
        return $t;
    }
    
    /**
     * +++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
     * 
     *          ENCRYPTION FUNCTIONS
     * 
     * +++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
     * 
     */
    function crypt($data=null, $l = 32){
               
        $salt = $this->random_password($l);
        $hash = '';
        
        if(empty($data)){                       
            $hash = hash( 'crc32b', md5($this->random_password($l)));
        } else {
            $hash = hash( 'crc32b', md5($this->random_password($l) . $data));
        }    
        //pr($hash);
        
            if (CRYPT_BLOWFISH == 1) {
                $hash = crypt($hash, '$2a$07$'. $salt .'$');
                
            }                    
            else if (CRYPT_SHA256 == 1) {
                $hash = crypt($hash, '$5$rounds=5000$'. $salt .'$');
            }

            else if (CRYPT_SHA512 == 1) {
                $hash = crypt($hash, '$6$rounds=5000$'. $salt . '$');
            }
                        
            else if (CRYPT_MD5 == 1) {
                $hash = crypt($hash, '$1$rasmusle$');
            }  
            
            else if (CRYPT_STD_DES == 1) {
                $hash = crypt($hash, 'rl');
            }
            else if (CRYPT_EXT_DES == 1) {
                $hash = crypt($hash, '_J9..rasm');
            }
        $hash = preg_replace("/[^a-zA-Z0-9]+/", "", $hash.$this->random_password(12, 3, 4));
                
        return $hash; 
    }
    
    /**
	 * Function to create strong passwords
	 * @ref http://www.dougv.com/2010/03/23/a-strong-password-generator-written-in-php/
	 * 
	 */	 
	function random_password($l = 8, $c = 0, $n = 0, $s = 0) {
		 // get count of all required minimum special chars
		 $count = $c + $n + $s;
	 
		 // sanitize inputs; should be self-explanatory
		 if(!is_int($l) || !is_int($c) || !is_int($n) || !is_int($s)) {
			  trigger_error('Argument(s) not an integer', E_USER_WARNING);
			  return false;
		 }
		 elseif($l < 0 || $l > 64 || $c < 0 || $n < 0 || $s < 0) {
			  trigger_error('Argument(s) out of range', E_USER_WARNING);
			  return false;
		 }
		 elseif($c > $l) {
			  trigger_error('Number of password capitals required exceeds password length', E_USER_WARNING);
			  return false;
		 }
		 elseif($n > $l) {
			  trigger_error('Number of password numerals exceeds password length', E_USER_WARNING);
			  return false;
		 }
		 elseif($s > $l) {
			  trigger_error('Number of password capitals exceeds password length', E_USER_WARNING);
			  return false;
		 }
		 elseif($count > $l) {
			  trigger_error('Number of password special characters exceeds specified password length', E_USER_WARNING);
			  return false;
		 }
	 
		 // all inputs clean, proceed to build password
	 
		 // change these strings if you want to include or exclude possible password characters
		 $chars = "abcdefghijklmnopqrstuvwxyz";
		 $caps = strtoupper($chars);
		 $nums = "0123456789";
		 $syms = "!@#$%^&*()-+?";
		 $out = '';
	 
		 // build the base password of all lower-case letters
		 for($i = 0; $i < $l; $i++) {
			  $out .= substr($chars, mt_rand(0, strlen($chars) - 1), 1);
		 }
	 
		 // create arrays if special character(s) required
		 if($count) {
			  // split base password to array; create special chars array
			  $tmp1 = str_split($out);
			  $tmp2 = array();
	 
			  // add required special character(s) to second array
			  for($i = 0; $i < $c; $i++) {
				   array_push($tmp2, substr($caps, mt_rand(0, strlen($caps) - 1), 1));
			  }
			  for($i = 0; $i < $n; $i++) {
				   array_push($tmp2, substr($nums, mt_rand(0, strlen($nums) - 1), 1));
			  }
			  for($i = 0; $i < $s; $i++) {
				   array_push($tmp2, substr($syms, mt_rand(0, strlen($syms) - 1), 1));
			  }
	 
			  // hack off a chunk of the base password array that's as big as the special chars array
			  $tmp1 = array_slice($tmp1, 0, $l - $count);
			  // merge special character(s) array with base password array
			  $tmp1 = array_merge($tmp1, $tmp2);
			  // mix the characters up
			  shuffle($tmp1);
			  // convert to string for output
			  $out = implode('', $tmp1);
		 }
		
		 return $out;
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
	function check_header_size($index = 'userfile', $label='File'){
		$config=array(
			'upload_path' => './uploads/',
			'allowed_types' => 'gif|jpg|png',
			'max_size'	=> '2000',
			'max_width'  => '1004',
			'max_height'  => '480'
		);
			
		if( isset($_FILES[$index]) && !empty($_FILES[$index]['name']) ) {
			list($width, $height, $type, $attr) = getimagesize($_FILES['headerfile']['tmp_name']);
			if($width < $config['max_width']) {
				$this->validation_errors .= '<div> '.$label.' width should be greater than '. $config['max_width'] . 'px </div>'; 
				return false;
			}
			if($height < $config['max_height']) {
				$this->validation_errors .= '<div> '.$label.' height should be greater than '. $config['max_height']. 'px </div>'; 
				return false;
			}
			if($_FILES[$index]['size'] > $config['max_size']) {
				$this->validation_errors .= '<div> Maximum file size for '.$label.' should not exceed to '. $config['max_size'] / 1000 . 'KB </div>'; 
				return false;			
			}
			
			return true;
		} else {
			return true;
		}
		
		
	}
	
}

/**ie
 * Prints the $data
 * @param Mixed $data
 */
function pr($data){ echo '<pre style="background: #eee; padding: 10px;">'; print_r($data); echo '</pre>';}

/**
 * Prints the $data and halt the process.(die)
 * @param Mixed $data
 */
function prd($data){ echo '<pre style="background: #eee; padding: 10px;">'; print_r($data); echo '</pre>'; die(); }

/**
 * Function to check if a $data exists and is not empty, if not valid a second parameter will be return.
 * @param Mixed $data
 * @param Mixed $pamalit
 * @return Mixed 
 */
function ie(&$data, $pamalit=''){
    if(isset($data) ){
        if( (empty($data)) || ($data == '') || ($data == ' ')) {return $pamalit; }
        else { return $data; }
    } else {
        return $pamalit;
    }
    
}

/** Function to check if a data has been set and not empty. **/
function issetNotEmpty(&$data) { return isset($data) && (!empty($data)); }

function ei(&$data, $pamalit=''){
    if(isset($data) ){
        if( (empty($data)) || ($data == '') || ($data == ' ')) {return $pamalit; }
        else { return $data; }
    } else {
        return $pamalit;
    }
    
}

/**
 * Function to check if $needle is in a multidimensional array.
 * Same functionality with PHP's in_array function but works with multidimensional arrays
 * @param String $needle
 * @param Array $haystack
 * @param Boolean $strict
 * @return Boolean 
 */
function in_array_r($needle, $haystack, $strict = true) {
    foreach ($haystack as $item) {
        if (($strict ? $item === $needle : $item == $needle) || (is_array($item) && in_array_r($needle, $item, $strict))) {
            return true;
        }
    }

    return false;
}


/**
 * Function to send email via SMTP.
 * 
 * @param String $to
 * @param String $subject
 * @param String $body
 * @return PEAR mail object
 */
function imail($to,$subject,$body) {
	include "/Mail-1.2.0/Mail.php";
	include "/Mail_Mime-1.8.5/Mail/mime.php";
	
	$from = 'thepetropolist@gmail.com';
	$host = "ssl://smtp.gmail.com";
	$port = "465";
	$username = $from;
	$password = "Petropolis2012";				 
	$headers = array ('From' => $from,'To' => $to,'Subject' => $subject);

	$crlf = "\n";
	$mime = new Mail_mime(array('eol' => $crlf));
	$mime->setTXTBody(strip_tags($body));
	$mime->setHTMLBody($body);
	$body = $mime->get();
	$headers = $mime->headers($headers);

	$smtp = Mail::factory('smtp',array ('host' => $host,'port' => $port,'auth' => true,'username' => $username,'password' => $password));				 
	
	return $smtp->send($to, $headers, $body);		
}


function count_stash($pet_id='') {
	$count = 0;
	if (isset($_SESSION['stash'])) {
		if ($pet_id!='') {			
			if (isset($_SESSION['stash'][$pet_id])) {
				foreach ($_SESSION['stash'][$pet_id]['products'] as $product_id=>$data2) {
					foreach ($data2['variations'] as $variant=>$qty) {
						$count += $qty;
					}
				}
			}
		} else {
			foreach ($_SESSION['stash'] as $pet_id=>$data) {
				foreach ($data['products'] as $product_id=>$data2) {
					foreach ($data2['variations'] as $variant=>$qty) {
						$count += $qty;
					}
				}
			}
		}
	}	
	return $count; 
}

function currency_info($code) {
	$info = array(
		'name' => '',
		'code' => '',
		'prefix' => '',
		'suffix' => ''
	);
	switch ($code) {
	case 'usd':
		$info = array(
			'name' => 'US Dollar',
			'code' => 'usd',
			'prefix' => '$',
			'suffix' => ''
		);
		break;
	}
	return $info;
}

function toCurrency($str,$info=array()) {
	return ei($info['prefix']).number_format($str,2,'.',',').ei($info['suffix']);
}