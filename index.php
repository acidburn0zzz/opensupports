<?php
/* Gets information from database, etc.*/
include 'controller.php';
if($_GET[mode] == "view_ticket"){
	$reg = $api->get_ticket($_GET[ticketid]);
	if($reg[email] != $_GET[email]){
		header('Location: index.php');
		exit;
	}
}
if($_GET[mode] == "create_user" && !$DATA[register]){
	header('Location: index.php');
	exit;
}
if(($_GET[mode] == "create_ticket" || $_GET[mode] == "view_ticket" || $_GET[mode] == "check_ticket" || $_GET[mode] == "list_docs")  && $DATA[login]){
	header('Location: index.php');
	exit;
}
if(file_exists('install/index.php')) header('Location: install/');
?>
<html>
<?php include 'header.php'; //Head Content?>
<body>
<div class="all" align="center">
<?php
$codes = $api->get_codes('index.php', true);
foreach($codes as $code){
	include("plugins/$code");
}
?>
<?php include 'top.php'; //Top Bar ?>
<?php
if(isset($_GET[error])) include "error_box.php";
switch($_GET[mode]){
 case 'create_ticket':
  if(!$DATA[login]) include 'create_ticket.php';
 break;
 case 'check_ticket':
  if(!$DATA[login]) include 'check_ticket.php';
 break;
 case 'create_user':
  if($DATA[register] && $DATA[login]) include 'register.php';
 break;
 case 'view_ticket':
   if(!$DATA[login]) include 'view_ticket.php';
 break;
 case 'list_docs':
   if(!$DATA[login]) include 'list_docs.php';
 break;
 case 'success':
  include 'panel_success.php';
 break;
 case 'view_doc':
   if(!$DATA[login]) include 'panel_doc.php';
 break; 
 case 'error':
   include 'panel_error.php';
 break;
default:
  include 'main.php'; //Content of the index page
 break;
}
?>
<?php include 'end.php'; //Main Vaue ?>
</div>
<?php
$codes = $api->get_codes('index.php', false);
foreach($codes as $code){
	include("plugins/$code");
}
?>
</body>
</html>