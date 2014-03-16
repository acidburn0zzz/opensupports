<form action="action.php?id=newproperty" method="post">
		  <table class="formtable" id="newpropertyform">
          		<tr>
			     <td class="tdtext"><?php echo $TEXT['Input type']?></td>
		         <td class="tdform">
                 <select class="input-select" name="inputtype" id="inputtype" onchange="javascript:changeinputtype()">
                 <option value="text" <?php if($_GET[inputtype] == "" || $_GET[inputtype] == "text") echo 'selected="selected"';?>><?php echo $TEXT['Text']; ?></option>
                 <option value="checkbox" <?php if($_GET[inputtype] == "checkbox") echo 'selected="selected"';?>><?php echo $TEXT['Checkbox']; ?></option>
                 <option value="select" <?php if($_GET[inputtype] == "select") echo 'selected="selected"';?>><?php echo $TEXT['Select']; ?></option>
                 </select></td>
                </tr>
                <tr>
			     <td class="tdtext"><?php echo $TEXT['Type']?></td>
		         <td class="tdform"><select class="input-select" name="type">
                 <option value="user"><?php echo $TEXT['Users']; ?></option>
                 <option value="staff"><?php echo $TEXT['Staff']; ?></option>
                 <option value="tickets"><?php echo $TEXT['Tickets']; ?></option>
                 </select></td>
                </tr>
			    <tr>
			      <td class="tdtext"><?php echo $TEXT['Name']?></td>
		         <td class="tdform"><input class="input-text" name="name" type="text" /></td>
                </tr>
                <?php
				if($_GET[inputtype] == "checkbox"){
                ?>
                <tr>
			      <td class="tdtext"><?php echo $TEXT['Default value'];?></td>
		          <td class="tdform"><input class='input-text' name="value" type="checkbox" /></td>
                </tr>
                <?php } else if($_GET[inputtype] == "select"){?>
                <tr>
			     <td class="tdtext"><?php echo $TEXT['Options'];?></td>
		         <td class="tdform">
                 <a href="javascript:addoption()"><?php echo $TEXT['Add Option'];?></a>
                 <div id="optionlist">
                 <input type="text" name="op1" class="input-text"/><br />
                 </div>
                 </td>
                 <input type="hidden" name="optn" id="optn" value='1'>
                </tr>
                <?php } else {?>
                <tr>
			      <th class="first" width="212"><?php echo $TEXT['Default value'];?></th>
		         <td align="left"><input name="value" type="text" /></td>
                </tr>
                <?php } ?>
                <tr>
			      <td class="tdtext"><?php echo $TEXT['Is editable'];?></td>
		         <td class="tdform"><input class="input-checkbox" name="editable" type="checkbox" checked /></td>
                </tr>
                <tr>
			      <td colspan="2" ><input type="submit" class="button" value="<?php echo $TEXT['Submit'];?>"></td>
                </tr>
	      </table>
</form>