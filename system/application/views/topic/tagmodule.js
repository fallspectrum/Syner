//Global counter for tag_id. Everytime a tag is added a tag_id is associated
//with it.
tag_id = 0;

function remove_tag(tag_num) {
	tagBox = document.getElementById("tagBox");
	tag = document.getElementById("tag" + tag_num);
	tagBox.removeChild(tag);
}


//sets the current state of the tag visually
function set_tag_state(tag_num,ignored) {
	tagBox = document.getElementById("tagBox");
	tag = document.getElementById("tag" + tag_num);
	
	tagOperation = eval("document.tagForm" +tag_num + ".tagOperation"+tag_num);
	if(ignored == 1) {
		for(var i=0; i < tagOperation.length; i++) {
			tagOperation[i].checked = false;
		}
		tag.setAttribute("class","normal ignore");
	}
	else {

		for(var i=0; i < tagOperation.length; i++) {
			if(tagOperation[i].checked) {
				switch(tagOperation[i].value) {
					case 'and':
						tag.setAttribute("class","select normal and");
						break;
					case 'or':
						tag.setAttribute("class","select normal or");
						break;
					case 'excluded':
						tag.setAttribute("class","select normal exclude");
						break;

				}
			}
		}
	}
}

//appends a tag to list of tags
function append_tag(tag_name) {
	var li = document.createElement("li");
	li.setAttribute("class","normal ignore");
	li.setAttribute("id","tag"+tag_id);

	
	var tagLink = document.createElement("span");
	tagLink.setAttribute("onclick","set_tag_state(" + tag_id + ",1);");
	var tagTxt = document.createTextNode(tag_name);
	tagLink.appendChild(tagTxt);
	
	
	var form = document.createElement("form");
	form.setAttribute("name","tagForm" + tag_id);
	
	radio = document.createElement("input");
	radio.setAttribute("type","radio");
	radio.setAttribute("name","tagOperation"+tag_id);
	radio.setAttribute("value","and");
	radio.setAttribute("onclick","set_tag_state(" + tag_id + ");");
	form.appendChild(radio);
	
	radio = document.createElement("input");
	radio.setAttribute("name","tagOperation"+tag_id);
	radio.setAttribute("type","radio");
	radio.setAttribute("value","or");
	radio.setAttribute("onclick","set_tag_state(" + tag_id + ");");
	form.appendChild(radio);
	
	radio = document.createElement("input");
	radio.setAttribute("name","tagOperation"+tag_id);
	radio.setAttribute("type","radio");
	radio.setAttribute("value","excluded");
	radio.setAttribute("onclick","set_tag_state(" + tag_id + ");");
	form.appendChild(radio);

	form.appendChild(tagLink);
	li.appendChild(form);	

	
	remove_link = document.createElement("a");
	remove_link.setAttribute("href","#");
	remove_link.setAttribute("onclick","remove_tag(" + tag_id + ");");

	removeImage = document.createElement("img");
	removeImage.setAttribute("class","inline");
	removeImage.setAttribute("src", "/syner/styles/icons/remove_tag_ico.png");

	remove_link.appendChild(removeImage);
	form.appendChild(remove_link);

	
	//add tag to the end of the tag listing.
	tagBox = document.getElementById("tagBox");
	tagBoxEnd = tagBox.childNodes[tagBox.childNodes.length-2];
	tagBox.insertBefore(li,tagBoxEnd);


	tag_id++;
}

function add_tag() {
	rules = new Array();
	rules.push(new Array('#addtag','The tag field',"trim|word_count[1]|max_word_count[1]]"));
	if(!validate_form(rules)) {
		append_tag($('#addtag').val());
	}
}
