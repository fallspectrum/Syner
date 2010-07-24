<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

	<head> 
		<title>
			Syner.org - Solving the problems that affect you.
		</title>
		<link rel="stylesheet" type="text/css" href="<?=SY_SITEPATH?>styles/layout.css" />
		<link rel="stylesheet" type="text/css" href="<?=SY_SITEPATH?>styles/content.css" />
		
		<!--Need description -->
		 <meta name="description" content="">
		 <!-- meta keywords need to have a set base of keywords listed within everypage so webcrawlers can relate to the synergy project, also, most if not all of these tags should be able to be changed from within the admin control panel so the admin can specify how it is seen by web crawlers
		 and last, tags that are contained within a specific topic should also transfer in the meta keywords seen here in the layout, this way those tags also transfer and are visible to web crawlers -->
		 <meta name="keywords" content="open, source, open-source, project, synergy, synergism, synergos, working together, problem, solving, problem solving, collaborative, emergence, web, development, developer, community, wiki, wikipedia, free, trending, solution, cloud, crowd, selection, group"></head> 
		 
		
		<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.4.2/jquery.js"></script>
		<script type="text/javascript" src="<?=SY_SITEPATH?>system/application/config/global.js"></script>
		<?php 
		if(isset($js_files)) {
			foreach ($js_files as $file) {
				echo "<script type='text/javascript' src='" . $file . "'></script>\n";
			}
		}
		?>	
	</head>

 <body id="">
 <div id="container">
	<div id="header">
		<div id="logo">
			<div class="logoBox">
				<a href="<?=SY_SITEPATH?>index.php">
				<img src="<?=SY_SITEPATH?>styles/logo4.png" border="0" />
				</a>
			</div>
		</div>
		<div id="headnav">
			<ul id="headlist">
				<li class="headnav" ><a href="<?=SY_SITEPATH?>index.php/topic/search" class="headnav" id="active"><img src="<?=SY_SITEPATH?>styles/icons/search_ico.png" border="0" /> Search</a></li>
				<li class="headnav" id="#"><a href="<?=SY_SITEPATH?>index.php/topic/popular" class="headnav" id=""><img src="<?=SY_SITEPATH?>styles/icons/popular_ico.png" border="0" /> Popular</a></li>
				<li class="headnav" id="#"><a href="<?=SY_SITEPATH?>index.php/topic/recent" class="headnav" id=""><img src="<?=SY_SITEPATH?>styles/icons/recent_ico.png" border="0" /> Recent</a></li>
			</ul>
		</div>
		<div id="usernav">
			<ul id="userlist">
			
				<?php 
				
				
				
				if (get_user_privilege() === 0) { echo '	
				
				<li class="usernav"><a href="' . SY_SITEPATH  .'index.php/user/login"><img src=" ' . SY_SITEPATH . 'styles/icons/login_ico.png" border="0" /> Log In</a></li>
				<li class="usernav" id="first"><a href="' . SY_SITEPATH . 'index.php/user/register/" class="border"><img src="' . SY_SITEPATH . 'styles/icons/register2_ico.png" border="0" /> Register</a></li>
				'; } 
				
				else { echo '
				<li class="usernav"><a href="' . SY_SITEPATH . 'index.php/user/logout/"><img src="' . SY_SITEPATH . 'styles/icons/logout_ico.png" border="0" /> Log Out</a></li>
				<li class="usernav"><a href="' . SY_SITEPATH . 'index.php/user/settings/" class="border"><img src="' . SY_SITEPATH . 'styles/icons/settings_ico.png" border="0" /> Settings</a></li>
				<li class="usernav"><a href="' . SY_SITEPATH . 'index.php/user/home/" class="border"><img src="' . SY_SITEPATH . 'styles/icons/home_ico.png" border="0" /> Home</a></li>
				';}
				
				if (get_user_privilege() === 2) {
				echo '
					<li class="usernav"><a href="' . SY_SITEPATH . 'index.php/admin/anb/" class="border"><img src="' . SY_SITEPATH .'styles/icons/acp_ico.png" border="0" /> ACP</a></li>
				';
				}
				?>
			</ul>
		</div>
	</div>
	
		<?=$content?>
		
			<div id="footer">
			<!-- Footnav LI items should be controlled from within the ACP -->
			<ul class="footnav">
				<li class="footnav" id="border"><a href="">User Guide</a></li>
				<li class="footnav" id="border"><a href="">About Us</a></li>
				<li class="footnav" id="border"><a href="">Code of Conduct</a></li>
				<li class="footnav" id="border"><a href="">Terms of Use</a></li>
				<li class="footnav" id=""><a href="">Privacy</a></li>
			</ul>
			 <a href="http://www.syner.org"><img src="<?=SY_SITEPATH?>styles/syner.png" border="0" id="syner" /></a>
		</div>
	</div>
</body>
</html>
</body>
</html>
