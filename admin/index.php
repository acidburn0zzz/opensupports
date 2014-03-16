<?php
session_start();
if($_SESSION[TYPE] == "staff") header('Location: staff/index.php');
else if($_SESSION[TYPE] == "admin") header('Location: admin_main.php?mode=home&submode=home');
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<?php include "admin_head.php"?>
<body>
<div id="main">
	<div id="header">
		<a href="index.php"><div id="headerlogo"></div></a>
	</div>
	<div id="middle">
    	<div id='loginboxesdiv'>
    		<form action="login.php?id=admin" method="post">
      			<div class="loginbox" id='adminloginbox'>
            	 <div class='loginbox-title'>Admin Login</div>            	 
             	 <div class="loginbox-field">
                		<input id="adminuser" onclick="erase('adminuser');" type="text" name="adminuser" class='loginbox-user' value='username'/>
              	 </div>
              	 <div class="loginbox-field">
                		<input id="adminpass" onclick="erase('adminpass');" type="password" name="adminpass" class='loginbox-pass' value='password'/>
              	 </div>
				
              	 <div class="loginbox-field">
                		<input type="submit" class="loginbox-button" value="LOG IN" />
                	</td>
            
            	 </div>
            	</div>
            </form>
            
            <form action="login.php?id=staff" method="post" >
            	<div class="loginbox" id='staffloginbox'>
            	 <div class='loginbox-title'>Staff Login</div>            	 
             	 <div class="loginbox-field">
                		<input id="staffuser" onclick="erase('staffuser');" type="text" name="staffuser" class='loginbox-user' value="username" />
              	 </div>
              	 <div class="loginbox-field">
                		<input id="staffpass" onclick="erase('staffpass');" type="password" name="staffpass" class='loginbox-pass' value='password' />
              	 </div>
				
              	 <div class="loginbox-field">
                		<input type="submit" class="loginbox-button" value="LOG IN" />
                	</td>
            
            	 </div>
            	</div>
           </form>
    	</div>
    </div>
</div>
</body>
</html>
