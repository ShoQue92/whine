<?php
require 'database_functies.php';
require 'functies.php'; 
?>
<html>
<head>
<?php require 'headers.php'; 

// hoogste beoordeling ophalen

$hoogstebeoordeling = 0;
$hoogstebeoordelinguid = "";

foreach ($beoordelingen_json as $flesbeoordeling){
	// elke fles afgaan, hoogste beoordeling pakken
	if($flesbeoordeling['Gemiddelde waardering'] > $hoogstebeoordeling){
		$hoogstebeoordeling = $flesbeoordeling['Gemiddelde waardering'];
		$hoogstebeoordelinguid = $flesbeoordeling['UID'];
	}
}

?>

<script>
$(document).on("pagecreate", "#page", function(){
	
	var huidigepagina = 0;
	var aantalpaginas = 5;
	var initieletext = $(".infoscrollera").html();
	
	window.setInterval(function(){
		// veranderen div inhoud
		if(huidigepagina == aantalpaginas){
			huidigepagina = 1;
		}
		else{
			huidigepagina = huidigepagina + 1;
		}
		
		$(".infoscrollerb").fadeOut("Slow", function(){
			
			switch(huidigepagina){
			case 1:
				$(".infoscrollera").html(initieletext);
				$(".infoscrollerb").html("Momenteel <?php echo $aantalflessen; ?> flessen in de koelkast");
				break;
			case 2:
				$(".infoscrollera").html("Momenteel in de koelkast");
				$(".infoscrollerb").html("<?php echo $aantalflessenrood; ?> fles(sen) rood");
				break;	
			case 3:
				$(".infoscrollera").html("Momenteel in de koelkast");
				$(".infoscrollerb").html("<?php echo $aantalflessenwit; ?> fles(sen) wit");
				break;		
			case 4:
				$(".infoscrollera").html("Momenteel in de koelkast");
				$(".infoscrollerb").html("<?php echo $aantalflessenrose; ?> fles(sen) rosé");
				break;		
			case 5:
				$(".infoscrollera").html("Best beoordeelde fles");
				$(".infoscrollerb").html("Fles met UID: <?php echo $hoogstebeoordelinguid; ?>");
				break;	
			};
			
		});
			
		$(".infoscrollerb").fadeIn("Slow");		
				
			
	}, 3000);
});

</script>

</head>
<body> 

<?php paginaheader("Wijnkoeler"); 

?>

<div id="intf_init_bottle_status" style="display:none">
<h3 class="ui-bar ui-bar-a ui-corner-all" style="text-align:center;color:red">Nieuwe wijnfles gescand!</h3>
<a href="nieuwefles.php" class="ui-btn ui-shadow" data-transition="pop">Toevoegen Nieuwe Fles</a>
</div>
<div class="ui-grid-solo">
	<div id="temp_<?php echo $randomnummer; ?>" class="temp ui-block-a">Temperatuur laden..</div>
</div>
<div class="ui-grid-solo">
	<div class="datumdiva ui-block-a">Weekdag</div>
</div>
<div class="ui-grid-solo">
	<div class="datumdivb ui-block-a">Datum</div>
</div>
<div class="ui-grid-solo">
	<div class="ui-block-a">
		<a href="koelkast.php"><img src="images/koelkast.png" style="width:100%" /></a>
	</div>
</div>
<div class="ui-grid-solo">
	<div class="infoscrollera ui-block-a">Koelkast feitjes</div>
</div>
<div class="ui-bar ui-bar-a ui-corner-all infoscrollerparent">
	<div class="ui-grid-solo">
		<div class="infoscrollerb ui-block-a"></div>
	</div>
</div>

<?php require 'paginaeind.php'; ?>

</body>
</html>