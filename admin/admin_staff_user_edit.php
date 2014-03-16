<form action="action.php?id=editstaff" method="post">
<input type="hidden" name="staffid" value="<?php echo $staff[id];?>">
		  <table class="formtable">
			    <tr>
			      <td class="tdtext" ><?php echo $TEXT['Full Name']?></td>
		         <td class="tdform"><input name="name" type="text" value="<?php echo $staff[name];?>"/> 
	              (<?php echo $staff[user]?>)</td>
                </tr>
                <tr>
			      <td class="tdtext" ><?php echo $TEXT['Email'];?></td>
		        <td class="tdform"><input name="email" type="text" value="<?php echo $staff[email];?>"/></td>
                </tr>
                <tr>
			     <td class="tdtext" ><?php echo $TEXT['Departments'];?></td>
		         <td class="tdform">
                 <?php
				 $query = $api->get_departments();
				 while($dep = mysqli_fetch_array($query)){
                 ?>
                 <input <?php 
				 $string = ", ".$staff[departments].",";
				 $pos = strpos($string,", ".$dep[name].",");
				 if($pos !== false) echo 'checked="checked"'; ?> name="d<?php echo $dep[id];?>" type="checkbox" class="input-checkbox"/><?php echo $dep[name];?><br>
                 <?php } ?>
                 </td>
                </tr>
                <tr>
			      <td class="tdtext" ><?php echo $TEXT['Languages'];?></td>
		         <td class="tdform">
                 <?php
                 $query = $api->get_langs(true);
				 while($lang_array = mysqli_fetch_array($query)){
                 ?>
                 <input <?php 
				 $string = ",".$staff[langs].",";
				 $pos = strpos($string,",".$lang_array[short].",");
				 if($pos !== false) echo 'checked="checked"';
				  ?>
                   name="<?php echo $lang_array[short];?>" type="checkbox" class="input-checkbox" /><?php echo $lang_array[name];?><br>
                 <?php } ?>
                 </td>
                </tr>
                <tr>
			      <td class="tdtext" ><?php echo $TEXT['Can Manage Users'];?></td>
		         <td class="tdform">
                 <input name="manage-users" <?php if($staff[manage]) echo 'checked="checked"'; else echo ""; ?> type="checkbox" class="input-checkbox2" /><br>
                 </td>
                </tr>
                 <tr>
			     <td class="tdtext" ><?php echo $TEXT['Can Create Docs'];?></td>
		         <td class="tdform">
                 <input class="input-checkbox2" name="manage-docs" type="checkbox" <?php if($staff[docs]) echo 'checked="checked"'; else echo ""; ?> /><br>
                 </td>
                </tr>
                <tr>
                <td class="tdtext" ><?php echo $TEXT['Password'];?></td>
		         <td class="tdform">
                 <input type="text" class="input-text" name="password" id="password" value="">
                 </td>
                </tr>
                <tr>
			      <th class="tdform" colspan="2"><input type="submit" class="button" value="<?php echo $TEXT['Submit'];?>"></th>
                </tr>
	      </table>
          <input type="hidden" name="staffid" id="staffid" value="<?php echo $staff[id];?>">
          </form>
          <br>
          <table class="formtable">
          <tr>
  			<td class="tdtext" colspan="3">
  				<?php echo $TEXT['Properties'];?>
  			</td>
  		  </tr>
  <?php
  
  $query = $api->get_propvalues('staff', $staff[id]);
  while($reg = mysqli_fetch_array($query)){
  ?>
  <tr>
  <td class="tdtext">
  <?php echo $reg[name];?>
  </td>
  <td class="tdform">
  <?php
  $reg2 = $api->get_property('name', $reg[name]);
  	if($reg2[input] == "checkbox"){
		?>
        <input type="checkbox" class="input-checkbox2" onchange="modifystaffprop2('<?php echo $reg[name]; ?>');" <?php echo ($reg[value] == "on") ? "checked='checked'" : ""; ?>>
		<?php
	}
	elseif($reg2[input] == "select"){
		?>
        <select class='input-select' onchange="modifystaffprop('<?php echo $reg[name]; ?>');" id="<?php echo $reg[name];?>" name="provalue-<?php echo $reg[name];?>">
		<?php
		$array = explode("~", $reg2[value]);
		$lenght = count($array) - 1;
		for($i=0; $i<$lenght; ++$i){
		?>
		<option value="<?php echo $array[$i]; ?>" <?php if($reg[value] == $array[$i]) echo "selected='selected'";?>><?php echo $array[$i]; ?></option>
		<?php } ?>
		</select>
		<?php
	}
	elseif($reg2[input] == "text"){
		?>
        <form action="action.php" method="get">
        <input type="hidden" name="id" value="staffprop">
        <input type="hidden" name="toid" value="<?php echo $staff[id]?>">
        <input type="hidden" name="name" value="<?php echo $reg[name];?>">
        <input class='input-text' type="text" name="pvalue" value="<?php echo $reg[value];?>">
        </form>
		<?php
	}
  ?>
  </td>
  </tr>
  <?php } ?>
  <tr>
  <th colspan="3" class='tdtext'>
  <?php echo $TEXT['Filters']; ?>
  </th>
  </tr>
  <?php
  
  $query = $api->get_extra('filter', 'toid', $staff[id]);
  while($filter = mysqli_fetch_array($query)){
	  ?>
      <tr>
      <td class="tdtext">
      <?php echo $filter[name];?>
      </td>
      <td class="tdform">
	  <?php
	  $query2 = $api->get_extra('defaultfilter', 'name', $filter[name]);
	  if(!mysqli_num_rows($query2)){
		  echo $filter[value];
	  }
	  else{
	  	$prop = $api->get_property('name', $filter[name]);
		if($prop[input] == "checkbox"){
		?>
        <form action="action.php?id=editfilter&name=<?php echo $prop[name];?>&toid=<?php echo $staff[id];?>" method="post">
		
        <select name="def" class="input-select">
		<option value="1" <?php if($filter[value] == '1') echo "selected='selected'";?>><?php echo $TEXT['Yes'];?></option>
		<option value="0" <?php if($filter[value] == '0') echo "selected='selected'";?>><?php echo $TEXT['No'];?></option>
		<option value="both" <?php if($filter[value] == 'both') echo "selected='selected'";?>><?php echo $TEXT['Both'];?></option>
		</select>
       
        
<?php
		}elseif($prop[input] == "select"){
		?>
		<form action="action.php?id=editfilter&name=<?php echo $prop[name];?>&toid=<?php echo $staff[id];?>" method="post">
		<?php
	    $options_array = explode("~", $prop[value]);
	    $i=0;
	    $lenght = count($options_array) - 1;
		$values = "~".$filter[value];
	    for($i=0; $i<$lenght; ++$i){
		$find = "~".$options_array[$i]."~";
		$pos = strpos($values, $find);
	   ?>
		<input type="checkbox" class="input-checkbox" name="op<?php echo $i; ?>" <?php if($pos !== false) echo "checked"; ?>/> <?php echo $options_array[$i];?>
       <?php 
         }
	    }
	   ?>
       </td>
        <td>
        <input type="submit" class="button" value="<?php echo $TEXT['Submit'];?>">
        </form>
	  <?php
	  } //END ELSE
	  ?> 
    </td>
   </tr>
  <?php
  } //END WHILE
  ?>
          </table>
          <br />
          <a href="admin_main.php?mode=staffuser&submode=staffsure&id=<?php echo $staff[id];?>" class="subbutton" id='deleteuser'><?php echo $TEXT['Delete User'];?></a>