<table class="listing">
			    <tr>
			      <th class="first" ><?php echo $TEXT['Full Name'];?></th>
		         <td><?php echo $staff[name];?></td>
                </tr>
                <tr>
			      <th class="first" ><?php echo $TEXT['Email'];?></th>
		         <td><?php echo $staff[email];?></td>
                </tr>
                <tr>
			      <th class="first" ><?php echo $TEXT['Username'];?></th>
		         <td><?php echo $staff[user];?></td>
                </tr>
                <tr>
			      <th class="first" ><?php echo $TEXT['Tickets'];?></th>
		         <td><?php echo $staff[tickets];?></td>
                </tr>
                <tr>
			      <th class="first" ><?php echo $TEXT['Departments'];?></th>
		         <td><?php echo $staff[departments];?></td>
                </tr>
                <tr>
			      <th class="first" ><?php echo $TEXT['Languages'];?></th>
		         <td><?php echo $staff[langs];?></td>
                </tr>
                <tr>
			      <th class="first" ><?php echo $TEXT['Can Manage Users'];?></th>
		         <td><?php echo $staff[manage];?></td>
                </tr>
                <tr>
			      <th class="first" ><?php echo $TEXT['Can Create Docs'];?></th>
		         <td><?php echo $staff[docs];?></td>
                </tr>
                <tr>
			      <th class="first" colspan="2" style="text-align:center"><?php echo $TEXT['Properties'];?></th>
                </tr>
                <?php
				$query = $api->get_extra('propertystaff', 'toid', $staff[id]);
                while($prop = mysqli_fetch_array($query)){
				?>
                <tr>
			     <th class="first" ><?php echo $prop[name];?></th>
		         <td><?php echo $prop[value];?></td>
                </tr>
                <?php } ?>
                <tr>
			      <th class="first" colspan="2" style="text-align:center"><?php echo $TEXT['Filters'];?></th>
                </tr>
				<?php
				$query = $api->get_extra('filter', 'toid', $staff[id]);
                while($filter = mysqli_fetch_array($query)){
				?>
                <tr>
			     <th class="first"><?php echo $filter[name];?></th>
		         <td><?php echo $filter[value];?></td>
                </tr>
                <?php } ?>
	      </table>