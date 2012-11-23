<!-- ACC CATEGORY LISTS -->
<ul class="tab-main-menu-list acc-menu-list">
	<?php foreach($accessories_cat as $cat_id => $category) { 
		$li_cat_class = '';
		if($cat_id == $cat) { $li_cat_class = 'current'; }
	?>
	<li class="<?php echo $cat_id . ' ' . $li_cat_class;?> ">
		<?php echo anchor('accessories/'.$cat_id.'/',$category, 'class="' . $li_cat_class . '"'); ?>
	</li>
	<?php } ?>
</ul>

<div class="acc-content">
	<ul class="acc-thumb-list">
		<?php foreach($images as $i => $img) { ?>
			<li class="<?php echo (($i+1)%2) ? 'first' : ''?>">
				<a href="<?php echo $img['url']; ?>" target="_blank">
					<img src="<?php echo site_url('/images/accessories/'.$img['img']); ?>" alt="<?php echo $img['alt']; ?>" class="acc-thumb-img" />
				</a>
			</li>
		<?php } ?>
	</ul>
</div>

<script>
	$(document).ready(function() {
		$('.acc-thumb-list li').css('opacity', 0.9);
		$('.acc-thumb-list li').hover(function() {
			$(this).animate({ opacity: 1}, 500);
		}, function() {
			$(this).animate({ opacity: 0.9}, 500);
		});
	});
</script>

