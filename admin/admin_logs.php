<img src="img/bg-th-left.gif" width="8" height="7" alt="" class="left" />
<table class="listing" id="table-logs">
					<tr>
						<th class="first"><?php echo $TEST['Date'];?></th>
						<th class="last"><?php echo $TEST['Log'];?></th>
					</tr>
                	<?php
                    $query = $api->query("SELECT * FROM LOGS ORDER BY id DESC LIMIT 50");
					while($log = mysqli_fetch_array($query)){
					?>
					<tr>
						<td class="first"><?php echo $log['date'];?></td>
						<td><?php echo $log['data'];?></td>
					</tr>
                    <?php } ?>
</table>