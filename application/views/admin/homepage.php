<div class="admin-title">Homepage Phones
<?php echo anchor('admin/phones', 'Go to phones', 'class="small floatRight"'); ?>
</div>
<div class="admin-content">
	<div class="list-div">
		<?php if(validation_errors()){ 
			echo '<div class="error">' .  validation_errors() . '</div>'; 
			
		} 
		
		if(issetNotEmpty($file_error)){
			echo '<div class="error">' .  $file_error . '</div>'; 
		}
		?>
		<?php echo $this->jm->display_session_message(); ?>
		
		
			<?php foreach($banners as $banner) { ?>
				<div class="banner-div">
					<?php echo form_open_multipart('admin/homepage'); 
						echo form_hidden('id', $banner['id']);
					?>
					<table width="100%" border="0" cellpadding="0" cellspacing="0" class="login-table">
						<tr>
							<td class="bold">Homepage Image #<?php echo $banner['id'];?></br></br> </td>
							<td>&nbsp;</td>
						</tr>
						<tr>
							<td class="valign-top">Large Image </td>
							<td>
								<?php echo form_upload(array('name' => 'large_image','id'=> 'large_image', 'value' => $banner['large_image'] )); ?>
								(This should be 782 x 439 pixel in dimension)<br/><br/>
								<?php echo img(array('src' => $this->jm->banner_upload_path.$banner['large_image'], 'width' => 500,  'class' => 'img-banner') ); ?>
								<br/><br/>
								
							</td>
						</tr>
						<tr>
							<td class="valign-top">Small Image </td>
							<td>
								<?php echo form_upload(array('name' => 'small_image','id'=> 'small_image', 'value' => $banner['small_image'])); ?>
								(This should be 194 x 78 pixel in dimension) <br/><br/>
								<?php echo img(array('src' => $this->jm->banner_upload_path.$banner['small_image'], 'height' => 100,  'class' => 'img-banner') ); ?>
								<br/><br/>
								
							</td>
						</tr>
						
						<tr>
							<td>Large Text 1</td>
							<td>								
								<?php echo form_input(array('name' => 'large_text_1','id'=> 'large_text_1', 'maxlength'   => '500', 'size' => '50', 'value' => $banner['large_text_1'] )); ?>
								
							</td>
						</tr>
						
						<tr>
							<td>Large Text 2</td>
							<td>								
								<?php echo form_input(array('name' => 'large_text_2','id'=> 'large_text_2', 'maxlength'   => '500', 'size' => '50', 'value' => $banner['large_text_2'] )); ?>
								
							</td>
						</tr>
														
						<tr>
							<td>Small Text</td>
							<td>								
								<?php echo form_input(array('name' => 'small_text','id'=> 'small_text', 'maxlength'   => '500', 'size' => '50', 'value' => $banner['small_text'] )); ?>
								
							</td>
						</tr>
						
						<tr>
							<td>"Learn More" URL</td>
							<td>								
								<?php echo form_input(array('name' => 'url','id'=> 'url', 'maxlength'   => '500', 'size' => '50', 'value' => $banner['url'] )); ?>
								
							</td>
						</tr>
						
						<tr>
							<td>&nbsp;</td>
							<td>								
								Discount &nbsp;
								<?php echo form_checkbox('discount', $banner['discount'], $banner['discount'], 'id="discount"'); ?>
								&nbsp;&nbsp;
								Time Sensitive 
								&nbsp;
								<?php echo form_checkbox('time_sensitive', $banner['time_sensitive'], $banner['time_sensitive'], 'id="time_sensitive"'); ?>
								
								
							</td>
						</tr>
						
						
						<tr>
							<td>&nbsp;</td>
							<td><input type="submit" id="submit" value="Update Homepage Image" class="login-submit-button" /></td>
						</tr>
					</table>	
					<?php echo form_close(); ?>
				</div>
			<?php } ?>							
		
	</div>
</div>

<script>
$(document).ready(function(){
	$('#discount').click(function() {
		$('#time_sensitive').attr('value', '0').removeAttr('checked');
		if($(this).val() == '1') { $(this).attr('value', '0');}
		else { $(this).attr('value', '1');}
	});
	
	$('#time_sensitive').click(function() {
		$('#discount').attr('value', '0').removeAttr('checked');
		if($(this).val() == '1') { $(this).attr('value', '0');}
		else { $(this).attr('value', '1');}
	});
});
function toggleCheckbox(el){
	console.log(el.val());
	
}
</script>