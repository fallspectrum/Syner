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
				<h3>Search:</h3>
				<form><input type="text" name="search" value="" size="40" /><input type="submit" value="Search" /><a href="search_results.php">Click here to see what search results look like</a>
				</form>
								<div id="spacer"></div>

				<p>
				The next step in the process is to select an area.  By default Global is selected.
				</p>
				<p>
				There should be a graphic or instructions that describe how selecting another area can narrow the scope of the search down.  "By selecting Country, you can find problems that affect a specific country."  I know I don't have a checkbox or dropdown up in the area menu but there should be one for the selected area item.  This way a user could click a checkbox in the global area "include subareas" and this would search all problems within the project.  The next step should also say," You can include tags to filter your results and only show problems with those tags."
				<p>
					
				</p>
				</p>
				<div id="spacer"></div>
				<p>
				At the bottom of the find page we can include an submit option:
				</p>
				<form>"Can't find the problem you're looking for?<input type="submit" value="Submit One" />"</form>
				<p>
					As long as we encourage some type of "seach before submit" mentality within the community.
				</p>
				
				
				
			</div>
			
		</div>
		
<?php
	require("footer.php");
?>