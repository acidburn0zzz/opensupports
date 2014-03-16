<?php
/*Ticket has been already saw*/
if($ticket['staffuser'] == $STAFF[user] && $ticket[isnew] == 1)
	$api->view_ticket($ticket[id]);
?>
<script type="text/javascript" src="../../nicedit/nicEdit.js"></script>
<script type="text/javascript">
	bkLib.onDomLoaded(function() { nicEditors.allTextAreas() });
</script>
  <table class="tableticket">
	  <tr>
						<td class='textname'><?php echo $TEXT['Title'];?></td>
            			<td class='textinput'><?php echo $ticket[title];?></td>
						<td class='textname'><?php echo $TEXT['Department'];?></td>
                        <td class='textinput'>
                        <select class="input-select" id="depselect" name="dep" onchange="changedep();">
                        <?php
						$query = $api->get_departments();
						while($reg = mysqli_fetch_array($query)){
                        ?>
                        <option value="<?php echo $reg[name];?>" <?php if($reg[name] == $ticket[department]) echo "selected='selected'"; ?>><?php echo $reg[name];?></option>
                        <?php } ?>
                        </select>
                        </td>
						
	</tr>
					<tr>
                    	<td class='textname'><?php echo $TEXT['Written By'];?></td>
         				<td class='textinput'><?php
						if(!$DATA[login]){
					 		echo $ticket['userid'];
						}
						else{
							$q = $api->get_user_by_id($ticket[userid]);
							echo $q[name];
						}
                        ?>
                        </td>
					    <td class='textname'><?php echo $TEXT['Date'];?></td>
                        <td class='textinput'><?php echo $ticket['date'];?></td>
					</tr>
               <?php
               
				$query = $api->get_propvalues('ticket', $ticket[id]);
				$count = 1;
				while($reg = mysqli_fetch_array($query)){
					$reg2 = $api->get_property('name', $reg[name]);
					if($count == 3){
						echo "</tr>";
						$count = 1;
					}
					if($count == 1){
						echo "<tr>";
					}
					++$count;
                ?>
					    <td class='textname'><?php echo $reg[name];?></td>
                        <td  class='textinput'>
                        <?php
						if($reg2[input] == "text"){
                        ?><form action="action.php?id=ticketprop&ticketid=<?php echo $ticket[id];?>&name=<?php echo $reg[name];?>" method="post">
                        <input class="input-text" type="text" name='pvalue' value='<?php echo $reg[value];?>' />
                        </form>
                        <?php } elseif($reg2[input] == "checkbox") { ?>
                        <input class="input-checkbox" type="checkbox" id="<?php echo $reg[name]; ?>" onchange="modifyprop2('<?php echo $reg[name]; ?>');" <?php echo ($reg[value] == "on") ? "checked='checked'" : ""; ?>  />
                        <?php } elseif($reg2[input] == "select") { ?>
                        <select class="input-select" onchange="modifyprop('<?php echo $reg[name]; ?>');" id="<?php echo $reg[name];?>" name="provalue-<?php echo $reg[name];?>">
						<?php
						$array = explode("~", $reg2[value]);
						$lenght = count($array) - 1;
						for($i=0; $i<$lenght; ++$i){
						?>
						<option value="<?php echo $array[$i]; ?>" <?php if($reg[value] == $array[$i]) echo "selected='selected'";?>><?php echo $array[$i]; ?></option>
						<?php } ?>
						</select>
						<?php } ?>
                        </td>
                <?php
				}
				if($count != 1) echo "</tr>";
				?>
  </table>
  <div class='ticketcontent'>
  <?php echo $ticket[content];?>
  </div>
  <div class="normalbar"><?php echo $TEXT['Responses'];?></div>
    <table class="commentlist">
  	<?php
  	
	$query = $api->get_comments($ticket[id]);
	while($comment = mysqli_fetch_array($query)){
    ?>
      <tr>
        <td height="50%"><?php
		if($comment[isstaff])
       		echo "<span class='username'". $comment[username]. '</span>';
		else
			echo $comment[username] . ' (' . $comment[userid]. ')';
		?></td>
        <td><?php echo $comment['date'];?></td>
      </tr>
      <tr>
        <td colspan="2" style="background-color:#FFF"><?php echo $comment[content]; ?></td>
      </tr>
    <?php } ?>
    </table>
    <?php
	/*Verify if the ticket doesn belong to anyone*/
	if($ticket[staffuser] == "" && $_GET[response] != "yes"){
	?>
    <br>
	<a href="index.php?mode=ViewTickets&submode=Ticket%20Viewer&id=<?php echo $ticket[id];?>&response=yes"><?php echo $TEXT['I will answer this ticket'];?></a>
	<?php
    }
	else if(!$ticket[isclosed]){
	 if($ticket[staffuser] == "") {
	 	$api->own_ticket($ticket[id], $STAFF[id]);
		$STAFF[tickets]++;
	 }
	?>
	
	<div id="customresponses-div"><select class="input-select" id='customresponses' onchange="changecontent();">
	<option value='0'><?php echo $TEXT['Dont use Template'];?></option>
	<?php
	$result = $api->query("SELECT * FROM TEXT WHERE type='response' AND lang='$ticket[lang]'");
	$cont = '';
	while($response = mysqli_fetch_array($result)){
		if($_GET[text] == $response[id]) $cont = $response['value'];
	?>
	<option value="<?php echo $response[id]; ?>" <?php if($_GET[text] == $response[id]) echo 'selected';?> ><?php echo $response[name];?></option>
	<?php
	}
	?>
	</select>
	</div>
    <form action="action.php?id=respondticket" method="post">
    <textarea name="content" cols="60" rows="10" class="input-textarea">
    	<?php
    	echo $cont;
    	?>
    </textarea>
    <input type="hidden" name="ticketid" value="<?php echo $ticket[id];?>">
    <input type="submit" value="<?php echo $TEXT['Submit']; ?>">
    </form>
    <div id="subbuttons">
    <a href="action.php?id=derivate&ticketid=<?php echo $ticket[id];?>"><?php echo $TEXT['Derivate this ticket'];?></a><br>
    <a href="action.php?id=closeticket&ticketid=<?php echo $ticket[id];?>"><?php echo $TEXT['Close this ticket'];?></a>
    </div>
	<?php } ?>