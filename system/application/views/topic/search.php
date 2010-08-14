<div id="body">
	
		<div id="leftBox">
			<?php
				require('groupmodule.php');
				require('tagmodule.php');
			?>
			
		</div>
		<div id="rightBox">
			<div id="content">
				<br />
				<form onSubmit="return do_search()">
					<input type="text" name="search" value="" size="40" id = "txt_search"/>
					<input type="submit" value="Search" class="button" /> <br>
					<label for="text_search" id="txt_search_error"></label>
				</form>
				<div id="spacer"></div>
				<p>
				<h1>
					To start your search, select the group you'd like to search in.
				</h1>
				</p>
				<div id="search_results">
					<a href="">Topic title</a>
					<p> This is dummy topic used to help style results.</p>
				</div>
				
				<div id="spacer"></div>
				<p>
				<strong>Can't find what you're looking for?</strong>  <a href="submit/"><b>Submit A Problem</b></a>
				</p>
				
				
			</div>
			
		</div>




