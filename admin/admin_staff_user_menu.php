<div class="menumode">
		  <div class="menumode-title"><?php echo $TEXT['Staff'] . ": " . $staff[name];?></div>
		  <ul class="menumode-nav">
          		<a href="admin_main.php?mode=staffuser&submode=staffdetails&id=<?php echo $staff[id];?>"><li><?php echo $TEXT['Staff Details'];?></li></a>
				<a href="admin_main.php?mode=staffuser&submode=stafflogs&id=<?php echo $staff[id];?>"><li><?php echo $TEXT['Staff Logs'];?></li></a>
				<a href="admin_main.php?mode=staffuser&submode=staffticket&id=<?php echo $staff[id];?>"><li><?php echo $TEXT['Tickets'];?></li></a>
                <a href="admin_main.php?mode=staffuser&submode=staffedit&id=<?php echo $staff[id];?>"><li><?php echo $TEXT['Edit and Delete'];?></li></a>
			</ul>
</div>