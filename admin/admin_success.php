<?php
switch($_GET['success']){
	case 'upgraded':
		$success = $TEXT['Your system has been upgraded'];
	break;
	case 'newstaff':
		$success = $TEXT['Staff member has been created'];
	break;
	case 'staffupdate':
		$success = $TEXT['Staff user updated'];
	break;
	case 'staffdeleted':
		$success = $TEXT['Staff user deleted'];
	break;
	case 'titleset':
		$success = $TEXT['Title has been updated'];
	break;
	case 'emailset':
		$success = $TEXT['Main email has been updated'];
	break;
	case 'system':
		$success = $TEXT['Users system has been updated'];
	break;
	case 'dropuser':
		$success = $TEXT['Users table has been truncated'];
	break;
	case 'droptable':
		$success = $TEXT['Tickets table has been truncated'];
	break;
	case 'newdep':
		$success = $TEXT['New department created'];
	break;
	case 'deletedep':
		$success = $TEXT['Department deleted'];
	break;
	case 'newdep':
		$success = $TEXT['New department created'];
	break;
	case 'newdep':
		$success = $TEXT['New department created'];
	break;
	case 'langs':
		$success = $TEXT['Langs settings updated'];
	break;
	case 'changetheme':
		$success = $TEXT['Theme settings updated'];
	break;
	case 'newtheme':
		$success= $TEXT['New theme uploaded'];
	break;
	case 'newproperty':
		$success = $TEXT['New property added'];
	break;
	case 'editprop':
		$success = $TEXT['Property edited'];
	break;
	case 'deleteprop':
		$success = $TEXT['Property has been deleted'];
	break;
	case 'newfilter':
		$success = $TEXT['New filter created'];
	break;
	case 'mmail':
		$success = $TEXT['Massive mail sent'];
	break;
	case 'langedit':
		$success = $TEXT['Text updated'];
	break;
	case 'newplugin':
		$success = $TEXT['New plugin installed'];
	break;
	case 'updateplugin':
		$success = $TEXT['Plugin updated'];
	break;
	case 'maintenanceon':
		$success = $TEXT['Maintenance mode on'];
	break;
	case 'maintenanceoff':
		$success = $TEXT['Maintenance mode off'];
	break;
	default:
		$success = $TEXT['Successful Operation'];
	break;
}
?>
<div class="sucessmessage"> <?php echo $success; ?> </div>
<br>