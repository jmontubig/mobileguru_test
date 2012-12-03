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
redStart = 1;
currentIndex=0;

//DEFAULTS
redOffset = 195;	
grayAnimDuration = 800;
redAnimDuration = 3000;
totalWidth = 782;
totalDuration = 12000;

$(document).ready(function() {
	
	//sidebar height adjustments
	cH = $('.header-content-div').height();
	sH = $('.sidebar-div').height();
	//console.log(cH);
	//console.log(sH);
	if(cH > sH) {
		$('.sidebar-div').css('height', cH);
	} 
	
	//scrollables	
   $('.top-images').hover(function() {
	 isHover =1;
	 
	 redStart=0;
	 $('.indicator-div .red-indicator').stop();
	 
   }, function() {
	 isHover =0;	 
	 start_red_indicator($('.indicator-div .red-indicator').width());
   });
   
   $('.top-images .banner-right').click(function() {
		isHover = 1;
		next();
		
		redStart=1;
		$('.indicator-div .red-indicator').stop();
		//isHover = 1;
   });

	$('.top-images .banner-left').click(function() {
		isHover = 1;
		previous();
		
		redStart=1;
		$('.indicator-div .red-indicator').stop();
		//isHover = 1;
   });	   
   
   $('.banner-tab-list li').hover(function() {
	 isHover =1;
	 $('.indicator-div .red-indicator').stop();
	 
	 hoverImage($(this));
   }, function() {
		isHover =0;
		redStart=1;
		img_name = $(this).attr('rel');
		
		start_red_indicator($('.indicator-div .red-indicator').width());
		//setIndicator(currentIndex);
		
		$('.top-images .top-img').hide();
		$('.top-images').find('.active').fadeIn(300);
   });
   
   $('.img-hover').hover(function() {
		$(this).find('.unhover').hide();
		$(this).find('.hover').fadeIn(300);
   }, function() {
		$(this).find('.unhover').fadeIn(300);
		$(this).find('.hover').hide();
   });
   
   
   $(".phones").scrollable({ circular: true, mousewheel: true });
   setIndicator(-1, null);
   //start_red_indicator(0);
   
   //MAIN MENU SUB MENU ANIMATION//
   $('.sidebar-main-menu-list li').find('.sidebar-menu-list').hide(); 
   $('.sidebar-main-menu-list li.current').find('.sidebar-menu-list').show();  
   
   $('.sidebar-main-menu-list li').hover(function(e) {		
		if($(this).find('ul.sidebar-menu-list').length > 0) {
			//if($(this) == e.target){
				if($(this).find('ul.sidebar-menu-list').css('display') == 'none') {
					//console.log('test');
					if(!$(this).hasClass('active')) {
						$(this).find('ul.sidebar-menu-list').show(200);					
						$(this).addClass('current');
					}
					
				} else {
					if(!$(this).hasClass('active')) {
						$(this).find('ul.sidebar-menu-list').hide(200);					
						$(this).removeClass('current');
					}
				}
			//}
		}

   });
   
   
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
	red_indicator = $('.indicator-div .red-indicator');
		
	iWidth = indicator.width();
	rWidth = red_indicator.width();
	
	currentIndex = index; 
	
	if(action == 'next') { newWidth = iWidth + redOffset;  }
	else { 
		newWidth = iWidth - redOffset;  
		if(newWidth < 0 ){ newWidth = 0; }
	}
	//console.log(totalDuration - (redAnimDuration*( newWidth/redOffset) ));
	
	if( ((index+1) >= 0)  ){
		//start_red_indicator();
		//console.log(index+1);
		index_ = index+1;
		remainingDurationOffset = redAnimDuration*(index_ );
		rNewWidth = index_ * redOffset ;
		red_indicator.clearQueue();

		
		red_indicator.css('width', rNewWidth);
		red_indicator.animate({
				width : totalWidth
		}, totalDuration - remainingDurationOffset, 'linear', function() {
			red_indicator.clearQueue();
			red_indicator.css('width', 0);
			start_red_indicator(red_indicator.width());
		});
		
	} else {
		
	}
	
	//console.log(newWidth);
	if( !(newWidth > 782-195) ) {
		//set the gray indicator
		indicator.animate({
				width : newWidth
		}, grayAnimDuration, function() {
			/*if( !(newWidth > 779) ) {
				red_indicator.css('width', newWidth);
				red_indicator.animate({
						width : newWidth+redOffset
				}, redAnimDuration, function() {
					
				}); 
			}*/
		}); 	
	} else {
		//set the gray indicator
		indicator.css('width', 0);
		/*
		indicator.animate({
				width : 195
		}, grayAnimDuration, function() {
			
		}); 
		
		//set the red indicator	
		red_indicator.css('width',redOffset);
		red_indicator.animate({
				width : redOffset+redOffset
		}, redAnimDuration+grayAnimDuration+200, function() {
			
		}); */
	}
	
	//setTimeout(function() {
	//if(isHover != 1) {
		/*indicator.css('width', '0px');
		indicator.animate({
				width : '782px'
		}, 2800, function() {
			
		});*/ 
	//}
	//}, 3000);
}



function start_red_indicator(startWidth){
	red_indicator = $('.indicator-div .red-indicator');
	
	index_ = currentIndex+1;
	remainingDurationOffset = redAnimDuration*(index_ );
	rNewWidth = index_ * redOffset ;
	red_indicator.clearQueue();

	red_indicator.css('width', startWidth);
	red_indicator.animate({
			width : totalWidth
	}, totalDuration - remainingDurationOffset, 'linear', function() {
		
	});
	
	
	//if(isHover != 1) {
		red_indicator.css('width', startWidth); 		
		red_indicator.animate({
				width : totalWidth
		}, totalDuration, 'linear', function() {
		
			//red_indicator.animate({
			//	width : '0px'
			//}, 200, 'linear', function() {
			//	start_red_indicator();
			//});
		}); 
	
	//} else {
		//w = red_indicator.css('width');
		//red_indicator.stop().css('width', w);
	//}
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
