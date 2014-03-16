<div class="panelbox2">
	<div class="title"><?php echo $TEXT['Create an User']; ?></div>
	<div class="desciption"><?php echo $TEXT['Create an User description']; ?></div>
	<div class="ubox">
		<form action="action.php?id=newuser" method="POST">
		<div id="create_user_form">
		<div class="form-div">
			<div class="ntext"><?php echo $TEXT['Name']; ?></div>
			<input type="text" class="text-input" id="n-name" name="n-name">
		</div>
		<div class="form-div">
			<div class="ntext"><?php echo $TEXT['Email']; ?></div>
			<input type="text" class="email-input" id="n-email" name="n-email">
		</div>
		<div class="form-div">
			<div class="ntext"><?php echo $TEXT['Password']; ?></div>
			<input type="password" class="pass-input" id="n-pass" name="n-pass">
		</div>
		<div class="form-div">
			<div class="ntext"><?php echo $TEXT['Repeat Password']; ?></div>
			<input type="password" class="pass-input" id="n-rpass" name="n-rpass">
		</div>
         <?php
		 $query = $api->get_properties('user');
		while($reg = mysqli_fetch_array($query)){
			if($reg[input] == "text"){
		?>
        <div class="form-div">
			<div class="ntext"><?php echo $reg[name];?></div>
				<?php if($reg[edit]) {?><input type="text" class="text-input" name="provalue-<?php echo $reg[name];?>" value="<?php echo $reg[value];?>"><?php }else{ echo $reg[value];}?>
		</div>
		<?php
			} else if($reg[input] == "checkbox"){
		?>
        <div class="form-div">
			<div class="ntext"><?php echo $reg[name];?></div>
				<input type="checkbox"  class="checkbox-input" name="provalue-<?php echo $reg[name];?>" <?php if($reg[value] == 'on') echo "checked='checked'";?> <?php if(!$reg[edit]) echo "disabled='disabled'"; ?>>
		</div>
		<?php } else if($reg[input] == "select" && $reg[edit]){
			?>
        <div class="form-div">
			<div class="ntext"><?php echo $reg[name];?></div>
			<select class="select-input" name="provalue-<?php echo $reg[name];?>">
				<?php
				$array = explode("~", $reg[value]);
				$lenght = count($array) - 1;
				for($i=0; $i<$lenght; ++$i){
				?>
				<option value="<?php echo $array[$i]; ?>"><?php echo $array[$i]; ?></option>
				<?php } ?>
			</select>
		</div>
            <?php
			}
		}
    	?>
    	</div>
		<div class="form-div">
				<input type="submit" class="button" value="<?php echo $TEXT['Submit'];?>">
		</div>
		</form>
	</div>
</div>
