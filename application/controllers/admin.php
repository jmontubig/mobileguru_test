<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Admin extends MY_Admin {
	
	public function login() {
		
		if($this->jm->get_logged_user()){
			$this->session->set_flashdata('error', 'You are already logged in.');
			redirect('admin/homepage'); 
		}
		
		$validation = $this->form_validation; 
								
		$validation->set_rules('username','Username','required|xss_clean');			
		$validation->set_rules('password', 'Password', 'required|xss_clean');		
		//$salt = '1f77032a7cb2cdf4a72f13ffa22bc04742fda05a';
		//$password = 'Admin2011';
		
		//pr(sha1($salt.sha1($salt.$password)));
		
		//pr($salt.$password);	
		if($this->input->post(null, TRUE)) { 
			if ($validation->run()) {	
				$validate_user = $this->Users->check_user_login($this->input->post('username'), $this->input->post('password'));
				if($validate_user){
					$this->session->set_flashdata('success', 'Logged In Successfully');			
					$this->session->set_userdata('users', $validate_user);
					redirect('admin/homepage');
					
				} else {
					$this->session->set_flashdata('error', 'Login Failed!');				
					redirect('admin/login');
				}
			}
		}
		
		$this->load->view('admin/login');
	}
	
	public function logout(){
		$this->session->unset_userdata('users');
		$this->session->set_flashdata('success', 'Logout Successfully!');				
		redirect('admin/login');
	}
	
	/**
	 * Admin Function for homepage images
	 */
	public function homepage(){
		
		$this->data['banners'] = $this->Homepages->get_all(null, false);
		
		$validation = $this->form_validation; 
        $validation->set_rules('large_text_1', 'Large Text 1', 'required|trim|xss_clean|max_length[500]');	
        $validation->set_rules('large_text_2', 'Large Text 2', 'required|trim|xss_clean|max_length[500]');	
		$validation->set_rules('small_text', 'Small Text', 'required|trim|xss_clean|max_length[500]');	
		
		if($this->input->post(NULL, true)){
			
			//pr($this->input->post());
			//pr($_FILES);
			$tmp_files = $_FILES;
			//prd($this->Files->check_header_size());
			$id = $this->input->post('id');
			$data = array(
				'large_text_1'=> $this->input->post('large_text_1'),
				'large_text_2'=> $this->input->post('large_text_2'),
				'small_text'=> $this->input->post('small_text'),
				'url'=> $this->input->post('small_text'),
				'time_sensitive'=> $this->input->post('time_sensitive') ? 1:0,
				'discount'=> $this->input->post('discount') ? 1:0
			);
			$post_data = $this->input->post(); //prd($data);	
			$h_phone = $this->Homepages->get($id, true);
			//if(isset($post_data['time_sensitive'])) { $data['time_sensitive'] = 1; }
			//else { $data['time_sensitive'] = 0; }
			//if(isset($post_data['discount'])) { $data['discount'] = 1; }
			
			$config['upload_path'] = './images/banners/';
			$config['allowed_types'] = 'gif|jpg|png';
			$config['encrypt_name']	= true;
			$config['max_size']	= '2000';			
			$config['max_width']  = '1024';
			$config['max_height']  = '768';
			$file_error = '';
			$error = 0;
			
			if($validation->run()){						
				
				$this->load->library('upload', $config);
				//prd($_FILES);
				foreach($tmp_files as $i => $file){
					$_FILES = array();
					if($error) break; 

					$_FILES['userfile']['name']    = $file['name'];
					$_FILES['userfile']['type']    = $file['type'];
					$_FILES['userfile']['tmp_name'] = $file['tmp_name'];
					$_FILES['userfile']['error'] = $file['error'];				
					$_FILES['userfile']['size'] = $file['size'];
					
					if(!empty($_FILES['userfile']['name'])) {
						if (!$this->upload->do_upload()) {
							$file_error .= $this->upload->display_errors('<div>', '</div>');						
							$error = 1;
						} else {
							$file_data = $this->upload->data();
							$data[$i] = $file_data['file_name'];
						}
					}
				}
				
				if(!$error) { //no upload errors
				
					$this->db->where('id',$id);
					$this->db->update('homepages',$data);
					
					if(issetNotEmpty($data['large_image'])) { unlink($this->jm->get_base_path('images/banners').'/'.$h_phone['large_image']); }
					if(issetNotEmpty($data['small_image'])) { unlink($this->jm->get_base_path('images/banners').'/'.$h_phone['small_image']); }
					
					$this->session->set_flashdata('success', 'Header Image #'.$id.' was successfully updated!');	
					redirect('admin/homepage');		
				} else {
					$this->data['file_error'] = $file_error;
				}				
			}
			
		}
		$this->load->view('admin/homepage', $this->data);
	}
	
	/**
	 * Function for phones
	 */ 
	public function phones($action='index', $id=null){
		
		$this->display_fields = array(
			'image' => 'Phone Image',
			'name' => 'Name',
			'brand_id' => 'Brand',
			'type_id' => 'Type',
			'descp' => 'Description',
			'price' => 'Price',
			'duration' => 'Duration'
			
		);
				
		
		$this->data['display_fields'] = $this->display_fields;
		$this->data['fields'] = $this->db->field_data('phones');
		$this->data['hiddenlist'] = array('created' => date('Y-m-d H:i:s'), 'updated' => date('Y-m-d H:i:s'));
		
		//setups
		if($action == 'index') {
			
			$this->data['phones'] = $this->Phones->get_all(null, false);
		} else if( ($action == 'edit') || ($action == 'delete') ) {
			
			$phone = $this->Phones->get($id, true);
			$this->data['phone'] = $phone;
			//pr($id);	
			$this->data['id'] = $id;
			//prd($this->data['phone']);
		} else { } 
		
		//prd($this->Phones->get($id, true));
		//for delete action
		if( $action == 'delete' ) {
			if(empty($id) && empty($phone) ) {				
				$this->session->set_flashdata('error','Invalid Request!');	
				redirect('admin/phones');
			} else {
				$this->db->delete('phones', array('id' => $id)); 
				
				//remove old pic on server
				unlink($this->jm->get_base_path('images/phones').'/'.$phone['image']);						
				$this->session->set_flashdata('success',$phone['name'].' has been successfully deleted!');	
				
				
				redirect('admin/phones');
			}
		}
		
		
		//validation
		foreach($this->display_fields as $dfield => $dlabel){
			if($dfield != 'image'){
				$this->form_validation->set_rules($dfield, $dlabel, 'required|trim|xss_clean');
			} else {
				$this->form_validation->set_rules($dfield, $dlabel, 'trim|xss_clean');
			}
		}
		
		
		//post data processing
		if($this->input->post(null, TRUE)) {
			$post = $this->input->post(null, TRUE); 
            //$this->Phones->set_form_validation($this->form_validation); 
			
			 if($this->form_validation->run() ){  
				$tmp_files = $_FILES;
				
				$config['upload_path'] = './images/phones/';
				$config['allowed_types'] = 'gif|jpg|png';
				$config['encrypt_name']	= true;
				$config['max_size']	= '2000';			
				$config['max_width']  = '1024';
				$config['max_height']  = '768';
				$file_error = '';
				$error = 0;
				
				$this->load->library('upload', $config);
				foreach($tmp_files as $i => $file){
					$_FILES = array();
					if($error) break; 

					$_FILES['userfile']['name']    = $file['name'];
					$_FILES['userfile']['type']    = $file['type'];
					$_FILES['userfile']['tmp_name'] = $file['tmp_name'];
					$_FILES['userfile']['error'] = $file['error'];				
					$_FILES['userfile']['size'] = $file['size'];
					
					if(!empty($_FILES['userfile']['name'])) {
						if (!$this->upload->do_upload()) {
							$file_error .= $this->upload->display_errors('<div>', '</div>');						
							$error = 1;
						} else {
							$file_data = $this->upload->data();
							$post[$i] = $file_data['file_name'];
						}
					}
				}
				//prd($post);
				if(!$error) { //no upload errors
					
					$this->db->where('id',$id);
					
					if($action == 'add'){
						
						$this->db->insert('phones',$post);
						$this->session->set_flashdata('success', $post['name'].' has been added successfully!');	
						
					} else if($action == 'edit') {
						
						
						$this->db->where('id',$id);
						$this->db->update('phones',$post);
						
						//remove old pic on server
						unlink($this->jm->get_base_path('images/phones').'/'.$phone['image']);						
						$this->session->set_flashdata('success', $post['name'].' has been updated successfully!');	
						
					}
					
					redirect('admin/phones');		
				} else {
					$this->data['file_error'] = $file_error;
				}				
				
				
				
			 } 
		}
		//prd($action);
		
		//views
		if($action == 'index') { $this->listing(); } 
		else { $this->load->view('admin/phones_'.$action, $this->data);	}
		
		//pr($this->data['phones']);
		
		//$this->load->view('admin/phones_'.$action, $this->data);			
	}
	
	protected function listing($order='name-asc', $filter_by='all', $limit=10, $offset=0) {
		//$this->listing();prd($this->session);

		$this->display_fields = array(
			'image' => 'Phone Image',
			'name' => 'Name',
			'brand_id' => 'Brand',
			'type_id' => 'Type',
			'descp' => 'Description',
			'price' => 'Price',
			'duration' => 'Duration',			
			'created' => 'Date Created'
		);
		
		//$this->Users->get_most_purchased_brands();
		//$this->data['users'] = $query->result_array();
		$this->data['options'] = array(
			'order' => $order,
			'filter_by' => $filter_by,
			'limit' => $limit,
			'offset' => $offset
		); 
		// //pr($this->data['options']);
		$this->data['display_fields'] = $this->display_fields;
		
		$aray = explode('-',$order);
		$sortby = trim($aray[0]);
		$sortdir = trim($aray[count($aray)-1]);
		//pr($this->display_fields);

		if (!isset($this->display_fields[$sortby])) {
			$this->session->set_flashdata('error', 'Sort field is not correct.');
			redirect('admin/phones');
		}
		if (!in_array($sortdir,array('asc','desc'))) {
			$sortdir = 'asc';
		}
		$sort_order = $sortby. ' '. $sortdir;
		//pr($sort_order);
		$this->data['sortby'] = $sortby;
		$this->data['sortdir']  = $sortdir;
		
		//PAGINATIONS
		$this->load->library('pagination');			
		$config = array();                
		$this->set_pagination_config($config);
		$cond = array();
		$like = array();
		
		if( $filter_by != 'all')  {
			if(array_key_exists($filter_by, $this->display_fields)) 
			{ 
				$like = array('name' => $filter_by );
			}
			
		}
		
		//$this->db->where('users', $cond);
		//if(!empty($like)) $this->db->or_like($like);
		//$all = $this->db->get();
		
		$all = $this->Phones->get_data('phones',null, null, $sort_order, $cond, $like);	
		$this->data['phones'] = $this->Phones->get_data('phones',$limit, $offset, $sort_order, $cond, $like);	
		$this->data['overall_count'] = count($all);
		//pr($all);
		
		
		//pr($this->data['phones']);
		

		$config['num_links'] = 4;
		$config['total_rows'] = count($all);
		$config['base_url'] = site_url('/admin/listing/'. $sortby . '-' . $sortdir . '/' . $filter_by.'/'.$limit );
		$config['per_page'] = $limit;
		$config['uri_segment'] = 6;

		$this->pagination->initialize($config); 
		$this->data['pagination'] = $this->pagination->create_links();
		$this->load->view('admin/phones_index',$this->data);
	}
	
	
}