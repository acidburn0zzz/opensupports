<div class="panelbox2">
	<div class="title"><?php echo $TEXT['Ticket Status'];?></div>
	<div class="ubox">
	<form action="index.php" method="GET">
	<input type="hidden" name="mode" value="view_ticket">
	<div class="form-div">
		<div class="ntext"><?php echo $TEXT['Ticket ID'];?></div>
		<input type="text" class="text-input" name="ticketid" id="ticketid">
	</div>	
	<div class="form-div">
		<div class="ntext"><?php echo $TEXT['Email'];?></div>
		<input type="text" class="email-input" name="email" id="email">
	</div>
	<div class="form-div">
		<input type="submit" class="button" value="<?php echo $TEXT['Submit'];?>">
	</div>
	</from>
	</div>
</div>