<div class="leftmenu">
<div class="leftmenutitle"><?php echo $TEXT['Tickets Departments'];?></div>
<ul class="leftmenunav">
	<?php
	$string = ", ".$STAFF[departments].",";
	$query = $api->get_departments();
	while($dep = mysqli_fetch_array($query)){
		$pos = strpos($string,", ".$dep[name].",");
		if($pos !== false) echo '<a href="index.php?mode=Tickets&submode='.$dep[name].'"><li>'.$dep[name].'</li></a>';
	}
	?>
</ul>
</div>