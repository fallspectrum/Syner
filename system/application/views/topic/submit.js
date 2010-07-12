//default number of tags on page - 1
tag_count = 2;
function validate_topic_form()  
{
	var form_rules = new Array();

	//validate title
	form_rules.push(new Array('#problem_title','Title','trim|min_length[10]'));
	
	//validate problem content
	form_rules.push(new Array('#problem_content', 'The description of the problem','trim|min_length[10]'));
	
	//validate each tag
	for(var i=0;i<=tag_count;i++){
		form_rules.push(new Array('#tag'+i,'This tag','min_length[4]'));
	}

	
	validate_form(form_rules);
}

