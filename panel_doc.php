<?php
$reg = $api->get_doc($_GET['doc']);
?>
<div class="panelbox">
		<div class="title"><?php echo $TEXT['Doc Viewer']; ?></div>
		<div class="ticketbox">
			<div class="ticketbox-title">
				<?php echo $reg[title]; ?>
			</div>
			<div class="ticketbox-user">
				<?php echo $reg[by]; ?>				
			</div>
			<div class="ticketbox-date"><img class="dateicon">
			<?php echo $reg['date']; ?>			
			</div>
            <div class="ticketbox-file">
			<a href="files/<?php echo $reg['file']; ?>"><?php echo $reg['file']; ?></a>
			</div>
			<div class="ticketbox-content">
			<?php echo $reg[content];?>
			</div>
		</div>
</div>
