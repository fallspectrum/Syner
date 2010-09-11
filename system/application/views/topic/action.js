var FOR=0;
var AGAINST=1;
var UNDECIDED=2;
var UNSUSCRIBE=3;

function settings_saved() 
{
	alert("Your settings have saved successfully.");
}

function save_siding(siding) 
{
	//get topic id from url
	url = window.location.pathname.split('/');
	topic_id = url[6];

	sj = new Simple_json();
	sj.success_callback = settings_saved;
	sj.submit(SY_SITEPATH + "index.php/topic/subscribe_json","topic_id=" + topic_id + "&siding="+siding);
}


