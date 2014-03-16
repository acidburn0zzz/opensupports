<div class="sucessmessage"><?php echo $TEXT['Successful operation'];?></div>
<?php
      switch($_GET[id]){
		  case 'newstaff':
		  $user_str = $api->sql_escape($_GET[user]);
		  $query = $api->query("SELECT * FROM STAFF WHERE user='$user_str'");
		  $reg = mysqli_fetch_array(mysqli_query($conexion, $query));
?>
          <table class="listing">
			    <tr>
			      <th class="first" width="212"><?php echo $TEXT['Full Name'];?></th>
		         <td align="left"><?php echo $reg[name]?></td>
                </tr>
                <tr>
			      <th class="first" width="212"><?php echo $TEXT['Username'];?></th>
		         <td align="left"><?php echo $reg[user]?></td>
                </tr>
                <tr>
			      <th class="first" width="212"><?php echo $TEXT['Email'];?></th>
		         <td align="left"><?php echo $reg[email]?></td>
                </tr>
	      </table>
<?php
		  break;
	  }
a?>