<link rel="stylesheet" href="<?php echo site_url('css/isotope.style.css'); ?>" />
<script src="<?php echo site_url('/js/jquery.isotope.min.js'); ?>" type="text/javascript"></script>
<style>
#container .element {

	text-align: center;	
	position: relative;
	cursor: pointer; 
	width: 378px; 
	height: 296px; 
	padding: 0; 
	margin: 0 0 20px 0;
	float: left; 
}

#container .element img { margin: 0; padding: 0;}
#container { display: block; }
	#container .first { margin-right: 5px;}
		
</style>

<!-- ACC CATEGORY LISTS -->
<section id="options" class="clearfix">
	<ul id="filters" class="tab-main-menu-list acc-menu-list option-set" data-option-key="filter">
		<?php foreach($accessories_cat as $cat_id => $category) { 
			$li_cat_class = '';
			if($cat_id == $cat) { $li_cat_class = 'current'; }
		?>
		<li class="<?php echo $cat_id . ' ' . $li_cat_class;?> ">
			<?php echo anchor('#filter',$category, 'class="' . $li_cat_class . '"  data-option-value=".'.$cat_id .'"'); ?>
		</li>
		<?php } ?>
	</ul>
</section> <!-- #options -->

<div class="acc-content">
		
	<div id="container">
		<?php foreach($images as $image) { $count=0; ?>
			<?php foreach($image as $i => $img) { ?>
				<div class="element <?php echo (!($count%2)) ? 'first' : ''; ?> <?php echo $img['type']; ?>" data-symbol="1" data-category="<?php echo $img['type']; ?>">
					<a href="<?php echo $img['url']; ?>" target="_blank">
						
						<img src="<?php echo site_url('/images/accessories/'.$img['img']); ?>" alt="<?php echo $img['alt']; ?>"  />
					</a>
				</div>
			<?php $count++; } ?>
		<?php } ?>
	</div>
	
	
</div>

<script>
	$(document).ready(function() {
		$('#container .element img').css('opacity', 0.9);
		$('#container .element img').hover(function() {
			$(this).animate({ opacity: 1}, 500);
		}, function() {
			$(this).animate({ opacity: 0.9}, 500);
		});
		
		
		//ISOTOPE
		
	 var $container = $('#container');

      $container.isotope({
        itemSelector : '.element',		
		
		masonry: { columnWidth: 0 }
      });
      var selected = 'current';
      
      var $optionSets = $('#options .option-set'),
          $optionLinks = $optionSets.find('a');

      $optionLinks.click(function(){
        var $this = $(this);
        // don't proceed if already selected
        if ( $this.parents('li').hasClass(selected) ) {
          return false;
        }
        var $optionSet = $this.parents('.option-set');
        $optionSet.find('li').removeClass(selected);
        $this.parents('li').addClass(selected);
  
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
	  
	  $('#container .element').hide();
	  setTimeout(function() {
		var select = $optionSets.find('.'+selected+' a');
		$optionSets.find('li a').click();
		select.click();
		$('#container .element').show();
		
	  }, 1000);
	  
	  
	  
	});
</script>

