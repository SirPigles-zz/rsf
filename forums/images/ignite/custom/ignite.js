/**
 * Author: eNvy - XSTYLE
 * Ver. 1.0.
 * Description: All the custom jQuery scripts.
 * Credits: Jason (Tipsy), envira (Dropdown menu), and myself (Slide menu).
 * ATTENTION: DO NOT MODIFY OR DELETE ANYTHING HERE IF YOU DON'T KNOW ABOUT JQUERY AND HOW IT WORKS.
*/

/* Toggle Menu - Start */

$(document).ready(function () {
	$("#toggle").click(function () {
		$("#userbar").animate({width: 'toggle'});
	});
});

/* Toggle Menu - End */

/* Tipsy - Start */

jQuery(function() {
	jQuery("a").tipsy({gravity: jQuery.fn.tipsy.autoNS});
	jQuery("title").tipsy({gravity: jQuery.fn.tipsy.autoNS});
	jQuery("img").tipsy({gravity: jQuery.fn.tipsy.autoNS});
	jQuery("i").tipsy({gravity: jQuery.fn.tipsy.autoNS});
	jQuery("span").tipsy({gravity: jQuery.fn.tipsy.autoNS});
	jQuery("div").tipsy({gravity: jQuery.fn.tipsy.autoNS});
	jQuery("label").tipsy({gravity: jQuery.fn.tipsy.autoNS});
	jQuery("input").tipsy({gravity: jQuery.fn.tipsy.autoNS});
});

/* Tipsy - End */

/* Toggle Search - Start */

jQuery(document) .ready(function() {    
	$('.toggle_search').on('click', function(){
        $('.dropdown_search').slideToggle('100');
        return false;
    });
    $('html, body').on('click',function(){
        $('.dropdown_search').slideUp('100');
    });
    $(".dropdown_search").click(function(e){
        e.stopPropagation();
    });
});

jQuery(document) .ready(function() {    
	$('.thread_togglesearch').on('click', function(){
        $('.thread_search').slideToggle('100');
        return false;
    });
    $('html, body').on('click',function(){
        $('.thread_search').slideUp('100');
    });
    $(".thread_search").click(function(e){
        e.stopPropagation();
    });
});

/* Toggle Search - End */