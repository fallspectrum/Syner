<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

	<head> 
		<link rel="stylesheet" type="text/css" href="<?=SY_SITEPATH?>styles/css.css" />
		<title>Syner.org - Solving the problems that affect you.
		</title>
		
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
				<img src="<?=SY_SITEPATH?>styles/logo3.png" border="0" />
				</a>
			</div>
		</div>
		<div id="headnav">
			<ul id="headnav">
				<li class="headnav" id="#"><a href="search.php" class="headnav"><img src="<?=SY_SITEPATH?>styles/icons/search_ico.png" border="0" /> Search</a></li>
				<li class="headnav" id="#"><a href="popular.php" class="headnav"><img src="<?=SY_SITEPATH?>styles/icons/popular_ico.png" border="0" /> Popular</a></li>
				<li class="headnav" id="#"><a href="recent.php" class="headnav"><img src="<?=SY_SITEPATH?>styles/icons/recent_ico.png" border="0" /> Recent</a></li>
			</ul>
		</div>
		<div class="usernav">
			<ul class="usernav">
			
				<?php if (get_user_privilege() === 0) { echo '	
				
				<li class="usernav" id="first"><a href="' . SY_SITEPATH . 'index.php/user/register/"><img src="' . SY_SITEPATH . 'styles/icons/register2_ico.png" border="0" /> Register</a></li>
				<li class="usernav"><a href="' . SY_SITEPATH  .'index.php/user/login"><img src=" ' . SY_SITEPATH . 'styles/icons/login_ico.png" border="0" /> Log In</a></li>
				'; } 
				
				else { echo '
				<li class="usernav" id="first"><a href="' . SY_SITEPATH . 'index.php/user/home/"><img src="' . SY_SITEPATH . 'styles/icons/home_ico.png" border="0" /> Home</a></li>
				<li class="usernav" id="first"><a href="' . SY_SITEPATH . 'index.php/user/settings/"><img src="' . SY_SITEPATH . 'styles/icons/settings_ico.png" border="0" /> Settings</a></li>
				<li class="usernav"><a href="' . SY_SITEPATH . 'index.php/user/logout/"><img src="' . SY_SITEPATH . 'styles/icons/logout_ico.png" border="0" /> Log Out</a></li>
				';}
				
				if (get_user_privilege() === 2) {
				echo '
					<li class="usernav" id="first"><a href="' . SY_SITEPATH . 'index.php/admin/control/"><img src="' . SY_SITEPATH .'styles/icons/acp_ico.png" border="0" /> ACP</a></li>
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
				<li class="footnav" id="border"><a href="">FAQ</a></li>
				<li class="footnav" id="border"><a href="">Support</a></li>
				<li class="footnav" id="border"><a href="">About</a></li>
				<li class="footnav" id="border"><a href="">Contact Us</a></li>
				<li class="footnav" id="border"><a href="">Terms of Use</a></li>
				<li class="footnav" id=""><a href="">Privacy</a></li>
			</ul>
				
			
			 Powered By <a href="">Syner <img src="<?=SY_SITEPATH?>styles/syner.png" border="0" id="syner" /></a>
		</div>
	</div>
</body>
</html>
</body>
</html>
