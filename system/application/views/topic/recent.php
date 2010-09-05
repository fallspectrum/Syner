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
					if(count($topics) == 0 ) {
						echo "<p> No topics matched your request.</p>";
					}
					else {
						foreach($topics as $topic) {
							echo '<a href="' . SY_SITEPATH . "index.php/topic/view/topic_id/" .
							      $topic['id'] .  '">' . $topic['title'] . '</a>';
							echo '<p>' . $topic['content'] . '</p><br>';
						}
					}
					?>
				</div>
				<br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br />
				<br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br />
				
			</div>
			
		</div>




