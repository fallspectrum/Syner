<?php
	$searchnav = "active";
	require("header.php");
?>
<!-- div body tag opens in " ".php and closes in footer.php-->
<div id="body">
	
		<div id="leftBox">
			<?php
				require('groupmod.php');
			?>
		</div>
		<div id="rightBox">
			<div id="content">
				<br />
				<form><input type="text" name="search" value="" size="40" /><input type="submit" value="Search" />
				</form>
								<div id="spacer"></div>
		
				<div id="resultsheader">
					<div id="resultstitle">
				Results:
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
					<div id="minispacer"></div>
						<div id="resultItem">
							<div id="itemTitle">
							<a href="topic_problem.php">The Synergy Project needs a good layout. (Problem Title)</a>
							</div>
							<div id="itemTags">
							(maybe make tags that relate to filter align left, non-relate align right?)Tags Tags Tags
							</div>
							<div id="minispacer"></div>
						</div>
						<div id="resultItem">
							<div id="itemTitle">
							<a href="topic_problem.php">Problem Title</a>
							</div>
							<div id="itemTags">
							Tags Tags Tags
							</div>
							<div id="minispacer"></div>
						</div>
						<div id="resultItem">
							<div id="itemTitle">
							<a href="topic_problem.php">Problem Title</a>
							</div>
							<div id="itemTags">
							Tags Tags Tags
							</div>
							<div id="minispacer"></div>
						</div>
						<div id="resultItem">
							<div id="itemTitle">
							<a href="topic_problem.php">Problem Title</a>
							</div>
							<div id="itemTags">
							Tags Tags Tags
							</div>
							<div id="minispacer"></div>
						</div>
						<div id="resultItem">
							<div id="itemTitle">
							<a href="topic_problem.php">Problem Title</a>
							</div>
							<div id="itemTags">
							Tags Tags Tags
							</div>
							<div id="minispacer"></div>
						</div>
						<div id="resultItem">
							<div id="itemTitle">
							<a href="topic_problem.php">Problem Title</a>
							</div>
							<div id="itemTags">
							Tags Tags Tags
							</div>
							<div id="minispacer"></div>
						</div>
						<div id="resultItem">
							<div id="itemTitle">
							<a href="topic_problem.php">Problem Title</a>
							</div>
							<div id="itemTags">
							Tags Tags Tags
							</div>
							<div id="minispacer"></div>
						</div>
						<div id="resultItem">
							<div id="itemTitle">
							<a href="topic_problem.php">Problem Title</a>
							</div>
							<div id="itemTags">
							Tags Tags Tags
							</div>
							<div id="minispacer"></div>
						</div>
						<div id="resultItem">
							<div id="itemTitle">
							<a href="topic_problem.php">Problem Title</a>
							</div>
							<div id="itemTags">
							Tags Tags Tags
							</div>
							<div id="minispacer"></div>
						</div>
						<div id="resultItem">
							<div id="itemTitle">
							<a href="topic_problem.php">Problem Title</a>
							</div>
							<div id="itemTags">
							Tags Tags Tags
							</div>
							<div id="minispacer"></div>
						</div>
						
				<div id="resultsheader">
					<div id="pageoptions">
						<a href="">1</a> <a href="">2</a> <a href="">3</a> <a href="">></a> <a href="">»</a>
					</div>
				</div>
				<div id="spacer"></div>	
				<form align="center">Can't find the problem you're looking for?<input type="submit" value="Submit One" /></form>

				
				
			</div>
			
		</div>
		
<?php
	require("footer.php");
?>