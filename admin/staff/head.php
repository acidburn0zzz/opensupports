<head>
	<title>Staff Admin Panel</title>
	<style media="all" type="text/css">@import "css/all.css";</style>
    <script>
	function changepage(){
			var selected = document.getElementById("selectpage").selectedIndex;
			window.location = "index.php?mode=<?php echo $_GET[mode];?>&submode=<?php echo $_GET[submode];?>&page="+selected;
	}
	function changedep(){
			var selected = document.getElementById("depselect").value;
			window.location = "action.php?id=changedepartment&ticketid=<?php echo $ticket[id];?>&dep="+selected;
	}
	function modifyprop(name){
		var selected = document.getElementById(name).value;
		window.location = "action.php?id=ticketprop&ticketid=<?php echo $ticket[id];?>&name="+name+"&pvalue="+selected;
	}
	function modifyprop2(name){
		if(document.getElementById(name).checked)
			window.location = "action.php?id=ticketprop&ticketid=<?php echo $ticket[id];?>&name="+name+"&pvalue=on";
		else
			window.location = "action.php?id=ticketprop&ticketid=<?php echo $ticket[id];?>&name="+name+"&pvalue=";		
	}
	function modifystaffprop(name){
		var selected = document.getElementById(name).value;
		window.location = "action.php?id=staffprop&name="+name+"&pvalue="+selected;
	}
	function modifystaffprop2(name){
		if(document.getElementById(name).checked)
			window.location = "action.php?id=staffprop&name="+name+"&pvalue=on";
		else
			window.location = "action.php?id=staffprop&name="+name+"&pvalue=";		
	}
	function changecontent(){
		var selected = document.getElementById('customresponses').value;
		window.location = "index.php?mode=ViewTickets&submode=Ticket%20Viewer&id=<?php echo $_GET[id];?>&text="+selected;
	}
	</script>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
</head>
<script src="../../js/jquery.js"></script>
