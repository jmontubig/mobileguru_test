<script src="<?php echo site_url('/js/data_calculator.js'); ?>" type="text/javascript"></script>
<!-- TAB LISTS -->
<ul class="phone-cat-list plan-steps tab-list">
	<li class="current tab1-select">
		<?php echo anchor('#','1 Choose your Devices'); ?>
	</li>
	
	<li>
		<?php echo anchor('#','2 Calculate your data usage'); ?>
	</li>
	
	<li>
		<?php echo anchor('#','3 Your Monthly Plan'); ?>
	</li>	
</ul>
<div class="tab-holder-div">

	<br/>
	<div class="tab1 choose tab">
		<div class="rbno2 cap title">How many of each type of device will you have on your account?</div>
		<div class="tab-list-holder">
			<ul class="tab-list clearfix">
				<li>
					<div class="tab-img centerText">
						<a href="#">
						<?php echo img('images/smartphone.png'); ?>
						</a>
					</div>
					<div class="tab-title oswald cap centerText">
						Smartphone
					</div>
					
					<select autocomplete="false" id="smartphone_count" class="dropdown">
						<option value="0">0</option>
						<option value="1">1</option>
						<option value="2">2</option>
						<option value="3">3</option>
						<option value="4">4</option>
						<option value="5">5</option>
						<option value="6">6</option>						
					</select>

				</li>
				
				<li>
					<div class="tab-img centerText">
						<a href="#">
						<?php echo img('images/basicphone.png'); ?>
						</a>
					</div>
					<div class="tab-title oswald cap centerText">
						Basic Phone
					</div>
					
					<select autocomplete="false" id="basicphone_count" class="dropdown">
						<option value="0">0</option>
						<option value="1">1</option>
						<option value="2">2</option>
						<option value="3">3</option>
						<option value="4">4</option>
						<option value="5">5</option>
						<option value="6">6</option>						
					</select>
					
				</li>
				
				<li>
					<div class="tab-img centerText">
						<a href="#">
						<?php echo img('images/tablet.png'); ?>
						</a>
					</div>
					<div class="tab-title oswald cap centerText">
						Tablet
					</div>
					
					<select autocomplete="false" id="tablet_count" class="dropdown">
						<option value="0">0</option>
						<option value="1">1</option>
						<option value="2">2</option>
						<option value="3">3</option>
						<option value="4">4</option>
						<option value="5">5</option>
						<option value="6">6</option>						
					</select>
					
				</li>
				
				<li>
					<div class="tab-img centerText">
					<a href="#">
						<?php echo img('images/internetservice.png'); ?>
					</a>
					</div>
					<div class="tab-title oswald cap centerText">
						Internet Service
					</div>
					
					<select autocomplete="false" id="internetservice_count" class="dropdown">
						<option value="0">0</option>
						<option value="1">1</option>
						<option value="2">2</option>
						<option value="3">3</option>
						<option value="4">4</option>
						<option value="5">5</option>
						<option value="6">6</option>						
					</select>
				</li>
				
			</ul>
			
			><div class="start-calculate-btn" style="display: none;">Start Calculating</div>
			<div class="plan-lines"><?php echo img('images/plans-line.jpg'); ?></div>
		</div>
	</div>
	
	<!-- ==============TAB 2 ============== -->
	<div class="tab2 calculate tab" style="display: none;">
		<div class="rbno2 cap title">How much data will each of these devices use every month? Select one to begin</div>
		
		<ul class="tab2-list tab-list clearfix">								
				<li></li>				
		</ul>
		
		
		<div class="slider-div" id="slider-div">
			
			<!-- EMAIL -->
			<div class="email-slider-div">
				<div class="slider-title">
					<span class="oswald cap valign-center title-main">Email</span>
					&nbsp;&nbsp;&nbsp;
					<span class="arial valign-center">About how many emails do you send/receive every day?</span>
				</div>
				<div class="slider-title-holder">
					<div class="slider-holder">
						<div class="slider-bar"></div>
						<div class="slider-texts">
							<div class="marker first selected" rel="email" >0</div>
							<div class="marker second" rel="email">5</div>
							<div class="marker third" rel="email">25</div>
							<div class="marker fourth" rel="email">50</div>
							<div class="marker fifth" rel="email">100</div>
							<div class="marker last" rel="email">250</div>
							
						</div>
					</div>
					
					<div class="slider-amount">
						29 MB/mo
					</div>
					
					
				</div>
			</div>
			
			
			<!-- WEB -->
			<div class="web-slider-div">
				<div class="slider-title">
					<span class="oswald cap valign-center title-main">Web</span>
					&nbsp;&nbsp;&nbsp;
					<span class="arial valign-center">About how many web pages do you visit every day?</span>
				</div>
				<div class="slider-title-holder">
					<div class="slider-holder">
						<div class="slider-bar"></div>
						<div class="slider-texts">
							<div class="marker first selected" rel="web">0</div>
							<div class="marker second" rel="web">5</div>
							<div class="marker third" rel="web">25</div>
							<div class="marker fourth" rel="web">50</div>
							<div class="marker fifth" rel="web">100</div>
							<div class="marker last" rel="web">250</div>
							
						</div>
					</div>
					
					<div class="slider-amount">
						29 MB/mo
					</div>
					
					
				</div>
			</div>
			
			
			
			<!-- MUSIC -->
			<div class="music-slider-div">
				<div class="slider-title">
					<span class="oswald cap valign-center title-main">Music</span>
					&nbsp;&nbsp;&nbsp;
					<span class="arial valign-center">About how many minutes do you stream music every day?</span>
				</div>
				<div class="slider-title-holder">
					<div class="slider-holder">
						<div class="slider-bar"></div>
						<div class="slider-texts">
							<div class="marker first selected" rel="music">0</div>
							<div class="marker second" rel="music">5</div>
							<div class="marker third" rel="music">15</div>
							<div class="marker fourth" rel="music">60</div>
							<div class="marker fifth" rel="music">120</div>
							<div class="marker last" rel="music">240</div>							
						</div>
					</div>
					
					<div class="slider-amount">
						29 MB/mo
					</div>
					
					
				</div>
			</div>
			
			
			
			<!-- Video -->
			<div class="video-slider-div">
				<div class="slider-title">
					<span class="oswald cap valign-center title-main">Video</span>
					&nbsp;&nbsp;&nbsp;
					<span class="arial valign-center">About how many minutes do you stream videos every day?</span>
				</div>
				<div class="slider-title-holder">
					<div class="slider-holder">
						<div class="slider-bar"></div>
						<div class="slider-texts">
							<div class="marker first selected" rel="video">0</div>
							<div class="marker second" rel="video">2</div>
							<div class="marker third" rel="video">10</div>
							<div class="marker fourth" rel="video">30</div>
							<div class="marker fifth" rel="video">60</div>
							<div class="marker last" rel="video">120</div>							
						</div>
					</div>
					
					<div class="slider-amount">
						29 MB/mo
					</div>
					
					
				</div>
			</div>
			
			
			
			
			
			
		</div>
		<br/>
		<div class="calculate-total-btn" style="display: none;">Calculate Estimates</div>
		<br/>
		<div class="plan-lines"><?php echo img('images/plans-line.jpg'); ?></div>
	
	</div><!-- end of tab 2 -->
	
	<!-- =================  TAB 3  ================ -->
	<div class="tab3 estimates tab" style="display: none;">
		<div class="rbno2 cap title">Your Estimated Monthly Plan</div>
		
		<ul class="tab3-list tab-list clearfix">								
				<li></li>				
		</ul>
		
	</div>
	
	<div class="foot-note">
		These are just estimates, and data transfer amounts will vary. Downloads that buffer, such as streaming music and video, will bill for all of the data that has been downloaded, even though you may not have listened to or watched the entire download. Please regularly check and manage your usage.		
	</div>

</div>

<div class="content-footer">
	&copy; 2012 Mobile guru. All rights reserved<br/>
	275 Greenwich St, New YOrk, NY 10007<br/>
	212.346.9662<br/>
</div>