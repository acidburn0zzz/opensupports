		  <table class="listing">
			    <tr>
			      <th class="first" width="212"><?php echo $TEXT['Username'];?></th>
			      <th width="78"><?php echo $TEXT['Tickets'];?></th>
			      <th width="127"><?php echo $TEXT['Departments'];?></th>
                  <th width="62"><?php echo $TEXT['View'];?></th>
			      <th width="64"><?php echo $TEXT['Edit'];?></th>
			      <th width="68"><?php echo $TEXT['Delete'];?></th>
		        </tr>
                <?php
				if($_GET[id] == "all") $query = $api->query("SELECT * FROM STAFF ORDER BY tickets DESC LIMIT 30");
				else $query = $api->query("SELECT * FROM STAFF ORDER BY tickets DESC");
				while($reg = mysqli_fetch_array($query)){
                ?>
			    <tr>
			      <td class="first"><a href="admin_main.php?mode=staffuser&submode=staffdetails&id=<?php echo $reg[id];?>"><?php echo $reg['name'] . "</a> (". $reg['user']. ")";?></td>
				  <td><?php echo $reg[tickets];?></td>
				  <td><?php echo $reg[departments]?></td>
			      <td><a href="admin_main.php?mode=staffuser&submode=staffdetails&id=<?php echo $reg[id];?>"><img src="img/login-icon.gif" width="16" height="16" alt="" /></a></td>
			      <td><a href="admin_main.php?mode=staffuser&submode=staffedit&id=<?php echo $reg[id];?>"><img src="img/edit-icon.gif" width="16" height="16" alt="" /></a></td>
			      <td><a href="admin_main.php?mode=staffuser&submode=staffsure&id=<?php echo $reg[id];?>"><img src="img/hr.gif" width="16" height="16" alt="" /></a></td>
		        </tr>
                <?php } ?>
	      </table>