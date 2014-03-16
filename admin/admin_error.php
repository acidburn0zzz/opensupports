<?php
switch($_GET['error']){
	case 'propname':
		$error = $TEXT['Property already exist'];
	break;
	case 'name':
		$error = $TEXT['Name is very short'];
	break;
	case 'email':
		$error = $TEXT['Insert a valid email'];
	break;
	case 'title':
		$error = $TEXT['Title is too short'];
	break;
	case 'changetheme':
		$error = $TEXT['File could not be uploaded'];
	break;
	case 'uploadfile':
		$error = $TEXT['File could not be uploaded'];
	break;
	case 'newplugin':
		$error = $TEXT['Plugin could not be installed'];
	break;
	case 'updateplugin':
		$error = $TEXT['Update file not found'];
	break;
}
?>
<div class='errormessage'><?php echo $error; ?></div>