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
				
			
		<link href="<?php echo site_url('/css/styles.css'); ?>" rel="stylesheet" type="text/css" />
        
		<!--[if IE]>               
			<link href="<?php echo site_url('/css/ie.css'); ?>" rel="stylesheet" type="text/css" />
        <![endif]-->
        
        <!--[if lt IE 7]>	
			<link href="<?php echo site_url('/css/ie6-and-down.css'); ?>" rel="stylesheet" type="text/css" />
        <![endif]-->
                       
        <script src="<?php echo site_url('/js/jquery-1.8.1.min.js'); ?>" type="text/javascript"></script>
        <script src="<?php echo site_url('/js/jquery-ui-1.8.21.custom.min.js'); ?>" type="text/javascript"></script>
		<script src="<?php echo site_url('/js/jquery.mousewheel.min.js'); ?>" type="text/javascript"></script>     
        <script src="<?php echo site_url('/js/jquery.fileUploader.js'); ?>" type="text/javascript"></script>
        <script src="<?php echo site_url('/js/jquery.validate.min.js'); ?>" type="text/javascript"></script>
        <script src="<?php echo site_url('/js/jquery-ui-timepicker-addon.js'); ?>" type="text/javascript"></script>     
		<script src="<?php echo site_url('/js/jquery.tools.min.js'); ?>" type="text/javascript"></script>
		

        <script src="<?php echo site_url('/js/custom.js'); ?>" type="text/javascript"></script> 
		

</head>  
<?php 
	$page = $this->uri->rsegment(3); 
	 if( ($page != 'faq') && ($page != 'business') ) { $page = 'home';}
?>
<body class="<?php echo $this->uri->segment(1).' '.$this->uri->segment(1).'-'.$this->uri->segment(2); ?>">  
	<div id="wrapper">
		<div id="float-wrap" class="clearfix">
			<div class="sidebar-div">			
				<?php $this->load->view('sidebar'); ?>
			</div>
			
			<div class="header-content-div">
				<div class="header">
					<?php echo img('/images/logo.jpg', 'class="header-logo"'); ?>
					<ul class="header-menu-list">
						<li class="<?php echo ($page=='faq')? 'current': ''; ?>"><div><?php echo anchor('faq', 'FAQ'); ?></div></li>
						<li class="<?php echo ($page=='business')? 'current': ''; ?>"><div><?php echo anchor('business', 'Business'); ?></div></li>						
						<li class="<?php echo ($page=='home')? 'current': ''; ?>"><div><?php echo anchor('/', 'Individual'); ?></div></li>
					</ul>
				</div>
				
				<!-- START CONTENT -->
				<div id="content">