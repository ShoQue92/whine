<?php
require 'functies.php'; 
?>
<html>
<head>
<?php require 'headers.php'; ?>

</head>
<body>

<?php paginaheader("Koelkast"); ?>

<script>

$(document).on("pagecreate", "#page", function(){
    $(".animateMe .ui-collapsible-heading-toggle").on("click", function (e) { 
        var current = $(this).closest(".ui-collapsible");             
        if (current.hasClass("ui-collapsible-collapsed")) {
            //collapse all others and then expand this one
            $(".ui-collapsible").not(".ui-collapsible-collapsed").find(".ui-collapsible-heading-toggle").click();
            $(".ui-collapsible-content", current).slideDown(300);
        } else {
            $(".ui-collapsible-content", current).slideUp(300);
        }
    });
});

</script>

<?php

$db = new SQLite3('db/whine_inventory.db');

$tablesquery = $db->query("PRAGMA table_info(whine_bottles);");
$query = $db->prepare("SELECT * FROM whine_bottles order by date_in_fridge;");
$aantalflessen = $db->querySingle("SELECT count(1) FROM whine_bottles where type in('Rood','Wit','Rosé') and deleted_ind = 'N' and opgedronken_ind = 'N';");
$aantalflessenhistorie = $db->querySingle("SELECT count(1) FROM whine_bottles where type in('Rood','Wit','Rosé') and deleted_ind = 'N' and opgedronken_ind = 'J';");

$queryrood = $db->prepare("SELECT * FROM whine_bottles where type = 'Rood' and deleted_ind = 'N' and opgedronken_ind = 'N' order by date_in_fridge;");
$querywit = $db->prepare("SELECT * FROM whine_bottles where type = 'Wit' and deleted_ind = 'N' and opgedronken_ind = 'N' order by date_in_fridge;");
$queryrose = $db->prepare("SELECT * FROM whine_bottles where type = 'Rosé' and deleted_ind = 'N' and opgedronken_ind = 'N' order by date_in_fridge;");

$resultaatrood = $queryrood->execute();
$resultaatwit = $querywit->execute();
$resultaatrose = $queryrose->execute();

$queryopgedronken = $db->prepare("SELECT * FROM whine_bottles where deleted_ind = 'N' and opgedronken_ind = 'J' order by date_in_fridge desc;");
$resultaatopgedronken = $queryopgedronken->execute();

$queryopgedronkenmaanden = $db->prepare("SELECT strftime('%Y %m',date_in_fridge) as jaarmaand FROM whine_bottles where deleted_ind = 'N' and opgedronken_ind = 'J' order by date_in_fridge desc;");
$resultaatopgedronkenmaanden = $queryopgedronkenmaanden->execute();

$queryfleseigenschappen = $db->prepare("SELECT * FROM bottle_properties order by property_id;");
$resultaatqueryfleseigenschappen = $queryfleseigenschappen->execute();

$vertaling = array('Druifsoort' => 'main_grape', 'Jaar' => 'year', 'Datum in koelkast' => 'date_in_fridge', 'Soort wijn' => 'type');


function getwijnsoort($wijnsoort, $resultaat){
	global $tablesquery;
	global $vertaling;
	global $resultaatqueryfleseigenschappen;
	
	// geeft de inhoud vd wijnkoeler weer, kan aangeroepen worden met wijnsoort (rood, wit, rose) als input.
		?>
		<div class="ui-content">
			<div style="width:70%;float:left;height:70px" id="flesrood_afbeelding">
				<img src="images/wijn_<?php echo $wijnsoort; ?>_vb_zijkant.png" style="max-height:50px" />
			</div>
			<div style="width:25%;height:70px;float:right;text-align:center" id="flesrood_text">
				<p style="font-weight:bold"><?php echo ucfirst($wijnsoort); ?></p>
			</div>
		</div>

		<div data-role="collapsibleset">
		<?php
		while ($row = $resultaat->fetchArray()) {
		?>

			<div data-role="collapsible" class="animateMe" data-content-theme="c"><h3><?php echo $row['name']; ?> (<?php echo $row['year']; ?>)</h3>
			<?php
			while ($table = $tablesquery->fetchArray(SQLITE3_ASSOC)) {
				if($table['name'] == "name"){
					?>
						<div style="text-align:center"><h2><?php echo $row['name']; ?></h2></div>
						<div style="width:50%;margin:0 auto;text-align:center" class="wijnfoto"><img src="images/wijn_vb.png" style="max-height:100px;"></div>
						<table id="koelkast" style="width:100%">
										<?php
				}
				if($table['name'] != 'UID' and $table['name'] != 'name'){
					?>
							<tr>
								<td style="width:50%"><?php echo array_search($table['name'], $vertaling); ?></td>
								<td style="text-align:right;width:50%"><?php if($table['name'] == "date_in_fridge"){echo substr($row[$table['name']],0,16); } else {echo $row[$table['name']]; } ?></td>
							</tr>
					<?php
				}
			}
			?>		
						</table>
			<div class="ui-corner-all custom-corners" style="margin-top:10px">
				<div class="ui-bar ui-bar-a">
				<h3>Extra eigenschappen</h3>
				</div>
				<div class="ui-body ui-body-a">
						<table id="fleseigenschappen_tbl_<?php echo $row['UID']; ?>" style="width:100%">
				<?php
				while ($eigenschaprij = $resultaatqueryfleseigenschappen->fetchArray()) {
					if($eigenschaprij['UID'] == $row['UID']){
						// eigenschap van toepassing voor deze fles, tonen
						?>
						
							<tr>
								<td style="width:50%"><?php echo $eigenschaprij['property']; ?></td>
								<td style="text-align:right;width:40%"><?php echo $eigenschaprij['value']; ?></td>
								<td style="text-align:right;width:10%" class="eigenschapverwijderen"><a href="acties_get.php?actie=fleseigenschapverwijderen&id=<?php echo $eigenschaprij['property_id']; ?>" class="ui-btn ui-shadow ui-corner-all ui-icon-delete ui-btn-icon-notext">Delete</a></span></td>
							</tr>
						
						<?php
					}
				}
				?>
						</table>
				<a href="#fleseigenschappen_<?php echo $row['UID']; ?>" data-rel="popup" class="ui-btn ui-shadow" data-transition="pop">Nieuwe toevoegen..</a>
				</div>
				
			</div>
			<div class="ui-corner-all custom-corners">
				<div class="ui-body ui-body-a">
				<a href="acties_get.php?actie=flesverwijderen&uid=<?php echo $row['UID']; ?>" class="ui-btn ui-icon-delete ui-btn-icon-left">Verwijderen</a>
				</div>
				
			</div>
			</div>
		
			<div data-role="popup" id="fleseigenschappen_<?php echo $row['UID']; ?>" data-theme="a" class="ui-corner-all">
				<form name="wijneigenschappentoevoegen_<?php echo $row['UID']; ?>" action="acties_post.php" method="post" autocomplete="off">
					<div style="padding:10px 20px;">
						<h3>Eigenschap toevoegen</h3>
						<label for="eigenschap" class="ui-hidden-accessible">Eigenschap</label>
						<input type="text" name="eigenschap" placeholder="eigenschap" data-theme="a">
						<label for="waarde" class="ui-hidden-accessible">Waarde</label>
						<input type="text" name="waarde" placeholder="waarde" data-theme="a">
						<input type="hidden" name="uid" value="<?php echo $row['UID']; ?>">
						<button type="submit" class="ui-btn ui-corner-all ui-shadow ui-btn-b ui-btn-icon-left ui-icon-check" name="nieuwefleseigenschap" value="nieuwefleseigenschap">Opslaan</button>
					</div>
				</form>
			</div>
		<?php
		}
		?>
		</div>
	
<?php	
	
}

?>

<div id="actualofhistory" class="ui-bar ui-bar-a ui-corner-all">
	<div class="containing-element">
	<select class="koelkasttype" data-role="slider">
		<option value="nu">Nu in de koelkast</option>
		<option value="opgedronken">Al opgedronken</option>
	</select>
	</div>
</div>

<div class="wijnkoeler-inhoud">

<div id="koelkastheader">
<h3 class="ui-bar ui-bar-a ui-corner-all" style="text-align:center">In totaal <?php if($aantalflessen == 0){echo "geen flessen"; } else{ echo $aantalflessen . ' fles'; if($aantalflessen > 1){echo "sen";}} ?> in de koelkast.</h3>
</div>

<?php

// rood
getwijnsoort("rood",$resultaatrood);

// wit
getwijnsoort("wit",$resultaatwit);

// rose
getwijnsoort("rose",$resultaatrose);

?>

</div>

<div class="wijnkoeler-historie" style="display: none">

	<div id="koelkast-historieheader">
	<h3 class="ui-bar ui-bar-a ui-corner-all" style="text-align:center">In totaal <?php if($aantalflessenhistorie == 0){echo "geen flessen"; } else{ echo $aantalflessenhistorie . ' fles'; if($aantalflessenhistorie > 1){echo "sen";}} ?> opgedronken.</h3>
	</div>

	<?php

	// collapsible per jaar/maand
	while ($row = $resultaatopgedronkenmaanden->fetchArray()) {
		$jaar = substr($row['jaarmaand'],0,4);
		$maand = substr($row['jaarmaand'],4);
		$maandstring = date("F", $jaar . "-" . $maand . "-01");
				
	?>
		<a href="#" class="ui-btn ui-icon-arrow-r ui-btn-icon-right" style="text-align:center"><?php echo $jaar . " " . $maandstring; ?></a>
	<?php

	}

	?>

</div>



<?php require 'paginaeind.php'; ?>

</body>
</html>