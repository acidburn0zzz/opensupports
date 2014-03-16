<table id="themestable" width="256" height="91" border="1" bordercolor="#0066CC">
          <tr>
          <td width="246">
          <form action="action.php?id=changetheme" method="post">
          <table class="formtable" width="259" height="83" border="0">
            <tr>
                <td class="tdtext" colspan="2"><?php echo $TEXT['Change theme'];?></td>
                </tr>
              <tr>
                <td class="tdform" width="176">
                <select class="input-select" name="default" id="default">
                <?php
				$rute = "../themes/";
				if (is_dir($rute)) { 
   				   if ($dh = opendir($rute)) { 
       				  while (($file = readdir($dh)) !== false) { 
            			if (is_dir($rute . $file) && $file!="." && $file!=".."){ 
							if($file != $DATA[theme])
               					echo '<option value="'.$file.'">'.$file.'</option>';
							else
								echo '<option selected="selected" value="'.$file.'">'.$file.'</option>';
            			} 
         			} 
      			closedir($dh); 
      			} 
   			   }
			   ?>
               </select>
                </td>
                <td class="tdform" width="73"><input type="submit" class="button" value="<?php echo $TEXT['Submit'];?>"></td>
              </tr>
          </table>
          </form>
          </td>
          <td width="231">
          <form action="action.php?id=newtheme" method="post" enctype="multipart/form-data">
          <table class="formtable" width="259" height="83" border="0">
            <tr>
                <td class="tdtext"><?php echo $TEXT['Install new theme'];?></td>
                </tr>
              <tr>
                <td class="tdform">
                <input class="input-file" type="file" name="zip_file" id="zip_file" accept="application/x-zip-compressed"/>
                <input class="button" type="submit" value="<?php echo $TEXT['Submit'];?>">
                </td>
              </tr>
          </table>
          </form>
          </td>
  </tr>
</table>