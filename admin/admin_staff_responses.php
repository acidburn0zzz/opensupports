<?php
if(isset($_GET[responseid])){
	$id = $api->sql_escape($_GET[responseid]);
	$query = $api->query("SELECT * FROM TEXT WHERE id='$id'");
	$response = mysqli_fetch_array($query);
}
?><script type="text/javascript" src="../nicedit/nicEdit.js"></script>
<script type="text/javascript">
	bkLib.onDomLoaded(function() { nicEditors.allTextAreas() });
</script>
<form action="action.php?id=response" method="post">
		  <table class="formtable">
			    <tr>
			      <td class="tdtext" width="212"><?php echo $TEXT['Edit'];?></td>
		         <td class="tdform">
                 <select class="input-select" name="editresponse" id="editresponse" onchange="changeresponse();">
                 <option value="new"><?php echo $TEXT['New Response'];?></option>
                 <?php
                 $query = $api->query("SELECT * FROM TEXT WHERE type='response'");
				 while($reg = mysqli_fetch_array($query)){
				 ?>
                 <option value="<?php echo $reg[id]; ?>" <?php if($reg[id] == $id) echo 'selected="selected"';?>><?php echo $reg[name];?></option>
                 <?php } ?>
                 </select>
                 </td>
                </tr>
                <tr>
			      <td class="tdtext" width="212"><?php echo $TEXT['Title'];?></td>
		         <td class="tdform"><input class="input-text" name="title" type="text" value="<?php if(isset($id)) echo $response[name];?>" /></td>
                </tr>
                
                <tr>
			     <td class="tdtext"><?php echo $TEXT['Languages'];?></td>
		         <td class="tdform">
                 <select class="input-select" name="lang" id="lang">
                 <?php
                 $query = $api->get_langs(true);
				 while($reg = mysqli_fetch_array($query)){
				 ?>
                 <option value="<?php echo $reg[short]; ?>" <?php if($reg[short] == $response[lang]) echo 'selected="selected"'?>><?php echo $reg[name];?></option>
                 <?php } ?>
                 </select>
                 </td>
                </tr>
                
                <tr>
			      <td class="tdtext" width="212"><?php echo $TEXT['Message'];?></td>
		         <td class="tdform" style="background-color:#FFF"><center><textarea class='input-textarea' name="content" cols="60" rows="10" ><?php if(isset($id)) echo $response[value];?></textarea></center></td>
                </tr>
                <tr>
			      <td class="tdform" colspan="2"><input type="submit" class="button" value="<?php echo $TEXT['Submit'];?>"></td>
                </tr>
	      </table>
</form>