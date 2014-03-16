<?php
if(isset($_GET['lang']) && strlen($_GET['lang']) == 2) $lang = filter_input(INPUT_GET, 'lang', FILTER_SANITIZE_SPECIAL_CHARS);
else $lang = 'en';

include ("../lang/" . $lang .".php");
?>
<html>
<head>
	<title>OpenSupports | Installation</title>
	<style media="all" type="text/css">@import "../admin/css/all.css";</style>
    <script>
    	function changelang(){
    		var selected = document.getElementById("langselect").value;
			window.location = "index.php?lang="+selected;
    	}
    </script>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
</head>
<body>
<div id="main">
	<div id="header">
		<div id="headerlogo"></div>
	</div>
		<div id='installdiv' align="center">
		<form action="install.php" method="get">
		 	 <table class="formtable">
		 	 	<tr>
		 	 		<td class="tdtext">
						<?php echo $TEXT['Default Language'];?>
					</td>
					<td class="tdform">
						<select name='langselect' id="langselect" class="input-select" onchange="changelang();">
							<option value="en" <?php if($lang == 'en') echo 'selected'; ?>>English</option>
							<option value="es" <?php if($lang == 'es') echo 'selected'; ?>>Español</option>
							<option value="de" <?php if($lang == 'de') echo 'selected'; ?>>Deutsch</option>
							<option value="tr" <?php if($lang == 'tr') echo 'selected'; ?>>Türk</option>
							<option value="ru" <?php if($lang == 'ru') echo 'selected'; ?>>Pусский</option>
							<option value="zh" <?php if($lang == 'zh') echo 'selected'; ?>>中文</option>
						</select>
					</td>
				</tr>
				<tr>
		 	 		<td class="tdtext">
						MySQL Server
					</td>
					<td class="tdform">
						<input type='text' class='input-text' value='localhost' name='sql-server'>
					</td>
				</tr>
				<tr>
					<td class="tdtext">
						MySQL <?php echo $TEXT['Username']; ?>
					</td>
					<td class="tdform">
						<input type='text' class='input-text' name='sql-username'>
					</td>
				</tr>
				<tr>
					<td class="tdtext">
						MySQL <?php echo $TEXT['Password']; ?>
					</td>
					<td class="tdform">
						<input type='password' class="input-text" name='sql-password'>
					</td>
				</tr>
				<tr>
					<td class="tdtext">
						MySQL DataBase
					</td>
					<td class="tdform">
						<input type='text' class="input-text" name='sql-db'>
					</td>
				</tr>
				<tr>
					<td class="tdtext">
						Admin Username
					</td>
					<td class="tdform">
						<input type='text' class="input-text" name='admin-username'>
					</td>
				</tr>
				<tr>
					<td class="tdtext">
						Admin <?php echo $TEXT['Password']; ?>
					</td>
					<td class="tdform">
						<input type='password' class="input-text" name='admin-password'>
					</td>
				</tr>
				<tr>
					<td class="tdtext">
						<?php echo $TEXT['Title']; ?>
					</td>
					<td class="tdform">
						<input type='text' class='input-text' value='My Support Center' name='set-title'>
					</td>
				</tr>
				<tr>
					<td class="tdtext">
						<?php echo $TEXT['Email']; ?>
					</td>
					<td class="tdform">
						<input type='text' class='input-text' value='noreply@yoursite.com' name='set-email'>
					</td>
				</tr>
				<tr>
					<td class="tdtext">
						<?php echo $TEXT['Users system']; ?>
					</td>
					<td class="tdform">
						<input type='checkbox' class='input-checkbox2' checked="checked" name='set-usersystem'>
					</td>
				</tr>
				<tr>
					<td class="tdtext">
						<?php echo $TEXT['Users can register']; ?>
					</td>
					<td class="tdform">
						<input type='checkbox' class='input-checkbox2' checked="checked" name='set-registration'>
					</td>
				</tr>
				<tr>
					<td class="tdtext">
						<?php echo $TEXT['Supported Languages']; ?>
					</td>
					<td class="tdform">
						<input type='checkbox' class='input-checkbox' name='langs-en' <?php if($lang == 'en') echo 'checked'; ?>>English<br>
						<input type='checkbox' class='input-checkbox' name='langs-es' <?php if($lang == 'es') echo 'checked'; ?>>Spanish<br>
						<input type='checkbox' class='input-checkbox' name='langs-de' <?php if($lang == 'de') echo 'checked'; ?>>German<br>
						<input type='checkbox' class='input-checkbox' name='langs-tr' <?php if($lang == 'tr') echo 'checked'; ?>>Turkish<br>
						<input type='checkbox' class='input-checkbox' name='langs-ru' <?php if($lang == 'ru') echo 'checked'; ?>>Russian<br>
						<input type='checkbox' class='input-checkbox' name='langs-zh' <?php if($lang == 'zh') echo 'checked'; ?>>Chinese<br>
					</td>
				</tr>
				<tr>
					<td class="tdform" colspan="2">
						<input type="submit" class="button" value="Install">
					</td>
				</tr>
			 </table>
		</form>
		</div>
    </div>
</body>
</html>