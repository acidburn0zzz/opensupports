<?php
switch($_GET[mode]){
	case 'Users':
		if(!$DATA[login]){
			header('Location: index.php');
			exit;
		}
		if(!$STAFF[manage]){
			header('Location: index.php');
			exit;
		}
	break;
	case 'Docs':
		if(!$STAFF[docs]){
			header('Location: index.php');
			exit;
		}
	break;
	case 'ViewTickets':
	/*Get information about the ticket*/
	$ticket = $api->get_ticket($_GET[id]);
	/*Verify if this ticket doesn't belong to other staffuser*/
	if($ticket[staffuser] != $STAFF[user] && $ticket[staffuser] != "") header('Location: index.php');
	/*Verify if this department belongs to the staffuser*/
	$listof = ", ". $STAFF[departments].",";
	$search = ", ".$ticket[department]. ",";
	if(strpos($listof, $search) === false) header('Location: index.php');
	break;
}
?>