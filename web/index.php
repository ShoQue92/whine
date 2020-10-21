<html>
<head>
<title>Wijnkoeler</title>
<meta name="viewport" content="width=device-width, initial-scale=1"> 
<link rel="stylesheet" href="https://code.jquery.com/mobile/1.4.5/jquery.mobile-1.4.5.min.css" />
<script src="https://code.jquery.com/jquery-1.11.1.min.js"></script>
<script src="https://code.jquery.com/mobile/1.4.5/jquery.mobile-1.4.5.min.js"></script>
<link rel="stylesheet" href="style.css">
<script type="text/javascript" src="code.js"></script>
</head>
<body>

<div data-role="page">

<?php
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
<h3 class="ui-bar ui-bar-a ui-corner-all">Nieuwe wijnfles gescand, klik hieronder om toe te voegen.</h3>
<a href="nieuwefles.php" class="ui-btn ui-shadow" data-transition="pop">Toevoegen Nieuwe Fles</a>
<?php
}
else{
?>
<div>Bestand '<?php echo $nieuweflescsvpad; ?>' niet gevonden, invalid of al verwerkt..</div>
<?php
}
?>

</div><!-- /page -->


</body>
<html>