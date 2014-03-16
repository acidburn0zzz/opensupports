<?php
require "controller.php";
include "permissions.php";
?>
<html>
<?php include "head.php"; ?>
<body>
<?php
$codes = $api->get_codes('admin/staff/index.php', true);
foreach($codes as $code){
	include("../../plugins/$code");
}
?>
<div id="main">
	<?php include "header_menu.php"; ?>
	<div id="middle">
		<div id="left-column">
            <div id='loggedas'>
            Logged as: <span class="staffname"><?php echo $STAFF[name];?></span><br>
            </div>
        	<?php
			switch ($_GET[mode]){
			  case 'Tickets':
				include "menu_tickets.php";
			  break;
			  case 'ViewTickets':
				include "menu_tickets.php";
			  break;
			  case 'Users':
			  	if(isset($_GET[submode])) include "menu_user.php";
			  break;
			  case 'Docs':
			  	include "menu_docs.php";
			  break;
			}
            ?>
		</div>
		<div id="center-column">
		  <?php include "toptitle.php";?>
		  <div class="content">
		  <?php
		  switch ($_GET[mode]){
			case 'Tickets':
				if(isset($_GET[submode])) include "main_tickets.php";
			break;
			case 'ViewTickets':
				if(isset($_GET[submode])) include "main_viewtickets.php";
			break;
			case 'Users':
			  	if(!isset($_GET[submode])) include "main_users.php";
				elseif($_GET[submode] == "View") include "main_viewuser.php";
				elseif($_GET[submode] == "Edit") include "main_edituser.php";
				elseif($_GET[submode] == "Delete") include "main_deleteuser.php";
			break;
			case 'Docs':
				if($_GET[submode] == "Create") include "main_createdoc.php";
				else if($_GET[submode] == "Edit") include "main_editdoc.php";
				else if($_GET[submode] == "View") include "main_viewdoc.php";
				else if($_GET[submode] == "Delete") include "main_deletedoc.php";
				else include "main_listdocs.php";
			break;
			case 'extramode':
				$mode_plugin = $mode[plugin];
				$mode_file = $mode[file];
				if($mode[route] == "staff" && file_exists("../../plugins/$mode_plugin/$mode_file"))
					include "../../plugins/$mode_plugin/$mode_file";
				else echo "no";
			break;
			default:
				include "main_home.php";
			break;
		  }
          ?>
          </div>
		</div>
	</div>
</div>
<?php
$codes = $api->get_codes('admin/staff/index.php', false);
foreach($codes as $code){
	include("../../plugins/$code");
}
?>
</body>
</html>