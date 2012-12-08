<div class="admin-title">Admin Login</div>
<div class="admin-content">
	
	<div class="login-div">
		<?php if(validation_errors()){ 
			echo '<div class="error">' .  validation_errors() . '</div>'; 
			echo form_error('_check_email'); 
		} ?>
		<?php echo $this->jm->display_session_message(); ?>
		
		
		<?php echo form_open('admin/login'); ?>
			
		<table width="500" border="0" cellpadding="0" cellspacing="0" class="login-table">
			
			<tr>
				<td>Username: &nbsp; </td>
				<td>
					
					<?php
						echo form_input(array(
							  'name'        => 'username',
							  'id'          => 'username',              
							  'maxlength'   => '100',
							  'size'        => '50'              
						));
					?>
					<span class="red bold">*</span>
				</td>
			</tr>
			<tr>
				<td>Password: &nbsp; </td>
				<td>
					<?php
						echo form_password(array(
							  'name'        => 'password',
							  'id'          => 'password',              
							  'maxlength'   => '100',
							  'size'        => '50'              
						));
					?>
					<span class="red bold">*</span>				
				</td>
			</tr>
			<tr>
				<td>&nbsp;</td>
				<td><input type="submit" id="signin" value="Login" class="login-submit-button" /></td>
			</tr>
		</table>	
		<?php echo form_close(); ?>
	
	</div>
</div>