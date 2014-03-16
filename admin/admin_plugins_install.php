<form action="action.php?id=newplugin" method="post" enctype="multipart/form-data">
    <table class='fileform'>
    	<tr>
            <td>
            	<div id="installplugintitle"><?php echo $TEXT['Install new plugin'];?></b></div>
            </td>
        </tr>
        <tr>
            <td>
                <input class="input-file" type="file" name="zip_file" id="zip_file" accept="application/x-zip-compressed"/>
                <input class="button" type="submit" value="<?php echo $TEXT['Submit'];?>">
        	</td>
        </tr>
	</table>
</form>
