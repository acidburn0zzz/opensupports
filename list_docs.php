<div class="panelbox">
	<div class="title"><?php echo $TEXT['Docs and Guides']; ?></div>
	<div class="desciption"><?php echo $TEXT['Docs and Guides description']; ?></div>
	<table class="ticketlist">
		<tr class="toptr">
			<td class="toptd"><?php echo $TEXT['Title'];?></td>
			<td class="toptd"><?php echo $TEXT['Date'];?></td>
			<td class="toptd"><?php echo $TEXT['Written By'];?></td>			
		</tr>
		<?php
		$query = $api->get_docs();
		while($reg = mysqli_fetch_array($query)){
		?>
		<tr class="trlist">
			<td class="tdlist"><div class="ntext"><a href="indexs.php?mode=view_doc&doc=<?php echo $reg[id]; ?>"><?php echo $reg[title]; ?></div></td>
			<td class="tdlist"><?php echo $reg[date];?></td>
			<td class="tdlist"><?php echo $reg[by];?></td>
		</tr>
		<?php } ?>
	</table>
</div>
