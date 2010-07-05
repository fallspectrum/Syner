/**
 * This is a global javascript that is included in all pages
 */

// This variable should be exactly the same as it is in config.php
var SY_SITEPATH = '/syner/';

var SY_LOADING_ICON = SY_SITEPATH+"styles/icons/loading.png";
var SY_NOTICE_ICON = SY_SITEPATH+"styles/icons/reg_notice_ico.png";
var SY_OK_ICON = SY_SITEPATH+"styles/icons/reg_ok_ico.png";

/**
 * Do not edit below this line unless you know what you are doing
 */
 
function ajax_error(xhr,textStatus,errorThrow)
{
	$('#js_error').html("There was an error processing your request.");
	$('#js_error').show();
}

