<table class="listing" id='propertieslist'>
			    <tr>
			      <th class="first"><?php echo $TEXT['Property'];?></th>
			      <th><?php echo $TEXT['Default'];?></th>
                  <th><?php echo $TEXT['Type'];?></th>
                  <th><?php echo $TEXT['Is editable'];?></th>
                  <th><?php echo $TEXT['Plugin'];?></th>
                  <th class="last"><?php echo $TEXT['Is Filter'];?></th>
		        </tr>
                <?php
				$query = $api->query("SELECT * FROM PROPERTIES");
				while($reg = mysqli_fetch_array($query)){
                ?>
			    <tr>
			      <td class="first"><a href="admin_main.php?mode=settings&submode=editproperty&id=<?php echo $reg[id];?>"><?php echo $reg[name];?></a></td>
				  <td><?php echo $reg[value];?></td>
				  <td><?php echo $reg[type];?></td>
                  <td><?php echo ($reg[edit]) ? $TEXT['Yes'] : $TEXT['No'];?></td>
                  <td><?php echo $reg[plugin];?></td>
                  <td><?php 
				  	  if(($reg[input] == "checkbox" || $reg[input] == "select") && $reg[type] != "staff"){
				  	  if($reg[filter]){
						  ?>
						  <a href="admin_main.php?mode=settings&submode=editfilter&id=<?php echo $reg[id];?>"><?php echo $TEXT['Delete']; ?></a>
                      <?php
					  }else{
					  ?>
						  <a href="admin_main.php?mode=settings&submode=newfilter&id=<?php echo $reg[id];?>"><?php echo $TEXT['No']; ?></a>
                       <?php
                          }
					  }
						?>
                      </td>
		        </tr>
                <?php } ?>
</table>
<br>
<a href="admin_main.php?mode=settings&submode=newproperty" class="subbutton"><?php echo $TEXT['Add a new property'];?></a>


