				<table class="listing">
					<tr>
						<th class="first"><?php echo $TEXT['Username'];?></th>
						<th><?php echo $TEXT['Email'];?></th>
					  <th class="last"><?php echo $TEXT['Manage'];?></th>
					</tr>
                    <?php
					$logsq = mysqli_num_rows($api->query("SELECT * FROM USERS ORDER BY id DESC"));
					if(isset($_GET[page]))$calc = $_GET[page]*20;
					else $calc=0;
					
                    $query = $api->query("SELECT * FROM USERS ORDER BY id DESC LIMIT $calc,20");
					
					while($user = mysqli_fetch_array($query)){
                    ?>
					<tr>
						<td class="first"><a href="index.php?mode=Users&submode=View&id=<?php echo $user[id];?>"><?php echo $user[name]; ?></a></td>
						<td><?php echo $user['email']; ?></td>
						<td class="last"><a href="index.php?mode=Users&submode=Edit&id=<?php echo $user[id];?>"><?php echo $TEXT['Edit'];?></a> | <a href="index.php?mode=Users&submode=Delete&id=<?php echo $user[id];?>"><?php echo $TEXT['Delete'];?></a></td>
					</tr>
                    <?php } ?>
				</table>
			<div class="pageselect">
					<span class="pageselect-title"><?php echo $TEXT['Page'];?>: </span>
			  <select id="selectpage" onchange="changepage()">
                    	<?php
							for($i=0;$i<($logsq/20);$i++){
							?>
                            <option <?php if($_GET[page] == $i) echo 'selected="selected"';?> value="<?php echo ($i+1);?>"><?php echo ($i+1);?></option>
                        <?php } ?>						
					</select>
		    </div>