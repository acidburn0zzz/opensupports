<form action="action.php?id=newstaff" method="post">
		  <table class="formtable" id="fromstaff">
			    <tr>
			      <td class="tdtext"><?php echo $TEXT['Full Name'];?></td>
		         <td class="tdform"><input class="input-text" name="name" type="text" /></td>
                </tr>
                <tr>
			      <td class="tdtext"><?php echo $TEXT['Email'];?></td>
		         <td class="tdform"><input name="email" type="text" class="input-email" /></td>
                </tr>
                <tr>
			      <td class="tdtext"><?php echo $TEXT['Departments'];?></td>
		         <td class="tdform">
                 <?php
                 $query = $api->get_departments();
				 while($dep = mysqli_fetch_array($query)){
                 ?>
                 <input class="input-checkbox" name="d<?php echo $dep[id];?>" type="checkbox" /><?php echo $dep[name];?><br>
                 <?php } ?>
                 </td>
                </tr>
                <tr>
			     <td class="tdtext" width="212"><?php echo $TEXT['Languages'];?></td>
		         <td class="tdform">
                 <?php
                 $query = $api->get_langs(true);
				 while($dep = mysqli_fetch_array($query)){
                 ?>
                 <input class="input-checkbox" name="<?php echo $dep[short];?>" type="checkbox" /><?php echo $dep[name];?><br>
                 <?php } ?>
                 </td>
                </tr>
                <tr>
			      <td class="tdtext"><?php echo $TEXT['Can Manage Users'];?></td>
		         <td class="tdform">
                 <input name="manage-users" type="checkbox" class="input-checkbox2" />
                 </td>
                </tr>
                 <tr>
			      <th class="tdtext"><?php echo $TEXT['Can Create Docs'];?></td>
		         <td class='tdform'>
                 <input class="input-checkbox2" name="manage-docs" type="checkbox" />
                 </td>
                </tr>
                <tr>
			      <td colspan="2" class='trtitle'><?php echo $TEXT['Properties'];?></td>
                </tr>
                <?php
				$query = $api->get_properties('staff');
				while($prop = mysqli_fetch_array($query)){
                ?>
                <tr>
                	<td class="tdtext">
                    <?php echo $prop[name];?>
                	</td>
                	<td class='tdform'>
                    <?php
					if($prop[input] == "text"){
						?>
                        <input class="input-text" type="text" name="provalue-<?php echo $prop[name];?>" value="<?php echo $prop[value];?>">
						<?php
					} else if($prop[input] == "checkbox"){
                    ?>
                    <input class="input-checkbox2" type="checkbox" name="provalue-<?php echo $prop[name];?>" <?php if($prop[value] == "on") echo "checked";?>>
					<?php
                    } else if($prop[input] == "select"){
					?>
                    <select class="input-select" name="provalue-<?php echo $prop[name]; ?>">
						<?php
						$array = explode("~", $prop[value]);
						$lenght = count($array) - 1;
						for($i=0; $i<$lenght; ++$i){
						?>
						<option value="<?php echo $array[$i]; ?>"><?php echo $array[$i]; ?></option>
						<?php } ?>
					</select>
                    <?php } ?>
                	</td>
                </tr>
                <?php
				}
				?>
				<tr>
			      <td colspan="2" class="trtitle"><?php echo $TEXT['Filters'];?></td>
                </tr>
				<?php
				$query=$api->query("SELECT * FROM PROPERTIES WHERE filter='1'");
				while($filter = mysqli_fetch_array($query)){
				$default = mysqli_fetch_array($api->get_extra('defaultfilter', 'name', $filter[name]));
				?>
                <tr>
                <td class="tdtext">
                <?php echo $filter[name]; ?>
                </td>
                <td class="tdform">
                <?php
				if($filter[input] == 'checkbox'){	
                ?>
                <form action="action.php?id=editfilter&name=<?php echo $prop[name];?>" method="post">
				<select class="input-select" name="filter-<?php echo $filter[id];?>">
				<option value="1" <?php if($default[value] == '1') echo "selected='selected'";?>><?php echo $TEXT['Yes'];?></option>
				<option value="0" <?php if($default[value] == '0') echo "selected='selected'";?>><?php echo $TEXT['No'];?></option>
				<option value="both" <?php if($default[value] == 'both') echo "selected='selected'";?>><?php echo $TEXT['Both'];?></option>
				</select>
                <?php } else if($filter[input] == 'select'){
					
	    		$options_array = explode("~", $filter[value]);
	    		$i=0;
	    		$lenght = count($options_array) - 1;
				$values = "~".$default[value];
	   			for($i=0; $i<$lenght; ++$i){
				$find = "~".$options_array[$i]."~";
				$pos = strpos($values, $find);
			    ?>
				<input class="input-checkbox" type="checkbox" name="<?php echo "filter-$filter[id]-op$i"; ?>" <?php if($pos !== false) echo "checked"; ?>/> <?php echo $options_array[$i];?>
       			<?php 
        		}
	   			?>
				<?php } ?>
                </td>
                </tr>
                <?php } ?>
                <tr>
			      <td class="tdform" colspan="2"><input type="submit" class="button" value="<?php echo $TEXT['Submit'];?>"></td>
                </tr>
	      </table>
          </form>