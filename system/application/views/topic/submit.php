<!-- div body tag opens in " ".php and closes in footer.php-->
<div id="body">
	<div id="leftBox">
			<?php
				require('groupmodule.php');
			?>
			
		</div>
		<div id="rightBox">
			<div id="content">
				<h1>Problem Submission Form</h1>
				<form>
				<!-- Includes Title, Description, Tags, and Group.  We could employ a tag suggestion feature that scans the contents of the description that the user has typed, and based on that input would suggest tags for them to use: http://swift.ushahidi.com/extend/silcc/
				After a user submits this form a topic is created based on the input.  The user can continue to edit their topic from there.
				-->
				<h3>What group does this problem belong to? <img src="<?=SY_SITEPATH?>styles/icons/hint_ico.png" border="0" /></h3>
				<p>*img with arrow point to the group module to the left here*</p>
				
				<h3>How would you title this problem in a short phrase? <img src="<?=SY_SITEPATH?>styles/icons/hint_ico.png" border="0" /></h3>
				<label for="title">Title:</label>
				<input type="text" id="problem_title" size="80" />
				<label for="title" id="problem_title_error" style="display:none"></label>
				</p>		
				<h3>Could you describe this problem as best you can? <img src="<?=SY_SITEPATH?>styles/icons/hint_ico.png" border="0" /></h3>
				<p>
					<label for="problem_description">Description:</label>
					<span id="problem_description_error"></span>
					<textarea class="tinyMCE" id="problem_description"></textarea>
				</p>
				<h3>We need you to tag this problem, so other people can find it. <img src="<?=SY_SITEPATH?>styles/icons/hint_ico.png" border="0" /></h3>
				<p>Tags:<br />
						<input type="text" id="tag0"/> <span id="tag0_error" style="display:none"></span><br>
						<input type="text" id="tag1"/> <span id="tag1_error" style="display:none"></span><br>
						<input type="text" id="tag2"/> <span id="tag2_error" style="display:none"></span><br>
				</p>
					<input type="button" onclick="validate_topic_form()" value="Submit Problem" class="button" />
				</form>
			</div>
			
		</div>

