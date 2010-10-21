<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');?>
<div id="body">
	<div id="bigBox">
			<div class="topicnav" id="problem">
				<ul id="topicnav">
					<li class="problem"><a href="<?=SY_SITEPATH?>index.php/topic/view/topic_id/<?=$topic_id?>"><img src="<?=SY_SITEPATH?>styles/icons/problem_ico.png" border="0" /> Problem</a></li> 
					<li class="discussion"><a href="<?=SY_SITEPATH?>index.php/topic/discussion/problem_id/<?=$problem_id?>"><img src="<?=SY_SITEPATH?>styles/icons/discussion_ico.png" border="0" /> Discussion</a></li> 
					<li class="solutions"><a href=""><img src="<?=SY_SITEPATH?>styles/icons/solutions2_ico.png" border="0" /> Solutions</a></li>
					<li class="action"><a href="<?=SY_SITEPATH?>index.php/topic/action/topic_id/<?=$topic_id?>/"><img src="<?=SY_SITEPATH?>styles/icons/action_ico.png" border="0" /> Action</a></li>
				</ul>
			</div>

<div id="content">
			<h3>Discussion for problem "<?= $problem_title ?>"</h3>
			<div id="js_error" style="display: none"></div>
			<div class="response">
				<?php 
					if(count($posts) == 0 ) {
						echo "<p>There are no posts in this discussion yet.</p>";
					}
					else {
						foreach ($posts as $post) {
							echo '<div class="reply"><span class="username">' . $post['username'] . '</span>';
							echo '- ' . $post['time_updated'];
							echo '<p class="reply_content">' . $post['user_reply']. '</p>';
							echo '</div>';	
						}
					}
				?>
			</div>
		<?php
			if(get_user_privilege() > 0) 
			{
				//display response form here
				echo '<form onsubmit="return validate_topic_form();">';
				echo '<label for="reply" id="reply_error" style="display: none"></label>';
				echo '<textarea class="tinyMCE" id="reply"></textarea>';
				echo '<input type="submit" value="Submit Reply"/>';
				echo '</form>';
			}
			else {
				echo "Please log in to discuss the issue.";
			}
		?>
		</div>
	</div>
</div>
