<div class="top-bar">
	<?php
	if(!isset($_GET[mode])) $_GET[mode] = "Home";
	if($_GET[mode] != 'extramode'){
		echo "<div class='modetitle' >";
		echo (isset($_GET[submode])) ? $_GET[submode] : $_GET[mode];
		echo "</div>";
		?>
		<div class="breadcrumbs"><a href="#"><?php echo $_GET['mode'];?></a> <?php if(isset($_GET[mode])) echo "/"; ?> <a href="#"><?php echo $_GET['submode'];?></a></div>
		<?php
	} else{
		$mode = $api->get_mode($_GET[modeid]);
		echo "<div class='modetitle' >";
		if(isset($TEXT["$mode[name]"])) echo $TEXT["$mode[name]"];
		else echo $mode['name'];
		echo "</div>";
		?>
		<div class="breadcrumbs"><a href="#"><?php echo $mode['name']; ?></a></div>
		<?php
	}
	?>
	
</div>