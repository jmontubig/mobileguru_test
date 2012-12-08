<?php

/**
 * Extending the CI Controller * This parent model is responsible for custom functions that are added by Jonathan Montubig.
 * These functions are just global functions needed on controller's area only.
 * To use these functions, just extends your model with MY_Controller, so declaring your controller like these:
 *      class Docs extends MY_Controller {
 *          //your functions and variables here....
 *       }
 * 
 * @copyright January 2012
 * @author Jonathan Montubig
 */

class MY_Controller extends CI_Controller {
    
    var $default_redirect = 'user';
    var $user_login_page = 'user';
    var $allowedActions = array();
    var $forbiddenAreas = array();
    var $hash = '';
    var $page_title = 'Petropolis';
	
	var $data = null;
	var $post_data = null;
    
    
    function __construct()
    {
        parent::__construct();
		
        $this->output->set_header("Cache-Control: no-store, no-cache, must-revalidate, no-transform, max-age=0, post-check=0, pre-check=0");        
        $this->output->set_header("Pragma: no-cache");                      
    }
  
    
    /**
     * Utilizing the CodeIgniter's _remap function
     * to call extra functions with the controller action
     * @see http://codeigniter.com/user_guide/general/controllers.html#remapping
    **/
    public function _remap($method, $args) {
            // Call before action
            $this->before();
            // Always display Session Message if any
            $this->message();
				
                // Call the function from the url
                if(method_exists($this, $method) ){                  
                    call_user_func_array(array($this, $method), $args);                   
                } else { show_404('',FALSE); }
           
            // Call after action
            $this->after();
    }

    /**
     * These shouldn't be accessible from outside the controller
    **/
    protected function before() { 
		$this->load->view('header');
		return;  
	}
    protected function message() { return;  }
    protected function after() { 
		$this->load->view('footer');
		return; 
	}
	
	/**
     * Function to setup Pagination configurations, defaults are setup already, to change the defaults, just add another array parameter that consists of additional configuration
     * Array Format option can be:
     *      Array $config = array(
     *          base_url => ....
     *          total_rows => ...
     *          per_page => ...
     *          full_tag_open => ...
     *          full_tag_close => ...
     *          next_link => ...
     *          prev_link => ...
     *          cur_tag_open => ...
     *          cur_tag_close => ...
     *      )
     * 
     * @param Array $config Referenced array configurations
     * @param Array $options Referenced 
     */
    function set_pagination_config(&$config, $options=null) {
        $config['base_url'] = site_url('/admin/users');
        $config['total_rows'] = $this->db->count_all('users');
        $config['per_page'] = 10;

        $config['full_tag_open'] = '<div class="pages">';
        $config['full_tag_close'] = '</div>';

        $config['next_link'] = '<span class="next">Next</span>';
        $config['prev_link'] = '<span class="prev">Previous</span>';
        
        //$config['query_string_segment'] = 'test';
        
        $config['cur_tag_open'] = '<strong class="current">';
        $config['cur_tag_close'] = '</strong>';
        
        if(!empty($options)) {
            array_merge($config, $options);
        }
                
    }
	
	
	/** VALIDATION FUNCTIONS **/ 	 
	
	/**
    * Validation Function to check if email is valid.
    * @param String $email
    * @return Boolean 
    */
	function check_email_add($email)
	{
		
		if($this->Users->find_email($email)):			
			$this->form_validation->set_message('check_email_add', 'Email is already registered');
			return false;
		else:			
			
			return true;
		endif;
		return false;
		
	}
	
	/**
    * Validation Function to check a valid password.
    * @param type $pwd
    * @return type 
    */
	function valid_pass($pwd) 
	{
		$regex = "/(?=^.{8,12}$)(?=.*[0-9])(?=.*[A-Z])(?=.*[a-z])(?=.*[\W_])^.*/";			
		if (!preg_match($regex,$pwd)):
			$this->form_validation->set_message('valid_pass', 'Password should be more than 5 characters, with at least [1] Capital letter, [1] numeric character, and [1] special character.');
			return false;				 
		endif;
	}
	
	/**
	 * Callback Function to match password
	 */
	function match_passwords($password_check)
    {
        $password = $this->input->post('password');
    
        if($password !== $password_check):
            $this->form_validation->set_message('match_passwords', 'The Password field does not match the Confirm Password field.');
            return FALSE;
        else:
            return TRUE;
        endif;
    } 
	
	/**
    * Validation function to check if captcha is correct.
    * @param String $val
    * @return Boolean 
    */
    
	function check_captcha($val) {
	  if ($this->recaptcha->check_answer($this->input->ip_address(),$this->input->post('recaptcha_challenge_field'),$val)) {
	    return TRUE;
	  } else {
	    $this->form_validation->set_message('check_captcha',$this->lang->line('recaptcha_incorrect_response'));
	    return FALSE;
	  }
	} 

}


class MY_Admin extends MY_Controller {
    var $restricted_pages = array('login' => 'Login');
	
    protected function before() 
    { 
		
		if( (!$this->jm->get_logged_user()) &&  (!array_key_exists($this->uri->rsegment(2), $this->restricted_pages)) ){
			$this->session->set_flashdata('error', 'You are not authorized to access this section.');
			redirect('admin/login'); 
		}
		
        $this->load->view('admin_header');
        return;        
    }
    
    
    protected function after() 
    { 
        $this->load->view('admin_footer');
        return;        
    }

}