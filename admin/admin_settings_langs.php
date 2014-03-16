<script type="text/javascript" src="../nicedit/nicEdit.js"></script>
<script type="text/javascript">
	bkLib.onDomLoaded(function() { nicEditors.allTextAreas() });
</script>
<script type="text/javascript">
	function savetext() {
		var numItems = $('.input-textarea').length;
   		for(var i=0;i<numItems;i++){
   	    	nicEditors.findEditor('content'+i).saveContent();
   	    }
	}
</script>
<table id="languagestable">
          <tr>
          <td class="nav">
          <form action="action.php?id=langs" method="post">
          <table class="formtable">
            <tr>
                <td class="tdtext" colspan="2"><?php echo $TEXT['Supported Languages'];?></td>
                </tr>
              <tr>
                <td class="tdform"><?php
                $query = $api->get_langs();
				while($lang = mysqli_fetch_array($query)){
				?>
                <input  <?php echo ($lang[supported] ? 'checked="checked"' : '');?> name="<?php echo $lang[short];?>" type="checkbox" class="input-checkbox"><?php echo $lang[name];?><br>
                <?php }?>
                <input class="button" type="submit" value="<?php echo $TEXT['Submit'];?>">
                </td>
              </tr>
          </table>
          </form>
          </td>
          <td>
          <form action="action.php?id=langdefault" method="post">
          <table class="formtable">
            <tr>
                <td class="tdtext" colspan="2"><?php echo $TEXT['Default Language'];?></td>
                </tr>
              <tr>
                <td>
                <select class="input-select" name="default" id="default">
                <?php
                $query = $api->get_langs(true);
				while($la = mysqli_fetch_array($query)){
                ?>
                 <option <?php if($DATA['lang'] == $la[short]) echo 'selected="selected"'; ?> value="<?php echo $la[short];?>"><?php echo $la[name];?></option>
                <?php } ?>
                </select></td>
                <td class="tdform"><input type="submit" class="button" value="<?php echo $TEXT['Submit'];?>"></td>
              </tr>
          </table>
          </form>
          </td>
          </tr>
          <tr>
          <td colspan="2" align="center">
          <table id="texteditor">
          <tr>
          <td class="texteditortitle">
          <?php echo $TEXT['Text Editor'];?>
          </td>
          <td>
          <select class="input-select" name="langedit" id="langedit" onchange="changelang();">
           <?php
		   		$langedit = (isset($_GET[langedit])) ? $api->sql_escape($_GET[langedit]) : $DATA[lang];
				$query = $api->get_langs(false);
				while($la = mysqli_fetch_array($query)){
           ?>
                 <option <?php if($langedit == $la[short]) echo 'selected="selected"';?> value="<?php echo $la[short];?>"><?php echo $la[name];?></option>
           <?php } ?>
          </select>
          </td>
          </tr>
          <form action="action.php?id=langedit" method="post">
          <input type="hidden" name="langedit" value="<?php echo $langedit;?>">
          <?php
		  $query = $api->query("SELECT * FROM TEXT WHERE type='text' AND lang='$langedit' ORDER BY name ASC");
		  $str = "";
		  $count = 0;
		  while($txt = mysqli_fetch_array($query)){
          ?>
          <tr>
          <td class="txteditname">
          <?php echo $txt[name]; ?>
          </td>
          <td>
          <center><textarea class="input-textarea" id="content<?php echo $count;?>" name="content<?php echo $txt[id];?>" cols="50" rows="5"><?php echo $txt[value];?></textarea></center>
          </td>
          </tr>
          <?php $count++; } ?>
          <tr>
          <td>
          <input type="submit" class="button" value="<?php echo $TEXT['Submit'];?>" onclick="savetext()">
          </td>
          </tr>
          </form>
          </table>
          </td>
          </tr>
</table>