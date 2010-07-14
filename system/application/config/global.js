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
 * Element 2 is a string of rules, each seperated by a pipe character, specifying what to check or modify.
 * This function also hides the old error elements.
 * Valid checks are:
 * tinyMCE -must be set if interacting with tinyMCE editor.
 * trim - trim input, store value back into input
 * min_length[count] - make sure input is at least count characters long
 * @return 0 on success, 1 on error.
 */
function validate_form(rules)
{
	//The below array is an array of arrays. Each array holds the full element id, and
	//its corisponding error message.
	var bad_elements = new Array();
	
	for (var i in rules) {
		var element_id = rules[i][0];
		var element_title = rules[i][1];
		var element_error_id = element_id + "_error";
		var element_value= $(element_id).val();

 		//hide and remove old error message, remove highlight if set. 
		$(element_error_id).hide();
		$(element_id).removeClass("error");
		$(element_error_id).html("");
		
		var checks = rules[i][2].split("|");
		for (var j in checks) {
			var more_checks = 0;
			switch(checks[j]) {
				case "trim":
					element_value = jQuery.trim(element_value);	
					$(element_id).val(element_value);
					break;
				case "tinyMCE" :
					element_value = tinyMCE.get(element_id.substring(1)).getContent();
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
					bad_elements.push(new Array(element_id, element_title + " must be at least " + length + " characters long."));
				}
			}

		}
		
	}

	if(bad_elements.length > 0) {
		for (i in bad_elements) {
			handle_bad_element(bad_elements[i][0],bad_elements[i][1]);
		}
		scroll_to_element(bad_elements[0][0] + "_error")
		return 1;
	}

	else {
		return 0;
	}
}

/**
 * This function is mark a element as bad by changing the color.
 * The error field is also set. If more then 1 error message occurs for a element
 * the error is appended to the element.
 */
function handle_bad_element(css_selector,error_msg) 
{
	element_error_id = css_selector + "_error";

	if($(element_error_id).html() == "") {
		$(element_error_id).html(error_msg);
	} 
	else {
		error_html = $(element_error_id).html();
		//if message was not set from previous check then add it
		if(!error_html.search(/error_msg/)) {
			$(element_error_id).html(error_html + "<br>" + error_msg);
		}
	}
	$(element_error_id).show();
	$(css_selector).addClass("error");
}

/**
 * This function scrolls to a element on the page.
 */
function scroll_to_element(css_selector) {
	$('html,body').scrollTop($(css_selector).offset().top - 100);
}


/**
 * This function handles response messages from simple_json library
 */
function simple_json_response_handler(data)
{
        for (var i = 0; i < data.error_responses.length; i++)
        {
                var response = data.error_responses[i];
                var reference_id = "#" + response['reference_id'];
		var formal_name = response['reference_id'];
                var error_id = reference_id + "_error";
		//check if there is a formal name of the id.
		if(typeof(formal_names[formal_name]) != "undefined" )
		{
			formal_name = formal_names[formal_name];
		}
		switch(response['return_val']) 
               	{
			
			case '1': 
				simple_json_success();
				break;
			case '-1':
				handle_bad_element(reference_id, "The entered " + formal_name + " is invalid.");
				scroll_to_element(error_id); 
				break;
			case '-2':
				handle_bad_element(reference_id, "The entered " + formal_name + " is already taken.");
				scroll_to_element(error_id); 
				break;
			case '-3':
				handle_bad_element(reference_id, "There was an error communicating with the database.");
				scroll_to_element(error_id); 
				break;
			case '-4':
				$(error_id).html("There was an error trying to send the activation email.");
				$(error_id).show();
				scroll_to_element(element_id); 
				break;
		}
	}
        
}

