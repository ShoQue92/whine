<?php
require 'database_functies.php';
require 'functies.php'; 
?>
<html>
<head>
<?php require 'headers.php'; ?>
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
<div class="ui-bar ui-bar-a ui-corner-all">
	<div class="ui-grid-solo">
		<div class="infoscrollera ui-block-a">Momenteel in de koelkast</div>
	</div>
	<div class="ui-grid-solo">
		<div class="infoscrollerb ui-block-a">3 flessen in totaal</div>
	</div>
</div>

<?php require 'paginaeind.php'; ?>

</body>
</html>