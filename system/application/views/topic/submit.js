function validate_topic_form()  
{
	var form_rules = new Array();

	//validate title
	form_rules.push(new Array('#problem_title','Title','trim|min_length[10]'));
	
	//validate problem description
	form_rules.push(new Array('#problem_description', 'The description of the problem','tinyMCE|min_length[20]'));
	
	//validate tags
	form_rules.push(new Array('#problem_tags', 'The tags field', 'word_count[3]'));
	
	if(!validate_form(form_rules)) {
		post_data = "problem_title=" + $("#problem_title").val();
		post_data += "&problem_description=" + tinyMCE.get("problem_description").getContent();
		post_data += "&problem_tags=" + $('#problem_tags').val();

		sj = new Simple_json();
		sj.add_formal_name("#problem_tags","tags");
		sj.add_formal_name("#problem_title","problem title");

		sj.success_callback = function () {
			alert("Topic submitted successfully!");
		};

		sj.submit(SY_SITEPATH + 'index.php/topic/new_topic_ajax', post_data);
		return false;
	}
}
//initialize tinyMCE
init_tinyMCE();
