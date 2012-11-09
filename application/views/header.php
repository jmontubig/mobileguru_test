<?php     
echo doctype('html4-trans'); ?>
	
<html>
<head>
	<?php 
            $meta = array(
                array('name' => 'robots', 'content' => 'no-cache'),
                array('name' => 'description', 'content' => 'Petropolis'),
                array('name' => 'keywords', 'content' => 'pets, dogs, petropolis, foods, products'),
                array('name' => 'robots', 'content' => 'no-cache'),
                array('name' => 'Content-type', 'content' => 'text/html; charset=utf-8', 'type' => 'equiv')
            );
            echo meta($meta); 
        ?>
	<title><?php echo (isset($title) ? 'Petropolis - '.$title : 'Petropolis') ; ?></title>
	
	<?php //////ICONS///// ?>        
        <link rel="shortcut icon" type="image/x-icon" href="<?php echo site_url('/images/favicon.ico'); ?>">
        <link href="<?php echo site_url('/images/apple-touch-icon.png'); ?>" rel="apple-touch-icon" />
        <link href="<?php echo site_url('/images/apple-touch-icon.png'); ?>" rel="apple-touch-startup-image" />
        
		
        <meta name="apple-mobile-web-capable" content="yes" />
        <meta name="apple-mobile-web-app-status-bar-style" content="black" />
        <meta name="viewport" content="width=device-width, minimum-scale=1.0, maximum-scale=1.0" />                
       	
		<!--<link href='http://fonts.googleapis.com/css?family=Oswald:400,300,700' rel='stylesheet' type='text/css'>-->
		
		<link href="<?php echo site_url('/css/default.css'); ?>" rel="stylesheet" type="text/css" />
		<link href="<?php echo site_url('/css/classes.css'); ?>" rel="stylesheet" type="text/css" />
       <!-- <link href="<?php echo site_url('/css/style.css'); ?>" rel="stylesheet" type="text/css" /> -->
        <link href="<?php echo site_url('/css/main.css'); ?>" rel="stylesheet" type="text/css" />

        <link href="<?php echo site_url('/css/hdano.css'); ?>" rel="stylesheet" type="text/css" />
        <link href="<?php echo site_url('/css/lance.css'); ?>" rel="stylesheet" type="text/css" />
        <link href="<?php echo site_url('/css/nathan.css'); ?>" rel="stylesheet" type="text/css" />

        <link href="<?php echo site_url('/css/custom-theme/jquery-ui-1.8.21.custom.css'); ?>" rel="stylesheet" type="text/css" />
        
        <link href="<?php echo site_url('/css/datetimepicker.css'); ?>" rel="stylesheet" type="text/css" />
		
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
		<div id="header">
			<a href="<?php echo site_url('/'); ?>">
			<div class="logo"></div>
			</a>
			<div class="invite"></div>
			<div class="welcome">
				<p class="left">
				<?php if($this->jm->get_logged_user()) {    ?>
					WELCOME BACK, 
					<?php echo anchor('user', strtoupper($this->jm->get_logged_user('first_name')) ); ?>
					<small><a href="<?php echo site_url('user'); ?>">Edit Account</a><a href="<?php echo site_url('user/logout'); ?>">Logout</a></small>
				<?php } else { ?>
					<?php echo anchor('login', 'Login'); ?>  | 
					<?php echo anchor('register', 'Register'); ?> 
				<?php } ?>
				</p>
					<p class="right"><a href="<?php echo site_url('cart'); ?>">
					<?php 
					$username = strtoupper($this->jm->get_logged_user('first_name')); 
					if ($username) {
						echo $username."'S";
					} else {
						echo 'YOUR';
					}
					?> STASH</a>: <span id="cart-count"><?php echo count_stash(); ?></span> ITEMS</p>
			</div>
			
			<script>
			$(document).ready(function(){
				$('#cart-count').load("<?php echo site_url('cart/info'); ?>");
			});
			</script>
			
		</div>
		<div class="clear"></div>   
		
		<div id="content">