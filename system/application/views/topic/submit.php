<!-- div body tag opens in " ".php and closes in footer.php-->
<div id="body">
	<div id="leftBox">
			<div class="groupMod">
				<ul class="groupBox">
				<li id="title"><img src="<?=SY_SITEPATH?>styles/icons/groups3_ico.png" border="0" /> Groups</li>
				<li><a href="" class="normal"><img src="<?=SY_SITEPATH?>styles/icons/global_ico.png" border="0" /> Global</a></li>
				<li><a href="" class="normal"><img src="<?=SY_SITEPATH?>styles/icons/country_ico.png" border="0" /> Country</a></li>
				<li><a href="" class=""><img src="<?=SY_SITEPATH?>styles/icons/personal_ico.png" border="0" /> Personal</a></li>
				</ul>
			</div>
			
		</div>
		<div id="rightBox">
			<div id="content">
				<b>Problem Submission Form:</b><br />
				<p><span>Step 1 - Select the group that this problem belongs to.  *hint icon, question mark*<br />
				<------------</span></p>
				<p>When a user clicks the hint icon, they're given details about what each group is for, Global is for a problem that affects all people, country for country, personal are for personal problems.</p>
				<p><span>Step 2 - Title your problem.  *hint icon*</span></p>
				<p>When the user clicks the hint icon, they are told to summarize the problem in a short sentence.</p>
				<p><span>Step 3 - Describe your problem.  *hint icon*</span></p>
				<p>This is where the Tiny_MCE editor would be displayed.  If a user clicks the hint icon, they're given details about the tiny-MCE abilities, such as linking to outside/inside content, images, videos, etc.</p>
				<p><span>Step 4 - Tag your problem.  *hint icon*</span></p>
				<p>This field should have some sort of suggestion feature above or near it.  An example of a tag suggestion feature is:  <a href="http://swift.ushahidi.com/extend/silcc/">SiLCC</a>.  SiLCC takes the description content, and analyzes it to make quick suggestions for tags for the user.  When the user clicks the hint icon, they're told that tags are used to categorize problems, and are also used to help people find problem they're interested in.  
				<p><a href=""><b>SUBMIT</b></a></p>
				<p><i>Notes: maybe during the submission process, rather than having "hint icons" we could allocate the right part of the form to display input instructions while the user's cursor is within that field.  For example, when the user first selects within the title field, a display area tells the user some details about making a good title. When they move from title to description, the title helpful fades out, and the description helper fades in.  </i></p>
				
			</div>
			
		</div>