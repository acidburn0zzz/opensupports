<script type="text/javascript" src="nicedit/nicEdit.js"></script>
<script type="text/javascript">
	bkLib.onDomLoaded(function() { nicEditors.allTextAreas() });
</script>
<div class="panelbox">
		<div class="title"><?php echo $TEXT['Ticket Viewer']; ?></div>
		<table class="infotable">
			<tr>
				<td class="infotable1">
					<div class="ntext"><?php echo $TEXT['Title']; ?></div>
				</td>
				<td class="infotable2"><?php echo $ticket[title]; ?></td>
				<td class="infotable1">
					<div class="ntext"><?php echo $TEXT['Date']; ?></div>
				</td>
				<td class="infotable2"><?php echo $ticket[date]; ?></td>
			</tr>
			<tr>
				<td class="infotable1">
					<div class="ntext"><?php echo $TEXT['Author']; ?></div>
				</td>
				<td class="infotable2"><?php echo $_SESSION[NAME]; ?></td>
				<td class="infotable1">
					<div class="ntext"><?php echo $TEXT['Department']; ?></div>
				</td>
				<td class="infotable2"><?php echo $ticket[department]; ?> (<?php echo $ticket[lang];?>)</td>
			</tr>
            <?php
			$query = $api->get_propvalues("ticket", $ticket[id]);
			$count = 1;
			while($ticket2 = mysqli_fetch_array($query)){
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
					<div class="ntext"><?php echo $ticket2[name]; ?></div>
				</td>
				<td class="infotable2"><?php echo $ticket2[value]; ?></td>
				<?php
			}
			if($count != 1) echo "</tr>";
            ?>
		</table>
		<div class="ticketbox">
			<div class="ticketbox-title">
				<?php echo $ticket[title]; ?>
			</div>
			<div class="ticketbox-user">
				<?php echo $_SESSION[NAME]; ?>				
			</div>
			<div class="ticketbox-date"><img class="dateicon">
			<?php echo $ticket[date]; ?>			
			</div>
			<div class="ticketbox-content">
			<?php echo $ticket[content];?>
			</div>
		</div>
		<div class="commentstitle"><?php echo $TEXT['Responses'] ?></div>
		<?php
		$query2 = $api->get_comments($ticket[id]);
		while($ticket2 = mysqli_fetch_array($query2)){
		?>
		<div class="commentbox">
			<div class="comment-name-<?php if($ticket2[isstaff]) echo 'staff'; else echo 'user'?>">
				<?php echo $ticket2[username];?>
			</div>
			<div class="commentbox-date"><img class="dateicon">
				<?php echo $ticket2[date]; ?>
			</div>
			<div class="commentbox-content">
			<?php echo $ticket2[content];?>
			</div>
		</div>
		<?php } ?>
		<?php
		if($ticket[isclosed] == 0){
		?>
		<div class="title"><?php echo $TEXT['Respond'] ?></div>
		<div class="responsebox">
			<form action="action.php?id=response&ticketid=<?php echo $ticket[id];?>" method="POST">
			<div class="response-area">
			<textarea class="textarearesponse" rows="6" cols="70" id="textresponse" name="textresponse"></textarea>
			<input type="submit" class="button" value="Submit">			
			</div>
			</form>
		</div>
		<?php } ?>
</div>