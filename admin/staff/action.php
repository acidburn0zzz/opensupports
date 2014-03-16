<?php
include "controller.php";

$codes = $api->get_codes('admin/staff/action.php', true);
foreach($codes as $code){
	include("../../plugins/$code");
}

switch($_GET[id]){
	case 'respondticket':
		/*Comments Query*/
		$api->new_comment($_POST[ticketid], $_POST[content], $STAFF[id], $STAFF[name], true);

		$ticket = $api->get_ticket($_POST[ticketid]);
		if($DATA[login]){
			$url="http://".$_SERVER['HTTP_HOST'].$_SERVER['PHP_SELF'];
			$url = dirname($url);
			$url = dirname($url);
			$url = dirname($url);
			$url .= "/index.php";
			$ms = $TEXT['Mail:3'] . $url;
		}else{
			$url="http://".$_SERVER['HTTP_HOST'].$_SERVER['PHP_SELF'];
			$url = dirname($url);
			$url = dirname($url);
			$url = dirname($url);
			$url .= "/index.php?mode=view_ticket&ticketid=$ticket[id]&email=$ticket[email]";
			$ms = $TEXT['Mail:3'] . $url;
		}
		$api->mailto($ticket[email],$TEXT['Ticket answered'], $ms);
		$api->logs($TEXT['Ticket answered by']." ". $STAFF[user] . " #".$_POST[ticketid]);
		staff_logs($TEXT['Ticket answered'] . " #".$_POST[ticketid]);
		header('Location: index.php?mode=ViewTickets&submode=Ticket%20Viewer&id='. $_POST[ticketid]);
	break;
	case 'derivate':
		//*The ticket won't belong to any staffuser*/
		$api->derivate($_GET[ticketid]);
		/*The staffuser has one ticket less*/
		$STAFF[tickets]--;
		$api->logs($TEXT['Ticket has been derivated'] . ' #' . $_GET[ticketid]);
		staff_logs($TEXT['Ticket has been derivated'] . ' #' . $_GET[ticketid]);
		header('Location: index.php?mode=Tickets');
	break;
	case 'closeticket':
		/*The ticket's isclosed value goes to 1 (true)*/
		$api->close_ticket($_GET[ticketid]);
		$api->logs($TEXT['Ticket has been closed'] . ' #' . $_GET[ticketid]);
		header('Location: index.php?mode=ViewTickets&submode=Ticket%20Viewer&id='. $_GET[ticketid]);
	break;
	case 'username':
		/*Update name of the user*/
		$api->update_user_name($_POST[userid], $_POST[name]);
		$api->logs($TEXT['User has been updated'] . ' #' . $_POST[userid]);
		staff_logs($TEXT['User has been updated'] . ' #' . $_POST[userid]);
		header('Location: index.php?mode=Users&submode=View&id='. $_POST[userid]);
	break;
	case 'useremail':
		/*Update email of the user*/
		$api->update_user_email($_POST[userid], $_POST[email]);
		$api->logs($TEXT['User has been updated'] . ' #' . $_POST[userid]);
		staff_logs($TEXT['User has been updated'] . ' #' . $_POST[userid]);
		header('Location: index.php?mode=Users&submode=View&id='. $_POST[userid]);
	break;
	case 'deleteuser':
		/*Delete user*/
		$api->delete_user($_GET[userid]);
		$api->logs($TEXT['User has been deleted'] . ' #' . $_GET[userid]);
		staff_logs($TEXT['User has been deleted'] . ' #' . $_GET[userid]);
		header('Location: index.php?mode=Users');
	break;
	case 'createdoc':
		/*Verify the lenght of the fields*/
		if(strlen($_POST[title]) < 5){
			header('Location: index.php?mode=Docs&submode=Create&error=Title');
			exit;
		}
		if(strlen($_POST[content]) < 10){
			header('Location: index.php?mode=Docs&submode=Create&error=Content');
			exit;
		}
		/*Does the document has a file?*/
		if(!$_FILES['fileupload']['name']){
			$api->create_doc($_POST[title], $_POST[content], $STAFF[name]);
			$api->logs($TEXT['A new document has been created']. ' #'. $_POST[title]);
			staff_logs($TEXT['A new document has been created']. ' #'. $_POST[title]);
			header('Location: index.php?mode=Docs');
		}
		else{
			$target_path = "../../files/";
			
			/*Decide a name for the file*/
			$_FILES['fileupload']['name']  = $api->sql_escape($_FILES['fileupload']['name']);
			do{
			$filename = rand(1,1000000) . "_" . $_FILES['fileupload']['name'];
        	$filename=str_replace(" ","_",$filename);
			}while(mysqli_num_rows($api->query("SELECT file FROM DOCS WHERE file='$filename'")) == 1);
			
			$target_path = $target_path . $filename;
			
			/*Upload the file*/
			if(!move_uploaded_file($_FILES['fileupload']['tmp_name'], $target_path)){
				header('Location: index.php?mode=Docs&submode=Create&error=File');
				exit;
			}
			
			/*Insert the doc*/
			if(!$api->create_doc($_POST[title], $_POST[content], $STAFF[name], $filename)){
				header('Location: index.php?mode=Docs&submode=Create');
				exit;
			}
			$api->logs($TEXT['A new document has been created']. ' #'. $_POST[title]);
			staff_logs($TEXT['A new document has been created']. ' #'. $_POST[title]);
			header('Location: index.php?mode=Docs');
		}
   	break;
	case 'doctitle':
		/*Updates doc title*/
		$api->update_doc($_POST[docid], 'title', $_POST[title]);
		$api->logs($TEXT['Document has been updated'] . ' #'.$_POST[docid]);
		staff_logs($TEXT['Document has been updated'] . ' #'.$_POST[docid]);
		header('Location: index.php?mode=Docs&submode=View&id='.$_POST[docid]);
	break;
	case 'doccontent':
		/*Updates doc content*/
		$api->update_doc($_POST[docid], 'content', $_POST[content]);
		
		$api->logs($TEXT['Document has been updated'] . ' #'.$_POST[docid]);
		staff_logs($TEXT['Document has been updated'] . ' #'.$_POST[docid]);
		header('Location: index.php?mode=Docs&submode=View&id='.$_POST[docid]);
	break;
	case 'docfile':
		/*Updates doc file*/
		$target_path = "../../files/";
		
		/*Verify if document doesn't have other file*/
		$doc = $api->get_doc($_POST[docid]);
		if($doc['file'] != "") unlink($target_path.$doc['file']);
		
		/*Decide a name for the file*/
		$_FILES['fileupload']['name'] = $api->sql_escape($_FILES['fileupload']['name']);	
		do{
		$filename = rand(1,1000000) . "_" . $_FILES['fileupload']['name'];
        $filename = str_replace(" ","_",$filename);
		}while(mysqli_num_rows($api->query("SELECT file FROM DOCS WHERE file='$filename'")) == 1);
		
		$target_path = $target_path . $filename;
		
		/*Upload the file*/
		if(!move_uploaded_file($_FILES['fileupload']['tmp_name'], $target_path)){
			header('Location: index.php?mode=Docs&submode=Create&error=File');
			exit;
		}
		$api->update_doc($_POST[docid], 'filename', $filename);
		$api->logs($TEXT['Document has been updated'] . ' #'.$_POST[docid]);
		staff_logs($TEXT['Document has been updated'] . ' #'.$_POST[docid]);
		header('Location: index.php?mode=Docs&submode=View&id='.$_POST[docid]);
	break;
	case 'docdelete':
		/*Deletes the file*/
		$doc = $api->get_doc($_GET[docid]);
		if($doc['file'] != "") unlink('../../files/'.$doc['file']);
		
		$api->delete_doc($_GET[docid]);
		
		$api->logs($TEXT['Document has been deleted'] . ' #'.$_GET[docid]);
		staff_logs($TEXT['Document has been deleted'] . ' #'.$_GET[docid]);
		header('Location: index.php?mode=Docs');
	break;
	case 'ticketprop':
		if(isset($_POST[pvalue]))
			$api->edit_ticket_property($_GET[ticketid], $_GET[name], $_POST[pvalue]);
		else
			$api->edit_ticket_property($_GET[ticketid], $_GET[name], $_GET[pvalue]);
		$api->logs($TEXT['Ticket property updated']. ' #' . $_GET[ticketid]);
		staff_logs($TEXT['Ticket property updated']. ' #' . $_GET[ticketid]);
		header("Location: index.php?mode=ViewTickets&submode=Ticket%20Viewer&id=$_GET[ticketid]");
	break;
	case 'userprop':
		$api->update_user_property($_GET[userid], $_GET[pname], $_POST[pvalue]);
		$api->logs($TEXT['User property updated']. ' #' . $_GET[userid]);
		staff_logs($TEXT['User property updated']. ' #' . $_GET[userid]);
		header("Location: index.php?mode=Users&submode=View&id=$_GET[userid]");
	break;
	case 'changedepartment':
		$api->update_ticket_deparment($_GET[ticketid], $_GET[dep]);
		$listof = ", ". $STAFF[departments].",";
		$search = ", ".$_GET[dep]. ",";
		if(strpos($listof, $search) === false){
			$reg = $api->get_ticket($_GET[ticketid]);
			/*The ticket won't belong to any staffuser*/
			$api->derivate($_GET[ticketid]);
						
			/*The staffuser has one ticket less*/
			if($reg[staffuser] == $STAFF[user]){
				$STAFF[tickets]--;
			}
		}
		$api->logs($TEXT['Ticket property updated']. ' #' . $_GET[ticketid]);
		staff_logs($TEXT['Ticket property updated']. ' #' . $_GET[ticketid]);
		header("Location: index.php?mode=ViewTickets&submode=Ticket%20Viewer&id=$_GET[ticketid]");
	break;
	case 'staffprop':
		$prop = $api->get_property('name', $_GET[name]);
		if(!$prop[edit]){
			header('Location: index.php');
			exit;
		}
		$api->edit_staff_prop($_GET[name], $_GET[pvalue], $STAFF[id], false);
		header('Location: index.php');
	break;
	case 'editfilter':
		$prop = $api->get_property('name', $_GET[name]);
		if($prop[input] == "checkbox"){
			$api->edit_filter($_GET[name], $STAFF[id], $_POST[def]);
			header('Location: index.php');
		}else if($prop[input] == "select"){
			$options_array = explode("~", $prop[value]);
	    	$lenght = count($options_array) - 1;
			$array = array();
			for($i=0; $i<$lenght; ++$i){
				if($_POST["op$i"]) $array[] = $options_array[$i];
			}
			$api->edit_filter($_GET[name], $STAFF[id], $array);
			header('Location: index.php');
		}
	break;
}
$codes = $api->get_codes('admin/staff/action.php', false);
foreach($codes as $code){
	include("../../plugins/$code");
}
?>