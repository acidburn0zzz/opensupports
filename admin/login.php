<?php
require "../config.php";
/*Start Session*/
session_start();
/*Call API*/
require "../api/api.php";

/*Creates API*/
$api = new API;

/* Connects to MySQL Server */
$api->connect($mysql_server, $mysql_user, $mysql_pass, $mysql_db);

/*Get DATA information*/
$DATA = $api->get_data();

switch($_GET[id]){
	case 'admin':
		if($admin_user == $_POST[adminuser] && $admin_pass == $_POST[adminpass]){
			$_SESSION[TYPE] = "admin";
			header('Location: admin_main.php?mode=home&submode=home');
			exit;
		}
		else{
			header('Location: index.php');
			exit;
		}
	break;
	case 'staff':
		$result = $api->login_staff($_POST[staffuser], $_POST[staffpass]);
		if($result == false){
			header('Location: index.php');
			exit;
		}else{
			$_SESSION[TYPE] = "staff";
			$_SESSION[STAFFID] = $result[id];
			$_SESSION[CVERIFY] = false;
			header('Location: staff/index.php');
			exit;
		}
	break;
}
?>