		 	<table class="listing">
			    <tr>
                  <th class="first" width="108"><?php echo $TEXT['Title'];?></th>
			      <td width="198"><?php echo $DATA[title];?></td>
			      <th class="first" width="144"><?php echo $TEXT['Version'];?></th>
			      <td width="161"><?php echo $DATA[version];?></td>
		        </tr>
                <tr>
                  <th class="first" width="108"><?php echo $TEXT['Default Theme'];?></th>
			      <td width="198"><?php echo $DATA[theme];?></td>
			      <th class="first" width="144"><?php echo $TEXT['Default Language'];?></th>
			      <td><?php echo $DATA[lang];?></td>
		        </tr>
                <tr>
                  <th class="first" width="108"><?php echo $TEXT['Users system'];?></th>
			      <td><?php echo ($DATA['login'] ? $TEXT['Yes'] : $TEXT['No']);?></td>
			      <th class="first" width="144"><?php echo $TEXT['Users can register'];?></th>
			      <td><?php echo ($DATA['register'] ? $TEXT['Yes'] : $TEXT['No']);?></td>
		        </tr>
	      </table>
	      
<table id='disablesystem'>
	<form action='action.php?id=maintenancemode' method="post">
	<tr>
		<td>
			<?php echo $TEXT['Maintenance mode'];?>
		</td>
		<td>
			<input type='checkbox' name='maintenance' class="input-checkbox2" <?php if($DATA['maintenance']) echo 'checked'; ?>>
		</td>
		<td>
			<input type='submit' class="button" value='<?php echo $TEXT['Submit'];?>'>
		</td>
	</tr>
	</form>
</table>