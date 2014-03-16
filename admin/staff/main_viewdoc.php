<?php
$doc = $api->get_doc($_GET[id]);
?>
				<table id="viewdoc" cellpadding="0" cellspacing="0">
					<tr>
						<td class="textname"><?php echo $TEXT['Title'];?></td>
						<td style="background-color:#FFF"><?php echo $doc[title]; ?></td>
                        <td class="textname"><?php echo $TEXT['Written By'];?></td>
                        <td style="background-color:#FFF"><?php echo $doc[by]?></td>
					</tr>
                    <tr>
                    	<td class="textname"><?php echo $TEXT['File'];?></td>
                        <td style="background-color:#FFF"><?php echo ($doc['file']) ? "<a href='../../files/$doc[file]'>$doc[file]</a>": $TEXT['No file'];?></td>
						<td class="textname"><?php echo $TEXT['Date'];?></td>
						<td style="background-color:#FFF"><?php echo $doc['date']; ?></td>
					</tr>
                    <tr>
                    	<td colspan="4" align="center" style="background-color:#FFF"><?php echo $doc[content]; ?></td>
                    </tr>
				</table>
<br>
<div id="subbuttons">
	<a href="index.php?mode=Docs&submode=Edit&id=<?php echo $doc[id];?>"><?php echo $TEXT['Edit document'];?></a><br>
	<a href="index.php?mode=Docs&submode=Delete&id=<?php echo $doc[id];?>"><?php echo $TEXT['Delete document'];?></a>
</div>