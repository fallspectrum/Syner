<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');?>
<div id="body">
	<div id="bigBox">
		<div class="topicnav" id="problem">
			<ul id="topicnav">
				<li class="problem"><a href="<?=SY_SITEPATH?>index.php/topic/view/topic_id/<?=$topic_id?>"><img src="<?=SY_SITEPATH?>styles/icons/problem_ico.png" border="0" /> Problem</a></li> 
				<li class="discussion"><a href=""><img src="<?=SY_SITEPATH?>styles/icons/discussion_ico.png" border="0" /> Discussion</a></li>
				<li class="solutions"><a href=""><img src="<?=SY_SITEPATH?>styles/icons/solutions2_ico.png" border="0" /> Solutions</a></li>
				<li class="action"><a href="<?=SY_SITEPATH?>index.php/topic/action/topic_id/<?=$topic_id?>/"><img src="<?=SY_SITEPATH?>styles/icons/action_ico.png" border="0" /> Action</a></li>
			</ul>
		</div>

		Not having the edit button breaks view.	

		<div id="content">
			<h3>Subscription Options</h3>
			<ul>
				<li><a href="<?=SY_SITEPATH . "index.php/topic/action/topic_id/" . $topic_id . "/subscription_action/for"?>">For Topic</a></li>
				<li><a href="<?=SY_SITEPATH . "index.php/topic/action/topic_id/" . $topic_id . "/subscription_action/undecided"?>">Undecided</a></li>
				<li><a href="<?=SY_SITEPATH . "index.php/topic/action/topic_id/" . $topic_id . "/subscription_action/against"?>">Against Topic</a></li>
				<?php
					if (isset($subscription_info)) {
						echo '<li><a href="' . SY_SITEPATH . "index.php/topic/action/topic_id/" . $topic_id . '/subscription_action/unsuscribe">Unsuscribe</a></li>';
					}
				?>
			</ul>
			<?php
				//format subscription info if given
				if(isset($subscription_info)) {
					echo "<h3>Subscription Info</h3>";
					echo "<ul>";
					echo "<li>Number of people subscribed: " . $subscription_info['subscription_count'] . "</li>";
					echo "<li>Number of people for the topic: " . $subscription_info['for_count'] . "</li>";
					echo "<li>Number of people against the topic: " . $subscription_info['against_count'] . "</li>";
					echo "<li>Number of people undecided about the topic: " . $subscription_info['undecided_count'] . "</li>";
					echo "</ul>";

				}
				else {
					echo "<p>Please subscribe to topic to see subscription count.</p>";
				}
			?>
		</div>
