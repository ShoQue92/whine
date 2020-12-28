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


<div style="width:100%">
<a href="koelkast.php"><img src="images/koelkast.png" style="width:100%" /></a>
testenv:
<?php
echo getenv('INTF_ENV');
// dev
?>
</div>
<?php require 'paginaeind.php'; ?>

</body>
</html>