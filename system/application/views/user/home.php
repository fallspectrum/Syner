<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');?>
<!-- div body tag opens in " ".php and closes in footer.php-->
<div id="body">
	<div id="bigBox">
		<div id="content">
				<h1>
					Welcome home <?=$username?>!
				</h1>
				<div id="hometut">
					This is your home page.  Here you can track all the updates associated with any problems that you have chosen to follow.  At the moment you don't have any problems that you're following, to change that, simply click on the "Follow The Action" button when looking at a problem's Action Page. *insert tutorial graphics* 
				</div>
				<div id="homecontainer">
					<div id="homeleft">
						<h4>Your Updates:</h4>
						<div id="updatedisplay">
						<dt>
							<dl id="updates">
								<b>July 5th</b> 
								<dd>
									<a href="" class="bold">Problem title.</a> - <a href="">10 Edits</a>
								</dd>
								<dd>
									<a href="" class="bold">The world is coming to an end.</a> - <a href="">16 Edits</a>
								</dd>
								<dd>
									<a href="" class="bold">The sky is falling.</a> - <a href="">2 Edits</a>
								</dd>
								<dd>
									<a href="" class="bold">Chicken little is a bit too worried.</a> - <a href=""># of Edits</a>
								</dd>
							</dl>
						</dt>
						<dt>
							<dl>
							<b>July 1st</b> 
								<dd>
									<a href="" class="bold">Problem title.</a> - <a href="">10 Edits</a>
								</dd>
								<dd>
									<a href="" class="bold">The world is coming to an end.</a> - <a href="">16 Edits</a>
								</dd>
								<dd>
									<a href="" class="bold">The sky is falling.</a> - <a href="">2 Edits</a>
								</dd>
								<dd>
									<a href="" class="bold">Chicken little a bit too worried.</a> - <a href=""># of Edits</a>
								</dd>
							</dl>
						</dt>
						</div>
						<div id="updatecontrol">
						<a href=""><b class="big">1</b> 2 3</a> > <a href="">Older</a>
						</div>
					</div>
						<div id="homeright">
							<h4>You're Following:</h4>
							<?php
							if(count($topic_subscriptions) > 0) {
								foreach($topic_subscriptions as $subscription) {
									echo "<dt><dl>";
									echo '<a href="' . SY_SITEPATH . 'index.php/topic/view/topic_id/' . $subscription['topic_id'] . '" class="bold">' . $subscription['title'] . '</a>';
									echo "<dd>\r\n-Since: " . $subscription['date'] . '</dd></dl></dt>';
								}
							}
							else {
								echo "You are currently not subscriped to any topics.";
							}
							?>
						</ul>
					</div>
				</div>
		</div>
	</div>
</div>
