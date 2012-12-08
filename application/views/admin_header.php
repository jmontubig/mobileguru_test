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
				
			
		<link href="<?php echo site_url('/css/reset.css'); ?>" rel="stylesheet" type="text/css" />
		<link href="<?php echo site_url('/css/default.css'); ?>" rel="stylesheet" type="text/css" />
		<link href="<?php echo site_url('/css/classes.css'); ?>" rel="stylesheet" type="text/css" />
		<link href="<?php echo site_url('/css/admin.css'); ?>" rel="stylesheet" type="text/css" />
        
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
		

        <script src="<?php echo site_url('/js/admin.js'); ?>" type="text/javascript"></script> 
		

</head>  

<body>  
	<div class="admin-header">
		<div class="admin-content">
			<span class="oswald cap">Mobileguru</span>
			<span class="rbno2">| Admin</span>
			<div class="floatRight">
				<?php if($this->jm->is_user_admin()) {
					echo anchor('admin/logout', 'Logout', 'class="header-link"');
				} else {
					echo anchor('admin/login', 'Login', 'class="header-link"');
				}
				?>
			</div>
		</div>
	</div>
	
	<div id="wrapper">
		
		
	