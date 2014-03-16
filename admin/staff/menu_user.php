<?php
$user =$api->get_user_by_id($_GET[id]);
?>
<div class="leftmenu">
<div class="leftmenutitle"><?php echo $TEXT['Users'] . " (" . $user[name] . ")";?></div>
<ul class="leftmenunav">
	<a href="index.php?mode=Users&submode=View&id=<?php echo $user[id];?>"><li><?php echo $TEXT["User Details"];?></li></a>
	<a href="index.php?mode=Users&submode=Edit&id=<?php echo $user[id];?>"><li><?php echo $TEXT["Edit User"];?></li></a>
    <a href="index.php?mode=Users&submode=Delete&id=<?php echo $user[id];?>"><li><?php echo $TEXT["Delete User"];?></li></a>
</ul>
<a href="index.php?mode=Users" class="link"><?php echo $TEXT['List Users'];?></a>
</div>