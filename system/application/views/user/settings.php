<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');?>
<!-- div body tag opens in " ".php and closes in footer.php-->
<div id="body">
	<div id="bigBox">
		<div id="content">
			<h1>
				User Account Settings
			</h1>
			<div id="asettingsmargin">
				<form>
				<b>Display my real name...</b> <a href=""><img src="<?=SY_SITEPATH?>styles/icons/hint_ico.png" border="0" /></a><br />
				<input type="radio" name="realname" value="yes" /> Yes
				<input type="radio" name="realname" value="no" checked/> No <br />
				<!-- The "real name" input only displays when the user selects "yes" for the name -->
				<b>My real name is...</b><br />
				<input type="text" name="realname" value="" size="40"  />
				<br /><br />
				<div id="spacer"></div>
				<br />
				<b>My current email is...</b><br /> <input type="text" name="email" value="user's@email.com" size="40"  /> <br />
				<b>I would like you to email me updates about the problems I am following...</b> <a href=""><img src="<?=SY_SITEPATH?>styles/icons/hint_ico.png" border="0" /></a><br />
				<input type="radio" name="emailupdates" value="yes" /> Yes
				<input type="radio" name="emailupdates" value="no" checked/> No <br />
				<!-- The "how often" input only displays when the user selects "yes" for the updates -->
				<b>How often?</b>
				<br /> 
				<select name="cars">
					<option value="volvo">Daily</option>
					<option value="saab">Weekly</option>
					<option value="fiat">Monthly</option>
				</select>
				<br /><br />
				<div id="spacer"></div>
				<br />
				<b>*set default group area*</b>
				<br /><br />
				</form>
			</div>
		</div>
	</div>
</div>
