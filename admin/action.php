<?php
require "controller.php";

$codes = $api->get_codes('admin/action.php', true);
foreach($codes as $code){
	include("../plugins/$code");
}

switch($_GET[id]){
	case 'newstaff':
		if(strlen($_POST['name']) < 4){
			header('Location: admin_main.php?mode=staff&submode=newstaff&error=name');
			exit;
		}//Verify name
		if(!$api->validate_email($_POST['email'])){
			header('Location: admin_main.php?mode=staff&submode=newstaff&error=email'); //Verify email
			exit;
		}
		
		/*Create Departments' array*/
		$select_dep = $api->get_departments();
		$array1 = array();
		while($dep = mysqli_fetch_array($select_dep)){
			if($_POST["d".$dep[id]]) $array1[] = $dep[name]; 
		}
		
		/*Create Langs' array*/
		$select_lang = $api->get_langs(true);
		$array2 = array();
		while($lang = mysqli_fetch_array($select_lang)){
			if($_POST[$lang[short]]) $array2[] = $lang[short]; 
		}		
		
		/*Create properties */
		$properties_array = array();
	
		$query = $api->get_properties("staff");
		while($reg = mysqli_fetch_array($query)){
			$provalue = str_replace(" ", "_", "$reg[name]");
			$properties_array[$provalue] = $_POST["provalue-$provalue"];
		}
		/*Create Filters*/
		$filters_array = array();
		$query = $api->query("SELECT * FROM PROPERTIES WHERE filter='1'");
		while($filter = mysqli_fetch_array($query)){
			if($filter[input] == "checkbox"){
				$filters_array["$filter[id]"] = $_POST["filter-$filter[id]"];
			}
			else if($filter[input] == "select"){
				$options_array = explode("~", $filter[value]);
	    		$lenght = count($options_array) - 1;
				$string = "";
				for($i=0; $i<$lenght; ++$i){
					if($_POST["filter-$filter[id]-op$i"]) $filters_array["$filter[id]-op$i"] = true;
					else $filters_array["$filter[id]-op$i"] = false;
				}			
			}
		}
		$staff = $api->new_staff($_POST['name'], $_POST['email'],$_POST['manage-users'],$_POST['manage-docs'], $array1, $array2, $properties_array, $filters_array);
		/*Send Email to Staff Member*/
		$url="http://".$_SERVER['HTTP_HOST'].$_SERVER['PHP_SELF'];
		$url = dirname($url);
		$url .= "/index.php";
		$ms = $TEXT["Mail:1"] .$DATA[title]." - ".$TEXT['Support Center'].".\n\n" . $TEXT['Your username'].": ".$staff[username]."\n".$TEXT['Your Password'].": ".$staff[password]."\n".$url;
		$api->mailto($_POST[email],$TEXT['Staff Details'],$ms);
		
		/*Create new log*/
		$api->logs($TEXT['New Staff user created'].": #".$staff[id]);
		header('Location: admin_main.php?mode=staffuser&submode=staffdetails&id='.$staff[id].'&success=newstaff');
	break;
	case 'editstaff':
		if(strlen($_POST['name']) < 4){
			header("Location: admin_main.php?mode=staffuser&submode=staffedit&id=$_POST[staffid]&error=name"); //Verify name
			exit;
		}
		if(!$api->validate_email($_POST['email'])){
			header("Location: admin_main.php?mode=staffuser&submode=staffedit&id=$_POST[staffid]&error=email"); //Verify email
			exit;
		}
		if($_POST['manage-users'] == true) $musers=1; //Can Manage Users?
		else $musers=0;
		if($_POST['manage-docs'] == true) $mdocs=1; //Can Create Docs?
		else $mdocs=0;
		/*Create Departments' string*/
		$select_dep = $api->get_departments();
		$dstring = "";
		while($dep = mysqli_fetch_array($select_dep)){
			if($_POST["d".$dep[id]]) $dstring .= $dep[name].", "; 
		}
		if(strlen($dstring) > 2) $dstring = substr($dstring, 0, -2);
		/*Create Langs' string*/
		$select_lang = $api->get_langs(true);
		$dlang = "";
		while($lang = mysqli_fetch_array($select_lang)){
			if($_POST[$lang[short]]) $dlang .= $lang[short].","; 
		}
		if(strlen($dlang) > 2) $dlang = substr($dlang, 0, -1);
		$staff = $api->get_staff($_POST['staffid']);
		/*Update user settings*/
		$api->update_staff($_POST['staffid'], 'name', $_POST['name']);
		$api->update_staff($_POST['staffid'], 'email', $_POST['email']);
		if(strlen($_POST[password]) > 0){
			$hash = crypt($_POST[password]);
			$api->update_staff($_POST['staffid'], 'pass', $hash);
		}
		$api->update_staff($_POST['staffid'], 'manage', $musers);
		$api->update_staff($_POST['staffid'], 'docs', $mdocs);
		$api->update_staff($_POST['staffid'], 'departments', $dstring);
		$api->update_staff($_POST['staffid'], 'langs', $dlang);
				
		/*Send Email to Staff Member*/
		$place = $dstring = substr($_SERVER["REQUEST_URI"], 0, -22);
		$query = sprintf("SELECT * FROM STAFF WHERE id='%s'",$api->sql_escape($_POST['staffid']));
		$staff = mysqli_fetch_array($api->query($query));
		$url="http://".$_SERVER['HTTP_HOST'].$_SERVER['PHP_SELF'];
		$url = dirname($url);
		$ms = $TEXT['Mail:2'] . $url . "\n\n". $TEXT['Your username'].": ". $staff[user];
		if(strlen($_POST[password])>0)
			$ms .= "\n".$TEXT['Your Password'] . ": ". $_POST[password];
		
		$api->mailto($staff[email],$TEXT['Staff Details'],$ms);
		/* Create new log */
		$api->logs($TEXT['Staff user updated'].": #".$staff[id]);
		header('Location: admin_main.php?mode=staffuser&submode=staffdetails&id='.$staff[id].'&success=staffupdated');
	break;
	case 'delete':
		$api->delete_staff($_GET[staffid]);
		$api->mailto($_POST[email],$TEXT['Staff Details'],$TEXT['Mail:7']);
		$api->logs($TEXT['Staff user deleted'].": #".$api->sql_escape($_GET[staffid]));
		header('Location: admin_main.php?mode=staff&submode=liststaff&success=staffdeleted');
	break;
	case 'titleset':
		if(strlen($_POST['title']) < 4){
			header('Location: admin_main.php?mode=settings&submode=generalsettings&error=title'); //Verify title
		exit;
		}
		$api->update_data('title', $_POST[title]);
		$api->logs($TEXT['Title has been updated']);
		header('Location: admin_main.php?mode=settings&submode=about&success=titleset');
	break;
	case 'emailset':
		if(strlen($_POST['email']) < 4){
			header('Location: admin_main.php?mode=settings&submode=generalsettings&error=email'); //Verify email
			exit;
		}
		$api->update_data('mainmail', $_POST[email]);
		$api->logs($TEXT['Main email has been updated']);
		header('Location: admin_main.php?mode=settings&submode=about&success=emailset');
	break;
	case 'system':
		$_POST['system'] == true ? $v=1 : $v=0;
		$api->update_data('login', $v);
		$_POST['register'] == true ? $v=1 : $v=0;
		$api->update_data('register', $v);
		$api->logs($TEXT['Users system has been updated']);
		header('Location: admin_main.php?mode=settings&submode=about&success=system');
	break;
	case 'dropusers':
		$api->drop_table("users");
		$api->logs($TEXT['Users table has been truncated']);
		header('Location: admin_main.php?mode=settings&submode=about&success=dropusers');
	break;
	case 'droptable':
		$api->drop_table("tickets");
		$api->logs($TEXT['Tickets table has been truncated']);
		header('Location: admin_main.php?mode=settings&submode=about&success=droptable');
	break;
	case 'backup':
		backup_tables();
	break;
	case 'newdep':
		$api->add_department($_POST[title]);
		$api->logs($TEXT['New department created']);
		header('Location: admin_main.php?mode=settings&submode=departments&success=newdep');
	break;
	case 'deletedep':
		$api->delete_department($_POST['delete']);
		$api->logs($TEXT['Department deleted'].": ".$api->sql_escape($_POST[delete]));
		header('Location: admin_main.php?mode=settings&submode=departments&success=deletedep');
	break;
	case 'langs':
		$query = $api->get_langs();
		while($l = mysqli_fetch_array($query)){
			if($_POST[$l[short]]) $api->query("UPDATE LANG SET supported='1' WHERE short='$l[short]'");
			else $api->query("UPDATE LANG SET supported='0' WHERE short='$l[short]'");
		}
		$api->logs($TEXT['Langs settings updated']);
		header('Location: admin_main.php?mode=settings&submode=langs&success=langs');
	break;
	case 'langdefault':
		$api->update_data('lang', $_POST['default']);
		$api->logs($TEXT['Langs settings updated']);
		header('Location: admin_main.php?mode=settings&submode=langs&success=langs');
	break;
	case 'changetheme':
		$api->update_data('theme', $_POST['default']);
		$api->logs($TEXT['Theme settings updated']);
		header('Location: admin_main.php?mode=settings&submode=themes&success=changetheme');
	break;
	case 'newtheme':
		$name_file = $_FILES['zip_file']['name']; 
		$type_file = $_FILES['zip_file']['type']; 
		$size_file = $_FILES['zip_file']['size']; 
   	if (!move_uploaded_file($_FILES['zip_file']['tmp_name'], $name_file)){ 
		header('Location: admin_main.php?mode=settings&submode=themes&error=changetheme');
		exit;
   	}
	$api->logs($TEXT['New theme uploaded']);
	$zip = new ZipArchive;
	$res = $zip->open($name_file);
	if ($res === TRUE) {
	$theme_name = explode(".", $name_file);
  	$zip->extractTo('../themes/'.$theme_name[0].'/');
  	$zip->close();
  	unlink($name_file);
	header('Location: admin_main.php?mode=settings&submode=themes&success=newtheme');
	} else {
	header('Location: admin_main.php?mode=settings&submode=themes&error=changetheme');
	}
	break;
	case 'newproperty':
	$name = $api->sql_escape($_POST[name]);
	if(mysqli_num_rows($api->query("SELECT * FROM PROPERTIES WHERE name='$name'")) > 0){
		header('Location: admin_main.php?mode=settings&submode=newproperty&error=propname');
		exit;
	}
	$edit = ($_POST[editable] == true) ? 1 : 0;
	if($_POST[inputtype] == "select"){
		$array = array();
		$str = "";
		for($i=1;$i<=$_POST[optn];++$i){
			if(strlen($_POST["op$i"]) > 0) $array[] = $_POST["op$i"];
		}
		$api->new_property($name, $edit, $_POST[type], $_POST[inputtype], $array, $filter, 'no');
	}else{
		$api->new_property($name, $edit, $_POST[type], $_POST[inputtype], $_POST[value], $filter, 'no');
	}
	
	$api->logs($TEXT['New property added']);
	header('Location: admin_main.php?mode=settings&submode=properties&success=newproperty');
	break;
	case 'editproperty':
		$id = (int) $_POST[propid];
		
		$prop = $api->get_property('id', $id);
		
		if($prop[input] == "select"){
			$str = "";
			$array = array();
			for($i=0;$i<=$_POST[optn];++$i){
				if(strlen($_POST["op$i"]) > 0) $array[] = $_POST["op$i"];
			}
			$api->edit_property($id, $_POST[name], $_POST[editable], $array);
		} else {
			$api->edit_property($id, $_POST[name], $_POST[editable], $_POST[value]);
		}
		$api->logs($TEXT['Property edited'] . ": #".$id);
		header('Location: admin_main.php?mode=settings&submode=editproperty&id='.$id.'&success=editprop');
	break;
	case 'deleteproperty':
		$id = (int) $_GET[propid];
		$api->delete_property($id);
		$api->logs($TEXT['Property has been deleted'] . " #$id");
		header('Location: admin_main.php?mode=settings&submode=properties&success=deleteprop');
	break;
	case 'newfilter':
		$id = (int) $_GET[filterid];
		$prop = $api->get_property('id', $id);
		if($prop[input] == "checkbox"){
			$def = $api->sql_escape($_POST[def]);			
		}elseif($prop[input] == "select"){
			$max = $_POST['max'];
			$options_array = explode("~", $prop[value]);
			$def = array();
			for($i=0; $i<$max; ++$i){
				if($_POST["op$i"]){
					$def[] = $options_array[$i];
				}
			}
		}
		$api->create_filter($id, $def, $_POST[iseditable]);
		$api->logs($TEXT['New filter created']);
		header("Location: admin_main.php?mode=settings&submode=properties&success=newfilter");
	break;
	case 'staffprop':
		$id = (int) $_GET[toid];
		$api->edit_staff_prop($_GET[name], $_GET[pvalue], $id);
		header("Location: admin_main.php?mode=staffuser&submode=staffedit&id=$id");
	break;
	case 'editfilter':
		$name = $api->sql_escape($_GET[name]);
		$id = $api->sql_escape($_GET[toid]);
		$query = $api->query("SELECT * FROM EXTRA WHERE name='$name' AND type='defaultfilter'");
		if(!$query){
			header("Location: admin_main.php?mode=staffuser&submode=staffedit&id=$id&error=filternotexist");
			exit;
		}
		
		$filter = mysqli_fetch_array($query);
		
		$prop = $api->get_property('name', $name);
		
		if($prop[input] == "checkbox"){
			$api->edit_filter($name, $id, $_POST[def]);
		}else if($prop[input] == "select"){
			$options_array = explode("~", $prop[value]);
	    	$lenght = count($options_array) - 1;
			$array = array();
			for($i=0; $i<$lenght; ++$i){
				if($_POST["op$i"]) $array[] = $options_array[$i];
			}
			$api->edit_filter($name, $id, $array);
		}
		header("Location: admin_main.php?mode=staffuser&submode=staffedit&id=$id");
	break;
	case 'deletefilter':
		$filterid = $_GET[filterid];
		$api->delete_filter($filterid);
		$api->logs($TEXT['Filter deleted'] . "#$filterid");
		header('Location: admin_main.php?mode=settings&submode=properties');
	break;
	case 'mmail':
		$title = $api->sql_escape($_POST[title]);
		$message = $api->sql_escape($_POST[content]);
		if($_POST[sendto] == "users"){
			if($DATA[login] != 1){
				header('Location: admin_main.php?mode=home&submode=mmail&error=nologin');
			}
			$query = $api->query("SELECT * FROM USERS");
		} else if($_POST[sendto] == "staff"){
			$query = $api->query("SELECT * FROM STAFF");
		}
		while($reg = mysqli_fetch_array($query)){
			$api->mailto($reg[email], $title, $message);
		}
		$api->logs($TEXT['Massive mail sent']);
		header('Location: admin_main.php?mode=home&submode=mmail&success=mmail');
	break;
	case 'langedit':
		$lang = $api->sql_escape($_POST[langedit]);
		$query = $api->query("SELECT * FROM TEXT WHERE type='text' AND lang='$lang'");
		while($reg = mysqli_fetch_array($query)){
			$content = $api->sql_escape($_POST["content$reg[id]"]);
			$api->text_edit($reg[name], $content, $lang);
		}
		$api->logs($TEXT['Text updated']);
		header('Location: admin_main.php?mode=settings&submode=langs&success=langedit');
	break;
	case 'response':
		if($_POST[editresponse] == 'new'){
		$response = $api->add_text($_POST[title], $_POST[content], 'response', $_POST[lang], 'no');
		header("Location: admin_main.php?mode=staff&submode=responses&responseid=$response[id]");
		}else{
		$id = (int) $_POST[editresponse];
		$title = $api->sql_escape($_POST[title]);
		$lang = $api->sql_escape($_POST[lang]);
		$content = $api->sql_escape($_POST[content]);
		
		$api->query("UPDATE TEXT SET name='$title' WHERE id='$id'");
		$api->query("UPDATE TEXT SET lang='$lang' WHERE id='$id'");
		$api->query("UPDATE TEXT SET value='$content' WHERE id='$id'");
		header("Location: admin_main.php?mode=staff&submode=responses&responseid=$id");
		}
	break;
	case 'update':
		$name_file = $_FILES['zip_file']['name']; 
		$type_file = $_FILES['zip_file']['type']; 
		$size_file = $_FILES['zip_file']['size']; 
 	  	if (!move_uploaded_file($_FILES['zip_file']['tmp_name'], $name_file)){ 
			header('Location: admin_main.php?mode=settings&submode=update&error=uploadfile');
			exit;
	   	}
		$zip = new ZipArchive;
		$res = $zip->open($name_file);
		if ($res === TRUE) {
	  		$zip->extractTo('../');
		  	$zip->close();
	  	unlink($name_file);
		require "update.php";
		unlink("update.php");
		header('Location: admin_main.php?mode=settings&submode=update&success=upgraded');
		exit;
		}
		else{
			header('Location: admin_main.php?mode=settings&submode=update&error=uploadfile');
		}
	break;
	case 'deleteplugin':
		$name = $api->sql_escape($_GET[plugin]);
		$api->query("DELETE FROM PLUGINS WHERE name='$name'");
		$api->query("DELETE FROM EXTRA WHERE plugin='$name'");
		$api->query("DELETE FROM PROPERTIES WHERE plugin='$name'");
		$api->query("DELETE FROM MODES WHERE plugin='$name'");
		$api->query("DELETE FROM CODE WHERE plugin='$name'");
		$api->query("DELETE FROM TEXT WHERE plugin='$name'");
		rrmdir("../plugins/$name");
		header('Location: admin_main.php?mode=plugins&submode=listplugins');
	break;
	case 'newplugin':
		$name_file = $_FILES['zip_file']['name']; 
		$type_file = $_FILES['zip_file']['type']; 
		$size_file = $_FILES['zip_file']['size']; 
   		if (!move_uploaded_file($_FILES['zip_file']['tmp_name'], $name_file)){ 
			header('Location: admin_main.php?mode=plugins&submode=installplugins&error=uploadfile');
			exit;
   		}
		
		$zip = new ZipArchive;
		$res = $zip->open($name_file);
		if ($res === TRUE) {
			$plugin_name = explode(".", $name_file);
			$isnew = true;
			if($api->get_plugin($plugin_name[0])) $isnew = false;
			
  			$zip->extractTo("../plugins/$plugin_name[0]/");
  			$zip->close();
  			unlink($name_file);
			if(file_exists('../plugins/'.$plugin_name[0].'/install.php') && $isnew){
				include('../plugins/'.$plugin_name[0].'/install.php');
				unlink('../plugins/'.$plugin_name[0].'/install.php');
				header('Location: admin_main.php?mode=plugins&submode=listplugins&success=newplugin');
			}elseif(file_exists('../plugins/'.$plugin_name[0].'/update.php') && !$isnew){
				include('../plugins/'.$plugin_name[0].'/update.php');
				unlink('../plugins/'.$plugin_name[0].'/update.php');
				header('Location: admin_main.php?mode=plugins&submode=listplugins&success=updateplugin');
			}
			else{
				if($isnew) header('Location: admin_main.php?mode=plugins&submode=listplugins&error=newplugin');
				else header('Location: admin_main.php?mode=plugins&submode=listplugins&error=updateplugin');
				exit;
			}
		} else {
			header('Location: admin_main.php?mode=plugins&submode=listplugins&error=uploadfile');
			exit;
		}
	$api->logs($TEXT['New plugin installed']);
	break;
	case 'maintenancemode':
		if($_POST[maintenance]){
			$api->update_data('maintenance', '1');
			header('Location: admin_main.php?mode=settings&submode=about&success=maintenanceon');
		}else{
			$api->update_data('maintenance', '0');
			header('Location: admin_main.php?mode=settings&submode=about&success=maintenanceoff');
		}
	break;
}

function email($email){
 if (!ereg("^([a-zA-Z0-9._]+)@([a-zA-Z0-9.-]+).([a-zA-Z]{2,4})$",$email)){ 
          return false; 
 } else { 
  if(strlen($email) < 6) return false;
  else return true; 
 } 
}

/* backup the db OR just a table */
function backup_tables($tables = '*')
{
	global $api;
	
	if($tables == '*')
	{
		$tables = array();
		$result = $api->query('SHOW TABLES');
		while($row = mysqli_fetch_row($result))
		{
			$tables[] = $row[0];
		}
	}
	else
	{
		$tables = is_array($tables) ? $tables : explode(',',$tables);
	}
	
	foreach($tables as $table)
	{
		$result = $api->query('SELECT * FROM '.$table);
		$num_fields = mysqli_num_fields($result);
		
		$return.= 'DROP TABLE '.$table.';';
		$row2 = mysqli_fetch_row($api->query('SHOW CREATE TABLE '.$table));
		$return.= "\n\n".$row2[1].";\n\n";
		
		for ($i = 0; $i < $num_fields; $i++) 
		{
			while($row = mysqli_fetch_row($result))
			{
				$return.= 'INSERT INTO '.$table.' VALUES(';
				for($j=0; $j<$num_fields; $j++) 
				{
					$row[$j] = addslashes($row[$j]);
					$row[$j] = ereg_replace("\n","\\n",$row[$j]);
					if (isset($row[$j])) { $return.= '"'.$row[$j].'"' ; } else { $return.= '""'; }
					if ($j<($num_fields-1)) { $return.= ','; }
				}
				$return.= ");\n";
			}
		}
		$return.="\n\n\n";
	}
	download($return,"database.sql");
}

function rrmdir($dir) {
   if (is_dir($dir)) {
     $objects = scandir($dir);
     foreach ($objects as $object) {
       if ($object != "." && $object != "..") {
         if (filetype($dir."/".$object) == "dir"){
         	if(count(scandir($dir."/".$object)) > 2) rrmdir($dir."/".$object);
			else rmdir($dir."/".$object);
		 }else unlink($dir."/".$object);
       }
     }
     reset($objects);
     rmdir($dir);
   }
}
$codes = $api->get_codes('admin/action.php', false);
foreach($codes as $code){
	include("../plugins/$code");
}
?>