
<div class="top-images">
		<?php foreach($banners as $banner) { ?>
			<div class="top-img <?php echo 'banner_'. $banner['id']; ?>" rel="<?php echo 'banner_'. $banner['id']; ?>">
				<div class="left-panel">
					<div class="large-text1"><?php echo $banner['large_text_1']; ?></div>
					<div class="large-text2"><?php echo $banner['large_text_2']; ?></div>
					<div class="learn-more"><?php echo anchor($banner['url'],'Learn More'); ?></div>
				</div>
				
				<?php echo img(array('src' => $this->jm->banner_upload_path.$banner['large_image'], 'width' => 782, 'height' => 439, 'class' => 'img-banner') ); ?>
			</div>
		<?php } ?>

		<?php echo img(array('src' => 'images/banner-left.png', 'width' => 782,  'class' => 'banner-left') ); ?>
		<?php echo img(array('src' => 'images/banner-right.png', 'width' => 782,  'class' => 'banner-right') ); ?>
									
	</div>
	
	<div class="indicator-div">
		<div class="red-indicator"></div>
		<div class="indicator"></div>						
	</div>
	
	<ul class="banner-tab-list" >
		<?php foreach($banners as $banner) { ?>
			<li class="banner-tab <?php echo 'banner_'. $banner['id']; ?>" rel="<?php echo 'banner_'. $banner['id']; ?>" style="background:url(<?php echo $this->jm->banner_upload_path.$banner['small_image']; ?>);" >
				<div class="name"><?php echo $banner['small_text']; ?></div>
				<div class="overlay"></div>
				<?php 
					if($banner['discount']) { echo '<div class="dollar"></div>'; } 
					else if($banner['time_sensitive']) { echo '<div class="clock"></div>'; }
					else {}					
				?>
			</li>
		<?php } ?>
		
	</ul>
					
<script>
$(function() {
	$('.top-images .top-img').hide().first().show().addClass('active');
	$('.banner-tab-list li').first().addClass('active');
    setInterval( "slideSwitch()", 3000 );
});

</script>					