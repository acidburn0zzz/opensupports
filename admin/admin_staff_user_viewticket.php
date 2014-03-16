<?php 
$ticket = $api->get_ticket($_GET[ticket]);
?>
<table width="623" class="listing">
			    <tr>
			      <th class="first" width="109"><?php echo $TEXT['Title'];?></th>
		         <td width="225" align="left"><?php echo $ticket['title'];?></td>
		         <th width="93" align="center" class="first"><?php echo $TEXT['Date'];?></th>
		         <td width="184" align="left"><?php echo $ticket['title'];?></td>
                </tr>
                <tr>
			      <th class="first" width="109"><?php echo $TEXT['Author'];?></th>
		         <td align="left"><?php
				 if(!$DATA[login]){
					 echo $ticket['userid'];
				}
				else{
					$q = $api->get_user_by_id($ticket[userid]);
					echo $q[name];
				}
				 ?></td>
		         <th align="center" class="first"><?php echo $TEXT['Department'];?></th>
		         <td align="left"><?php echo $ticket[department];?></td>
                </tr>
          </table>
      <table width="340" height="62" class="listing">
        <tr>
          <th class="first" width="140"><?php
				 if(!$DATA[login]){
					 echo $ticket['userid'];
				}
				else{
					echo $q[name];				
				}
				 ?></th>
          <td width="471" rowspan="2" align="left"><?php echo $ticket[content]?></td>
        </tr>
        <tr>
          <th class="first" width="140"><?php echo  $ticket['date'];?></th>
        </tr>
      </table>
      <table width="340" height="62" class="listing">
      <?php
	  $query = $api->get_comments($ticket[id]);
	  while($com = mysqli_fetch_array($query)){
      ?>
        <tr>
          <th class="first" width="140"><?php
				echo $com[username];
				 ?></th>
          <td width="471" rowspan="2" align="left"><?php echo $com[content]?></td>
        </tr>
        <tr>
          <th class="first" width="140"><?php echo  $com['date'];?></th>
        </tr>
        <?php } ?>
      </table>