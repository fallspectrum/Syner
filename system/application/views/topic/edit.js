function examine_data(data) {
	$('#problem_title').val(data.topic.title);
	editor = tinyMCE.get('problem_description').setContent(data.topic.content);
	tags = "";
	for (tag in data.topic.tags) { 
		tags += data.topic.tags[tag] + " ";
	}
	$('#problem_tags').val(tags);
}


//query for topic data
function editor_loaded(editor) {
	//get topic id from url
	url = window.location.pathname.split('/');
	topic_id = url[6];

	//send request for topic information
	sj = new Simple_json();
	sj.examine_data_callback = examine_data;
	sj.submit(SY_SITEPATH + "index.php/topic/edit_load_topic_ajax","topic_id=" + topic_id);
}


//Init tinyMCE. 
init_tinyMCE(editor_loaded);
