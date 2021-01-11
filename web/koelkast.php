<?php
require 'database_functies.php';
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
			toon_wijninfo_koeler($row,"nu");
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
<h3 class="ui-bar ui-bar-a ui-corner-all" style="text-align:center">In totaal <?php if($aantalflessen == 0){echo "geen flessen"; } else{ echo $aantalflessen . ' fles'; if($aantalflessen > 1){echo "sen";}} ?></h3>
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
	<h3 class="ui-bar ui-bar-a ui-corner-all" style="text-align:center">In totaal <?php if($aantalflessenhistorie == 0){echo "geen flessen"; } else{ echo $aantalflessenhistorie . ' fles'; if($aantalflessenhistorie > 1){echo "sen";}} ?></h3>
	</div>

	<?php

	// knop per jaar/maand
	while ($row = $resultaatopgedronkenmaanden->fetchArray()) {
		$jaar = (int) substr($row['jaarmaand'],0,4);
		$maand = (int) substr($row['jaarmaand'],4);
		setlocale(LC_TIME, 'nl_NL.utf8');
		$maandstring = ucfirst(strftime("%B", mktime(0,0,0,$maand,1,$jaar)));
				
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
		$maandstring = ucfirst(strftime("%B", mktime(0,0,0,$maand,1,$jaar)));
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
				toon_wijninfo_koeler($row,"historie");
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