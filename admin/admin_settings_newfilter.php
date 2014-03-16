<?php
$id = (int) $_GET[id];
$prop = $api->get_property('id', $id);
?>
<form action="action.php?id=newfilter&filterid=<?php echo $id;?>" method="post">
	<table class="formtable" id='newfilterform'>
		<tr>
			<td class="tdtext">
				<?php echo $TEXT['Property']; ?>
			</td>
			<td class="tdform">
				<?php echo $prop[name]; ?>
			</td>
		</tr>
		<tr>
			<td class="tdtext">
				<?php echo $TEXT['Default value']; ?>
			</td>
			<td class="tdform">	
				<?php
					if($prop[input] == "checkbox"){
				?>
				<select class="input-select" name="def">
					<option value="1"><?php echo $TEXT['Yes'];?></option>
					<option value="0"><?php echo $TEXT['No'];?></option>
					<option value="both"><?php echo $TEXT['Both'];?></option>
				</select>
				<?php
				}elseif($prop[input] == "select"){
					$options_array = explode("~", $prop[value]);
					$i=0;
					$lenght = count($options_array) - 1;
					for($i=0; $i<$lenght; ++$i){
				?>
				<input type="checkbox" class="input-checkbox" name="op<?php echo $i; ?>" checked/> <?php echo $options_array[$i];?> <br />
				<?php 
				}
				} ?>
				<input type="hidden" name="max" value="<?php echo $lenght; ?>">
			</td>
		</tr>
		<tr>
			<td class="tdform" >
				<input class="input-checkbox" type="checkbox" name="editable" checked/> <?php echo $TEXT['Is editable']; ?>
			</td>
			<td>
				<input class="button" type="submit" value="<?php echo $TEXT['Submit'];?>">
			</td>
		</tr>
	</table>
</form>