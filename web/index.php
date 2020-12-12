<html>
<head>
<?php require 'headers.php'; ?>
</head>
<body>

<?php paginaheader("Wijnkoeler"); 

$nieuweflescsvpad = "interface_files/intf_init_bottle.csv";

$filevalid=false;
if( file_exists($nieuweflescsvpad)){
	$fp = file($nieuweflescsvpad);
	if(count($fp) == 2){
		$bestand = file($nieuweflescsvpad,FILE_SKIP_EMPTY_LINES); 
		$bestandinhoud = array_map("str_getcsv",$bestand, array_fill(0, count($bestand), ';'));
		
		if($bestandinhoud[1][6] == "registered"){	
			$filevalid=true;
		}
	}
}

if($filevalid){
?>
<h3 class="ui-bar ui-bar-a ui-corner-all" style="text-align:center;color:red">Nieuwe wijnfles gescand!</h3>
<a href="nieuwefles.php" class="ui-btn ui-shadow" data-transition="pop">Toevoegen Nieuwe Fles</a>
<?php
}
/*
else{
?>
<div>Bestand '<?php echo $nieuweflescsvpad; ?>' niet gevonden, invalid of al verwerkt..</div>
<?php
}
*/
?>
<div style="width:100%">
<img src="images/koelkast.png" style="width:100%" />
</div>
<?php require 'paginaeind.php'; ?>

<?php require 'menu.php'; ?>

</body>
</html>