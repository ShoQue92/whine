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

$queryopgedronken = $db->prepare("SELECT *, strftime('%Y %m',date_in_fridge) as jaarmaand FROM whine_bottles where deleted_ind = 'N' and opgedronken_ind = 'J' order by date_in_fridge desc;");
$resultaatopgedronken = $queryopgedronken->execute();

$queryopgedronkenmaanden = $db->prepare("SELECT distinct strftime('%Y %m',date_in_fridge) as jaarmaand FROM whine_bottles where deleted_ind = 'N' and opgedronken_ind = 'J' order by date_in_fridge desc;");
$resultaatopgedronkenmaanden = $queryopgedronkenmaanden->execute();

$queryfleseigenschappen = $db->prepare("SELECT * FROM bottle_properties order by property_id;");
$resultaatqueryfleseigenschappen = $queryfleseigenschappen->execute();

$vertaling = array('Druifsoort' => 'main_grape', 'Jaar' => 'year', 'Datum in koelkast' => 'date_in_fridge', 'Soort wijn' => 'type', 'Fles opgedronken' => 'opgedronken_ind', 'Fles verwijderd' => 'deleted_ind');


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
			toon_wijninfo_koeler($row,$tablesquery,"nu",$resultaatqueryfleseigenschappen,$vertaling);
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

<div class="wijnkoeler-historie-overzicht" style="display: none">

	<div class="koelkast-historieheader">
	<h3 class="ui-bar ui-bar-a ui-corner-all" style="text-align:center">In totaal <?php if($aantalflessenhistorie == 0){echo "geen flessen"; } else{ echo $aantalflessenhistorie . ' fles'; if($aantalflessenhistorie > 1){echo "sen";}} ?> opgedronken.</h3>
	</div>

	<?php

	// knop per jaar/maand
	while ($row = $resultaatopgedronkenmaanden->fetchArray()) {
		$jaar = (int) substr($row['jaarmaand'],0,4);
		$maand = (int) substr($row['jaarmaand'],4);
		setlocale(LC_TIME, 'nl_NL.utf8');
		$maandstring = strftime("%B", mktime(0,0,0,$maand,1,$jaar));
				
	?>
		<a href="#" class="ui-btn ui-icon-arrow-r ui-btn-icon-right koelkasthistorieknop" style="text-align:center" name="<?php echo $jaar . "-" . $maand; ?>"><?php echo $jaar . " " . $maandstring; ?></a>
	<?php

	}

	?>

</div>
<?php

// divs maken per jaar/maand
while ($row = $resultaatopgedronkenmaanden->fetchArray()) {
		$jaar = (int) substr($row['jaarmaand'],0,4);
		$maand = (int) substr($row['jaarmaand'],4);
		setlocale(LC_TIME, 'nl_NL.utf8');
		$maandstring = strftime("%B", mktime(0,0,0,$maand,1,$jaar));
		$classnaam = $jaar . "-" . $maand;
?>
<div class="wijnkoeler-historie-maand-<?php echo $classnaam; ?> wijnkoeler-historie-maand" style="display:none">
	<a href="#" class="ui-btn ui-icon-arrow-l ui-btn-icon-left koelkasthistorieknop" style="text-align:center" name="terug">Terug naar overzicht</a>
	<div class="koelkast-historieheader">
	<h3 class="ui-bar ui-bar-a ui-corner-all" style="text-align:center"><?php echo $jaar . " " . $maandstring; ?></h3>
	</div>
		<?php
		while ($row = $resultaatopgedronken->fetchArray()) {
			$jaarrij = (int) substr($row['jaarmaand'],0,4);
			$maandrij = (int) substr($row['jaarmaand'],4);
			$classnaamrij = $jaarrij . "-" . $maandrij;
			if($classnaam == $classnaamrij){
				// maand van fles == maand van div
				toon_wijninfo_koeler($row,$tablesquery,"historie",$resultaatqueryfleseigenschappen,$vertaling);
			}
		}
		?>
</div>
<?php
}
?>


<?php require 'paginaeind.php'; ?>

</body>
</html>