<?php $this->load->view('home-banner'); ?>
<div class="content-lower-float-holder clearfix">
	<div class="floatLeft">
		<div class="img-hover carousel">
			<div class="unhover">
				<?php echo img('/images/phone.jpg'); ?>
			</div>
			<div class="hover">
				<?php $this->load->view('home-carousel'); ?>
			</div>
		</div>
		
		<div class="clearfix">
			<div class="floatLeft"><a href="<?php echo base_url('/plans');?>"><?php echo img('/images/right-plan.jpg'); ?></a></div>
			<div class="floatRight"><a href="<?php echo base_url('/accessories');?>"><?php echo img('/images/accessories.jpg'); ?></a></div>
		</div>
		
		
	</div>
	
	<div class="floatRight">
		<a href="<?php echo base_url('/business');?>">
			<?php echo img('/images/bussiness.jpg', 'width="259" height="397"'); ?>
		</a>
	</div>
	
	
</div>
<br/><br/><br/><br/>
					
				
