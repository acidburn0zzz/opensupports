<?php
$prop = $api->get_property('id', $_GET[id]);
?>
<form action="action.php?id=editproperty" method="post">
		  <table class="formtable" id='editpropertyform'>
			    <tr>
			      <td class="tdtext"><?php echo $TEXT['Name']?></td>
		         <td class="tdform"><input class="input-text" name="name" type="text" value="<?php echo $prop[name];?>"/></td>
                </tr>
                <?php if($prop[input] == "checkbox"){
				?>
                <tr>
			      <td class="tdtext"><?php echo $TEXT['Default value'];?></td>
		         <td class="tdform"><input name="value" class="input-checkbox" type="checkbox" <?php if($prop['value'] == 'on') echo "checked";?> /></td>
                </tr>
                <?php } else if($prop[input] == "text"){?>
                <tr>
			     <td class="tdtext"><?php echo $TEXT['Default value'];?></td>
		         <td class="tdform"><input name="value" class="input-text" type="text" value="<?php echo $prop[value];?>"/></td>
                </tr>
                <?php } else if($prop[input] == "select"){?>
                <tr>
			      <td class="tdtext"><?php echo $TEXT['Options'];?></td>
				 <td class="tdform">
                 <a href="javascript:addoption()"><?php echo $TEXT['Add Option'];?></a>
                 <br />
				 <?php
				 $options_array = explode("~", $prop[value]);
				 $i=0;
				 $lenght = count($options_array) - 1;
				 for($i=0; $i<$lenght; ++$i){
				 ?>
                 <input class="input-text" type="text" name="op<?php echo $i; ?>" value="<?php echo $options_array[$i];?>"/><br />
                 <?php } ?>
                 <div id="optionlist">
                 </div>
                 <script>
				 optn = <?php echo ($lenght-1); ?>;
				 </script>
                 </td>
                 <input type="hidden" name="optn" id="optn" value='<?php echo $lenght-1; ?>'>
               
                </tr>
                <?php } ?>
                <tr>
			      <td class="tdtext"><?php echo $TEXT['Is editable'];?></td>
		         <td class="tdform"><input class="input-checkbox" type="checkbox" name="editable" <?php echo ($prop[edit]) ? 'checked' : '';?> /></td>
                </tr>
                <tr>
			      <td class="tdtext"><?php echo $TEXT['Type'];?></td>
		         <td class="tdform">
                 <?php echo $prop[type];?>
                 </td>
                </tr>
                <tr>
		         <td align="tdform">
                 <input type="submit" class="button" value="<?php echo $TEXT['Submit'];?>">
                 </td>
                </tr>
	      </table>
          <input type="hidden" name="propid" value="<?php echo $prop[id];?>">
          </form>
          <br />
          <p align="left">
          <a href="action.php?id=deleteproperty&propid=<?php echo $prop[id];?>" class="subbutton">
          <?php echo $TEXT['Delete Property'];?></a>
          </p>