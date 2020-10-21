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
$aantalflessen = $db->querySingle("SELECT count(1) FROM whine_bottles;");

$resultaat = $query->execute();

$vertaling = array('Druifsoort' => 'main_grape', 'Jaar' => 'year', 'Datum in koelkast' => 'date_in_fridge');

while ($row = $resultaat->fetchArray()) {

?>
<div>
<h3 class="ui-bar ui-bar-a ui-corner-all" style="text-align:center">In totaal <?php if($aantalflessen == 0){echo "geen"; } else{ echo $aantalflessen . ' fles'; if($aantalflessen > 1){echo "sen";}} ?> in de koelkast.</h3>
</div>
<div style="width:70%;float:left;height:70px">
	<img src="images/wijn_rood_vb_zijkant.png" style="max-height:50px" />
</div>
<div style="width:25%;height:70px;float:right;text-align:center">
	<p style="font-weight:bold">Rood</p>
</div>

<div data-role="collapsible" data-content-theme="c">
	<h3><?php echo $row['name']; ?></h3>
	<?php
	while ($table = $tablesquery->fetchArray(SQLITE3_ASSOC)) {
		if($table['name'] == "name"){
			?>
				<div style="text-align:center"><h2><?php echo $row['name']; ?></h2></div>
				<div style="width:50%;margin:0 auto;text-align:center" class="wijnfoto"><img src="images/wijn_vb.png" style="max-height:100px;"></div>
				<table data-role="table" class="ui-shadow table-stripe ui-responsive">
					<thead>
						<tr class="ui-bar-d">
							<th>Eigenschap</th>
							<th>Waarde</th>
						</tr>
					</thead>
						<tbody>
			<?php
		}
		if($table['name'] != 'UID' and $table['name'] != 'name'){
			?>
							<tr>
								<td><?php echo array_search($table['name'], $vertaling); ?></td>
								<td><?php echo $row[$table['name']]; ?></td>
							</tr>
			<?php
			
		}
	}
	?>
						</tbody>
				</table>
	<div data-role="collapsible" data-content-theme="c">
		<h3>Extra eigenschappen</h3>
		<p>aanvullen..</p>
	</div>
</div>

<div style="width:25%;height:70px;float:left;text-align:center">
	<p style="font-weight:bold">Wit</p>
</div>
<div style="width:70%;float:right;height:70px;text-align:right">
	<img src="images/wijn_wit_vb_zijkant.png" style="max-height:50px" />
</div>


<div style="width:70%;float:left;height:70px">
	<img src="images/wijn_rose_vb_zijkant.png" style="max-height:50px" />
</div>
<div style="width:25%;height:70px;float:right;text-align:center">
	<p style="font-weight:bold">Rosé</p>
</div>
<?php
}

?>

<?php require 'paginaeind.php'; ?>

<?php require 'menu.php'; ?>

</body>
</html>