<?php     
echo doctype('html4-trans'); 
?>	
<html>
<head>
	<?php 
            $meta = array(
                array('name' => 'robots', 'content' => 'no-cache'),
                array('name' => 'description', 'content' => 'MobileGuru'),
                array('name' => 'keywords', 'content' => 'mobile, technology, guru, mobileguru, phones'),
                array('name' => 'robots', 'content' => 'no-cache'),
                array('name' => 'Content-type', 'content' => 'text/html; charset=utf-8', 'type' => 'equiv')
            );
            echo meta($meta); 
        ?>
	<title><?php echo (isset($title) ? 'MobileGuru - '.$title : 'MobileGuru') ; ?></title>
	
	<?php //////ICONS///// ?>        
        <link rel="shortcut icon" type="image/x-icon" href="<?php echo site_url('/images/favicon.ico'); ?>">
        <link href="<?php echo site_url('/images/apple-touch-icon.png'); ?>" rel="apple-touch-icon" />
        <link href="<?php echo site_url('/images/apple-touch-icon.png'); ?>" rel="apple-touch-startup-image" />
        		
        <meta name="apple-mobile-web-capable" content="yes" />
        <meta name="apple-mobile-web-app-status-bar-style" content="black" />
        <meta name="viewport" content="width=device-width, minimum-scale=1.0, maximum-scale=1.0" />       			
				
        <link href="<?php echo site_url('/css/custom-theme/jquery-ui-1.8.21.custom.css'); ?>" rel="stylesheet" type="text/css" />        
        <link href="<?php echo site_url('/css/datetimepicker.css'); ?>" rel="stylesheet" type="text/css" />
		<link href="<?php echo site_url('/css/styles.css'); ?>" rel="stylesheet" type="text/css" />
        
		<!--[if IE]>               
			<link href="<?php echo site_url('/css/ie.css'); ?>" rel="stylesheet" type="text/css" />
        <![endif]-->
        
        <!--[if lt IE 7]>	
			<link href="<?php echo site_url('/css/ie6-and-down.css'); ?>" rel="stylesheet" type="text/css" />
        <![endif]-->
                       
        <script src="<?php echo site_url('/js/jquery-1.6.2.min.js'); ?>" type="text/javascript"></script>
        <script src="<?php echo site_url('/js/jquery-ui-1.8.21.custom.min.js'); ?>" type="text/javascript"></script>
        <script src="<?php echo site_url('/js/jquery.fileUploader.js'); ?>" type="text/javascript"></script>
        <script src="<?php echo site_url('/js/jquery.validate.min.js'); ?>" type="text/javascript"></script>
        <script src="<?php echo site_url('/js/jquery-ui-timepicker-addon.js'); ?>" type="text/javascript"></script>     

        <script src="<?php echo site_url('/js/custom.js'); ?>" type="text/javascript"></script> 
		

</head>  

<body class="<?php echo $this->uri->segment(1).' '.$this->uri->segment(1).'-'.$this->uri->segment(2); ?>">  
	<div id="wrapper">
		<div id="float-wrap" class="clearfix">
			<div class="sidebar-div">
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
						
						<a href="#" target="blank">
							<?php echo img('/images/sidebar-map.jpg'); ?>
						</a>
						
						<br/>
						<ul class="sidebar-main-menu-list">
							<!-- DEVICES -->
							<li class="current">
								<div class="sidebar-menu-div">
									<div class="sidebar-count">23</div>
									<div class="title metrophobic cap">Devices</div>
									<ul class="sidebar-menu-list">
										<li><?php echo anchor('/','Basic Phones'); ?></li>
										<li class="current"><?php echo anchor('/','Smart Phones'); ?></li>
										<li><?php echo anchor('/','Tablets'); ?></li>
										<li><?php echo anchor('/','Hotspots'); ?></li>
										<li><?php echo anchor('/','Homephone'); ?></li>										
									</ul>
								</div>
							</li>
							
							<!-- PLANS -->
							<li>
								<div class="sidebar-menu-div">
									<div class="title metrophobic cap">Plans</div>
									<div class="sidebar-count">3</div>
								</div>
							</li>
							
							
							<!-- ACCESSORIES-->
							<li>
								<div class="sidebar-menu-div">
									<div class="title metrophobic cap">Accessories</div>
									<div class="sidebar-count">94</div>
								</div>
							</li>
							
							<!-- PROTECTION-->
							<li>
								<div class="sidebar-menu-div">
									<div class="title metrophobic cap">Protection</div>
									<div class="sidebar-count">2</div>
								</div>
							</li>
							
						</ul>
						
					
						
					</div>
				</div>
			</div>
			<div class="header-content-div">
				<div class="header">
					<?php echo img('/images/logo.jpg', 'class="header-logo"'); ?>
					<ul class="header-menu-list">
						<li><div>FAQ</div></li>
						<li><div>Business</div></li>						
						<li class="current"><div>Individual</div></li>
					</ul>
				</div>
				<div id="content">
					<div class="top-images">
						<div class="top-img">
							<div class="left-panel">
								<div class="large-text1">The Samsung Galaxy has arrived.</div>
								<div class="large-text2">Designed for Humans <br/> Inspired by Nature</div>
								<div class="learn-more"><?php echo anchor('/','Learn More'); ?></div>
							</div>
							<?php echo img('/images/banner-1.jpg', 'width="782"'); ?>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</body>
</html>