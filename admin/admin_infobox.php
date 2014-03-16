<div class="infobox">
		<?php echo $TEXT['Version'];?>: <?php echo $DATA[version];
		 if($DATA[version] != $DATA['actualversion']) echo '<a href="admin_main.php?mode=settings&submode=update">(UPDATE)</a>';
		?>
        <br />
        <?php if($DATA[version] == $DATA['actualversion']) { ?><span style="color:#0C3">OK.</span> <?php echo $TEXT['No Update'];?> <a href="admin_main.php?mode=settings&submode=update&verifyversion=on"><img src='img/refresh.png'></a>
	    <?php } else {?><span style="color:#F00"><?php echo $TEXT["WARNING."];?> </span><?php echo $TEXT['Please Update'];?>
	    <?php } ?><br />
</div>
