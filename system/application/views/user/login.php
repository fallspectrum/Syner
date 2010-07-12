<!-- div body tag opens in " ".php and closes in footer.php-->
<div id="body">
	<div id="bigBox">
		<div id="content">
			<span><b>Log In</b></span>
				
				<table>
					<tr>
						<td width="300">
						</td>
						<td width="200">
							<br />
							<form onsubmit="return validate_login_form();">
								<table>
									<tr>
										<td align="right">	
											<b>Username:</b>
										</td>
										<td align="left">
											<input type="text" style="margin: 0;" name="username" title="Your username." id="username" size="25" />
											<!--<img src="<?=SY_SITEPATH?>styles/icons/loading.gif" style="display: none" alt="loading..." id="username_icon" />-->
											<label class="error" id="username_error"></label>
</td>
									</tr>
									<tr>
										<td align="right">
											<b>Password:</b>
										</td>
										<td  align="left">
											<input type="password" name="password" title="Your password." id="password" size="25" /><br />
											<!--<img src="<?=SY_SITEPATH?>styles/icons/loading.gif" style="display: none" alt="loading..." id="password_icon" />-->
											<label class="error" id="password_error"></label>
										</td>
									</tr>
									<tr>
										<td>
											
										</td>
										<td  align="left">
										<!--<img src="<?=SY_SITEPATH?>styles/icons/loading.gif" style="display: none" alt="loading..." id="js_icon" />-->
										<label class="jserror" id="js_error"></label>
										<input type="submit" value="Log In" /><br />
										<a href="">Forgot your password?</a>
										</td>
									</tr>
								</table>
								
							</form>
							
						
						</td>
					</tr>
				</table>
			
		</div>
	</div>
