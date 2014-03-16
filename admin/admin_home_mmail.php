<script type="text/javascript" src="../nicedit/nicEdit.js"></script>
<script type="text/javascript">
	bkLib.onDomLoaded(function() { nicEditors.allTextAreas() });
</script>
<form action="action.php?id=mmail" method="post">
		  <table class="formtable" id='mmailform'>
			    <tr>
			     <td class='tdtext'>
			     	<?php echo $TEXT['Send to'];?>
			     </td>
		         <td class="tdform">
                 	<select name="sendto" class="input-select">
                 		<?php if($DATA[login] == 1){ ?><option value="users"><?php echo $TEXT['Users'];?></option><?php } ?>
                 		<option value="staff"><?php echo $TEXT['Staff'];?></option>
                	</select>
                 </td>
                </tr>
                <tr>
			      <td class="tdtext">
			      	<?php echo $TEXT['Title']?>
			      </td>
		         <td class="tdform">
		         	<input name="title" type="text" class="input-text"/>
		         </td>
                </tr>
                <tr>
			      <td class="tdtext">
			      	<?php echo $TEXT['Message']?>
			      </td>
		         <td class='input-textarea'>
		         	<center><textarea name="content" cols="60" rows="10" ></textarea></center>
		         </td>
                </tr>
                <tr>
			      <td colspan="2" class="tdform">
			      	<input type="submit" class="button" value="<?php echo $TEXT['Submit'];?>">
			      </td>
                </tr>
	      </table>
</form>