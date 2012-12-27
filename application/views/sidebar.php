<?php 
	$page = $this->uri->rsegment(1); 
	$sub_page = $this->uri->rsegment(3);  
?>

<div class="sidebar-top">
	<a href="<?php echo site_url('/contact'); ?>" target="blank">
	<?php echo img('/images/sidebar-top.jpg'); ?>
	</a>
</div>

<div class="sidebar-content-div ptsans"> 
	
	<div class="sidebar-content">
		<div class="breather">
			<div class="oswald cap title">Location</div>
			<div class="ptsans">275 Greenwich St <br/>
			New York, NY 10007</div>
			<br/>
			<div class="oswald cap title">Phone</div>
			<div class="ptsans">(212) 346-9662</div>
		</div>
		<?php /* 
		
		
		<iframe width="177" height="127" frameborder="0" scrolling="no" marginheight="0" marginwidth="0" src="https://maps.google.com/maps?f=q&amp;source=s_q&amp;hl=en&amp;geocode=+&amp;q=275+Greenwich+St++New+York,+NY+10007&amp;ie=UTF8&amp;hq=&amp;hnear=275+Greenwich+St,+New+York,+10007&amp;t=m&amp;ll=40.717079,-74.010258&amp;spn=0.008262,0.015278&amp;z=14&amp;iwloc=A&amp;output=embed"></iframe><br />
	*/ ?>
	<a href="https://maps.google.com/maps?q=275+Greenwich+St,+New+York,+NY+10007,+United+States&hl=en&sll=37.09024,-95.712891&sspn=34.808514,86.572266&oq=275+Greenwich+St++New+York,+NY+10007&hnear=275+Greenwich+St,+New+York,+10007&t=m&z=16" target="blank">
			<?php echo img('/images/sidebar-map.jpg'); ?>
		</a>
		
	
	
		<?php /* 
		<script src="https://maps.googleapis.com/maps/api/js?v=3.exp&sensor=false"></script>
		 <script>
		  //function initialize() {
			$(document).ready(function() { 
			var mapOptions = {
			  zoom: 1,
			  center: new google.maps.LatLng(40.717079, -74.010258),
			  disableDefaultUI: true,
			  mapTypeId: google.maps.MapTypeId.ROADMAP
			
			};
			
			var map = new google.maps.Map(document.getElementById('map_canvas'), mapOptions);
		  
		  
			}); 
		  
		</script>
		<div id="map_canvas" style="width: 177px ;height: 127px; "></div>
		*/ ?>
	
		<br/>
		<ul class="sidebar-main-menu-list">
			<!-- DEVICES -->
			<li class="<?php echo ($page == 'devices') ? 'current active' : ''; ?>">
				<div class="sidebar-menu-div">
					<div class="sidebar-count">23</div>
					<div class="title metrophobic cap">Devices</div>
					<ul class="sidebar-menu-list">
						<li class="<?php echo ($sub_page == 'basic-phones') ? 'current' : ''; ?>">
							<?php echo anchor('/devices/basic-phones','Basic Phones'); ?>
						</li>
						<li class="<?php echo ($sub_page == 'smartphones') ? 'current' : ''; ?>">
							<?php echo anchor('/devices/smartphones','Smart Phones'); ?>
						</li>
						<li class="<?php echo ($sub_page == 'tablets') ? 'current' : ''; ?>">
							<?php echo anchor('/devices/tablets','Tablets'); ?>
						</li>
						<li class="<?php echo ($sub_page == 'hotspots') ? 'current' : ''; ?>">
							<?php echo anchor('/devices/hotspots','Hotspots'); ?>
						</li>
						<li class="<?php echo ($sub_page == 'home-phone') ? 'current' : ''; ?>">
							<?php echo anchor('/devices/home-phone','Homephone'); ?>
						</li>										
					</ul>
				</div>
			</li>
			
			<!-- PLANS -->
			<li class="<?php echo ($page == 'plans') ? 'current active' : ''; ?>">
				<div class="sidebar-menu-div">
					<div class="sidebar-count">3</div>
					<div class="title metrophobic cap">Plans</div>									
					<ul class="sidebar-menu-list">
						<li><?php echo anchor('/','Lorem Ipsum'); ?></li>
						<li><?php echo anchor('/','Lorem Ipsum'); ?></li>
						<li><?php echo anchor('/','Lorem Ipsum'); ?></li>
						<li><?php echo anchor('/','Lorem Ipsum'); ?></li>																	
					</ul>
				</div>
			</li>
			
			
			<!-- ACCESSORIES-->
			<li class="<?php echo ($page == 'accessories') ? 'current active' : ''; ?>">
				<div class="sidebar-menu-div">
					<div class="sidebar-count">94</div>
					<div class="title metrophobic cap">Accessories</div>									
					<ul class="sidebar-menu-list">
						<li class="<?php echo (($sub_page == 'cases-covers-and-holsters') ||  ( ($page == 'accessories') && ($sub_page == '') ) ) ? 'current' : ''; ?>">
							<?php echo anchor('/accessories','Cases, Covers and Holsters'); ?>
						</li>
						
						<li class="<?php echo ($sub_page == 'chargers-and-cables') ? 'current' : ''; ?>">
							<?php echo anchor('/accessories/chargers-and-cables','Chargers and Cables'); ?>
						</li>
												
						<li class="<?php echo ($sub_page == 'display-protection') ? 'current' : ''; ?>">
							<?php echo anchor('/accessories/display-protection','Display Protection'); ?>
						</li>
						<li class="<?php echo ($sub_page == 'headsets') ? 'current' : ''; ?>">
							<?php echo anchor('/accessories/headsets','Headsets'); ?>
						</li>
						
															
					</ul>
				</div>
			</li>
			
			<!-- PROTECTION-->
			<li class="<?php echo ($page == 'protection') ? 'current active' : ''; ?>">
				<div class="sidebar-menu-div">
					<div class="sidebar-count">2</div>
					<div class="title metrophobic cap">Protection</div>	
					<ul class="sidebar-menu-list">
						<li><?php echo anchor('/','Lorem Ipsum'); ?></li>
						<li><?php echo anchor('/','Lorem Ipsum'); ?></li>
						<li><?php echo anchor('/','Lorem Ipsum'); ?></li>
						<li><?php echo anchor('/','Lorem Ipsum'); ?></li>																	
					</ul>
				</div>
			</li>
			
		</ul>
		
	
		
	</div>
</div>