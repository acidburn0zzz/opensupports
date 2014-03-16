<div class="errorsmessage"><?php
switch($_GET[why]){
case 'email':
$errormessage =  $TEXT['Unvalid Email'];
break;
case 'pass':
$errormessage =  $TEXT['Password is too short'];
break;
case 'rpass':
$errormessage =  $TEXT['Passwords do not match'];
break;
default:
$errormessage =  $TEXT['Operation did not succeed'];
break;
}
echo $TEXT['Error'] . ": " . $errormessage;
?>
<br>
<div class="goback">
	<a href="<?php
	if(isset($_GET[url])) echo htmlentities($_GET[url]);
	else echo 'index.php';
	?>"><?php echo $TEXT['Go back'];?>
</div>
</div>
