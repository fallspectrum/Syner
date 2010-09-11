<!-- div body tag opens in " ".php and closes in footer.php-->
<div id="body">
	<div id="bigBox">
			<div class="topicnav" id="problem">
				<ul id="topicnav"> 
					<li class="problem"><a href=""><img src="<?=SY_SITEPATH?>styles/icons/problem_ico.png" border="0" /> Problem</a></li> 
					<li class="discussion"><a href=""><img src="<?=SY_SITEPATH?>styles/icons/discussion_ico.png" border="0" /> Discussion</a></li> 
					<li class="solutions"><a href=""><img src="<?=SY_SITEPATH?>styles/icons/solutions2_ico.png" border="0" /> Solutions</a></li> 
					<li class="action"><a href="<?=SY_SITEPATH?>index.php/topic/action/topic_id/<?=$topic_id?>"><img src="<?=SY_SITEPATH?>styles/icons/action_ico.png" border="0" /> Action</a></li>
				</ul> 
			</div>
			
			<div class="controlnav">
				<ul id="controlnav"> 
					<li class="edit"><a href="javascript:toggle_editor();"><img src="<?=SY_SITEPATH?>styles/icons/edit_ico.png" border="0" /> Edit</a></li> 
				</ul> 
			</div>
			
			<div id="content" class="topic problem">
				<h3>
				Topic Title Field
				</h3>
				<div id="minispacer"></div>
				<p>
				<!-- Tiny MCE form display -->
					<form src="problemajax" name="mceeditor">
					<div id="tiny_mce_div" class="tiny_mce_div">
					</div>
					</form>
				</p>
				<p>
				Basically when a user would approach a problem for the first time, they would see the Title, Tags, and Description in plain text.  When they hit the "Edit" button then the page loads TinyMCE for the problem description, and then two separate fields for the title, and tags.  When the user selects a button "Save" then then their changes are placed, an action is created that defines the changes and places it within the history feature (action page) and they're returned to the page in non-editor mode (plain text).  It would probably be helpful to have a "preview" option before the user submits.  It may even be helpful if we force the user to preview before submitting.  I see TinyMCE has a built in preview option.
				</p>
				<div id="minispacer"></div>
				Tags displayed down here.
			</div>
			
		</div>
