<?php
session_start();

require 'database_functies.php';
require 'functies.php'; 

if('GET' === $_SERVER['REQUEST_METHOD']){
	if(isset($_GET["uid"])){
		$uid = $_GET["uid"];
		$_SESSION['uid'] = $uid;
	}
}

?>

<html>
<head>
<?php require 'headers.php'; ?>
</head>
<body> 

<?php 

paginaheader("Beoordelen"); 

?>

<?php
if(isset($_SESSION['uid']) && isset($_SESSION['naam'])){
?>
	<script>
	
	$(document).on("pagecontainerload", function(){
		/*$("." + <?php echo $_SESSION['uid']; ?>).collapsible({
		  collapsed: false
		});*/
		var position = $(".<?php echo $_SESSION['uid']; ?>").offset().top;
		$.mobile.silentScroll(position);
	}); 
	/*$(document).on("collapsibleexpand", ".<?php echo $_SESSION['uid']; ?>", function () {
		var position = $(this).offset().top;
		$.mobile.silentScroll(position);
	});*/
	</script>
<?php
	unset($_SESSION['uid']);
}
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
<a href="acties_get.php?actie=naamverwijderen" class="ui-btn ui-icon-delete ui-btn-icon-left ui-corner-all">Naam aanpassen?</a>
</div>
<div data-role="collapsibleset">
<?php
while ($row = $resultaatalleflessenbehalveverwijderd->fetchArray()) {
	toon_wijninfo_koeler($row,"beoordelen");
?>

<?php

}//while
?>
</div>
<?php

} // else
?>

<?php require 'paginaeind.php'; ?>

</body>
</html>