<?php
require "controller.php";
if($_GET[mode] == 'staffuser'){
$staff = $api->get_staff($_GET[id]);
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<?php include "admin_head.php";?>
<body>
<?php
$codes = $api->get_codes('admin/admin_main.php', true);
foreach($codes as $code){
	include("../plugins/$code");
}
?>
<div id="main">
	<?php include "admin_topbar.php";?>
	<div id="middle">
		<?php
		switch($_GET['mode']){
		case 'settings':
			include "admin_settings_menu.php";
		break;
		case 'home':
			include "admin_home_menu.php";
		break;
		case 'plugins':
			include "admin_plugins_menu.php";
		break;
		case 'staff':
			include "admin_staff_menu.php";
		break;
		case 'staffuser':
			include "admin_staff_user_menu.php";
		break;
		}
		?>
	  <div class='principal'>
		<?php if($_GET[submode] != 'staffsure' && $_GET[submode] != 'editfilter' && $_GET[submode] != 'settingsure' && $_GET[submode] != 'success' && !isset($_GET[deleteid]) && !isset($_GET[modeid]))include "admin_titlebar.php"; ?>
		<div class="content">
          <?php
		  if(isset($_GET['error'])) include "admin_error.php";
		  if(isset($_GET['success'])) include "admin_success.php";
		  switch($_GET[submode]){
		  	  case 'home':
				  include "admin_home.php";
			  break;
			  case 'about':
			  	include "admin_settings.php";
			  break;
			  case 'generalsettings':
			  	include "admin_settings_general.php";
			  break;
			  case 'departments':
			  	include "admin_settings_departments.php";
			  break;
			  case 'langs':
			  	include "admin_settings_langs.php";
			  break;
			  case 'themes':
			  	include "admin_settings_themes.php";
			  break;
			  case 'codeeditor':
			  	include "admin_settings_editor.php";
			  break;
			  case 'settingsure':
			  	include "admin_settings_sure.php";
			  break;
			  case 'logs':
			  	include "admin_home_logs.php";
			  break;
			  case 'mmail':
			  	include "admin_home_mmail.php";
			  break;
			  case 'liststaff':
			  	include "admin_staff.php";
			  break;
			  case 'newstaff':
			  	include "admin_newstaff.php";
			  break;
			  case 'staffdetails':
			  	include "admin_staff_user_details.php";
			  break;
			  case 'stafflogs':
			  	include "admin_staff_user_logs.php";
			  break;
			  case 'staffticket':
			  	include "admin_staff_user_ticket.php";
			  break;
			  case 'staffedit':
			  	include "admin_staff_user_edit.php";
			  break;
			  case 'staffviewticket':
			  	include "admin_staff_user_viewticket.php";
			  break;
			  case 'staffsure':
			  	include "admin_staff_user_sure.php";
			  break;
			  case 'properties':
			  	include "admin_settings_properties.php";
			  break;
			  case 'newfilter':
			  	include "admin_settings_newfilter.php";
			  break;
			  case 'editfilter':
			  	include "admin_settings_editfilter.php";
			  break;
			  case 'newproperty':
			  	include "admin_settings_newproperty.php";
			  break;
			  case 'editproperty':
			  	include "admin_settings_editproperty.php";
			  break;
			  case 'responses':
			  	include "admin_staff_responses.php";
			  break;
			  case 'update':
			  	include "admin_settings_update.php";
		      break;
			  case 'listplugins':
			  	include "admin_plugins_list.php";
			  break;
			  case 'installplugins':
			  	include "admin_plugins_install.php";
			  break;
			  case 'extramode':
				$mode = $api->get_mode($_GET[modeid]);
				$mode_plugin = $mode[plugin];
				$mode_file = $mode[file];
				if($mode[route] == "admin/". $_GET[mode] && file_exists("../plugins/$mode_plugin/$mode_file"))
					include "../plugins/$mode_plugin/$mode_file";
			  break;
		  }
          ?>
        </div>        
	  </div>
	</div>
</div>
<?php
$codes = $api->get_codes('admin/admin_main.php', false);
foreach($codes as $code){
	include("../plugins/$code");
}
?>
</body>
</html>