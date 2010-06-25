<?php
	require("header.php");
?>
<!-- div body tag opens in " ".php and closes in footer.php-->
<div id="body">
	<div id="bigBox">
		<div id="content">
			<h2>Registration is simple, fast, and easy!</h2>
				<div id="spacer"></div>
				<p>
					<b>
						<u>The Synergy Project</u> is here to help you, solve your problems.  To do that, we want to connect you to problems you're most likely to care about, and to people who are trying to solve the same ones.  Once you've registered, you will be able to submit your own content representing the world, and if you choose to.. you can represent an area.
					</b>
				</p>
				<div id="minispacer"></div>
				<p>
					<form>
											Hi, my <b>username</b> is 
					<input type="text" name="regusername" title="Your username." />.
						I understand that I need this username to log into my account.  My username will also be attached to any content I submit or edit.
					</form>
				</p>
				<p>
					<form>
						My <b>email-address</b> is 
						<input type="text" name="regemail" title="Your email address." />.  
						I understand that I need an email to help verify that I am human.  My email will never be publicly displayed, and is not searchable.
					</form>
				</p>
				<div id="minispacer"></div>
				<p>	
					<i>
						Currently The Synergy Project is in testing.  Once an invite is available, you will receive an email notifying you of your access.
					</i>
				</p>
				<p>
					<b>
						Just to make sure you're human, could you solve this problem for us?
					</b>
				</p>
				
				*Captcha*<br /><br />
				<form>
					<input type="submit" value="Submit" />
				</form>
				
				
				
				
				
			</div>
		</div>
		
<?php
	require("footer.php");
?>