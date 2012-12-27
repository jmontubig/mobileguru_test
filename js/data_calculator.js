/** GLOBALS **/

//device numbers
var smartphone_count = 0,
	basicphone_count = 0,
	tablet_count = 0,
	internetservice_count = 0,
	previous_count = 0,
	current_index = '',
	current_device;

//maps
var email_map = { 0: 'first', 5 : 'second', 25 : 'third', 50 : 'fourth', 100: 'fifth', 250: 'last' };
var web_map = { 0: 'first', 5 : 'second', 25 : 'third', 50 : 'fourth', 100: 'fifth', 250: 'last' };
var music_map = { 0: 'first', 5 : 'second', 15 : 'third', 60 : 'fourth', 120: 'fifth', 240: 'last' };
var video_map = { 0: 'first', 2 : 'second', 10 : 'third', 30 : 'fourth', 60: 'fifth', 120: 'last' };

//calculator vars
var datasets = new Array;
var total_gb_mo_usage = 0;
var dataset_rules = {
	
	email : {
		day : { 0:0, 5:1, 25:7, 50:15, 100:29, 250:73 },
		month: { 0:0, 150:1, 750:7, 1500:15, 3000:29, 7500:73 }		
	},
	web : {
		day : { 0:0, 5:150, 25:750, 50:1500, 100:3000, 250:7500 },
		month: { 0:0, 150:150, 750:750, 1500:1500, 3000:3000, 7500:7500 }
	},
	music : {
		day : { 0:0, 5:150, 15:450, 60:1800, 120:3600, 240: 7200 },
		month: { 0:0, 150:150, 450:450, 1800:1800, 3600:3600, }
	},
	video : {
		day : { 0:0, 2:650, 10:3250, 30:9750, 60:19500, 120:39000 },
		month: { 0:0, 150:150, 450:450, 1800:1800, 3600:3600 }
	}
};

var prices = {
	smartphone : 40,
	basicphone : 20,
	tablet : 10,
	internetservice : 30
	}, 
	
	price_per_mb = 0.013; //in dollars


$(document).ready(function() {
	setDropdowns();
	$('.plan-steps').click(function() { return false; } );
	$('.start-calculate-btn').click(function() {
		calculateDataUsage();
		if(!(datasets.length > 3)) {
			$('ul.tab2-list').css('min-height', '162px').css('height', '162px');
		} else {
			$('ul.tab2-list').css('min-height', '290px').css('height', '290px');
		}
	});
	
	$('.calculate-total-btn').click(function() {
		
		calculateTotalUsage('.tab3-list');		
	});
});

/** ===================== BIND EVENTS ===================== **/

/** LINK CLICK TO SHOW DROPDOWN MENUS **/
$('.dropdownLink').live("click", function (a) {
	//hide all dropdown
	
	//toggleDropdown(this);
	c = $(this).prev('ul.dropdownMenu');//ul	
	if (c.length > 0) {
		if ($(this).prev('ul.dropdownMenu').css("display") == "none") {
			$("ul.dropdownMenu").hide();
			$(this).prev('ul.dropdownMenu').show();
		} else {
			$("ul.dropdownMenu").hide();
			$(this).prev('ul.dropdownMenu').hide();
		}
			
	}
	return false;
});

/** SELECT CLICK ON DROPDOWN MENU **/
$("ul.dropdownMenu li").live("click", function (a) {
	a.preventDefault();	
	
	var opt = $(this).parents('li').find('select option[value='+$(this).find('a').text()+']'),
		select = $(this).parents('li').find('select'),
		ul = $(this).parents('ul.dropdownMenu'),
		link = ul.next('a.dropdownLink');		
	
	
	//set the link
	link.find('span').text($(this).find('a').text());
	
	//remove selected classes on ul a
	$(this).parents('ul.dropdownMenu').find('a').removeClass('selected');
	
	//add selected class on a tag on the object clicked
	$(this).find("a").addClass("selected");
	
	//changes on select options
	$(this).parents('li').find('select option').removeAttr('selected');
	opt.attr('selected', 'selected')
	opt.trigger('click');
	opt.trigger('change');
	
	//set global variable counters
	if(ul.attr('id') == 'smartphone_countStyled') { smartphone_count=0; smartphone_count += Number($(this).text()); }
	if(ul.attr('id') == 'basicphone_countStyled') { basicphone_count=0; basicphone_count +=  Number($(this).text()); }
	if(ul.attr('id') == 'tablet_countStyled') { tablet_count=0; tablet_count += Number($(this).text()); }
	if(ul.attr('id') == 'internetservice_countStyled') { internetservice_count=0; internetservice_count += Number($(this).text()); }
	//basicphone_count = 0;
	//tablet_count = 0;
	//internetservice_count = 0;
	
	showCalculateButton();
	
	//hide dropdown menu
	$(this).parents('ul.dropdownMenu').hide();
});


/** SLIDER EVENTS **/
//slider points
var slider_points = {
	first : 50,
	second : 125,
	third : 210,
	fourth : 295,
	fifth : 390,
	last : 478
};
$('#slider-div .marker').live('click', function() {
	

	var	offset = 'first';
	
	if($(this).hasClass('first')) { offset ='first'; }
	if($(this).hasClass('second')) { offset ='second'; }
	if($(this).hasClass('third')) { offset ='third'; }
	if($(this).hasClass('fourth')) { offset ='fourth'; }
	if($(this).hasClass('fifth')) { offset ='fifth'; }
	if($(this).hasClass('last')) { offset ='last'; }
	
	$(this).parents('.slider-texts').find('.marker').removeClass('selected');
	$(this).addClass('selected');
	$(this).parents('.slider-holder').find('.slider-bar').animate({
		width: slider_points[offset]
	}, 200);

});

$('.device_list').live('click', function() {
	var device_data;
	$('.device_list').removeClass('selected');
	$(this).addClass('selected');

	current_index = $(this).attr('id');
	current_device = findIndexBy(datasets, 'id', current_index, false);
	
	updateSliders();
	
});

$('.marker').live('click', function() {
	var type = $(this).attr('rel'), 
		value = $(this).text();

	updateDataset(type, value);
	calculateSubTotal(type, value);
	calculateOverallUsage();
	
	if(total_gb_mo_usage > 0) {
		$('.calculate-total-btn').show();
	} else{
		$('.calculate-total-btn').hide();
	}
});


/**** ======================= END BIND EVENTS ==============  *****/

/** ON DOCUMENT CLICK TO HIDE DROPDOWNS VISIBLE **/
$(document).click(function() {
	$('ul.dropdownMenu').hide();
	return false;
});


/** ===================== FUNCTIONS ============== **/

/** Function setup and convert all dropdowns with .dropdown class **/
function setDropdowns(){
	var dClass = 'dropdown', 
		selects = $("select."+dClass),
		el_id,
		selected;
		
	
	//hide selects
	selects.css({
			position : "absolute",
			left : "-9999px",
			top : "-9999px"
	});
	
	//createDropdowns
	selects.each(function(i, el) {
		el_id = $(el).attr('id');
		
		selected = ($(el).find("option[selected=selected]").length > 0) ? $(el).find("option[selected=selected]") : $(el).find('option').first();
		
		selected_link = $(el).after('<a href="javascript:void(0)" class="dropdownLink" rel="'+ el_id + '"><span>'+selected.text()+'</span></a>');

		ul_content = '<ul class="dropdownMenu" id="'+el_id+'Styled" >';
		
		//get options
		options = $(el).find('option');
		
		options.each(function(opt_index, opt) {
			if(opt == selected) li_class = 'selected';
			else li_class = '';			
			li_text = '<a href="javascript:void(0)" class="' + li_class + '">' + $(opt).text() + "</a>";
			ul_content += '<li>'+li_text+'</li>';			
		});
		
		ul_content += '</ul>';
		ul = selected_link.after(ul_content);
		//$('.'+selected).show();
		$('.dropdownMenu').hide();

		//$(el).after('<p>test</p>');
		//parent_el = $(el).wrap('<div class="dropdown-div"></div>');
				
	});
	
}


/** Function to show the calculate button at the first page **/
function showCalculateButton(){
	
	if(smartphone_count || basicphone_count || tablet_count || internetservice_count){
		$('.start-calculate-btn').show();	
	} else {
		$('.start-calculate-btn').hide();
	}	
}

//** Function to calculate data usage on step 1 **/
function calculateDataUsage(){
	var total_count = smartphone_count + basicphone_count + tablet_count + internetservice_count;
	if(total_count > 6) {
		alert('Maximum number of devices exceeded. You can only have 6 devices.');
	} else {
		if( (total_count > previous_count) || (total_count < previous_count) ) {
			$('ul.plan-steps li').removeClass('current');
			$('ul.plan-steps li').eq(1).addClass('current');
			//$('.tab1').hide();
			$('.tab2').show();
			previous_count = total_count;
			
			//populate devices
			populateDevices();
		}
	}
}

/** Function to create device datas **/
function createDeviceFragment(type){
	var device = new Array;
	var type_name = '';
	
	if(type == 'smartphone')  type_name = 'Smartphone';
	if(type == 'basicphone') type_name = 'Basic Phone'; 
	if(type =='tablet') type_name = 'Tablet'; 
	if(type =='internetservice') type_name = 'Internet Service';

	device = {
		id : create_uid(),
		type : type,
		type_name : type_name,
		total_usage : 0,
		data : {
			web: 0,
			email: 0,
			music: 0,
			video: 0
		}
	};
	
	return device; 
}

/** Function to populate datasets and the display view **/
function populateDevices() {
	datasets = new Array;
	
	for (var i = 0; i < smartphone_count; i++) {
		device = createDeviceFragment("smartphone");
		//console.log(device);
		datasets.push(device);		
	}
	
	for (var i = 0; i < basicphone_count; i++) {
		device = createDeviceFragment("basicphone");
		//console.log(device);
		datasets.push(device);		
	}
	
	for (var i = 0; i < tablet_count; i++) {
		device = createDeviceFragment("tablet");
		//console.log(device);
		datasets.push(device);		
	}
	
	for (var i = 0; i < internetservice_count; i++) {
		device = createDeviceFragment("internetservice");
		//console.log(device);
		datasets.push(device);		
	}
	
	
	//populate view list
	populateDeviceList('.tab2-list');
}

function populateDeviceList(list_class){
	$(list_class).html('');
	var li = '';
	var li_class = '';
	var id = '';
	
	for (var i = 0; i < datasets.length; i++) {
		li_class = '';
		
		li_class = li_class + ' ' + datasets[i]['type'] + '_device';
		li += '<li class="device_list '+li_class+'" id="'+datasets[i]['id']+'">'; 
			//li += '<a href="#" class="close"></a>';
			li += '<div class="tab-img centerText">'
				li += '<img src="images/'+datasets[i]['type']+'.png"/>';
			li += '</div>';
			li += '<div class="tab-title oswald cap centerText">' + datasets[i]['type_name'] ;
			li += '</div>';
			
		li += '</li>';
		
		if(i == 0) {  id = datasets[i]['id']; }
	}
	

	li += '<li class="" id="total_gb">';
		li += total_gb_mo_usage;
		li +=' GB/mo in usage';
	li += '</li>';
	
	$(list_class).html(li);
	$('#'+id).trigger('click');
}

function removeDevice(id){
	//console.log(id);

	//var remIndex = $.inArray(remObj, datasets);
	var remIndex = findIndexBy(datasets, 'id', id);
	datasets.splice(remIndex);
	//console.log(remIndex);
	$('#'+id).remove();
	//console.log(datasets);
	
}

/** Function to update the sliders, 
 * 	it will get the current data on the global vars 
 * 	current_index and current_device
 */ 
function updateSliders(){
	//console.log(datasets);
	//console.log(current_index);
	//console.log(current_device);
	
	//console.log(email_map[current_device['data']['email']]);
	
	//set email slider
	$('.email-slider-div .'+email_map[current_device['data']['email']]).trigger('click');
	
	//set web slider
	$('.web-slider-div .'+web_map[current_device['data']['web']]).trigger('click');
	
	//set music slider
	$('.music-slider-div .'+music_map[current_device['data']['music']]).trigger('click');
	
	//set video slider
	$('.video-slider-div .'+video_map[current_device['data']['video']]).trigger('click');
	
}

function updateDataset(type, value){
	var type_map, index;
	if(type == 'email') type_map = email_map;
	if(type == 'web') type_map = web_map;
	if(type == 'music') type_map = music_map;
	if(type == 'video') type_map = video_map;
	
	//console.log(current_index);
	
	index = findIndexBy(datasets, 'id', current_index, true);
	//console.log(value);
	//console.log(type);
	//console.log(type_map[value]);
	
	datasets[parseInt(index)]['data'][type] = value;
	//console.log(datasets);
}

/** Function to calculate subtotal for each sliders **/
function calculateSubTotal(type, value) {
	var type_map;
	if(type == 'email') type_map = email_map;			
	if(type == 'web') type_map = web_map;
	if(type == 'music') type_map = music_map;
	if(type == 'video') type_map = video_map;
	
	$('.'+type+'-slider-div').find('.slider-amount').text(dataset_rules[type]['day'][value]+' MB/mo');
}

/** Function to calculate overall GB usage **/
function calculateOverallUsage(){
	//console.log(datasets);
	var overall = 0, overall_text;
	for (var i = 0; i < datasets.length; i++) {
		overall += parseInt(dataset_rules['email']['day'][datasets[i]['data']['email']]);
		overall += parseInt(dataset_rules['web']['day'][datasets[i]['data']['web']]);
		overall += parseInt(dataset_rules['music']['day'][datasets[i]['data']['music']]);
		overall += parseInt(dataset_rules['video']['day'][datasets[i]['data']['video']]);
	}
	overall_gb = overall/1000;
	total_gb_mo_usage = overall/1000; //only in GB
	
	if((overall/1000) > 1) { overall_text = (Math.round((overall/1000)*100)/100) + ' GB/mo in usage'; }
	else { overall_text = overall + ' MB/mo in usage'; }
	$('#total_gb').text(overall_text);
	
}

/** Function to calculate overall estimates **/
function calculateTotalUsage(list_class){
	$('ul.plan-steps li').removeClass('current');
	$('ul.plan-steps li').eq(2).addClass('current');
	//$('.tab1').hide();
	$('.tab3').show();
	
	$(list_class).html('');
	var li = '';
	var li_class = '';
	var id = '';
	var total = total_gb_mo_usage;
	var phone_price = 0; 
	
	for (var i = 0; i < datasets.length; i++) {
		li_class = '';
		
		li_class = li_class + ' ' + datasets[i]['type'] + '_estimate';
		li += '<li class="device_list '+li_class+'" id="estimate_'+datasets[i]['id']+'">'; 
			//li += '<a href="#" class="close"></a>';
			li += '<div class="tab-img centerText">'
				li += '<img src="images/'+datasets[i]['type']+'.png"/>';
			li += '</div>';
			li += '<div class="tab-title oswald cap centerText">' + datasets[i]['type_name'] ;
			li += '</div>';
			
			li += '<div class="tab-price rbno2 cap centerText">$' + prices[datasets[i]['type']] ;
			li += '</div>';
			
		li += '</li>';
		phone_price += prices[datasets[i]['type']];
		
		li += '<li class="device_list plus" >'; 
				
		li += '</li>';
	}
	

	
	if(total_gb_mo_usage > 1) {  overall_text = total_gb_mo_usage + ' GB'; }
	else { overall_text = (total_gb_mo_usage*1000) + ' MB'; }
	

	li += '<li class="" id="total_gb">';
		li += '<div class="oswald tab-total-sub-desc">Unlimited Talk & Text with</div>';
		li += '<div class="oswald tab-total">'+overall_text+'</div>';
		li += '<div class="oswald tab-total-desc">Shared Data</div>';
		total = (total*1000)*price_per_mb;
		li += '<div class="tab-price rbno2 cap centerText">$' + round(total) + '</div>';
	li += '</li>';
	
	li += '<li class="device_list equals" >'; 
			
	li += '</li>';
	
	li += '<li class="tab-grand-total rbno2 cap centerText" id="grand_total">';
		total = total + phone_price
		li += '$ ' + round(total) + '/Mo';
	li += '</li>';
	
	$(list_class).html(li);
	
}


/** UTILS **/
function create_uid() {
	var A = new Date();
	var B = A.getFullYear() + "" + A.getMonth() + "" + A.getDate() + "" + A.getTime();
	return B + Math.floor(Math.random()*30);
}

function findIndexBy(a, field, value, index) {
    for (var i = 0; i < a.length; i++) {
        if (a[i][field] == value) {
			//console.log('check '+field+' = ' + value);
			if(index) return i;
            else return a[i];
        }
    }
    return -1;
}

function round(data) {
	return Math.round((data)*100)/100;
}