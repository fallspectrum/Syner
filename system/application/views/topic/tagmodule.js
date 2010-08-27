function Tag_Module() {

	//we need a backreference to initiated class
	me = this;
	
	//Global counter for tag_id. Everytime a tag is added a tag_id is associated
	//with it.
	this.tag_dom_id = 0;
	
		
	//holds tag_descriptors. We will walk this list when seeing how operations
	//affect one another.
	this.tag_descriptions = new Array();
}

Tag_Module.prototype.Tag_Descriptor = function(tag_name,tag_id,tag_operator,tag_dom_id)
	{
		this.name = tag_name;
		this.id = tag_id;
		this.operator = tag_operator;
		this.dom_id = tag_dom_id;
	}


//appends a tag to list of tags
Tag_Module.prototype.append_tag = function(tag_name,tag_id) 
{
	var li = document.createElement("li");
	li.setAttribute("class","normal ignore");
	li.setAttribute("id","tag"+me.tag_dom_id);

	
	var tagLink = document.createElement("span");
	tagLink.setAttribute("onclick","set_tag_state(" + me.tag_dom_id + ",1);");
	var tagTxt = document.createTextNode(tag_name);
	tagLink.appendChild(tagTxt);
	
	
	var form = document.createElement("form");
	form.setAttribute("name","tagForm" + me.tag_dom_id);
	
	radio = document.createElement("input");
	radio.setAttribute("type","radio");
	radio.setAttribute("name","tagOperation"+me.tag_dom_id);
	radio.setAttribute("value","and");
	radio.setAttribute("onclick","set_tag_state(" + me.tag_dom_id + ");");
	form.appendChild(radio);
	
	radio = document.createElement("input");
	radio.setAttribute("name","tagOperation"+me.tag_dom_id);
	radio.setAttribute("type","radio");
	radio.setAttribute("value","or");
	radio.setAttribute("onclick","set_tag_state(" + me.tag_dom_id + ");");
	form.appendChild(radio);
	
	radio = document.createElement("input");
	radio.setAttribute("name","tagOperation"+me.tag_dom_id);
	radio.setAttribute("type","radio");
	radio.setAttribute("value","excluded");
	radio.setAttribute("onclick","set_tag_state(" + me.tag_dom_id + ");");
	form.appendChild(radio);

	form.appendChild(tagLink);
	li.appendChild(form);	

	
	remove_link = document.createElement("a");
	remove_link.setAttribute("href","#");
	remove_link.setAttribute("onclick","remove_tag(" + me.tag_dom_id + ");");

	removeImage = document.createElement("img");
	removeImage.setAttribute("class","inline");
	removeImage.setAttribute("src", "/syner/styles/icons/remove_tag_ico.png");

	remove_link.appendChild(removeImage);
	form.appendChild(remove_link);

	
	//add tag to the end of the tag listing.
	tagBox = document.getElementById("tagBox");
	tagBoxEnd = tagBox.childNodes[tagBox.childNodes.length-2];
	tagBox.insertBefore(li,tagBoxEnd);

	//add tag to tag list
	me.tag_descriptions.push(new me.Tag_Descriptor(tag_name,tag_id,"or",me.tag_dom_id));

	me.tag_dom_id++;
}

//sets the current state of the tag visually
Tag_Module.prototype.set_tag_state = function(tag_num,ignored) {

	tagBox = document.getElementById("tagBox");
	tag = document.getElementById("tag" + tag_num);
	
	
	//find tag descriptor
	var tag_describer;
	for (i in me.tag_descriptions) {
		if(me.tag_descriptions[i].dom_id == tag_num) {
			tag_describer = me.tag_descriptions;
			break;
		}
	}

	tagOperation = eval("document.tagForm" +tag_num + ".tagOperation"+tag_num);
	if(ignored == 1) {
		for(var i=0; i < tagOperation.length; i++) {
			tagOperation[i].checked = false;
		}
		tag.setAttribute("class","normal ignore");
		tag_describer.operation = "ignore";
	}
	else {

		for(var i=0; i < tagOperation.length; i++) {
			if(tagOperation[i].checked) {
				switch(tagOperation[i].value) {
					case 'and':
						tag.setAttribute("class","select normal and");
						tag_describer.operation = "and";
						break;
					case 'or':
						tag.setAttribute("class","select normal or");
						tag_describer.operation = "or";
						break;
					case 'excluded':
						tag.setAttribute("class","select normal exclude");
						tag.operation = "exclude";
						break;

				}
			}
		}
	}
}


//This function is called when the add tag button is clicked.
Tag_Module.prototype.add_tag = function() 
{
	rules = new Array();
	rules.push(new Array('#addtag','The tag field',"trim|word_count[1]|max_word_count[1]]"));

	if(!validate_form(rules)) {
		var found_tag = false;
		var tag_name = $('#addtag').val();
		
		for(i in me.tag_descriptions) {
			if( me.tag_descriptions[i].name == tag_name ) {
				found_tag = true;
				break;
			}

		}
		
		//if we are adding a unique tag
		if (found_tag == false) {

			//Talk to server and make sure the tag is ok to add...
			sj = new Simple_json();
			sj.examine_data_callback = function (data) {
				if(data.tag_id >= 0) {
					me.append_tag(tag_name,data.tag_id);
				}
				else {
					alert("Invalid tag named supplied.");
				}
			};

			sj.submit(SY_SITEPATH + "index.php/topic/validate_tag_json","addtag=" + tag_name);


		}
		
		//tag already exists...
		else { 
			alert("Tag already exists.");
		}
	}
}

Tag_Module.prototype.remove_tag = function(tag_num) {
	tagBox = document.getElementById("tagBox");
	tag = document.getElementById("tag" + tag_num);
	tagBox.removeChild(tag);

	//find tag in tag_descriptions and remove it
	for (i in me.tag_descriptions) {
		if(me.tag_descriptions[i].dom_id == tag_num) {
			me.tag_descriptions.splice(i,1);
			break;
		}
	}
}

tag_module = new Tag_Module();
add_tag = tag_module.add_tag;
remove_tag = tag_module.remove_tag;
set_tag_state = tag_module.set_tag_state;


