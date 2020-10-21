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

<a href="index.php" class="ui-btn ui-shadow" data-transition="pop">Terug</a>

<?php

$nieuweflescsvpad = "workdir/nieuwefles.csv";
$filecorrect = false;

if( file_exists($nieuweflescsvpad)){
	$fp = file($nieuweflescsvpad);
	if(count($fp) == 2){
		$filecorrect = true;
		# file bevat 2 regels, verdergaan
		$bestand = file($nieuweflescsvpad,FILE_SKIP_EMPTY_LINES); 
		$bestandinhoud = array_map("str_getcsv",$bestand, array_fill(0, count($bestand), ';'));
	}
	else{
		# file bestaat maar bevat geen 2 regels
		echo "bestand " . $nieuweflescsvpad . " heeft geen 2 regels.";
	}
}
else {
	# file bestaat niet, lege pagina
	echo "bestand " . $nieuweflescsvpad . " bestaat niet.";
}
?>
<h3 class="ui-bar ui-bar-a ui-corner-all">Toevoegen nieuwe wijnfles</h3>

<div data-corners="true" data-shadow="true" data-iconshadow="true" data-wrapperels="span" data-icon="null" data-iconpos="null" data-theme="b" class="ui-btn ui-btn-up-b ui-shadow ui-btn-corner-all ui-submit" aria-disabled="false">
<form name="wijnflestoevoegen" action="actie.php" method="post" autocomplete="off">
	<input type="hidden" name="actie" value="toevoegenfles" />
	<span class="ui-btn-inner ui-btn-corner-all">
		<div data-role="fieldcontain">	
			<?php
			$disabledvelden = array("UID","date_in_fridge");
			
			$kolomnr=0;
			foreach($bestandinhoud[0] as $header){
				if($header != "status"){
					if(in_array($header,$disabledvelden)){
					?>
					<input type="hidden" name="<?php echo $header; ?>" value="<?php echo $bestandinhoud[1][$kolomnr]; ?>" />
					<?php
					}
					?>
					<label for="<?php echo $header; ?>"><?php echo str_replace("_"," ",ucfirst($header)); ?></label>
					<input <?php if(in_array($header,$disabledvelden)){echo "disabled=\"disabled\""; } ?> type="text" name="<?php echo $header; ?>" value="<?php echo $bestandinhoud[1][$kolomnr]; ?>" />
					<?php
					}
			$kolomnr++;
			}
			?>
		</div>	
	</span>
	<button type="submit" data-theme="b" name="submit" value="submit" class="ui-btn-hidden" aria-disabled="false">Submit</button>
</form>	
</div>

</div><!-- /page -->

</body>
<html>
