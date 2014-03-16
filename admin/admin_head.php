<head>
	<title>OpenSupports | Admin Panel</title>
	<style media="all" type="text/css">@import "css/all.css";</style>
    <script>
	function changeinputtype(){
		var selected = document.getElementById("inputtype").value;
		window.location = "admin_main.php?mode=settings&submode=newproperty&inputtype="+selected;
	}
	function changeresponse(){
		var selected = document.getElementById("editresponse").value;
		window.location = "admin_main.php?mode=staff&submode=responses&responseid="+selected;
	}
	var optn = 1;
	function addoption(){
		optn++;
		document.getElementById('optionlist').innerHTML += "<input type='text' name='op"+optn+"' value='' /><br />";
		document.getElementById('optn').value = optn;
	}
	function changelang(){
		var selected = document.getElementById('langedit').value;
		window.location = "admin_main.php?mode=settings&submode=langs&langedit="+selected;
	}
	function modifystaffprop(name){
		var selected = document.getElementById(name).value;
		window.location = "action.php?id=staffprop&toid=<?php echo $staff[id];?>&name="+name+"&pvalue="+selected;
	}
	function modifystaffprop2(name){
		if(document.getElementById(name).checked)
			window.location = "action.php?id=staffprop&toid=<?php echo $staff[id];?>&name="+name+"&pvalue=on";
		else
			window.location = "action.php?id=staffprop&toid=<?php echo $staff[id];?>&name="+name+"&pvalue=";		
	}
	var earray = new Array(false,false,false,false);
	function erase(id){
	  switch(id){
	  	case 'staffuser':
	  		if(!earray[0]) document.getElementById(id).value = '';
	  		earray[0] = true;
	  	break;
	  	case 'staffpass':
	  		if(!earray[1]) document.getElementById(id).value = '';
	  		earray[1] = true;
	  	break;
	  	case 'adminuser':
	  		if(!earray[2]) document.getElementById(id).value = '';
	  		earray[2] = true;
	  	break;
	  	case 'adminpass':
	  		if(!earray[3]) document.getElementById(id).value = '';
	  		earray[3] = true;
	  	break;
	  }
	}
	</script>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
</head>
<script src="../js/jquery.js"></script>