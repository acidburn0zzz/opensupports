<?php
/* Get Acces information */
require "../../config.php";
/*Start Session*/
session_start();
/*Call API*/
require "../../api/api.php";

/*Creates API*/
$api = new API();

/* Connects to MySQL Server and get info*/
$api->connect($mysql_server,$mysql_user,$mysql_pass, $mysql_db);

/*Get DATA information*/
$DATA = $api->get_data();


if($_SESSION[TYPE] != "staff"){
	header('Location: ../index.php');
	exit;
}

/* Create Staff user array */
$STAFF = $api->get_staff($_SESSION[STAFFID]);

/* Language */
include ("../../lang/" . $DATA['lang'] .".php");

/* START: Get BTEXT from MySQL*/
if($_DATA['lang'] != 'en'){
	$txt = $api->get_text($_DATA['lang']);
	$txten = $api->get_text('en');
	$TEXT = array_merge($txten, $txt, $TEXT);
}
else{
	$txten = $api->get_text('en');
	$TEXT = array_merge($txten, $TEXT);
}
/* END: Get BTEXT from MySQL*/

if($_SESSION[CVERIFY] == false){
	staff_logs($TEXT['Staff logged']);
	$_SESSION[CVERIFY] = true;
}

function staff_logs($thing){
	global $STAFF;
	global $api;
	$query = $api->staff_logs($STAFF[user], $thing);
}

function download($result, $filename){ 
header("Content-Type: text/plain");
header('Content-Disposition: attachment; filename="'.$filename.'"');
header("Content-Length: " . strlen($result));
echo $result;
exit;
}
?>