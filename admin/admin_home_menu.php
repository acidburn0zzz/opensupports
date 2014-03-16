<div class="menumode">
		  <div class="menumode-title"><?php echo $TEXT['Homepage'];?></div>
          <ul class="menumode-nav">
          		<a href="admin_main.php?mode=home&submode=home"><li><?php echo $TEXT['Home'];?></li></a>
				<a href="admin_main.php?mode=home&submode=logs"><li><?php echo $TEXT['Logs'];?></li></a>
				<a href="admin_main.php?mode=home&submode=mmail"><li><?php echo $TEXT['Massive Mail'];?></li></a>
				<?php
$query = $api->get_modes('admin/home');
while($reg = mysqli_fetch_array($query)){
?>
				<a href="admin_main.php?mode=home&submode=extramode&modeid=<?php echo $reg[id]; ?>"><li><?php
	if(isset($TEXT["$reg[name]"])) echo $TEXT["$reg[name]"];
	else echo $reg['name'];
	?>				</li></a>
<?php } ?>
		  </ul>
</div>