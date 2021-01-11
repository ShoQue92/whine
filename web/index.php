<?php
require 'database_functies.php';
require 'functies.php'; 
?>
<html>
<head>
<?php require 'headers.php'; ?>

<script>
$(document).on("pagecreate", "#page", function(){
	window.setInterval(function(){
		// veranderen div inhoud
		var huidigepagina = 0;
		var aantalpaginas = 5;
		
		if(huidigepagina == aantalpaginas){
			huidigepagina = 1;
		}
		else{
			huidigepagina = huidigepagina + 1;
		}
		
		$(".infoscrollerb").fadeOut("Slow");
		
		switch(huidigepagina){
			case 1:
				$(".infoscrollerb").html("Aantal flessen");
				break;
			case 2:
				$(".infoscrollerb").html("Aantal flessen rood");
				break;	
			case 3:
				$(".infoscrollerb").html("Aantal flessen wit");
				break;		
			case 4:
				$(".infoscrollerb").html("Aantal flessen rose");
				break;		
			case 5:
				$(".infoscrollerb").html("Best beoordeelde fles");
				break;	
		};		
				
		$(".infoscrollerb").slideDown("Slow");		
				
			
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
	<div class="infoscrollera ui-block-a">Momenteel in de koelkast</div>
</div>
<div class="ui-bar ui-bar-a ui-corner-all">
	<div class="ui-grid-solo">
		<div class="infoscrollerb ui-block-a">3 flessen in totaal</div>
	</div>
</div>

<?php require 'paginaeind.php'; ?>

</body>
</html>