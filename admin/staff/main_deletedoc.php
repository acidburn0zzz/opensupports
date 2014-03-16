<?php
$doc = $api->get_doc($_GET[id]);
?>
<div class='sure'>
<div class="suretext"><?php echo $TEXT['Are you sure']; ?></div>
<a class="surebutton" href="action.php?id=docdelete&docid=<?php echo $doc[id]; ?>"><?php echo $TEXT['Yes']; ?></a>
</div>