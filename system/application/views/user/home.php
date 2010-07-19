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
							<dt>
								<dl>
									<a href="" class="bold">Problem title.</a>
									<dd>
									-Since: August 15th, 2009
									</dd>
								</dl>
							</dt>
							<dt>
								<dl>
									<a href="" class="bold">Problem title.</a>
									<dd>
									-Since: Date
									</dd>
								</dl>
							</dt>
							<dt>
								<dl>
									<a href="" class="bold">Problem title.</a>
									<dd>
									-Since: Date
									</dd>
								</dl>
							</dt>
							<dt>
								<dl>
									<a href="" class="bold">Problem title.</a>
									<dd>
									-Since: Date
									</dd>
								</dl>
							</dt>
						
						</ul>
					</div>
				</div>
		</div>
	</div>
</div>
