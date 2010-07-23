function validate_register_form()
{

	var form_rules = new Array();
	form_rules.push(new Array('#username','Username','trim|min_length[1]'));
	form_rules.push(new Array('#email','E-mail','trim|email'));
	form_rules.push(new Array('#password','Password','trim|min_length[6]'));
	form_rules.push(new Array('#confirm_password','Confirmation password','trim|min_length[6]|matches_element[#password][password]'));
	validate_form(form_rules);
	if(!validate_form(form_rules)) {
		sj = new Simple_json();
		
		sj.success_callback = function () {
			$("#register_container").fadeOut("slow");
			$("#success_container").delay(600).fadeIn("Fast");
		};
		
		data = "username=" + $('username').val() + "&email=" + $('#email').val() + "&password=" + $('password').val();
		url = SY_SITEPATH + 'index.php/user/registerajax';
		sj.submit(url,data);
	}
	return false;
}

