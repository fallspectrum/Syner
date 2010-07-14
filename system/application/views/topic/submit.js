//default number of tags on page - 1
tag_count = 2;

function simple_json_success() {
	alert("Coool!");
}

//This variable will be accessed globally by simple_json_response_handler for
//formal name lookup. 
var formal_names = new Array();
formal_names['tag0'] = "tag";
formal_names['tag1'] = "tag";
formal_names['tag2'] = "tag";
formal_names['problem_title'] = "problem title";

function validate_topic_form()  
{
	var form_rules = new Array();

	//validate title
	form_rules.push(new Array('#problem_title','Title','trim|min_length[10]'));
	
	//validate problem description
	form_rules.push(new Array('#problem_description', 'The description of the problem','tinyMCE|min_length[20]'));
	
	//validate each tag
	for(var i=0;i<=tag_count;i++){
		form_rules.push(new Array('#tag'+i,'This tag','min_length[4]'));
	}

	if(!validate_form(form_rules)) {
		post_data = "problem_title=" + $("#problem_title").val();
		post_data += "&problem_description=" + tinyMCE.get("problem_description").getContent();
		for(var i=0;i<=tag_count;i++){
			post_data += "&tag" + i + "=" + $("#tag" + i ).val();
		}
		
		$.ajax({
			url: SY_SITEPATH + 'index.php/topic/new_topic_ajax',
			dataType: 'json',
			data: post_data,
			type: 'POST',
			success: simple_json_response_handler,
			error: ajax_error
		});
		return false;
	}
}

//This function is called from simple_json_response_handler in global.js
function simple_json_success() {
	alert("Topic submitted successfully.");
}

//this is used by 
