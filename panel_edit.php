<div class="panelbox">
	<div class="title"><?php echo $TEXT['Edit Profile']; ?></div>
	<div class="description"><?php echo $TEXT['Edit Profile description']; ?></div>
	<div class="ubox" id="edit-mail">
		<div class="ntext"><?php echo $TEXT['Edit Email'];?></div>
		<form action="action.php?id=editemail" method="POST">
			<div class="ntext"><?php echo $TEXT['New Email'];?></div>
			<div class="form-div">
				<input type="text" class="email-input" id="e-email" name="e-email" value="<?php echo $_SESSION[EMAIL];?>">
			</div>
			<div class="form-div">
				<input type="submit" class="button" value="<?php echo $TEXT['Submit'];?>">
			</div>
		</form>
	</div>
	<div class="ubox" id="edit-pass">
		<div class="ntext"><?php echo $TEXT['Change Password'];?></div>
		<form action="action.php?id=editpass" method="POST">
			<div class="ntext"><?php echo $TEXT['New Password'];?></div>
			<div class="form-div">
				<input type="password" class="pass-input" id="e-pass" name="e-pass">
			</div>
			<div class="ntext"><?php echo $TEXT['Repeat Password'];?></div>
			<div class="form-div">
				<input type="password" class="pass-input" id="e-pass2" name="e-pass2">
			</div>
			<div class="form-div">
				<input type="submit" class="button" value="<?php echo $TEXT['Submit'];?>">
			</div>
		</form>
	</div>
     <?php
	 	$query = $api->get_propvalues("user", $_SESSION[ID]);
		while($reg = mysqli_fetch_array($query)){
		$e = $api->get_property("name",$reg[name]);
		if($e[edit]){
		if($e[input] == "text"){
		?>
        <div class="ubox" id="edit-<?php echo $reg[name];?>">
		<form action="action.php?id=property&name=<?php echo $reg[name];?>" method="POST">
			<div class="ntext"><?php echo $reg[name];?></div>
			<div class="form-div">
				<input type="text" class="text-input" name="provalue-<?php echo $reg[name];?>" value="<?php echo $reg[value];?>">
			</div>
			<div class="form-div">
				<input type="submit" class="button" value="<?php echo $TEXT['Submit'];?>">
			</div>
		</form>
		</div>
		<?php
			} else if($e[input] == "checkbox"){
		?>
        <div class="ubox" id="edit-<?php echo $reg[name];?>">
		<form action="action.php?id=property&name=<?php echo $reg[name];?>" method="POST">
			<div class="ntext"><?php echo $reg[name];?></div>
			<div class="form-div">
				<input type="checkbox"  class="checkbox-input" name="provalue-<?php echo $reg[name];?>" <?php if($reg[value] == 'on') echo "checked='checked'";?>>
			</div>
			<div class="form-div">
				<input type="submit" class="button" value="<?php echo $TEXT['Submit'];?>">
			</div>
		</form>
		</div>
		<?php } else if($e[input] == "select"){ ?>
        
        <div class="ubox" id="edit-<?php echo $reg[name];?>">
		<form action="action.php?id=property&name=<?php echo $reg[name];?>" method="POST">
			<div class="ntext"><?php echo $reg[name];?></div>
			<div class="form-div">
			<select class="select-input" name="provalue-<?php echo $reg[name];?>">
				<?php
				$array = explode("~", $e[value]);
				$lenght = count($array) - 1;
				for($i=0; $i<$lenght; ++$i){
				?>
				<option value="<?php echo $array[$i]; ?>" <?php if($array[$i] == $reg[value]) echo "selected='selected'"; ?>><?php echo $array[$i]; ?></option>
				<?php } ?>
			</select>
			</div>
			<div class="form-div">
				<input type="submit" class="button" value="<?php echo $TEXT['Submit'];?>">
			</div>
		</form>
		</div>
            <?php
			}
		  }
		}
    	?>
</div>
