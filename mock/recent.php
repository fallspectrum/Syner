<?php
	$recentnav = "active";
	require("header.php");
?>
<!-- div body tag opens in " ".php and closes in footer.php-->
<div id="body">
	
		<div id="leftBox">
			<?php
				require('groupmod.php');
			?>
			<?php
				require('tagmod.php');
			?>
		</div>
		<div id="rightBox">
			<div id="content">
				
				<div id="resultsheader">
					<div id="resultstitle">
				Most Recent:
					</div>
					<div id="pageoptions">
						<form action="">
							<select name="viewOptions">
							<option value="10" selected="selected">10 Per Page</option>
							<option value="25">25 Per Page</option>
							<option value="50">50 Per Page</option>
							</select>
							<a href="">1</a> <a href="">2</a> <a href="">3</a> <a href="">></a> <a href="">»</a>
							</form>
					</div>
				</div>
					<div id="spacer"></div>
						<div id="resultItem">
							<div id="itemTitle">
								<table width="100%"><tr><td align="left"><a href="topic_problem.php">Problem Title</a></td><td align="right">on Wed Jun 16, 2010 1:10 pm</td></tr></table>
							</div>
							<div id="itemTags">
								<table width="100%"><tr><td align="left"><a href="">Tag</a> <a href="">Tag</a></td><td align="right">Tags Tags Tags</td></tr></table>
							</div>
							<div id="minispacer"></div>
						</div>
						<div id="resultItem">
							<div id="itemTitle">
								<table width="100%"><tr><td align="left"><a href="topic_problem.php">Problem Title</a></td><td align="right">[submission timestamp]</td></tr></table>
							</div>
							<div id="itemTags">
								<table width="100%"><tr><td align="left"><a href="">Tag</a> <a href="">Tag</a></td><td align="right">Tags Tags Tags</td></tr></table>
							</div>
							<div id="minispacer"></div>
						</div>

						<div id="resultItem">
							<div id="itemTitle">
								<table width="100%"><tr><td align="left"><a href="topic_problem.php">Problem Title</a></td><td align="right">[submission timestamp]</td></tr></table>
							</div>
							<div id="itemTags">
								<table width="100%"><tr><td align="left"><a href="">Tag</a> <a href="">Tag</a></td><td align="right">Tags Tags Tags</td></tr></table>
							</div>
							<div id="minispacer"></div>
						</div>
						<div id="resultItem">
							<div id="itemTitle">
								<table width="100%"><tr><td align="left"><a href="topic_problem.php">Problem Title</a></td><td align="right">[submission timestamp]</td></tr></table>
							</div>
							<div id="itemTags">
								<table width="100%"><tr><td align="left"><a href="">Tag</a> <a href="">Tag</a></td><td align="right">Tags Tags Tags</td></tr></table>
							</div>
							<div id="minispacer"></div>
						</div>
						<div id="resultItem">
							<div id="itemTitle">
								<table width="100%"><tr><td align="left"><a href="topic_problem.php">Problem Title</a></td><td align="right">[submission timestamp]</td></tr></table>
							</div>
							<div id="itemTags">
								<table width="100%"><tr><td align="left"><a href="">Tag</a> <a href="">Tag</a></td><td align="right">Tags Tags Tags</td></tr></table>
							</div>
							<div id="minispacer"></div>
						</div>
						<div id="resultItem">
							<div id="itemTitle">
								<table width="100%"><tr><td align="left"><a href="topic_problem.php">Problem Title</a></td><td align="right">[submission timestamp]</td></tr></table>
							</div>
							<div id="itemTags">
								<table width="100%"><tr><td align="left"><a href="">Tag</a> <a href="">Tag</a></td><td align="right">Tags Tags Tags</td></tr></table>
							</div>
							<div id="minispacer"></div>
						</div>
						<div id="resultItem">
							<div id="itemTitle">
								<table width="100%"><tr><td align="left"><a href="topic_problem.php">Problem Title</a></td><td align="right">[submission timestamp]</td></tr></table>
							</div>
							<div id="itemTags">
								<table width="100%"><tr><td align="left"><a href="">Tag</a> <a href="">Tag</a></td><td align="right">Tags Tags Tags</td></tr></table>
							</div>
							<div id="minispacer"></div>
						</div>
						<div id="resultItem">
							<div id="itemTitle">
								<table width="100%"><tr><td align="left"><a href="topic_problem.php">Problem Title</a></td><td align="right">[submission timestamp]</td></tr></table>
							</div>
							<div id="itemTags">
								<table width="100%"><tr><td align="left"><a href="">Tag</a> <a href="">Tag</a></td><td align="right">Tags Tags Tags</td></tr></table>
							</div>
							<div id="minispacer"></div>
						</div>
						<div id="resultItem">
							<div id="itemTitle">
								<table width="100%"><tr><td align="left"><a href="topic_problem.php">Problem Title</a></td><td align="right">[submission timestamp]</td></tr></table>
							</div>
							<div id="itemTags">
								<table width="100%"><tr><td align="left"><a href="">Tag</a> <a href="">Tag</a></td><td align="right">Tags Tags Tags</td></tr></table>
							</div>
							<div id="minispacer"></div>
						</div>
						<div id="resultItem">
							<div id="itemTitle">
								<a href="topic_problem.php">Problem Title</a>
							</div>
							<div id="itemTags">
								<table width="100%"><tr><td align="left"><a href="">Tag</a> <a href="">Tag</a></td><td align="right">Tags Tags Tags</td></tr></table>
							</div>
							<div id="minispacer"></div>
						</div>
						
				<div id="resultsheader">
					<div id="pageoptions">
						<a href="">1</a> <a href="">2</a> <a href="">3</a> <a href="">></a> <a href="">»</a>
					</div>
				</div>
				
			</div>
			
		</div>
		
<?php
	require("footer.php");
?>