<?php
session_start();

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
<?php
// indien geen gebruiker opgegeven, dan vragen om naam, anders flessen weergeven
if(!isset($_SESSION['naam']) || strlen($_SESSION['naam']) < 1){
?>
<div class="containing-element">
	<p>Om te beginnen, geef je naam op zodat we die kunnen meenemen bij de beoordeling.</p>
		<form name="naamdoorgeven" action="acties_post.php" method="post" autocomplete="off">
		<label for="waarde" class="ui-hidden-accessible">Naam</label>
		<input type="text" name="naam" placeholder="naam" data-theme="a">
		<button type="submit" class="ui-btn ui-corner-all ui-shadow ui-btn-b ui-btn-icon-left ui-icon-check" name="naamdoorgeven" value="naamdoorgeven">Verder..</button>
	</form>
</div>
<?php
}
else{
// gebruiker bekend, dus flessen laten zien
?>

<div class="paginaheader">
<h3 class="ui-bar ui-bar-a ui-corner-all" style="text-align:center">Naam gezet op '<?php echo $_SESSION['naam']; ?>'</h3>
<a href="acties_get.php?actie=naamverwijderen" class="ui-btn ui-icon-delete ui-btn-icon-left">Naam aanpassen?</a>
</div>

<?php
}
?>

<?php require 'paginaeind.php'; ?>

</body>
</html>