<head>
<title><? echo $DATA[title] . " - " . $TEXT['Support Center'];?></title>
<link rel="StyleSheet" href="themes/<? echo $DATA[theme]; ?>/style.css" type="text/css">
<script>
	function changelang(){
			var selected = document.getElementById("selectlang").value;
			window.location = "?lang="+selected;
	}
	</script>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
</head>
<script src="js/jquery.js"></script>