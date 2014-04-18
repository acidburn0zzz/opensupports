<script type="text/javascript" src="../../nicedit/nicEdit.js"></script>
<script type="text/javascript">
	bkLib.onDomLoaded(function() { nicEditors.allTextAreas() });
</script>
<form action="action.php?id=createdoc" method="post" enctype="multipart/form-data">
                <table class="formtable">
					<tr>
						<td class='formtext'>
                        <?php echo $TEXT['Title'];?>
                        </td>
                        <td>
                        <input type="text" class='input-text' name="title">
                        </td>
					</tr>
                    <tr>
						<td class='formtext'>
                        <?php echo $TEXT['Content'];?>
                        </td>
                        <td>
                        <textarea name="content" class='input-textarea' rows="15" cols="60"></textarea>
                        </td>
					</tr>

                    <tr>
						<td class='formtext'>
                        <?php echo $TEXT['File'];?>
                        </td>
                        <td>
                        <input type="file" name="fileupload" class='input-file' id="fileupload">
                        </td>
					</tr>
                    <tr>
                    	<td class='formsubmit'>
                        <input type="submit" class="button" value="<?php echo $TEXT['Submit']?>">
                        </td>
                    </tr>
				</table>
</form>
