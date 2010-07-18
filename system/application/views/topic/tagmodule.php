<div class="tagMod">

				<ul class="tagBox">
				<li id="title"><img src="<?=SY_SITEPATH?>styles/icons/tags2_ico.png" border="0" /> Tags</li>
				<li id="add">
					<form>
						<input type="text" name="addtag" value="" size="20" /><input type="submit" value="Add" />
					</form>
				</li>
				<li id="" class="select normal and">
					<form>
						<input type="radio" name="operation" value="and" title="And" />
						<input type="radio" name="operation" value="or" title="Or" />
						<input type="radio" name="operation" value="exclude" title="Exclude" /> 	
							And<a href=""><img src="<?=SY_SITEPATH?>styles/icons/remove_tag_ico.png" border="0" class="inline"  /></a>
					</form>
				</li>
				<li id="" class="normal ignore">
					<form>
						<input type="radio" name="operation" value="and" title="And" />
						<input type="radio" name="operation" value="or" title="Or" />
						<input type="radio" name="operation" value="exclude" title="Exclude" /> 						
							Ignored<a href=""><img src="<?=SY_SITEPATH?>styles/icons/remove_tag_ico.png" border="0" class="inline"  /></a>
					</form>
				</li>
				<li id="" class="select normal or">
					<form>
						<input type="radio" name="operation" value="and" title="And" />
						<input type="radio" name="operation" value="or" title="Or" />
						<input type="radio" name="operation" value="exclude" title="Exclude" /> 	
							Or<a href=""><img src="<?=SY_SITEPATH?>styles/icons/remove_tag_ico.png" border="0" class="inline"  /></a>
					</form>
				</li>
				<li id="" class="select normal exclude">
					<form>
						<input type="radio" name="operation" value="and" title="And" />
						<input type="radio" name="operation" value="or" title="Or" />
						<input type="radio" name="operation" value="exclude" title="Exclude" /> 	
							Excluded<a href=""><img src="<?=SY_SITEPATH?>styles/icons/remove_tag_ico.png" border="0"  class="inline" /></a>
					</form>
				</li>
				<li id="bottom">
				<a href="" id="green">Save</a> / / / / <a href="" id="red">Remove All</a>
				</li>
				


	
</div>
