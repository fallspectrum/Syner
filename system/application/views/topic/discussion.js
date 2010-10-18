function validate_topic_form()  
{
	var form_rules = new Array();

	//get topic id from url
	url = window.location.pathname.split('/');
	problem_id = url[6];

	//validate reply content
	form_rules.push(new Array('#reply', 'The reply content','tinyMCE|min_length[10]|max_length[500]'));

	if(!validate_form(form_rules)) {
		post_data = "reply=" + tinyMCE.get("reply").getContent();
		post_data += "&problem_id=" + problem_id;
		
		sj = new Simple_json();
		
		sj.add_formal_name("#reply","reply"); 

		sj.success_callback = function () {
			jerror = $("#js_error");
			jerror.html("Reply submitted successfully.");
			jerror.show();
			jerror.focus();
		};

		sj.submit(SY_SITEPATH + 'index.php/topic/discussion_post_json', post_data);
		return false;
	}
}
//initialize tinyMCE
init_tinyMCE();
