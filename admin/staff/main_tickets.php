<?php
$string = ", ".$STAFF[departments].",";

$query = sprintf("SELECT * FROM DEPARTMENTS WHERE name='%s'",$api->sql_escape($_GET[submode]));
$dep = mysqli_fetch_array($api->query($query));
$pos = strpos($string,", ".$dep[name].",");
if($pos === false) header('Location: index.php');
?>
<table class="listing">
					<tr>
						<th class="first"><?php echo $TEXT['Title'];?></th>
						<th><?php echo $TEXT['Last Message'];?></th>
						<th><?php echo $TEXT['Written By'];?></th>
					    <th class="last"><?php echo $TEXT['Date'];?></th>
					</tr>
                    <?php
					/*Create query with langs filter*/
					$query = "SELECT * FROM TICKETS WHERE department='$dep[name]' AND (staffuser='$STAFF[user]' OR staffuser='')";
					$lang_list = explode(",", $STAFF[langs]);
					$max = count($lang_list)-1;
					$query .= " AND (";
					for($i=0;$i<$max;$i++){
						$query .= "lang='".$lang_list[$i]."' OR ";
					}
					$query .= "lang='$lang_list[$max]')";
					$logsq = mysqli_num_rows($api->query($query));
					/*Create pagination*/
					if(isset($_GET[page]))$calc = $_GET[page]*20;
					else $calc=0;
					$query .= " ORDER BY isnew DESC, isclosed ASC LIMIT $calc,20";
					$query2 = $api->query($query);
					
					/*Select all properties that are filters*/
					$query3 = $api->query("SELECT * FROM PROPERTIES WHERE filter='1'");		
					/*Show tickets with lang options + pagination*/	
					while($ticket = mysqli_fetch_array($query2)){
					$condition = true; /*First, assume that the staff can see the ticket*/
					while($prop = mysqli_fetch_array($query3)){
						/*Select the filter of each property for the staff*/
						$query4 = $api->query("SELECT * FROM EXTRA WHERE type='filter' AND name='$prop[name]' AND toid='$STAFF[id]'");
						$filter = mysqli_fetch_array($query4);
						//Select the property of the user or ticket
						if($prop[type] == "user"){
							$query4 = $api->query("SELECT * FROM EXTRA WHERE type='property' AND name='$prop[name]' AND toid='$ticket[userid]'");
						}else if($prop[type] == "tickets"){
							$query4 = $api->query("SELECT * FROM EXTRA WHERE type='propertyticket' AND name='$prop[name]' AND toid='$ticket[id]'");
						}
						$tprop = mysqli_fetch_array($query4);
						if($prop[input] == "checkbox"){
							if($filter[value] == '1' && $tprop[value] == ''){
								$condition = false;
							}
							else if($filter[value] == '0' && $tprop[value] == 'on'){
								$condition = false;
							}
						}
						else if($prop[input] == "select"){
							$value = "~".$filter[value];
							$pos = strpos($value, "~".$tprop[value]."~");
							if($pos === false){
								$condition = false;
							}
						}
					}
					if(!$condition){
						$logsq--;
						continue;
					}
                    ?>
					<tr>
						<td><div align="left"><?php if($ticket[isclosed]) echo '<img src="img/closed.png" width="16" height="16">'; ?> <a class="<?php
						if($ticket[staffuser] == "" || $ticket[isnew] == 1) echo "ticketstyle1";
						else if(!$ticket[isclosed]) echo "ticketstyle2";
						else echo "ticketstyle3";
                        ?>" href="index.php?mode=ViewTickets&submode=Ticket%20Viewer&id=<?php echo $ticket[id];?>"><?php echo $ticket['title']; ?></a></div></td>
						<td><?php echo $ticket['last']; ?></td>
						<td><?php
						if(!$DATA[login]){
					 		echo $ticket['userid'];
						}
						else{
							$q = $api->get_user_by_id($ticket[userid]);
							echo $q[name];
						}
                        ?></td>
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