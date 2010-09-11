<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');?>
<div id="body">
	<div id="bigBox">
		<div class="topicnav" id="problem">
			<ul id="topicnav">
				<li class="problem"><a href="../../view/topic_id/<?=$topic_id?>"><img src="<?=SY_SITEPATH?>styles/icons/problem_ico.png" border="0" /> Problem</a></li>
				<li class="discussion"><a href=""><img src="<?=SY_SITEPATH?>styles/icons/discussion_ico.png" border="0" /> Discussion</a></li>
				<li class="solutions"><a href=""><img src="<?=SY_SITEPATH?>styles/icons/solutions2_ico.png" border="0" /> Solutions</a></li>
				<li class="action"><a href="<?=SY_SITEPATH?>index.php/topic/action/topic_id/<?=$topic_id?>/"><img src="<?=SY_SITEPATH?>styles/icons/action_ico.png" border="0" /> Action</a></li>
			</ul>
		</div>

		Not having the edit button breaks view.	

		<div id="content">
			<ul>
				<li><a href="#" onclick="save_siding(FOR)">For Topic</a></li>
				<li><a href="#" onclick="save_siding(UNDECIDED)">Undecided</a></li>
				<li><a href="#" onclick="save_siding(AGAINST)">Against Topic</a></li>
				<li><a href="#" onclick="save_siding(UNSUSCRIBE)">Unsuscribe</a></li>
			</ul>
			<p>This is the action page.</p>
		</div>
