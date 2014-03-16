<div class="menumode">
		<div class="menumode-title"><?php echo $TEXT['Staff']?></div>
		<ul class="menumode-nav">
				<a href="admin_main.php?mode=staff&submode=liststaff"><li><?php echo $TEXT['List Users'];?></li></a>
                <a href="admin_main.php?mode=staff&submode=responses"><li><?php echo $TEXT['Custom Responses'];?></li></a>
				<a href="admin_main.php?mode=staff&submode=newstaff"><li><?php echo $TEXT['New Staff User'];?></li></a>
				<?php
$query = $api->get_modes('admin/staff');
while($reg = mysqli_fetch_array($query)){
?>
				<a href="admin_main.php?mode=staff&submode=extramode&modeid=<?php echo $reg[id]; ?>"><li><?php
	if(isset($TEXT["$reg[name]"])) echo $TEXT["$reg[name]"];
	else echo $reg['name'];
	?>				</li></a>
<?php } ?>
</ul>
</div>