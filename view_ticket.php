<?php
$reg = $api->get_ticket($_GET[ticketid]);
?>
<script type="text/javascript" src="nicedit/nicEdit.js"></script>
<script type="text/javascript">
	bkLib.onDomLoaded(function() { nicEditors.allTextAreas() });
</script>
<div class="panelbox2">
		<div class="title"><?php echo $TEXT['Ticket Viewer']; ?></div>
		<table class="infotable">
			<tr>
				<td class="infotable1">
					<div class="ntext"><?php echo $TEXT['Title']; ?></div>
				</td>
				<td class="infotable2"><?php echo $reg[title]; ?></td>
				<td class="infotable1">
					<div class="ntext"><?php echo $TEXT['Date']; ?></div>
				</td>
				<td class="infotable2"><?php echo $reg[date]; ?></td>
			</tr>
			<tr>
				<td class="infotable1">
					<div class="ntext"><?php echo $TEXT['Author']; ?></div>
				</td>
				<td class="infotable2"><?php echo $reg[userid]; ?></td>
				<td class="infotable1">
					<div class="ntext"><?php echo $TEXT['Department']; ?></div>
				</td>
				<td class="infotable2"><?php echo $reg[department]; ?> (<?php echo $reg[lang];?>)</td>
			</tr>
            <?php
			$query = $api->get_propvalues("ticket", $reg[id]);
			$count = 1;
			while($reg2 = mysqli_fetch_array($query)){
				if($count == 3){
					echo "</tr>";
					$count = 1;
				}
				if($count == 1){
					echo "<tr>";
				}
				++$count;
				?>
                <td class="infotable1">
					<div class="ntext"><?php echo $reg2[name]; ?></div>
				</td>
				<td class="infotable2"><?php echo $reg2[value]; ?></td>
				<?php
			}
			if($count != 1) echo "</tr>";
            ?>
		</table>
		<div class="ticketbox">
			<div class="ticketbox-title">
				<?php echo $reg[title]; ?>
			</div>
			<div class="ticketbox-user">
				<?php echo $reg[userid]; ?>				
			</div>
			<div class="ticketbox-date"><img class="dateicon">
			<?php echo $reg[date]; ?>			
			</div>
			<div class="ticketbox-content">
			<?php echo $reg[content];?>
			</div>
		</div>
		<div class="commentstitle"><?php echo $TEXT['Responses'] ?></div>
		<?php
		$query2 = $api->get_comments($reg[id]);
		while($reg2 = mysqli_fetch_array($query2)){
		?>
		<div class="commentbox">
			<div class="comment-name-<?php if($reg2[isstaff] == 1) echo 'staff'; else echo 'user'?>">
				<?php echo $reg2[username];?>
			</div>
			<div class="commentbox-date"><img class="dateicon">
				<?php echo $reg2[date]; ?>
			</div>
			<div class="commentbox-content">
			<?php echo $reg2[content];?>
			</div>
		</div>
		<?php } ?>
		<?php
		if($reg[isclosed] == 0){
		?>
		<div class="title"><?php echo $TEXT['Respond'] ?></div>
		<div class="responsebox">
			<form action="action.php?id=response&ticketid=<?php echo $_GET[ticketid];?>" method="POST">
			<input type="hidden" name="userid" value="<?php echo $reg[userid]; ?>">
			<input type="hidden" name="email" value="<?php echo $reg[email]; ?>">
			<div class="response-area">
			<textarea class="textarearesponse" rows="6" cols="70" id="textresponse" name="textresponse"></textarea>
			</div>
        <input type="submit" class="button" value="Submit">	
			</form>
		</div>
		<?php } ?>
</div>
