<link rel="stylesheet" href="<?php echo site_url('css/isotope.style.css'); ?>" />
<script src="<?php echo site_url('/js/jquery.isotope.min.js'); ?>" type="text/javascript"></script>
<style>
#container .element {
	margin: 10px 10px 0px 0;
	padding: 0; 
	float:left;
	width: 177px;
	height: 296px;
	text-align: center;	
	position: relative;
	border: 1px solid #e7e8e8;	
	cursor: pointer; 
}

#container .element img { margin: 0; padding: 0; height: 239px;}
#container .element .thumb-title { 
	padding: 10px 0; 
	font-size: 20px;
	text-transform: uppercase; 
	color: #525252;
	text-decoration: none; 
	font-family: 'rbno2', 'verdana', 'arial';
}
#container { display: block; }
	#container .element .thumb-desc { 
		font-family: 'Arial', 'Verdana'; 
		font-size: 12px;
		position: absolute; 
		left: 0;
		top: 0; 
		width: 100%;
		height: 100%;
		background: rgba(82, 82, 82, 0.85);
		color: #fff;
		display: none; 
	}
	#container .element .thumb-desc .desc-title { 
		text-transform: uppercase; 
		color: #fff;		
		font-family: 'rbno2', 'verdana', 'arial';
		padding: 10px 0; 
		font-size: 20px;
	}
	
	#container .element .thumb-desc .desc-content { 
		text-align: left; 
		padding: 10px 15px;
		font-size: 12px;
		line-height: 1.5em;
		height: 177px;
		width: auto;
		overflow: hidden;
	}
	
	#container .element .thumb-desc .desc-price {
		text-align: right;
		font-size: 22px; 
		text-decoration: uppercase; 
		font-family: 'oswald', 'Verdana', 'arial';
		padding: 0 15px;
	}
	
	#container .element .thumb-desc .desc-duration {
		text-align: right;
		padding: 0 15px;
	}	
</style>

<!-- CATEGORY LISTS -->
<ul class="phone-cat-list">
	<?php foreach($categories as $cat_id => $category) { 
		$li_cat_class = '';
		if($cat_id == $cat) { $li_cat_class = 'current'; }
	?>
	<li class="<?php echo $cat_id . ' ' . $li_cat_class;?> ">
		<?php echo anchor('devices/'.$cat_id.'/',$category, 'class="' . $li_cat_class . '"'); ?>
	</li>
	<?php } ?>
</ul>

<!-- BRAND LISTS -->
<section id="options" class="clearfix">
	<ul id="filters" class="phone-brand-list option-set" data-option-key="filter">
		<?php foreach($brands as $brand_id => $brand_obj) { 
			$li_brand_class = '';
			if($brand_id == $brand) { $li_brand_class = 'selected'; }
		?>
				<li class="<?php echo $brand_id; ?> ">
			<?php echo anchor('#filter', $brand_obj,'class="'.$li_brand_class.'" data-option-value=".'.$brand_id .'"'); ?>
		</li>
		
		<?php } ?>
	</ul>
</section> <!-- #options -->

<div id="container" class="clearfix">
	<?php foreach($phones as $phone) { ?>
	
		<div class="element transition <?php echo $phone['type']; ?>" data-symbol="1" data-category="<?php echo $phone['type']; ?>">
			<div class="thumb-title"><?php echo $phone['name']; ?></div>
			<img src="<?php echo site_url('/images/'.$phone['img']); ?>" alt="<?php echo $phone['name']; ?>" class="thumb-img" />
			<div class="thumb-desc">
				<div class="desc-title"><?php echo $phone['name']; ?></div>
				<div class="desc-content"><?php echo $phone['desc']; ?></div>
				<div class="desc-price"><?php echo $phone['price']; ?></div>
				<div class="desc-duration"><?php echo $phone['duration']; ?></div>
			</div>
		</div>	
		
	<?php } ?>
	
</div>

<script>
	$(document).ready(function() {
		$('#container .element').hover(function() {
			$(this).find('.thumb-desc').fadeIn(300);
		}, function() {
			$(this).find('.thumb-desc').fadeOut(100);
		});
		
		
		//ISOTOPE
		 var $container = $('#container');

      $container.isotope({
        itemSelector : '.element',
		animationEngine: 'best-available',
		filter: '.<?php echo $brand; ?>',
		masonry: { columnWidth: 5 }
      });
      
      
      var $optionSets = $('#options .option-set'),
          $optionLinks = $optionSets.find('a');

      $optionLinks.click(function(){
        var $this = $(this);
        // don't proceed if already selected
        if ( $this.hasClass('selected') ) {
          return false;
        }
        var $optionSet = $this.parents('.option-set');
        $optionSet.find('.selected').removeClass('selected');
        $this.addClass('selected');
  
        // make option object dynamically, i.e. { filter: '.my-filter-class' }
        var options = {},
            key = $optionSet.attr('data-option-key'),
            value = $this.attr('data-option-value'),
        // parse 'false' as false boolean
        value = value === 'false' ? false : value;
        options[ key ] = value;
        if ( key === 'layoutMode' && typeof changeLayoutMode === 'function' ) {
          // changes in layout modes need extra logic
          changeLayoutMode( $this, options )
        } else {

          // otherwise, apply new options
          $container.isotope( options );
        }		
		
        return false;
      });
	  
	  //$container.isotope({ filter: '.<?php echo $brand; ?>' });
	  //$('.<?php echo $brand; ?>').click();
	  
	});
</script>

