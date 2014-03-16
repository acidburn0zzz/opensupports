<table class="listing" id="userticketlist">
	          <tr>
	            <th class="first" width="62"><?php echo $TEXT['ID'];?></th>
	            <th width="271" class="last"><?php echo $TEXT['Title'];?></th>
                <th width="160" class="last"><?php echo $TEXT['Date'];?></th>
	            <th width="118" class="last"><?php echo $TEXT['Last Message'];?></th>
              </tr>
	          <?php
			  		$logsq = mysqli_num_rows($api->query("SELECT * FROM TICKETS WHERE staffuser='$staff[user]'"));
					if(isset($_GET[page]))$calc = $_GET[page]*20;
					else $calc=0;
					$query = $api->query("SELECT * FROM TICKETS WHERE staffuser='$staff[user]' ORDER BY id DESC LIMIT $calc,20");
					while($ticket = mysqli_fetch_array($query)){
			  ?>
	          <tr>
	            <td class="fisrt">
                <?php echo "#". $ticket[id];?>
                </td>
	            <td><img class="<?php
				if($ticket[isclosed] == 1) echo 'closeticket-icon';
				else echo 'openticket-icon';
				?>"><a href="admin_main.php?mode=staffuser&submode=staffviewticket&id=<?php echo $staff[id]?>&ticket=<?php echo $ticket[id]?>"><?php echo $ticket['title'];?></a></td>
                <td class="last">
                <?php echo $ticket['date'];?>
                </td>
                <td class="last">
                <?php echo $ticket['last'];?>
                </td>
              </tr>
	          <?php } ?>
            </table>
            <div class="pagenumbers">
            <?php
			for($i=0;$i<($logsq/20);$i++){
				?>
              <a href="admi_main.php?mode=staffuser&submode=staffticket&id=<?php echo $staff[id]."&page=" . $i; ?>"><?php
                if($_GET[page] == $i) echo "<b>".($i+1)."</b>";
				else echo ($i+1);
				?></a>
				<?
			}
            ?>
			</div>