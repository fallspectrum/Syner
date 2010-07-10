<!-- div body tag opens in " ".php and closes in footer.php-->
<div id="body">
	<div id="bigBox">
			<div class="topicnav" id="problem">
				<ul id="topicnav"> 
					<li class="problem"><a href="../../view/topic_id/<?=$topic_id?>"><img src="<?=SY_SITEPATH?>styles/icons/problem_ico.png" border="0" /> Problem</a></li> 
					<li class="discussion"><a href=""><img src="<?=SY_SITEPATH?>styles/icons/discussion_ico.png" border="0" /> Discussion</a></li> 
					<li class="solutions"><a href=""><img src="<?=SY_SITEPATH?>styles/icons/solutions2_ico.png" border="0" /> Solutions</a></li> 
					<li class="action"><a href=""><img src="<?=SY_SITEPATH?>styles/icons/action_ico.png" border="0" /> Action</a></li> 
				</ul> 
			</div>
			
			<div class="controlnav">
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
					<label for="problem_title">Problem Title:</label><input type="text" name="topic_title" value="Title" />
					</div>
					<p>Problem Description: 
					<!-- Tiny MCE form display -->
						<textarea id="problem_content" class="tinyMCE"></textarea>
						</form>
					</p>
					<p>Problem tags: 
						<input type="text" name="tag1" />
						<input type="text" name="tag1" />
						<input type="text" name="tag1" />
						<input type="text" name="tag1" />
						<input type="text" name="tag1" />
					</p>
					<p>
						<input type="button" value="Submit" />
					</p>
				<form>	
			</div>
			
		</div>