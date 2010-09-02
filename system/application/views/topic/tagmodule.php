<div class="tagMod">

				<ul id= "tagBox" class="tagBox">
				<li id="title"><img src="<?=SY_SITEPATH?>styles/icons/tags2_ico.png" border="0" /> Tags</li>
				<li id="add">
					<form>
						<input type="text" name="addtag" value="" id="addtag" size="20" />
						<label for = "addtag" id="addtag_error"></label>
						<input type="button" value="Add" onclick="add_tag()"/>
					</form>
				</li>
			
				<li id="bottom">
				<?php
					if(get_user_privilege() == 0) {
						echo '<span style="font-size: 80%"> Login to save tags</span> /   <a id="red" onClick="remove_all_tags()">Remove All</a>';
					}
					else {
						echo '<a id="green" onClick="save_tags()">Save</a> / / / / <a id="red" onClick="remove_all_tags()">Remove All</a>';
					}
				?>
				</li>
		</ul>				


	
</div>
