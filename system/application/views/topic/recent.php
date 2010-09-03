<div id="body">
	
		<div id="leftBox">
			<?php
				require('groupmodule.php');
			?>
			<?php
				require('tagmodule.php');
			?>
		</div>
		<div id="rightBox">
			<div id="content">
				<h1>
					This is the Most Recent listing.
				</h1>
				<div id="recent_results">
				<?php 
					foreach($topics as $topic) {
						echo '<a href="' . SY_SITEPATH . "index.php/topic/view/topic_id/" .
						      $topic['topic_id'] .  '">' . $topic['title'] . '</a>';
						echo '<p>' . $topic['content'] . '</p><br>';
					}
				?>
				</div>
				<br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br />
				<br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br />
				
			</div>
			
		</div>




