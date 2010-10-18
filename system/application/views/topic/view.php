<!-- div body tag opens in " ".php and closes in footer.php-->
<div id="body">
	<div id="bigBox">
			<div class="topicnav" id="problem">
				<ul id="topicnav"> 
					<li class="problem"><a href=""><img src="<?=SY_SITEPATH?>styles/icons/problem_ico.png" border="0" /> Problem</a></li> 
					<li class="discussion"><a href="<?=SY_SITEPATH?>index.php/topic/discussion/problem_id/<?=$topic_id?>"><img src="<?=SY_SITEPATH?>styles/icons/discussion_ico.png" border="0" /> Discussion</a></li> 
					<li class="solutions"><a href=""><img src="<?=SY_SITEPATH?>styles/icons/solutions2_ico.png" border="0" /> Solutions</a></li> 
					<li class="action"><a href="<?=SY_SITEPATH?>index.php/topic/action/topic_id/<?=$topic_id?>/"><img src="<?=SY_SITEPATH?>styles/icons/action_ico.png" border="0" /> Action</a></li>
				</ul> 
			</div>
			
			<div class="controlnav">
				<ul id="controlnav">
					<?php 
					
					if (get_user_privilege() === 2) {
						echo '
						<li><a href="' . SY_SITEPATH . 'index.php/"><img src="' . SY_SITEPATH .'styles/icons/control_ico.png" border="0" /> Control</a></li>
							';}
					
					if (get_user_privilege() !== 0) {
						echo "
						<li class='edit'><a href='../../edit/topic_id/" . $topic_id ."'><img src='" . SY_SITEPATH . "styles/icons/edit_ico.png' border='0' /> Edit</a></li> 
						";}
					else {
						echo "
						<li class='edit'><a><img src='" . SY_SITEPATH . "styles/icons/edit_ico.png' border='0' /> Please log in to edit this page</a></li> ";
					}
					
					?>
				</ul> 
			</div>
			
			<div id="content" class="topic problem">
				<div id="groupdisplay">
					
						<a href="">Root Group</a> > <a href="">Parent Group</a> > <a href=""><b>Current Group</b></a> <!--(display depends on hierarchy of group location) -->
					
				</div>
				
				<h3><?=$topic_title?></h3>
				
				<div id="problem_content">
				<p>
				<?=$problem_content?>
				</p>
				</div>
				<div id="minispacer"></div>
				<div id="tagDisplay">
				<?php 
					if (isset($topic_tags) && is_array($topic_tags)) { 
						foreach ($topic_tags as $tag) {
							echo  '<a href="">' . $tag . '</a> ';
						}
					}
				?>	
				</div>
			</div>
			
		</div>
