<div class="top">
<div class="usertop">
<?php
if(isset($_SESSION[ID]))
{ 
?>

<a href="close.php">
<div class="close-session">
<span class="ntext"><?php echo $USER[name]; ?></span>
</div>
</a>
<?php } else if($DATA[login]) { ?>
<div class="loginbar"><a href="index.php"><?php echo $TEXT['Login'];?></a> | <a href="index.php?mode=create_user"><?php echo $TEXT['Signup']; ?></a></div>
<?php } ?>
</div>
<div class="langmenu-div">
<select name="selectlang" class="langmenu" id="selectlang" onchange="changelang()">
 <?php
 $query = $api->get_langs();
 $rows_lang = @mysqli_num_rows($query) or die ("Error 13: Can't get rows' quantity");
 while($temp = mysqli_fetch_array($query))
 {
 ?>
 <option value="<?php echo $temp[short]; ?>" <?php if($_SESSION[LANG] == $temp[short]) echo 'selected="selected"';?>><?php echo $temp[name]; ?>
 </option>
 <?php } ?>
</select>
</div>
</div>
