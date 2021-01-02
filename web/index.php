<?php
require 'database_functies.php';
require 'functies.php'; 
?>
<html>
<head>
<?php require 'headers.php'; ?>

<script>

</script>

</head>
<body> 

<?php paginaheader("Wijnkoeler"); 

?>

<div id="intf_init_bottle_status" style="display:none">
<h3 class="ui-bar ui-bar-a ui-corner-all" style="text-align:center;color:red">Nieuwe wijnfles gescand!</h3>
<a href="nieuwefles.php" class="ui-btn ui-shadow" data-transition="pop">Toevoegen Nieuwe Fles</a>
</div>

<div id="temp_<?php echo $randomnummer; ?>" class="temp">Temperatuur laden..</div>
<div class="momenteelindekoelkast" style="width:100%;text-align:center;height:40px;line-height:40px;"><p>Momenteel in de koelkast</p></div>
<div class="momenteelindekoelkast" style="width:100%;text-align:center;height:40px;line-height:40px;"><p>adsfasdfasdf</p></div>
<div style="width:100%">
<a href="koelkast.php"><img src="images/koelkast.png" style="width:100%" /></a>
</div>

<?php require 'paginaeind.php'; ?>

</body>
</html>