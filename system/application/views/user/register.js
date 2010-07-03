/*
 * @todo replace successful message with somethign else then a alert box
 * @todo redirect user to some other page.
 * @todo add vaid email check here. Although done by the server it will save bandwith.
 */
 var loading_icon = "/syner/styles/icons/loading.png";
 var notice_icon = "/syner/styles/icons/reg_notice_ico.png";
 var ok_icon = "/syner/styles/icons/reg_ok_ico.png"
 
function register_form_response(data)
{
	for (var i = 0; i < data.error_responses.length; i++)
	{
		var response = data.error_responses[i];
		var reference_id = response['reference_id'];
		var field_icon = $("#" + reference_id + "_icon");
		
		if(reference_id != "success" )
		{
			var error_field = $("#"+ reference_id + "_error");
			error_field.show();
			
			field_icon.attr("src", notice_icon);
			field_icon.show();
			
			switch(response['return_val']) 
			{
				case '-1':
					error_field.html("The entered " + reference_id + " is invalid.");
					break;
				case '-2':
					error_field.html("The entered " + reference_id +" is already taken.");
					break;
				case '-3':
					error_field.html("There was an error communicating with the database.");
					break;
			}
		} else {
			field_icon.attr("src", ok_icon);
			field_icon.show();
			
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
	email = email.replace(/\s*$/,"");

	var password = $('#password').val();
	var confirm_password = $('#confirm_password').val();
	
	$('#username_icon').show();
	
	if(username.length <=0)
	{
		$('#username_error').html("Please supply a username.");
		$('#username_error').show();
		$('#username_icon').attr("src", notice_icon);
		
		
		return false;
	}
	$('#username_error').hide();
	$('#username_icon').hide();
	
	$('#email_icon').show();
	
	if(email.length <= 0) {
		$('#email_error').html("Please supply a email.");
		$('#email_error').show();
		
		$('#email_icon').attr("src", notice_icon);
		
		return false;
	}
	$('#email_error').hide();
	$('#email_icon').hide();


	//make sure password is atleast 6 characters
	$('#password_icon').show();
	
	if(password.length < 6) {
		$('#password_error').html("Please use a password at least 6 characters.");
		$('#password_error').show();
		
		$('#password_icon').attr("src", notice_icon);
		
		return false;
	}
	$('#password_error').hide();
	$('#password_icon').hide();
	
	//make sure confirmation pasword equals normal password
	
	$('#confirm_password_icon').show();
	if(password != confirm_password) {
		$('#confirm_password_error').html("Confirmation password does not match.");
		$('#confirm_password_error').show();
		
		$('#confirm_password_icon').attr("src", notice_icon);
		
		return false;
	}
	$('#confirm_password_error').hide();
	$('#confirm_password_icon').hide();

	//send the username and email off to the server.	
	$.ajax({
	  url: 'registerajax',
     	  dataType: 'json',
	  data: "username=" + username + "&email=" + email + "&password=" + password,
	  type:	'POST',
	  success: register_form_response,
	  error: ajax_error 

	});

	return false;
}
