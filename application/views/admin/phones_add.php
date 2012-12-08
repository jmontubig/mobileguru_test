<div class="admin-title">Add a New Phone 
	<?php echo anchor('admin/homepage', 'Goto homepage phones', 'class="small floatRight"'); ?>
	<?php echo anchor('admin/phones', 'Phones', 'class="small floatRight" style="padding: 0 10px;"'); ?>
</div>
<div class="admin-content">
	<div class="list-div">
		<?php if(validation_errors()) { 
			echo '<div class="error">' .  validation_errors() . '</div>'; 			
		} 
		
		if(issetNotEmpty($file_error)){
			echo '<div class="error">' .  $file_error . '</div>'; 
		}
		
			echo $this->jm->display_session_message(); 
			echo form_open_multipart('admin/phones/add', '', $hiddenlist ); 
			echo '<table width="100%" border="0" cellpadding="0" cellspacing="0" class="phone-add-table"> ';
			
			foreach($display_fields as $field => $label){	
				echo '<tr>';
					echo '<td>'. $label . '</td>';
					echo '<td>';
						/*
						if(($field == 'brand_id') || ($field == 'type_id') ) {
							echo $phone[$field]['label'];
						} 
						elseif(($field == 'image')) {
							echo img(array( 'src' => 'images/'.$phone[$field], 'height' => 100) );							
						}
						elseif(($field == 'created') || ($field == 'updated') ) {
							echo $this->jm->format_date($phone[$field], false);							
						} else {
							echo $label;
						}
						*/
						$option = array('name' => $field, 'value' => (set_value($field) == '') ? '' : set_value($field) );	
						//if(set_value($alias) == '') { $option['value'] = date('Y-m-d H:i:s'); }
						
						if($this->jm->isFK($field)){   
							   
							   if($field == 'brand_id') { $list = $this->Phones->getBrandList(); } 
							   else if($field == 'type_id') { $list = $this->Phones->getTypeList(); } 
							   else {  $list = ${$this->jm->isFK($field, true)}; }
								$form_input = form_dropdown($field, $list, $option['value']);
								
						} else {
							if($field == 'image'){
								$form_input = form_upload(array('name' => $field,'id'=> $field, 'value' => (set_value($field) ? set_value($field) : '') ));
							} else if($field == 'descp') {
								$form_input = form_textarea(array('rows' => 2, 'name' => $field,'id'=> $field, 'value' => (set_value($field) ? set_value($field) : '') ));
							} else {
								$form_input = $this->jm->get_form_field( $this->jm->get_field_type($field, $fields ), $option );    
							}

						}
						
						 echo '<div class="field">' . $form_input . '</div>';
						
					echo '</td>';
				echo '</tr>';
			}
			echo '<tr><td>&nbsp;</td><td>';
				 echo form_submit(array('value' => 'Add New Phone') );
				echo form_reset(array('value' => 'Reset')) . '&nbsp;';
               
			echo '</td></tr>';
			echo '</table>';
			echo form_close();
		?>
		
	</div>
</div>	
	
