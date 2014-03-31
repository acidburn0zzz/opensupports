<?php
if(file_exists("install/index.php")){
	header('Location: install/index.php');
	exit;
}

/* Get Acces information */
require "config.php";
/*Start Session*/
session_start();

/*Call API*/
require "api/api.php";

/*Creates API*/
$api = new API();

/* Connects to MySQL Server and get info*/
$api->connect($mysql_server,$mysql_user,$mysql_pass, $mysql_db);

/*Get DATA information*/
$DATA = $api->get_data();

if($DATA['maintenance']){
	header('HTTP/1.0 403 Forbidden');
	exit;
}

/* Language */
if(isset($_GET['lang']) && file_exists("lang/" . $_GET['lang'] .".php"))
	$_SESSION[LANG] = $_GET['lang'];

if(isset($_SESSION[LANG]) && strlen($_SESSION[LANG]) == 2)
	include ("lang/" . $_SESSION[LANG] .".php");
else{
	include ("lang/" . $DATA['lang'] .".php");
	$_SESSION[LANG] =  $DATA['lang'];
}

/* START: Get BTEXT from MySQL*/
if($_SESSION[LANG] != 'en'){
	$txt = $api->get_text($_SESSION[LANG]);
	$txten = $api->get_text('en');
	$TEXT = array_merge($txten, $txt, $TEXT);
}
else{
	$txten = $api->get_text('en');
	$TEXT = array_merge($txten, $TEXT);
}
/* END: Get BTEXT from MySQL*/

/* Get USER information */
if($_SESSION[TYPE] == "user"){
	$USER[email] = $_SESSION[EMAIL];
	$USER[id] = $_SESSION[ID];
	$USER[name] = $_SESSION[NAME];
	$islogin = true;
}
else {
	$islogin = false;
}
?>