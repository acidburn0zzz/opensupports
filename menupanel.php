<div class="menupanel">
<ul class="panel-full">
<li class="panel-line" id="menu-tickets"><a href="upanel.php"><?php echo $TEXT['Tickets Submitted']; ?></a></li>
<li class="panel-line" id="menu-new"><a href="upanel.php?id=new"><?php echo $TEXT['New Ticket']; ?></a></li>
<li class="panel-line" id="menu-edit"><a href="upanel.php?id=edit"><?php echo $TEXT['Edit Profile']; ?></a></li>
<li class="panel-line" id="menu-docs"><a href="upanel.php?id=docs"><?php echo $TEXT['Docs and Guides']; ?></a></li>
<?php
$query = $api->get_modes('user');
while($reg = mysqli_fetch_array($query)){
?>
<li class='panel-line'><a href="upanel.php?id=extramode&modeid=<?php echo $reg[id]; ?>"><?php
	if(isset($TEXT["$reg[name]"])) echo $TEXT["$reg[name]"];
	else echo $reg['name'];
	?></a></li>
<?php } ?>
</ul>
</div>
