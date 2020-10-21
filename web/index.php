<html>
<head>
<?php require 'headers.php'; ?>
</head>
<body>

<?php paginaheader("Wijnkoeler"); 

$nieuweflescsvpad = "workdir/nieuwefles.csv";

$filevalid=false;
if( file_exists($nieuweflescsvpad)){
	$fp = file($nieuweflescsvpad);
	if(count($fp) == 2){
		$bestand = file($nieuweflescsvpad,FILE_SKIP_EMPTY_LINES); 
		$bestandinhoud = array_map("str_getcsv",$bestand, array_fill(0, count($bestand), ';'));
		
		if($bestandinhoud[1][0] == "registered"){	
			$filevalid=true;
		}
	}
}

if($filevalid){
?>
<h3 class="ui-bar ui-bar-a ui-corner-all" style="text-align:center;color:red">Nieuwe wijnfles gescand, klik hieronder om toe te voegen.</h3>
<a href="nieuwefles.php" class="ui-btn ui-shadow" data-transition="pop">Toevoegen Nieuwe Fles</a>
<?php
}
else{
?>
<div>Bestand '<?php echo $nieuweflescsvpad; ?>' niet gevonden, invalid of al verwerkt..</div>
<?php
}
?>

<?php require 'paginaeind.php'; ?>

<?php require 'menu.php'; ?>

</body>
</html>