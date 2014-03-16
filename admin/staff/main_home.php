<table width="200" border="0" class="listing">
  <tr>
    <th><?php echo $TEXT['Name']; ?></th>
    <td><?php echo $STAFF[name] . " ($STAFF[user])";?></td>
    <th><?php echo $TEXT['Email']; ?></th>
    <td><?php echo $STAFF[email];?></td>
  </tr>
  <tr>
    <th><?php echo $TEXT['Departments']; ?></th>
    <td><?php echo $STAFF[departments];?></td>
    <th><?php echo $TEXT['Languages']; ?></th>
    <td><?php echo $STAFF[langs];?></td>
  </tr>
  <tr>
    <th><?php echo $TEXT['Can Manage Users']; ?></th>
    <td><?php echo $STAFF[manage] ? $TEXT['Yes'] : $TEXT['No'];?></td>
    <th><?php echo $TEXT['Can Create Docs']; ?></th>
    <td><?php echo $STAFF[docs] ? $TEXT['Yes'] : $TEXT['No'];?></td>
  </tr>
  <tr>
  <th colspan="4">
  <?php echo $TEXT['Properties'];?>
  </th>
  </tr>
  <?php
  $query = $api->get_propvalues('staff', $STAFF[id]);
  while($reg = mysqli_fetch_array($query)){
  ?>
  <tr>
  <td>
  <?php echo $reg[name];?>
  </td>
  <td>
  <?php
  $reg2 = $api->get_property('name', $reg[name]);
  if($reg2[edit]){
  	if($reg2[input] == "checkbox"){
		?>
        <input class="input-checkbox" type="checkbox" onchange="modifystaffprop2('<?php echo $reg[name]; ?>');" <?php echo ($reg[value] == "on") ? "checked='checked'" : ""; ?>>
		<?php
	}
	elseif($reg2[input] == "select"){
		?>
        <select class="input-select" onchange="modifystaffprop('<?php echo $reg[name]; ?>');" id="<?php echo $reg[name];?>" name="provalue-<?php echo $reg[name];?>">
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
        <input type="hidden" name="name" value="<?php echo $reg[name];?>">
        <input class="input-text" type="text" name="pvalue" value="<?php echo $reg[value];?>">
        </form>
		<?php
	}
  } else {
	  echo $reg[value];
  }
  ?>
  </td>
  </tr>
  <?php } ?>
  <tr>
  <th colspan="4">
  <?php echo $TEXT['Filters']; ?>
  </th>
  </tr>
  <?php
  
  $query = $api->get_extra('filter', 'toid', $STAFF[id]);
  while($filter = mysqli_fetch_array($query)){
	  ?>
      <tr>
      <td>
      <?php echo $filter[name];?>
      </td>
      <td>
	  <?php
	  $query2 = $api->query("SELECT * FROM EXTRA WHERE type='defaultfilter' AND name='$filter[name]' AND toid='1'");
	  if(!mysqli_num_rows($query2)){
		  echo $filter[value];
	  }
	  else{
		$prop = $api->get_property('name', $filter[name]);
		if($prop[input] == "checkbox"){
		?>
        <form action="action.php?id=editfilter&name=<?php echo $prop[name];?>" method="post">
		<select class="input-select" name="def">
		<option value="1" <?php if($filter[value] == '1') echo "selected='selected'";?>><?php echo $TEXT['Yes'];?></option>
		<option value="0" <?php if($filter[value] == '0') echo "selected='selected'";?>><?php echo $TEXT['No'];?></option>
		<option value="both" <?php if($filter[value] == 'both') echo "selected='selected'";?>><?php echo $TEXT['Both'];?></option>
		</select>
        
<?php
		}elseif($prop[input] == "select"){
		?>
		<form action="action.php?id=editfilter&name=<?php echo $prop[name];?>" method="post">
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
<br>
<div align="center">
    <a href="http://www.opensupports.com/wiki/" target="_blank"><img src="img/wiki.jpg"></a>
</div>