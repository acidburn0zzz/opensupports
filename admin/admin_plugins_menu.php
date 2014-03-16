<div class="menumode">
		  <div class="menumode-title"><?php echo $TEXT['Plugins'];?></div>
		  <ul class="menumode-nav">
				<a href="admin_main.php?mode=plugins&submode=listplugins"><li><?php echo $TEXT['Plugins List'];?></li></a>
				<a href="admin_main.php?mode=plugins&submode=installplugins"><li><?php echo $TEXT['Install Plugins'];?></li></a>
				<?php
$query = $api->get_modes('admin/plugins');
while($reg = mysqli_fetch_array($query)){
?>
				<a href="admin_main.php?mode=plugins&submode=extramode&modeid=<?php echo $reg[id]; ?>"><li><?php
	if(isset($TEXT["$reg[name]"])) echo $TEXT["$reg[name]"];
	else echo $reg['name'];
	?>				</li></a>
<?php } ?>
		  </ul>
</div>