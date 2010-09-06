function parse_json_response(data) 
{
	search_results = $("#search_results");
	search_results.empty();
	if(typeof(data.topics) == "undefined") {
		$("#txt_search_error").html("Sorry, no topics matched your search criteria.");
		$("#txt_search_error").show();
	
	}
	else {
		for(i in data.topics) {
			topic = data.topics[i];
			search_html = "<a href='" + SY_SITEPATH + "index.php/topic/view/topic_id/"+topic.id +"'>"+topic.title +"</a>" + "<p>"+topic.content + "</p>";
			search_results.append(search_html);
		}
		$("#txt_search_error").html("Search is complete.");
		$("#txt_search_error").show();
	}
}

function do_search() 
{
	var rules = new Array();
	rules.push(new Array("#txt_search","Search field","trim|min_length[4]"));
	if(!validate_form(rules)) {
		sc = new Simple_json();
		sc.add_formal_name("#txt_search","Search field");
		sc.examine_data_callback = parse_json_response;
		sc.submit(SY_SITEPATH + "index.php/topic/search_json", "txt_search=" + $("#txt_search").val());
	}
	return false;
}
