/*
 * @todo replace successful message with somethign else then a alert box
 * @todo redirect user to some other page.
 * @todo add vaid email check here. Although done by the server it will save bandwith.
 */


function validate_login_form()
{
	//strip whitespace from username
	
	var rules = new Array();
	rules.push(new Array('#username','Username','min_length[3]'));
	rules.push(new Array('#password','Password','min_length[6]'));
	if(!validate_form(rules)) {

		//send the username and email off to the server.	
		var sj = new Simple_json();
		sj.success_callback =  function () {
				$('js_error').html("You are now logged in. Redirecting you to your home page.");
				redirect("home");	
		};

		var data = "username=" + $('#username').val() + "&password=" + $('#password').val();
		sj.submit('login_ajax',data);
	}

	return false;
	
}
