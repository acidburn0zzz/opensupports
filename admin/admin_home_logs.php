<table class="listing" id='table-logs'>
				<tr>
						<th class="first">Date</th>
						<th class="last">Log</th>
				</tr>
                	<?php
                    $query = $api->query("SELECT * FROM LOGS ORDER BY id DESC LIMIT 20");
					while($log = mysqli_fetch_array($query)){
					?>
					<tr>
						<td class="first"><?php echo $log['date'];?></td>
						<td class="last"><?php echo $log['data'];?></td>
					</tr>
                    <?php } ?>
</table>