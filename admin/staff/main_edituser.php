				<table class="formtable">
					<tr>
                     	<form action="action.php?id=username" method="post">
						<td class='formtext'>
                        <?php echo $TEXT['Name'];?>
                        </td>
                        <td>
                        <input class="input-text" type="text" name="name" value="<?php echo $user[name]; ?>">
                        <input type="hidden" name="userid" value="<?php echo $user[id]?>">
                        </td>
                        <td>
                        <input class="button" type="submit" value="<?php echo $TEXT['Submit'];?>">
                        </td>
                        </form>
					</tr>
                    <tr>
                     	<form action="action.php?id=useremail" method="post">
						<td class="formtext">
                        <?php echo $TEXT['Email'];?>
                        </td>
                        <td>
                        <input class="input-text" type="text" name="email" value="<?php echo $user[email]; ?>">
                        <input type="hidden" name="userid" value="<?php echo $user[id]?>">
                        </td>
                        <td>
                        <input class="button" type="submit" value="<?php echo $TEXT['Submit'];?>">
                        </td>
                        </form>
					</tr>
                <?php				
				$query = $api->get_propvalues('user', $_GET[id]);
				while($reg = mysqli_fetch_array($query)){
					$reg2 = $api->get_property('name', $reg[name]);
                ?>
                <tr>
					    <td colspan="2" class="formtext"><?php echo $reg[name];?></td>
                        <td style="background-color:#FFF" colspan="2">
						<form action="action.php?id=userprop&userid=<?php echo $user[id];?>&pname=<?php echo $reg[name];?>" method="post">
                        <?php
						if($reg2[input] == "text"){
                        ?>
                        <input class="input-text" type="text" name='pvalue' value='<?php echo $reg[value];?>' />
                        <?php } elseif($reg2[input] == "checkbox") { ?>
                        <input class="input-checkbox" type="checkbox" id="<?php echo $reg[name]; ?>" name="pvalue" <?php echo ($reg[value] == "on") ? "checked='checked'" : ""; ?>  />
                        <?php } elseif($reg2[input] == "select") { ?>
                        <select class="input-select" id="<?php echo $reg[name];?>" name="pvalue">
						<?php
						$array = explode("~", $reg2[value]);
						$lenght = count($array) - 1;
						for($i=0; $i<$lenght; ++$i){
						?>
						<option value="<?php echo $array[$i]; ?>" <?php if($reg[value] == $array[$i]) echo "selected='selected'";?>><?php echo $array[$i]; ?></option>
						<?php } ?>
						</select>
						<?php } ?>
                        </td>
                        <td>
                        <input class="button" type="submit" value="<?php echo $TEXT['Submit'];?>">
                        </td>
				</tr>
                </form>
                <?php
				}
				?>
				</table>