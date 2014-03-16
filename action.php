<?php
include 'controller.php';
$codes = $api->get_codes('action.php', true);
foreach($codes as $code){
	include("plugins/$code");
}
switch($_GET[id]){
case 'login':
 $result = $api->login($_POST['l-email'],$_POST['l-pass']);
 if(!$result){
	 header('Location: index.php');
	 exit;
 }
 else{
	 $_SESSION[EMAIL] = $result[email];
	 $_SESSION[NAME] = $result[name];
	 $_SESSION[ID] = $result[id];
	 $_SESSION[TYPE] = "user";
	 header('Location: upanel.php');
	 exit;
 }
break;

case 'editemail':
 $email = $_POST['e-email'];
 if(!$api->validate_email($email)){
	header('Location: upanel.php?id=error&why=email&url=upanel.php?id=edit');
	exit;
 }
 $api->update_user_email($_SESSION[ID], $email);
 $api->mailto($_SESSION[EMAIL], $TEXT['Email Update'],$TEXT['Your email has been updated to'] . ": $email");
 $_SESSION[EMAIL] = $email;
 header('Location: upanel.php?id=success&url=upanel.php?id=edit');
break;

case 'editpass':
	$pass = $_POST['e-pass'];
	$pass2 = $_POST['e-pass2'];
	
	if(strlen($pass) < 6){
		header('Location: upanel.php?id=error&why=pass&url=upanel.php?id=edit');
		exit;
	}
	if($pass != $pass2){
		header('Location: upanel.php?id=error&why=rpass&url=upanel.php?id=edit');
		exit;
	}
	
	if(!$api->update_user_password($_SESSION[ID], $pass)){
		header('Location: upanel.php?id=error&why=pass&url=upanel.php?id=edit');
		exit;
	}
	$ms = $TEXT['Your password has been updated to'] .": ".$pass;
	$api->mailto($_SESSION[EMAIL], $TEXT['Password Update'],$ms);
	$_SESSION[PASS] = $pass;
	header('Location: upanel.php?id=success&url=upanel.php?id=edit');
break;

case 'new':
		$result = true;
		if(!$DATA['login'] && $DATA['recaptcha'] != "") $result = recaptcha();
		if(!$result){
			header('Location: index.php?mode=error&why=captcha&url=index.php?id=create_ticket');
			exit;
		}
		
		$properties_array = array();
		
		$query = $api->get_properties("tickets");
		while($reg = mysqli_fetch_array($query)){
			$properties_array["$reg[name]"] = $_POST["provalue-$reg[name]"];
		}
		
 		if($DATA['login']) $result = $api->new_ticket($_POST['n-department'], $_POST['n-lang'], $_POST['n-title'], $_POST['n-message'],  $_SESSION[EMAIL], $_SESSION[NAME], $_SESSION[ID],$properties_array);
 		else $result = $api->new_ticket($_POST['n-department'], $_POST['n-lang'], $_POST['n-title'], $_POST['n-message'], $_POST['n-email'], $_POST['n-name'],$_POST['n-name'],$properties_array);
		
		if($result != false){
			if(!$DATA['login']){
				$url="http://".$_SERVER['HTTP_HOST'].$_SERVER['PHP_SELF'];
				$url = dirname($url);
				$url .= "/index.php?mode=view_ticket&ticketid=".$result[id]."&email=$email";
				$ms = $TEXT['Mail:4'] . $url;
				$email = $_POST['n-email'];
			}
			else{
				$url="http://".$_SERVER['HTTP_HOST'].$_SERVER['PHP_SELF'];
				$url = dirname($url);
				$url .= "/index.php";
				$ms = $TEXT['Mail:5'] . $url;
				$email = $_SESSION[EMAIL];
			}
			$api->mailto($email, $TEXT['New Ticket'],$ms);
		}
		($DATA['login']) ? header('Location: upanel.php') : header('Location: index.php');
		exit;	
break;
case 'newuser':
	$properties_array = array();
	
	$query = $api->get_properties("user");
	while($reg = mysqli_fetch_array($query)){
		$provalue = str_replace(" ", "_", "$reg[name]");
		$properties_array[$provalue] = $_POST["provalue-$provalue"];
	}
	
	if($api->get_user('email', $_POST['n-email'])){
		header('Location: index.php?mode=error&why=email&url=index.php?mode=create_user');
		exit;
	}
	elseif(!$api->validate_email($_POST['n-email'])){
		header('Location: index.php?mode=error&why=email&url=index.php?mode=create_user');
		exit;
	}
	elseif($_POST['n-pass'] != $_POST['n-rpass']){
		header('Location: index.php?mode=error&why=pass&url=index.php?mode=create_user');
		exit;
	}
	elseif(strlen($_POST['n-pass']) < 6){
		header('Location: index.php?mode=error&why=rpass&url=index.php?mode=create_user');
		exit;
	}
	
	if(!$api->new_user($_POST['n-name'], $_POST['n-email'], $_POST['n-pass'], $_POST['n-rpass'], $properties_array)){
		header('Location: index.php?mode=error&url=index.php?mode=create_user');
		exit;
	}
	
	$url="http://".$_SERVER['HTTP_HOST'].$_SERVER['PHP_SELF'];
	$url = dirname($url);
	$url .= "/index.php";
	$ms = $TEXT['Mail:6'] . $url . "\n\n" . $TEXT['Your username'] . ": ".$_POST['n-email']."\n" . $TEXT['Your Password']. ": ".$_POST['n-pass']."\n";
	$api->mailto($_POST['n-email'], $TEXT['Welcome'], $ms);
	
	header('Location: index.php?mode=success&url=index.php');
break;
case 'response':
	if($DATA[login]){
		$api->new_comment($_GET['ticketid'],$_POST['textresponse'],$_SESSION[ID],$_SESSION[NAME]);
		header("Location: upanel.php?id=ticket&ticket=$_GET[ticketid]");
	}else{
		$api->new_comment($_GET['ticketid'],$_POST['textresponse'],$_POST[email],$_POST[userid]);
		header("Location: index.php?mode=view_ticket&ticketid='.$_GET[ticketid].'&email='.$_POST[email]");
	}
break;
case 'property':
	$name = $_GET[name];
	$provalue = str_replace(" ", "_", "provalue-$name");
	$value = $_POST[$provalue];
	$api->update_user_property($_SESSION[ID], $name, $value);
	header('Location: upanel.php?id=edit');
break;
}

$codes = $api->get_codes('action.php', false);
foreach($codes as $code){
	include("plugins/$code");
}
?>