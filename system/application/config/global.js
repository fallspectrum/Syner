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
 

/**
 *  This function is used to redirect the user.
 */
function redirect(page)
{
	window.location = page;
}

/**
 * This function inits tinyMCE. The callback function is called after it initializes.
 */
function init_tinyMCE (callback) {
	tinyMCEInitParam = {
		//General options
		mode: "specific_textareas",
		editor_selector: "tinyMCE",
		theme: "advanced",
		plugins: "safari,print,searchreplace,fullscreen,preview,table",
		theme_advanced_buttons1: ",fontsizeselect,|,italic,bold,underline,strikethrough,|,sub,sup,bullist,numlist,|,hr,|,justifyleft,justifycenter,justifyright,|,outdent,indent,|,anchor,link,unlink,|,search,replace,|,fullscreen,preview,|,help",
		theme_advanced_buttons2: "tablecontrols",
		theme_advanced_buttons3: "",
		theme_advanced_toolbar_location: "top",
		theme_advanced_toolbar_align: "left",
		theme_advanced_statusbar_location: "bottom",
		width: "100%",
		save_onsavecallback: "tinyMCE_save",
		add_form_submit_trigger: false
	};
	//set callback function if set
	if(typeof(callback) != "undefined") {
		tinyMCEInitParam.setup = function(ed) { ed.onInit.add(callback)};
	}
	tinyMCE.init(tinyMCEInitParam);
}

/**
 * This function is used to validate a form.
 * Rules is an array of rules. 
 * Element 0 of a rule is the id of the element on the page.
 * Element 1 of a rule is a formal name used in the error message.
 * Element 2 is a string of rules, each seperated by a pipe character, specifying what to check or modify.
 * This function also hides the old error elements.
 * Valid checks are:
 * tinyMCE -must be set if interacting with tinyMCE editor.
 * trim - trim input, store value back into input
 * -email - check to make sure field is a valid email address
 * -min_length[count] - make sure input is at least count characters long
 * -word_count[count][optional_character]  - explodes input and makes sure it has "count" words. Default character to 
 * 	explode by is a space is not provided (ex word_count[3] will explode by spaces). 
 * -max_word_count[count][optional_character]  - explodes input and makes sure it has a maximum of "count" words. Default character to 
 * 	explode by is a space is not provided (ex max_word_count[3] will explode by spaces). 
 * -matches_element[element_id][formal_name]  Makes sure current element matches other element id
 * -format_list[check][replacement] - Creates a list. Uses check as seperation point. Inserts replacement between
 *  	elements. 
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
				case "email" :
					var regex = /^([a-zA-Z0-9_.-])+@(([a-zA-Z0-9-])+.)+([a-zA-Z0-9]{2,4})+$/;
					if(!regex.test(element_value)) {
						bad_elements.push(new Array(element_id, element_title + " must be a valid email."));
					}
					break;
				default:
					more_checks = 1;
			}
			//Continute checking here if nothing matched.
			if(!more_checks) {
				continue;
			}

			//checks the min length of the field
			if (result = checks[j].match(/^min_length\[(.*)\]/)){
				length = result[1];
				//make sure value is the right length.
				if(element_value.length < length) {
					bad_elements.push(new Array(element_id, element_title + " must be at least " + length + " characters long."));
				}
			}

			else if (result = checks[j].match(/^word_count\[([0-9]*)\](?:\[(.)\])?/)){
					word_count = result[1];
					split_char = " ";
					if(typeof(result[2]) != 'undefined') {
						split_char = result[2];
					}	
					
					elements = element_value.split(split_char);
					if(element_value.length == 0 || elements.length < word_count) {
						bad_elements.push(new Array(element_id, element_title + " must have at least " + word_count + " words"));
					}
					$(element_id).val(element_value);
			}

			else if (result = checks[j].match(/^max_word_count\[([0-9]*)\](?:\[(.)\])?/)){
					word_count = result[1];
					split_char = " ";
					if(typeof(result[2]) != 'undefined') {
						split_char = result[2];
					}	
					
					elements = element_value.split(split_char);
					if(elements.length > word_count) {
						if(word_count == 1) {
							bad_elements.push(new Array(element_id, element_title + " can only have " + word_count + " word"));
						}
						else {
							bad_elements.push(new Array(element_id, element_title + " can only have " + word_count + " words"));
						}
					}
					$(element_id).val(element_value);
			}
			
			else if (result = checks[j].match(/^matches_element\[(.*)\]\[(.*)\]/)) {
				element = result[1];
				element_formal = result[2];
				if($(element).val() != $(element_id).val()) {
					bad_elements.push(new Array(element_id, element_title + " does not match " + element_formal));
				}
				
			}

			//creates a list. 1st argument is seperation point.  2nd argument is string to delimit by.
			else if (result = checks[j].match(/^format_list\[(.*)\]\[(.*)\]/)) {
				delimiter = result[1];
				replacement = result[2];
				
				
				//replace delimiters with replacement
				rx = new RegExp(delimiter,'g');
				element_value = element_value.replace(rx,replacement);
	

				//if delimiter appears twice in a row then replace it with single delimiter
				rx = new RegExp(replacement + '{2,}','g');
				element_value = element_value.replace(rx,replacement);
				
				//remove replacement from beginning 
				if(element_value[0] == replacement) {
					element_value = element_value.substring(1);
				}
				
				//remove replacement from end of string
				if(element_value[element_value.length -1] == replacement) {
					element_value = element_value.substring(0,element_value.length -1);
				}
				$(element_id).val(element_value);

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
 * This class is used to help interpret json messages created by
 * simple_json library
 */
function Simple_json() 
{

	/**
	 * Holds formal names used for error messages. Id is css selector.
	 */
	formal_names = new Array();
	this.add_formal_name = function(id,formal_name) {
		formal_names[id] = formal_name;
	};

	/**
	 * Called whenever we receive a success message. Should be overwritten.
	 */
	this.success_callback = function () {};


	/**
	 *  Used to create a ajax response.
	 */
	this.submit = function(a_url,a_data) {
		$.ajax({
			url: a_url,
			dataType: 'json',
			data: a_data,
			type: 'POST',
			success: this.response_handler,
			error: this.error_handler
		});
	};

	
	/**
	 * Callback for interpreting additional data
	 * @param data additional data
	 */
	this.examine_data_callback = function (data) {};
	
	/**
	 * Callback when there is an error.
	 * @todo disable verbose output
	 */
	this.error_handler = function (xhr,textStatus,errorThrow)
	{
		alert(xhr.responseText);
		$('#js_error').html("There was an error processing your request.");
		$('#js_error').show();
	};

	
	//if jquery calls response_handler for the success function, this does not
	//point to simple_json instance.
	var me = this;	
	
	/**
	 * This function handles response messages from simple_json library
	 */
	this.response_handler = function (data) 
	{
		me.examine_data_callback(data);
	
		//we are done if there are no error messages
		if(typeof(data.error_responses) == "undefined") {
			return;
		}
		for (var i = 0; i < data.error_responses.length; i++)
		{
			var response = data.error_responses[i];
			var reference_id = "#" + response['reference_id'];
			var formal_name = '#' + response['reference_id'];
			var error_id = reference_id + "_error";
			
			//check if there is a formal name of the id.
			if(typeof(formal_names[formal_name]) != "undefined" )
			{
				formal_name = formal_names[formal_name];
			}
			
			switch(response['return_val']) 
			{
				
				case '0': 
					me.success_callback();
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
				case '-5':
					$(error_id).html("Incorrect username or password.");
					$(error_id).show();
					scroll_to_element(error_id); 
					break;
			}
		}
		
	};
}
