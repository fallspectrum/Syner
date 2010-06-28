<!-- div body tag opens in " ".php and closes in footer.php-->
<div id="body">
	<div id="bigBox">
		<div id="content">
			<h2>Registration is simple, fast, and easy!</h2>
				<p>
					<span>
						The Synergy Project is here to help you, solve your problems. 
					</span>
				</p>
				<table>
					<tr>
						<td width="150">
						</td>
						<td>
							To do that, we want to connect you to problems you're most likely to care about.  After registering you'll be able to interact with people who are facing the same problems as you.  Once you've registered, you will be able to submit your own content representing the world, and if you choose to.. you can represent a group.
						</td>
					</tr>
				</table>
				<table>
					<tr>
						<td width="150">
						<!--very small input validation area (simple icons only) like:<img src="<?=SY_SITEPATH?>styles/icons/reg_notice_ico.png" /><img src="<?=SY_SITEPATH?>styles/icons/reg_ok_ico.png" />-->
						</td>
						<td width="400">
							<p>
								<form onSubmit="return validate_register_form();" method="POST" action="">
								
								<b>Username:</b><br /> 
								<input type="text" name="username" title="Your username." size="25" id="username" />
								<img src="<?=SY_SITEPATH?>styles/icons/loading.gif" style="display: none" alt="loading..." id="username_icon" />
								<label style="color: #F00;display: none;" id="username_error">aha</label>
								<br /><br />
								
								<b>Email-address:</b> <br />
								<input type="text" name="email" title="Your email address." size="30" id="email" /> 
								<img src="<?=SY_SITEPATH?>styles/icons/loading.gif" style="display: none" alt="loading..." id="email_icon" />
								<label style="color: #F00;display: none;" id="email_error"></label>
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
						By registering, you are agreeing to your <a href="">Terms of Use</a>.<br /><br />
							<input type="button" value="Register" onClick="validate_register_form()"/>(big register button)
						<form>
						</td>
						<td>
						</td>
					</tr>
				</table>
				
				
				
				
				
				
				
			</div>
		</div>
