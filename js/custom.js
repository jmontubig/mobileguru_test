/* 
 * Custom Function launch globally are 
 * declared here.
 */

/** JQUERY GLOBALS 
 *  If you need a jquery function to be global, just add it inside the document ready function.
 *  
 */
$(document).ready(function() {
   
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
