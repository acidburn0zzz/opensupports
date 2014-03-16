<div class="descriptiontext">
<br><?php echo $TEXT['How to update'];?><br><br>
</div>
<table class="listing">
	<tr>
		<th class="first"><?php echo $TEXT['Your version'];?></th>
		<td><?php echo $DATA[version];?></td>
	</tr>
	<tr>
		<th class="first"><?php echo $TEXT['Lastest Version'];?></th>
		<td><a href="http://www.opensupports.com/download/" target="_blank"><span style="color:#03C; font-size:12px"><?php echo $DATA['actualversion'];?></span></a> <a href="admin_main.php?mode=settings&submode=update&verifyversion=on" ><img src='img/refresh.png'></a></td>
	</tr>
</table>
<table class="formtable">
	<form action="action.php?id=update" method="post" enctype="multipart/form-data">
	<tr>
		<td class="tdtext" colspan="2"><?php echo $TEXT['Upgrade script'];?></td>
		</tr>
		
		<tr>
			<td class="tdform"><input type="file" class="input-file" name="zip_file" id="zip_file" accept="application/x-zip-compressed"></td>
			<td class="tdform"><input type="submit" class='button' value="<?php echo $TEXT['Submit'];?>"></td>
	</tr>
	</form>
</table>