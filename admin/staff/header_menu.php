<div id="header">
	<div id="logohead">		
	</div>
        <ul id="top-navigation">
        	<a href="index.php"><li id='<?php if(isset($_GET[mode])) echo 'topnav-home'; else echo 'topnav-home-active';?>'><?php echo $TEXT['Home'];?></li></a>
			<a href="index.php?mode=Tickets"><li <?php if($_GET[mode] == "Tickets") echo "id='topnav-tickets-active'"; else echo "id='topnav-tickets'"; ?>><?php echo $TEXT['Tickets'];?></li></a>
			<a href="index.php?mode=Users"><li <?php if($_GET[mode] == "Users") echo "id='topnav-users-active'"; else echo "id='topnav-users'"; ?>><?php echo $TEXT['Users'];?></li></a>
			<a href="index.php?mode=Docs"><li <?php if($_GET[mode] == "Docs") echo "id='topnav-docs-active'"; else echo "id='topnav-docs'"; ?>><?php echo $TEXT['Docs'];?></li></a>
            <?php
$query = $api->get_modes('staff');
while($reg = mysqli_fetch_array($query)){
?>
			<a href="index.php?mode=extramode&modeid=<?php echo $reg[id]; ?>"><li <?php if($_GET[modeid] == $reg[id]) echo "id='topnav-plugin-active'"; else echo "id='topnav-plugin'"; ?> ><?php
	if(isset($TEXT["$reg[name]"])) echo $TEXT["$reg[name]"];
	else echo $reg['name'];
	?>				</li></a>
<?php } ?>
			<a href="close.php"><li id='topnav-close'><?php echo $TEXT['Close Session'];?></li></a>
		</ul>
</div>