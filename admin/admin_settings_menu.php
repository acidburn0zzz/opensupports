<div class="menumode">
		  <div class="menumode-title"><?php echo $TEXT['Settings'];?></div>
		  <ul class="menumode-nav">
				<a href="admin_main.php?mode=settings&submode=about"><li><?php echo $TEXT['About'];?></li></a>
				<a href="admin_main.php?mode=settings&submode=generalsettings"><li><?php echo $TEXT['General Settings'];?></li></a>
                <a href="admin_main.php?mode=settings&submode=departments"><li><?php echo $TEXT['Departments'];?></li></a>
				<a href="admin_main.php?mode=settings&submode=langs"><li><?php echo $TEXT['Languages'];?></li></a>
				<a href="admin_main.php?mode=settings&submode=themes"><li><?php echo $TEXT['Themes'];?></li></a>
                <a href="admin_main.php?mode=settings&submode=properties"><li><?php echo $TEXT['Managed Properties'];?></li></a>
				<a href="admin_main.php?mode=settings&submode=update"><li><?php echo $TEXT['Update'];?></li></a>
				<?php
$query = $api->get_modes('admin/settings');
while($reg = mysqli_fetch_array($query)){
?>
				<a href="admin_main.php?mode=settings&submode=extramode&modeid=<?php echo $reg[id]; ?>"><li><?php
	if(isset($TEXT["$reg[name]"])) echo $TEXT["$reg[name]"];
	else echo $reg['name'];
	?>				</li></a>
<?php } ?>
			</ul>
</div>