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
							<form>
								<table>
									<tr>
										<td align="right">	
											<b>Username:</b>
										</td>
										<td align="left">
											<input type="text" name="username" title="Your username." id="username" size="25" />
											<img src="<?=SY_SITEPATH?>styles/icons/loading.gif" style="display: none" alt="loading..." id="username_icon" />
											<label style="color: #F00;display: none;" id="username_error"></label>
</td>
									</tr>
									<tr>
										<td align="right">
											<b>Password:</b>
										</td>
										<td  align="left">
											<input type="text" name="password" title="Your password." id="password" size="25" /><br />
											<img src="<?=SY_SITEPATH?>styles/icons/loading.gif" style="display: none" alt="loading..." id="password_icon" />
											<label style="color: #F00;display: none;" id="password_error"></label>
										</td>
									</tr>
									<tr>
										<td>
											
										</td>
										<td  align="left">
										<img src="<?=SY_SITEPATH?>styles/icons/loading.gif" style="display: none" alt="loading..." id="js_icon" />
										<p id="js_error" style="display:hidden"></p>
										<input type="button" value="Log In" onclick="validate_login_form()" /><br />
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
