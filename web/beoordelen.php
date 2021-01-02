<?php
require 'database_functies.php';
require 'functies.php'; 
?>
<html>
<head>
<?php require 'headers.php'; ?>
</head>
<body> 

<?php paginaheader("Beoordelen"); 

?>

<div class="paginaheader">
<h3 class="ui-bar ui-bar-a ui-corner-all" style="text-align:center">Fles beoordelen</h3>
</div>

<div class="containing-element">
	<p>Om te beginnen, geef je naam op zodat we die kunnen meenemen bij de beoordeling.</p>
	<label for="waarde" class="ui-hidden-accessible">Naam</label>
	<input type="text" name="eigenschap" placeholder="eigenschap" data-theme="a">
	<button type="submit" class="ui-btn ui-corner-all ui-shadow ui-btn-b ui-btn-icon-left ui-icon-check" name="nieuwefleseigenschap" value="nieuwefleseigenschap">Verder..</button>
</div>



<?php require 'paginaeind.php'; ?>

</body>
</html>