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
				<a id="green" onClick="save_tags()">Save</a> / / / / <a id="red" onClick="remove_tags()">Remove All</a>
				</li>
		</ul>				


	
</div>
