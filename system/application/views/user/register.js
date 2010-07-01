/*
 * @todo replace successful message with somethign else then a alert box
 * @todo redirect user to some other page.
 * @todo add vaid email check here. Although done by the server it will save bandwith.
 */
function register_form_response(data)
{
	for (var i = 0; i < data.error_responses.length; i++)
	{
		var response = data.error_responses[i];
		var reference_id = response['reference_id'];
		if(reference_id != "success" )
		{
			var error_field = $("#"+ reference_id + "_error");
			error_field.show();
			switch(response['return_val']) 
			{
				case '-1':
					error_field.html("Invalid characters were supplied.");
					break;
				case '-2':
					error_field.html("The entered " + reference_id +" is already taken.");
					break;
				case '-3':
					error_field.html("There was an error communicating with the database.");
					break;
			}
		}

		//there should only be 1 success message
		else {
			alert("Account registered successfully!");	
		}
	}
	
}

/*
* @todo find a better way to let the user know an error occured
*/
function ajax_error(xhr,textStatus,errorThrow)
{
	$('#js_error').html("There was an error processing your request.");
	$('#js_error').show();
}

function validate_register_form()
{
	//strip whitespace from username
	$('#js_error').hide();
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
	  success: register_form_response,
	  error: ajax_error 

	});

	return false;
}
