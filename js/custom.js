/* 
 * Custom Function launch globally are 
 * declared here.
 */

/** JQUERY GLOBALS 
 *  If you need a jquery function to be global, just add it inside the document ready function.
 *  
 */
timeout = 0; 
isHover = 0;

$(document).ready(function() {
	
	//sidebar height adjustments
	cH = $('.header-content-div').height();
	sH = $('.sidebar-div').height();
	
	if(cH > sH) {
		$('.sidebar-div').css('height', cH);
	} 
	
	//scrollables	
   $('.top-images').hover(function() {
	 isHover =1;
   }, function() {
	isHover =0;
   });
   
   $('.top-images .banner-right').click(function() {
		isHover = 1;
		next();
		//isHover = 1;
   });

	$('.top-images .banner-left').click(function() {
		isHover = 1;
		previous();
		//isHover = 1;
   });	   
   
   $('.banner-tab-list li').hover(function() {
	 isHover =1;
	 hoverImage($(this));
   }, function() {
		isHover =0;
		img_name = $(this).attr('rel');
		$('.top-images .top-img').hide();
		$('.top-images').find('.active').fadeIn(300);
   });
   
   
   $(".phones").scrollable({ circular: true, mousewheel: true });
   
});

function hoverImage(thisObj){
	img_name = thisObj.attr('rel');
	$('.top-images .top-img').hide();
	//$('.banner-tab-list li').removeClass('active');
	//thisObj.addClass('.active');
	$('.top-images').find('.'+img_name).fadeIn(300);
}
/** Function for the automatic slideshow **/

function slideSwitch(action) {
	if(isHover != 1) {
		next();
	}
}


function next() {
	var $active = $('.top-images .active');
		var $next = $active.next();
		
		var $last = $('.top-images .top-img').last();
		var $first = $('.top-images .top-img').first();
				
		
		if( $last.is($active) ) {
			$next = $('.top-images .top-img').first();				
		}
		var img_name = $next.attr('rel');
		
		$active.addClass('last-active');
		
		//class_name = 'top-menu-'+img_name;
		//console.log($('.top-main-menu').find('.'+class_name));
		//$('.top-images img').hide();
		//$('.top-main-menu .hover').hide();
		//$('.top-main-menu').find('.'+class_name).find('.hover').show();
		$('.banner-tab-list li').removeClass('active');
		$('.banner-tab-list li.'+img_name).addClass('active');
		
		//indicator
		//console.log($active.index());
		setIndicator($active.index(), 'next');
				
		
		 // console.log($next);
		//	 console.log( $('.top-images img').last());
		$next.css({opacity: 0.0, display: 'block'})
			.addClass('active')
			.animate({opacity: 1.0, display: 'none'}, 1000, function() {
				$active.removeClass('active last-active');
				//$('.top-menu-table').find('.'+class_name).find('.hover').hide();
			});
}


function previous() {
	var $active = $('.top-images .active');
		var $prev = $active.prev();
		
		var $last = $('.top-images .top-img').last();
		var $first = $('.top-images .top-img').first();
				
		
		if( $first.is($active) ) {
			$prev = $('.top-images .top-img').last();				
		}
		var img_name = $prev.attr('rel');
		
		$active.addClass('last-active');
		
		//class_name = 'top-menu-'+img_name;
		//console.log($('.top-main-menu').find('.'+class_name));
		//$('.top-images img').hide();
		//$('.top-main-menu .hover').hide();
		//$('.top-main-menu').find('.'+class_name).find('.hover').show();
		$('.banner-tab-list li').removeClass('active');
		$('.banner-tab-list li.'+img_name).addClass('active');
		
		//indicator
		//console.log($active.index());
		setIndicator($active.index(), 'previous');
				
		
		 // console.log($next);
		//	 console.log( $('.top-images img').last());
		$prev.css({opacity: 0.0, display: 'block'})
			.addClass('active')
			.animate({opacity: 1.0, display: 'none'}, 1000, function() {
				$active.removeClass('active last-active');
				//$('.top-menu-table').find('.'+class_name).find('.hover').hide();
			});
}


function setIndicator(index, action){
	indicator = $('.indicator-div .indicator');
	var param = { left: "+=195px" };
	var param_start = { left: "0px" };
	
	if(action == 'previous') { 
		param = { left: "-=195px" };
	}
	
	if(action == 'previous') {
		if(index == 0){ 
			indicator.animate({
				left : '585px'
			}, 500); 
		}
		else {
			indicator.animate(param, 500); 
		}
	} else {
		
		if(index == 3){
			indicator.animate(param_start, 500);		
		} else {
			indicator.animate(param, 500);
		}
		
	}
}

$(function() {
	$('.top-images .top-img').hide().first().show().addClass('active');
	$('.banner-tab-list li').first().addClass('active');
    setInterval( "slideSwitch()", 3000 );
});


/**
 * Function to convert a string to a slug, removing unnecessary characters
 * 
 */
function toSlug(str){
	//str = str.replace(/[^a-zA-Z 0-9-]+/g,'');
	//str = str.toLowerCase();
	str = str.replace(/\s/g,'-');
	return str;
};

function toSlugUrl(str) {
	str = str.replace(/[^a-zA-Z0-9-]+/g,'-');
	str = str.toLowerCase();
	return str;
}

/**
* function to insert span tags for first letters of word of specified elements 
*/
function insert_first_letters() {
	//var elements = document.getElementsByClassName("all-caps")
	var elements = $('.all-caps');
	for (var i=0; i<elements.length; i++){
		elements[i].innerHTML = elements[i].innerHTML.replace(/\b([a-z])([a-z]+)?\b/gim, "<span class='first-letter'>$1</span>$2")
	}
}
