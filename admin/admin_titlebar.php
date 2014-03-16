<?php
function submode(){
	global $TEXT;
	global $_GET;
	switch($_GET['submode']){
			  case 'about':
			  	 return $TEXT['About'];
			  break;
			  case 'generalsettings':
			  	 return $TEXT['General Settings'];
			  break;
			  case 'departments':
			  	return $TEXT['Departments'];
			  break;
			  case 'langs':
			  	 return $TEXT['Languages'];
			  break;
			  case 'themes':
			  	 return $TEXT['Themes'];
			  break;
			  case 'codeeditor':
			  	 return $TEXT['Code Editor'];
			  break;
			  case 'logs':
			  	return $TEXT['Homepage'];
			  break;
			  case 'liststaff':
			  	return $TEXT['List Users'];
			  break;
			  case 'newstaff':
			  	return $TEXT['New Staff User'];
			  break;
			  case 'staffdetails':
			  	return $TEXT['Staff Details'];
			  break;
			  case 'stafflogs':
			  	return $TEXT['Staff Logs'];
			  break;
			  case 'staffticket':
			  	return $TEXT['Tickets'];
			  break;
			  case 'staffedit':
			  	return $TEXT['Edit and Delete'];
			  break;
			  case 'staffviewticket':
			  	return $TEXT['Ticket Viewer'];
			  break;
			  case 'properties':
			  	return $TEXT['Managed Properties'];
			  break;
			  case 'newproperty':
			  	return $TEXT['New Property'];
			  break;
			  case 'editproperty':
			  	return $TEXT['Edit Property'];
			  break;
			  case 'newfilter':
			  	return $TEXT['Create Filter'];
			  break;
			  case 'mmail':
			  	return $TEXT['Massive Mail'];
			  break;
			  case 'responses':
			  	return $TEXT['Custom Responses'];
			  break;
			  case 'update':
			  	return $TEXT['Update'];
			  break;
			  case 'listplugins':
			  	return $TEXT['Plugins List'];
			  break;
			  case 'installplugins':
			  	return $TEXT['Install Plugins'];
			  break;
			  case 'home':
			  	return $TEXT['Home'];
			  break;
			  default:
			  	return $_GET['submode'];
			  break;
	}
}
function mode(){
	global $TEXT;
	global $_GET;
	switch($_GET['mode']){
	case 'settings': 
    	return $TEXT['Settings'];
	break;
	case 'home':
		return $TEXT['Homepage'];
	break;
	case 'staff':
		return $TEXT['Staff'];
	break;
	default:
		return $_GET['mode'];
	break;
	}
}
?>
<div class="titlebar"><br />
			  <div class="toptitle"><?php
			  echo submode();
			  ?></div>
				<div class="route"><?php echo mode(); ?> / <?php echo submode(); ?></div>
</div>