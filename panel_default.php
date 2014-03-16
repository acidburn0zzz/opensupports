<div class="panelbox">
	<div class="title"><?php echo $TEXT['Submitted Tickets']; ?></div>
	<div class="description"><?php echo $TEXT['Submitted Tickets description']; ?></div>
	<table class="ticketlist">
		<tr class="toptr">
			<td class="toptd"><?php echo $TEXT['Date'];?></td>
			<td class="toptd"><?php echo $TEXT['Last Message'];?></td>
			<td class="toptd"><?php echo $TEXT['Department'];?></td>
		</tr>
		<?php
		$query = $api->get_user_tickets($_SESSION[ID]);
		while($reg = mysqli_fetch_array($query)){
		?>
		<tr class="trlist">
			<td class="tdlist" colspan="3">
				<div class="<?php
				if($reg[isclosed] == 1) echo 'closet';
				else echo 'opent';
				?>"><a href="upanel.php?id=ticket&ticket=<?php echo $reg[id]; ?>"><?php echo $reg[title]; ?></div>
			</td>
		</tr>
		<tr class="trlist">
			<td class="tdlist"><?php echo $reg[date];?></td>
			<td class="tdlist"><?php echo $reg[last];?></td>
			<td class="tdlist"><?php echo $reg[department];?></td>
		</tr>
		<?php } ?>
	</table>
</div>