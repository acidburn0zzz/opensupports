<div class="main">
	<div class="welcomediv">
    	<div class="welcometitle"><?php echo $TEXT['Welcome'];?></div>
		<div class="welcometext">
    		<?php echo $TEXT['Welcometext']; ?>
    	</div>
    </div>
	<?php if ($DATA[login]) {?>
	<form id="loginform" action="action.php?id=login" method="POST">
	<div class="login">
		<div class="title"><?php echo $TEXT['Login'];?></div>
		<div class="email-field">
			<div class="ntext"><?php echo $TEXT['Email'];?></div>
			<div class="form-div"><input type="text" class="email-input" id="l-email" name="l-email"></div>
		</div>
		<div class="pass-field">
			<div class="ntext"><?php echo $TEXT['Password'];?></div>
			<div class="form-div"><input type="password" class="pass-input" id="l-pass" name="l-pass"></div>
		</div>
		<div class="submit-field">
			<div class="form-div"><input type="submit" class="button" value="<?php echo $TEXT['Submit'];?>"></div>
		</div>
	</div>
	</form>
	<?php
	} else {
	?>
	<div class="box">
		<div class="box_title" id='submit_ticket'><a href="index.php?mode=create_ticket"><?php echo $TEXT['Submit a ticket'];?></a></div>
		<div class="dtext"><?php echo $TEXT['Submit a ticket description'];?></div>
	</div>
	<div class="box">
		<div class="box_title" id="check_ticket"><a href="index.php?mode=check_ticket"><?php echo $TEXT['Check Your Ticket'];?></a></div>
		<div class="dtext"><?php echo $TEXT['Check Your Ticket description'];?></div>
	</div>
	<?php
	}
	if($DATA[login] && $DATA[register]){
	?>
	<div class="box">
		<div class="box_title" id="create_user"><a href="index.php?mode=create_user"><?php echo $TEXT['Create an User'];?></a></div>
		<div class="dtext"><?php echo $TEXT['Create an User description'];?></div>
	</div>
	<?php } ?>
	<div class="box">
		<div class="box_title" id="about_articles"><?php if(!$DATA[login]) {?><a href="index.php?mode=list_docs"><?php echo $TEXT['About Articles'];?></a><?php } else echo $TEXT['About Articles']; ?></div>
		<div class="dtext"><?php echo $TEXT['About Articles description'];?></div>
	</div>
</div>
