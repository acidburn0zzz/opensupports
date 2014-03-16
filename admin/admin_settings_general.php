<table id="generalstable">
          <tr>
          	<td>
          	<form action="action.php?id=system" method="post">
          	<table class="formtable" align="center" border="0">
          	  <tr>
                <td class="tdtext"><?php echo $TEXT['Users system']; ?><br><span class='extracomment'>*<?php echo $TEXT['Recommend drop'];?></span></td>
                <td class="tdform"><input type="checkbox" class="input-checkbox2" name="system" <?php if($DATA['login']) echo 'checked="checked"'; ?>></td>
              </tr>
              <tr>
                <td class="tdtext"><?php echo $TEXT['Users can register']; ?></td>
                <td class="tdform"><input class="input-checkbox2" type="checkbox" name="register" <?php if($DATA['register']) echo 'checked="checked"'; ?>></td>
              </tr>
              <tr>
                <td class="tdform"><input type="submit" class="button" value="<?php echo $TEXT['Submit'];?>"></td>
              </tr>
          </table>
          </form>
          </td>
          <td>
          <table>
          	<tr> 
          		<td>
          			<a href="admin_main.php?mode=settings&submode=settingsure&id=dropusers"><input type="submit" class='button' value="<?php echo $TEXT['Drop users table'];?>"></a>
          		</td>
          	</tr>
          	<tr>
          		<td>
          			<a href="admin_main.php?mode=settings&submode=settingsure&id=droptickets"><input type="submit" class='button' value="<?php echo $TEXT['Drop tickets table'];?>">
          			</a>
          		</td>
          	</tr>
          	<tr>
          		<td>
            		<a href="action.php?id=backup"><input type="submit" class='button' value="<?php echo $TEXT['Backup SQL database'];?>"></a>
          		</td>
          	</tr>
          </table>
          </td>
		</tr>
		<tr>
          	<td colspan="2">
          	<form action="action.php?id=titleset" method="post">
          	<table class='formtable'>
           		<tr>
                	<td class="tdtext" colspan="2"><?php echo $TEXT['Change Title'];?></td>
                </tr>
              	<tr>
                	<td class="tdform" ><input type="text" class="input-text" name="title" value="<?php echo $DATA['title'];?>"></td>
                	<td class="tdform" ><input type="submit" class="button" value="<?php echo $TEXT['Submit'];?>"></td>
              	</tr>
          	</table>
          	</form>
          	</td>
          </tr>
          <tr>
          	<td colspan="2">
          	<form action="action.php?id=emailset" method="post">
          	<table class='formtable'>
            	<tr>
                	<td class="tdtext" colspan="2"><?php echo $TEXT['Change Email'];?></td>
                </tr>
              	<tr>
                	<td><input type="text" class="input-email" name="email" value="<?php echo $DATA['mainmail'];?>"></td>
                	<td><input type="submit" class="button" value="<?php echo $TEXT['Submit'];?>"></td>
              	</tr>
          	</table>
          	</form>
          	</td>
          </tr>
</table>