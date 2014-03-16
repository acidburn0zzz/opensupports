<?php
if(isset($_GET[deleteid])){
?>
<div class='sure'>
		  <div class="suretext"><?php echo $TEXT['Are you sure'];?></div>
	      <a href="action.php?id=deleteplugin&plugin=<?php echo filter_input(INPUT_GET, 'deleteid', FILTER_SANITIZE_ENCODED); ?>" class="surebutton"><?php echo $TEXT['Delete'];?></a>
</div>
<?php
}
?>
<table class="listing" id='pluginlist'>
			    <tr>
			      <th class="first"><?php echo $TEXT['Name'];?></th>
			      <th><?php echo $TEXT['Author'];?></th>
                  <th><?php echo $TEXT['Version'];?></th>
                  <th class="last"><?php echo $TEXT['Delete'];?></th>
		        </tr>
                <?php
				$query = $api->plugin_list();
				while($reg = mysqli_fetch_array($query)){
                ?>
			    <tr>
			      <td class="first"><?php echo $reg[name];?></td>
				  <td><?php echo $reg[author];?></td>
				  <td><?php echo $reg[version];?></td>
				  <td><a href="admin_main.php?mode=plugins&submode=listplugins&deleteid=<?php echo $reg[name];?>"><img src="img/hr.gif" width="16" height="16" alt="" /></a></td>
		        </tr>
                <?php } ?>
</table>