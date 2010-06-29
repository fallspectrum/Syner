function validate_register_form()
{
	//strip whitespace from username
	
	var username = $('#username').val();
	username = username.replace(/^\s*/,"");
	username = username.replace(/\s*$/,"");

	//strip whitespace from email
	var email = $('#email').val();
	email = email.replace(/^\s*/,"");
	email = email.replace(/^\s*/,"");

	if(username.length <=0)
	{
		$('#username_error').html("Please supply a username.");
		$('#username_error').show();
		return false;
	}
	$('#username_error').hide();
		
	if(email.length <= 0) {
		$('#email_error').html("Please supply a email.");
		$('#email_error').show();
		return false;
	}
	$('#email_error').hide();

	//send the username and email off to the server.	
	$.ajax({
	  url: 'registerajax',
     	  dataType: 'json',
	  data: "username=" + username + "&email=" + email,
	  type:	'POST',
	  success: function(data)  { alert (data.responses[0]['reference_id'])  }
	});

	return false;
}
