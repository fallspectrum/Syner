<!-- div body tag opens in " ".php and closes in footer.php-->
<!-- lol so many divs! -->
<div id="body">
	<div id="bigBox">
		<div id="content">
				<div id="register_container">
					<p>
						<span>
							<b>
							Registration is simple, fast, and easy!
							</b>
						</span>
					</p>
					<table>
						<tr>
							<td width="150">
							</td>
							<td>
								The Synergy Project wants to help you solve your problems.  To do that, we want to connect you to problems you're most likely to care about.  Once you've registered, you will be able to submit your own content representing the world, and if you choose to.. you can represent a group.
							</td>
						</tr>
					</table>
				
					<table>
						<tr>
							<td width="150">
							<!--very small input validation area (simple icons only) like:<img src="<?=SY_SITEPATH?>styles/icons/reg_notice_ico.png" /><img src="<?=SY_SITEPATH?>styles/icons/reg_ok_ico.png" />-->
							</td>
							<td width="700px">
								<p>
									<form onSubmit="return validate_register_form();" method="POST" action="">
									
									<b>Username:</b><br /> 
									<input type="text" name="username" title="Your username." size="25" id="username" />
									<img src="<?=SY_SITEPATH?>styles/icons/loading.gif" style="display: none" alt="loading..." id="username_icon" />
									<label style="color: #F00;display: none;" id="username_error"></label>
									<br /><br />
									
									<b>Email-address:</b> <br />
									<input type="text" name="email" title="Your email address." size="30" id="email" /> 
									<img src="<?=SY_SITEPATH?>styles/icons/loading.gif" style="display: none" alt="loading..." id="email_icon" />
									<label style="color: #F00;display: none;" id="email_error"></label>
									<br /><br />
								
									<b>Password:</b> <br />
									<input type="password" name="password" title="Create a password." size="30" id="password" /> 
									<img src="<?=SY_SITEPATH?>styles/icons/loading.gif" style="display: none" alt="loading..." id="password_icon" />
									<label style="color: #F00;display: none;" id="password_error"></label>
									<br /><br />
		
									<b>Confirm Password:</b> <br />
									<input type="password" name="confirm_password" title="Please confirm your password." size="30" id="confirm_password" /> 
									<img src="<?=SY_SITEPATH?>styles/icons/loading.gif" style="display: none" alt="loading..." id="confirm_password_icon" />
									<label style="color: #F00;display: none;" id="confirm_password_error"></label>
							
							</p>
							</td>
						</tr>
					</table>
					<p>
						<span>
							To make sure you're human, could you solve this problem for us?
						</span>
					</p>
					<table>
						<tr>
							<td width="150">
							</td>
							<td width="450">
							*Captcha*<br /><br />
							By registering, you are agreeing to our <a href="">Terms of Use</a>.<br /><br /><!-- Terms of use link = pop up window. -->
								<label style="color: #F00;display: none;" id="js_error"></label><br />
								<input type="button" value="Register" onClick="validate_register_form()"/>
							<form>
							</td>
							<td>
							</td>
						</tr>
					</table>
				</div>
				<div id="success_container" style="display: none;">
					<p>
						<span>
							<b>
							Thank you for registering!
							</b>
						</span>
					</p>
					<table>
						<tr>
							<td width="150">
							</td>
							<td>
								An email with instructions on how to active your account have been sent to the email address you provided. One
								more step and you will be able to help solve problems you care about!
							</td>
						</tr>
					</table>
				</div>
		</div>
	</div>
