<?php
/*Get Acces information*/
include_once "../config.php";
/*Start Session*/
session_start();
/*Call API*/
require_once "../api/api.php";
require '../api/plugins_api.php';

/*Creates API*/
$api = new API;

/* Connects to MySQL Server */
$api->connect($mysql_server, $mysql_user, $mysql_pass, $mysql_db);

if($_SESSION[TYPE] != "admin"){
	header('Location: ../index.php');
	exit;
}

/*Get DATA information*/
$DATA = $api->get_data();


include ("../lang/" . $DATA['lang'] .".php");

/* START: Get BTEXT from MySQL*/
if($_DATA['lang'] != "en"){
	$txt = $api->get_text($DATA['lang']);
	$txten = $api->get_text('en');
	$TEXT = array_merge($txten, $txt, $TEXT);
}
else{
	$txten = $api->get_text('en');
	$TEXT = array_merge($txten, $TEXT);
}
/* END: Get BTEXT from MySQL*/

if($_GET['verifyversion'] == 'on'){
$client = new SoapClient("http://www.opensupports.com/version_server/server.php?wsdl");
$DATA['actualversion'] = $client->Version();
$api->update_data('actualversion', $DATA['actualversion']);
}

function download($result, $filename){ 
header("Content-Type: text/plain");
header('Content-Disposition: attachment; filename="'.$filename.'"');
header("Content-Length: " . strlen($result));
echo $result;
exit;
}
?>