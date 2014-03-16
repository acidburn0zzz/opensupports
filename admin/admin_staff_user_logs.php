		<table class="listing">
	          <tr>
	            <th class="first" width="126"><?php echo $TEXT['Date'];?></th>
	            <th width="485" class="last"><?php echo $TEXT['Log'];?></th>
              </tr>
	          <?php
			  		$logsq = mysqli_num_rows($api->query("SELECT * FROM STAFFLOG where user='$staff[user]'"));
					if(isset($_GET[page]))$calc = $_GET[page]*20;
					else $calc=0;
					$query = $api->query("SELECT * FROM STAFFLOG where user='$staff[user]' ORDER BY id DESC LIMIT $calc,20");
					while($log = mysqli_fetch_array($query)){
			  ?>
	          <tr>
	            <td class="first"><?php echo $log['date'];?></td>
	            <td class="last"><?php echo $log['log'];?></td>
              </tr>
	          <?php } ?>
        </table>
		<div class="pagenumbers" align="center">
            <?php
			
			for($i=0;$i<($logsq/20);$i++){
				?>
              <a href="admin_main.php?mode=staffuser&submode=stafflogs&id=<?php echo $staff[id]."&page=" . $i; ?>"><?php
                if($_GET[page] == $i) echo "<b>".($i+1)."</b>";
				else echo ($i+1);
				?></a>
				<?php
			}
            ?>
		</div>