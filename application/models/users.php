<?php 

/**
 * Users Model
 *
 * This model handles read and write functions for Brand Object
 *
 */
class Users extends MY_Model
{
	var $table_name = 'users';
	var $alias = 'Users';
	
	function __construct()
	{		 
		parent::__construct();
		
		//set class scope variables
		$this->display_field = 'username';
		$this->display_fields = array(
			'username' => 'Username'			
		);
	}
	
	/** Function to check if user already exists in database **/
	function check_user_login($username, $password)
	{
		$salt = $this->db->select('salt')->get_where('users', array('username' => $username))->row();
		
		if(!isset($salt->salt)) return 0; //check if email exists
        else {$salt = $salt->salt; }
		
		if ($salt !='') {
			$pw = sha1($salt.sha1($salt.$password));
            $this->db->select('*');
    		$this->db->from('users');
    		$this->db->where('username', $username);
    		$this->db->where('password', $pw);                        
    		$users = $this->db->get();
            $users = $users->result();

    		if(empty($users)) return -1;
    		$results = array();
            
    		foreach($users as $user){
    			$results['id'] = $user->id;    			
    			$results['username'] = $user->username;
			}
			
			return $results; 
			
		} else {
			return -2;
		}
	}
}
