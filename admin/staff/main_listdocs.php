				<table class="listing">
					<tr>
						<th class="first" width="177"><?php echo $TEXT['Title'];?></th>
						<th><?php echo $TEXT['Written By'];?></th>
					  <th class="last"><?php echo $TEXT['Date'];?></th>
					</tr>
                    <?php
					$logsq = mysqli_num_rows($api->get_docs());
					if(isset($_GET[page]))$calc = $_GET[page]*20;
					else $calc=0;
					
                    $query = $api->query("SELECT * FROM DOCS ORDER BY id DESC LIMIT $calc,20");
					
					while($doc = mysqli_fetch_array($query)){
                    ?>
					<tr>
						<td><a href="index.php?mode=Docs&submode=View&id=<?php echo $doc[id];?>"><?php echo $doc[title]; ?></a></td>
						<td><?php echo $doc['by']; ?></td>
						<td class="last"><?php echo $doc['date'];?></td>
					</tr>
                    <?php } ?>
				</table>
			<div class="pageselect">
					<span class="pageselect-title"><?php echo $TEXT['Page'];?>: </span>
			  <select class="input-select" id="selectpage" onchange="changepage()">
                    	<?php
							for($i=0;$i<($logsq/20);$i++){
							?>
                            <option <?php if($_GET[page] == $i) echo 'selected="selected"';?> value="<?php echo ($i+1);?>"><?php echo ($i+1);?></option>
                        <?php } ?>						
					</select>
		    </div>