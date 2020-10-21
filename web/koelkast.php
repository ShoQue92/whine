<html>
<head>
<?php require 'headers.php'; ?>
</head>
<body>

<?php paginaheader("Koelkast"); ?>

<?php

$db = new SQLite3('db/whine_inventory.db');

$tablesquery = $db->query("PRAGMA table_info(whine_bottles);");
$query = $db->prepare("SELECT * FROM whine_bottles order by date_in_fridge;");

$resultaat = $query->execute();

while ($row = $resultaat->fetchArray()) {

?>
<div data-role="collapsible" data-content-theme="c">
	<h3><?php echo $row['name']; ?></h3>
	<?php
	while ($table = $tablesquery->fetchArray(SQLITE3_ASSOC)) {
		echo $table['name'] . '<br />';
	}
	?>
</div>
<?php
}

?>

<?php require 'paginaeind.php'; ?>

<?php require 'menu.php'; ?>

</body>
</html>