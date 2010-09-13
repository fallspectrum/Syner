<!-- div body tag opens in " ".php and closes in footer.php-->
<div id="body">
	<div id="bigBox">
			<div class="topicnav" id="problem">
				<ul id="topicnav"> 
					<li class="problem"><a href="<?=SY_SITEPATH?>index.php/topic/view/topic_id/<?=$topic_id?>"><img src="<?=SY_SITEPATH?>styles/icons/problem_ico.png" border="0" /> Problem</a></li> 
					<li class="discussion"><a href=""><img src="<?=SY_SITEPATH?>styles/icons/discussion_ico.png" border="0" /> Discussion</a></li> 
					<li class="solutions"><a href=""><img src="<?=SY_SITEPATH?>styles/icons/solutions2_ico.png" border="0" /> Solutions</a></li> 
					<li class="action"><a href="<?=SY_SITEPATH?>index.php/topic/action/topic_id/<?=$topic_id?>"><img src="<?=SY_SITEPATH?>styles/icons/action_ico.png" border="0" /> Action</a></li>
				</ul> 
			</div>
			
			<div class="controlnav" id="edit">
				<ul id="controlnav">
					<?php 
					if (get_user_privilege() !== 0) {
						echo "
						<li class='edit'><a href='javascript:toggle_editor();'><img src='" . SY_SITEPATH . "styles/icons/edit_ico.png' border='0' /> Edit</a></li> 
						</ul> ";}
					else {
						echo "
						<li class='edit'><a><img src='" . SY_SITEPATH . "styles/icons/edit_ico.png' border='0' /> Please log in to edit this page</a></li> ";
					}
					
					?>
				</ul> 
			</div>
			
			<div id="content" class="topic problem">
				<form src="problemajax">
					<div id="titleDisplay">
					<label for="problem_title">Problem Title:</label><input type="text" name="problem_title" id="problem_title" value="Title" />
					</div>
					<p>Problem Description: 
					<!-- Tiny MCE form display -->
						<textarea id="problem_description" name="problem_description" class="tinyMCE"></textarea>
						</form>
					</p>
					<label>Problem tags:</label><br />
					<textarea id="problem_tags" cols="25" rows="2"></textarea>
					<p>
						<input type="button" value="Submit" />
					</p>
				<form>	
			</div>
			
		</div>
