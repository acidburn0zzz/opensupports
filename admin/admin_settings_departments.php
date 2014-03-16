<table id='departmentstable'>
          <tr>
          <td>
          <form action="action.php?id=newdep" method="post">
          <table class='formtable'>
            <tr>
                <td class="tdtext" colspan="2"><?php echo $TEXT['New Department'];?></td>
                </tr>
              <tr>
                <td class="tdform"><input class="input-text" type="text" name="title"></td>
                <td class="tdform"><input class="button" type="submit" value="<?php echo $TEXT['Submit'];?>"></td>
              </tr>
          </table>
          </form>
          </td>
          </tr>
          <tr>
          <td>
          <form action="action.php?id=deletedep" method="post">
          <table  class="formtable">
            <tr>
                <td class="tdtext" colspan="2"><?php echo $TEXT['Delete Department'];?></td>
                </tr>
              <tr>
                <td class="tdform" width="176">
                <select class="input-select" name="delete" id="delete">
                <?php
                $query = $api->get_departments();
				while($dep = mysqli_fetch_array($query)){
                ?>
                  <option value="<?php echo $dep[name];?>"><?php echo $dep[name];?></option>
                <?php } ?>
                </select></td>
                <td class="tdform"><input class="button" type="submit" value="<?php echo $TEXT['Submit'];?>"></td>
              </tr>
          </table>
          </form>
          </td>
          </tr>
</table>