<?php
$doc = $api->get_doc($_GET[id]);
?>
<script type="text/javascript" src="../../nicedit/nicEdit.js"></script>
<script type="text/javascript">
	bkLib.onDomLoaded(function() { nicEditors.allTextAreas() });
</script>
				<table class="formtable">
					<tr>
                    <form action="action.php?id=doctitle" method="post">
                    <input type="hidden" name="docid" value="<?php echo $doc[id];?>">
						<td class='formtext'><?php echo $TEXT['Title'];?></td>
						<td><input type="text" name="title" class="input-text" value="<?php echo $doc[title]; ?>" /></td>
                        <td><input type="submit" value="<?php echo $TEXT['Submit'];?>"></td>
					</form>
                    </tr>
                    <tr>
                    <form action="action.php?id=docfile" method="post" enctype="multipart/form-data">
                    <input type="hidden" name="docid" value="<?php echo $doc[id];?>" />
                    	<td class='formtext'><?php echo $TEXT['File'];?></td>
                        <td class="input-file"><input type="file" name="fileupload"></td>
                        <td class="button"><input type="submit" value="<?php echo $TEXT['Submit'];?>"></td>
                    </form>
                    </tr>
                    <form action="action.php?id=doccontent" method="post">
                    <input type="hidden" name="docid" value="<?php echo $doc[id];?>" />
                    <tr>
                    <td colspan="4" align="center" class="formtext"><?php echo $TEXT['Content'];?></td>
                    </tr>
                    <tr>
                    	<td colspan="4" align="center"><textarea class="input-textarea" rows="15" cols="80" name="content" id='content'><?php echo $doc[content]; ?></textarea></td>
                    </tr>
                    <tr>
                    <td colspan="4" align="center"><input class="button" onclick="nicEditors.findEditor('content').saveContent();" value="<?php echo $TEXT['Submit'];?>"></td>
                    </tr>
                    </form>
				</table>