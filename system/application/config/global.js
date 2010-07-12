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


/**
 *  This function is used to redirect the user.
 */
function redirect(page)
{
	window.location = page;
}

/***
 * This function is used to validate a form.
 * Rules is an array of rules. 
 * Element 0 of a rule is the id of the element on the page.
 * Element 1 of a rule is a formal name used in the error message.
 * Rule 2 is a string, seperated by a pipe character, specifying what to check.
 * This function also hides the old error elements.
 * Valid checks are trim and min_length[count].
 */
function validate_form(rules)
{
	
	for (var i in rules) {
		var element_id = rules[i][0];
		var element_title = rules[i][1];
		var element_error_id = element_id + "_error";
		var element_value= $(element_id).val();

		//hide old error message, remove highlight if set.
		$(element_error_id).hide();
		$(element_id).removeClass("error");

		var checks = rules[i][2].split("|");
		for (var j in checks) {
			var more_checks = 0;
			switch(checks[j]) {
				case "trim":
					element_value = jQuery.trim(element_value);	
					$(element_id).val(element_value);
				break;
				default:
					more_checks = 1;
			}
			//Continute checking here if nothing matched.
			if(!more_checks) {
				continue;
			}
			if (result = checks[j].match(/^min_length\[(.*)\]/)){
				length = result[1];
				//make sure value is the right length.
				if(element_value.length < length) {
					handle_bad_element(element_id, element_title + " must be at least " + length + " characters long.");
					return;
				}
			}

		}
			
	}
}

/**
 * This function is mark a element as "bad" by changing the color and scrolling to it.
 */
function handle_bad_element(css_selector,error_msg) 
{
	element_error_id = css_selector + "_error";
	$(element_error_id).html(error_msg);
	$(element_error_id).show();
	$(css_selector).addClass("error");
	$('html, body').animate({ scrollTop: $(css_selector).offset().top - 100 }, 500);
}
