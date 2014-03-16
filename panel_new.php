<script type="text/javascript" src="nicedit/nicEdit.js"></script>
<script type="text/javascript">
	bkLib.onDomLoaded(function() { nicEditors.allTextAreas() });
</script>
<div class="panelbox">
	<div class="title"><?php echo $TEXT['New Ticket']; ?></div>
	<div class="description"><?php echo $TEXT['New Ticket Description']; ?></div>
	<div class="ubox">
		<form action="action.php?id=new" method="POST">
		<div class="form-div">
        	<div id="departmentselect">
			<div class="ntext"><?php echo $TEXT['Department']; ?></div>
			<select class="select-input" name="n-department" id="n-department">
				<?php
				$list = $api->get_departments();
				while($reg = mysqli_fetch_array($list)){
				?>
				<option value="<?php echo $reg[name]; ?>"><?php echo $reg[name]; ?></option>
				<?php } ?>
			</select>
            </div>
            <div id="langselect">
			<div class="ntext"><?php echo $TEXT['Languages']; ?></div>
			<select class="select-input" name="n-lang" id="n-lang">
				<?php
				$list = $api->get_langs(true);
				while($reg = mysqli_fetch_array($list)){
				?>
				<option value="<?php echo $reg[short]; ?>" <?php if($DATA[lang] == $reg[short]) echo 'selected';?>><?php echo $reg[name]; ?></option>
				<?php } ?>
			</select>
            </div>
		</div>
		<div class="form-div">
			<div class="ntext"><?php echo $TEXT['Title']; ?></div>
			<input type="text" class="text-input" id="n-title" name="n-title">
		</div>
		<div class="form-div">
			<div class="ntext"><?php echo $TEXT['Message']; ?></div>
			<textarea class="textarea-input" id="n-message" rows="6" cols="70" name="n-message"></textarea>
		</div>
         <?php
		$query = $api->get_properties("tickets");
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
		<div class="form-div">
				<input type="submit" class="button" value="<?php echo $TEXT['Submit'];?>">
		</div>
		</form>
	</div>
</div>