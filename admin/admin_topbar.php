<div id="header">
		<a href="admin_main.php?mode=home&submode=logs" class="logo"><div id="headerlogo"></div></a>
		<ul id="top-navigation">
		    <a href="admin_main.php?mode=home&submode=logs"><li <?php if($_GET[mode] == 'home') echo 'class="active"';?>><?php echo $TEXT['Homepage']; ?></li></a>
			<a href="admin_main.php?mode=staff&submode=liststaff"><li <?php if($_GET[mode] == 'staff') echo 'class="active"';?>><?php echo $TEXT['Staff']; ?></li></a>
			<a href="admin_main.php?mode=settings&submode=about"><li <?php if($_GET[mode] == 'settings') echo 'class="active"';?>><?php echo $TEXT['Settings']; ?></li></a>
			<a href="admin_main.php?mode=plugins&submode=listplugins"><li <?php if($_GET[mode] == 'plugins') echo 'class="active"';?>><?php echo $TEXT['Plugins']; ?></li></a>
			<a href="close.php"><li><?php echo $TEXT['Close Session']; ?></li></a>
	  </ul>
	  <?php include "admin_infobox.php";?>
 </div>