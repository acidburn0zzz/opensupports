<?php
/*Get information from the database*/
include 'controller.php';
/*Back to index if the user isn't logged*/
if(!isset($_SESSION[ID])){
	header('Location: index.php');
	exit; 
}
if($_GET[id] == "ticket"){
	$ticket = $api->get_ticket($_GET[ticket]);
	if($ticket[userid] != $_SESSION[ID]){
		header('Location: upanel.php');
		exit;
	}	
}
?>
<html>
<?php include 'header.php'; //Head Content ?>
<body>
<?php
$codes = $api->get_codes('upanel.php', true);
foreach($codes as $code){
	include("plugins/$code");
}
?>
<center>
<div class="all" align="center">
<?php include 'top.php'; //Top Bar ?>
<div class="upanel">
<?php
/*Create the panel menu for the user*/
include 'menupanel.php';

/*Decide what panel will be showed*/
switch ($_GET['id']) {
	case "edit":
		include 'panel_edit.php'; //Edit the profile
		break;
	case "new":
		include 'panel_new.php'; //Create a ticket
		break;
	case "docs":
		include 'panel_docs.php'; //List the docs
		break;
	case "ticket":
		include 'panel_ticket.php'; //See a specific ticket
		break;
	case "success":
		include 'panel_success.php';
		break;
	case "error":
		include 'panel_error.php';
		break;
	case "doc":
		include 'panel_doc.php';
		break;
	case 'extramode':
		$id = (int) $_GET[modeid];
		$mode = $api->get_mode($id);
		$mode_plugin = $mode[plugin];
		$mode_file = $mode[file];
		if($mode[route] == 'user' && file_exists("plugins/$mode_plugin/$mode_file"))
			include "plugins/$mode_plugin/$mode_file";
	break;
	default:
		include 'panel_default.php'; //List the ticket that the user's sent
		break;
}
?>
</div>
<?php include 'end.php'; //Main Vaue ?>
</div>
</center>
<?php
$codes = $api->get_codes('upanel.php', false);
foreach($codes as $code){
	include("plugins/$code");
}
?>
</body>
</html>