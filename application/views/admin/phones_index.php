<div class="admin-title">Phones 
	<?php echo anchor('admin/homepage', 'Goto homepage phones', 'class="small floatRight"'); ?>
</div>
<div class="admin-content">
	<div class="list-div">
		<?php if(validation_errors()){ 
			echo '<div class="error">' .  validation_errors() . '</div>'; 
			
		} ?>
		
		<?php echo anchor('admin/phones/add', 'Add a New Phone', 'class="button"'); ?>
		<br/><br/>
		<?php echo $this->jm->display_session_message(); ?>
		<table width="100%" border="0" cellpadding="0" cellspacing="0" class="phone-list-table"> 
		
		<?php 
			echo '<tr>';
			foreach($display_fields as $field => $label){				
					echo '<td class="thead">';
						echo $label;
					echo '</td>';				
			}
			echo '<td class="thead">';
					echo 'Action';
				echo '</td>';
			echo '</tr>';
			foreach($phones as $phone){
				echo '<tr>';
					foreach($display_fields as $field => $label){	
						echo '<td>';
							if(($field == 'brand_id') || ($field == 'type_id') ) {
								echo $phone[$field]['label'];
							} 
							elseif(($field == 'image')) {
								echo img(array( 'src' => 'images/phones/'.ie($phone[$field], 'default-phone.png'), 'height' => 100) );							
							}
							elseif(($field == 'created') || ($field == 'updated') ) {
								echo $this->jm->format_date($phone[$field], false);							
							} else {
								echo $phone[$field];
							}
							
						echo '</td>';
					}
					echo '<td>';
						echo anchor('admin/phones/edit/'.$phone['id'], 'edit', 'class="button"');
						echo '&nbsp;&nbsp;';
						echo anchor('admin/phones/delete/'.$phone['id'], 'delete', 'class="button delete-button"');
					echo '</td>';
				echo '</tr>';
			}
			
			
		?>
		</table>
		
		<?php echo (isset($pagination) ? $pagination : '' ); ?>
	</div>
</div>

<script>
	$(document).ready(function() {
		$('.delete-button').click(function() {
			if(confirm('Are you sure you really want to delete this phone?') ){
				return true;
			} else {
				return false;
			}
		});
	});
</script>
