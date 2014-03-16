<table class="listing" cellpadding="0" cellspacing="0">
			    <tr>
			      <th class="first" width="212"><?php echo $TEXT['Full Name'];?></th>
		         <td align="left"><?php echo $user[name];?></td>
                </tr>
                <tr>
			      <th class="first" width="212"><?php echo $TEXT['Email'];?></th>
		         <td align="left"><?php echo $user[email];?></td>
                </tr>
                <?php
				$query = $api->get_propvalues('user', $user[id]);
				while($reg = mysqli_fetch_array($query)){
                ?>
                <tr>
			      <th class="first" width="212"><?php echo $reg[name];?></th>
		         <td align="left"><?php echo $reg[value];?></td>
                </tr>
                <?php } ?>
	      </table>
				<table class="listing" cellpadding="0" cellspacing="0">
					<tr>
						<th class="first" width="177"><?php echo $TEXT['Title'];?></th>
						<th><?php echo $TEXT['Department'];?></th>
                        <th><?php echo $TEXT['Last Message'];?></th>
					  <th class="last"><?php echo $TEXT['Date'];?></th>
					</tr>
                    <?php
					$query = $api->get_user_tickets($user[id]);
					$logsq = mysqli_num_rows($query);
					if(isset($_GET[page]))$calc = $_GET[page]*20;
					else $calc=0;
                    $query = $api->query("SELECT * FROM TICKETS WHERE userid='$user[id]' ORDER BY isnew DESC, isclosed ASC LIMIT $calc,20");
					while($ticket = mysqli_fetch_array($query)){
                    ?>
					<tr>
						<td><div align="left"><?php if($ticket[isclosed]) echo '<img src="img/closed.png" width="16" height="16">'; ?> <a class="<?php
						if($ticket[staffuser] == "" || $ticket[isnew] == 1) echo "first style1";
						else if(!$ticket[isclosed]) echo "first style2";
						else echo "first style3";
                        ?>" href="index.php?mode=ViewTickets&submode=Ticket%20Viewer&id=<?php echo $ticket[id];?>"><?php echo $ticket['title']; ?></a></div></td>
						<td><?php echo $ticket['Department']; ?></td>
                        <td><?php echo $ticket['last']; ?></td>
						<td class="last"><?php echo $ticket['date']; ?></td>
					</tr>
                    <?php } ?>
				</table>
			<div class="pageselect">
					<span class="pageselect-title"><?php echo $TEXT['Page'];?>: </span>
			  <select class="input-select" id="selectpage" onchange="changepage()">
                    	<?php
							for($i=0;$i<($logsq/20);$i++){
							?>
                            <option <?php if($_GET[page] == $i) echo 'selected="selected"';?> value="<?php echo ($i+1);?>"><?php echo ($i+1);?></option>
                        <?php } ?>						
					</select>
		    </div>