<?php

$randomnummer = rand(0, 50000);

function paginaheader($paginanaam){
	
?>
<div data-role="page" id="page" data-hide-during-focus="">
<?php
// alleen tonen op homepage
if($paginanaam == "Wijnkoeler"){
?>
<script>
var intf_init_bottle_status = 'checkbestand.php?actie=intf_init_bottle_status';
var intf_init_bottle_status_output;

window.setInterval(function(){
	$.get(intf_init_bottle_status, function (data) {
		intf_init_bottle_status_output=data;
		if($("div#intf_init_bottle_status").is(":visible") && intf_init_bottle_status_output == "Invalid"){
			// open, sluiten
			$("#intf_init_bottle_status").hide();
		}
		else if($("div#intf_init_bottle_status").is(":hidden") && intf_init_bottle_status_output == "Valid"){
			// gesloten, openen
			$("#intf_init_bottle_status").show();
		}
		else{
			// geen actie voor nu
		}
	});
}, 1000);

var intf_current_temp = 'checkbestand.php?actie=fetch_latest_temp';
var intf_current_temp_output;

window.setInterval(function(){
	$.get(intf_current_temp, function (data) {
		intf_current_temp_output=data;
		if(intf_current_temp_output.length < 1){
			// leeg, melding
			$(".temp").html("Geen temperatuur beschikbaar");
		}
		else{
			// temp tonen
			$(".temp").html(intf_current_temp_output + "&#176;C");
		}
		
		
	});
}, 1000);

</script>
<?php
}
?>
<script>
var intf_current_buildnum = 'checkbestand.php?actie=buildnumber';
var intf_current_buildnum_output;

window.setInterval(function(){
	$.get(intf_current_buildnum, function (data) {
		intf_current_buildnum_output=data;
		if($(".buildnum").text() < intf_current_buildnum_output){
			$(".buildnum").html("<a href='.' style='color:orange;text-decoration:none'>" + intf_current_buildnum_output + "</a>");
		}
	});
}, 1000);

</script>

<script>
var vorigeweergave = 'nu';
var huidigeweergave = 'nu';
jQuery( document ).on( "pagechange",function(){
$(".koelkasttype").on("slidestop", function(){
    // switch tussen wijnkoeler-inhoud div en wijnkoeler-historie div
	vorigeweergave = huidigeweergave;
	huidigeweergave = $( ".koelkasttype" ).val();
		if(vorigeweergave == 'nu' && huidigeweergave == 'opgedronken'){
			$('.wijnkoeler-inhoud').hide();
			$('.wijnkoeler-historie-overzicht').show();
		}
		else if(vorigeweergave == 'opgedronken' && huidigeweergave == 'nu'){
			$('.wijnkoeler-historie-overzicht').hide();
			$('.wijnkoeler-inhoud').show();
		}

})

$(document).on("click",".koelkasthistorieknop",function(){
	if($(this).attr('name') == 'terug'){
		// terug naar algemene opgedronken pagina
		$('.wijnkoeler-historie-maand').hide();
		$('.wijnkoeler-historie-overzicht').show();
	}
	else{
		// naar specifieke maand
		$('.wijnkoeler-historie-overzicht').hide();
		$('.wijnkoeler-historie-maand-' + $(this).attr('name')).show();
	}
})

})




</script>
<div data-role="header">
	<h1><?php echo $paginanaam; ?></h1>
	<a href="#nav-panel" data-icon="bars" data-iconpos="notext">Menu</a>
	<a href="#add-form" data-icon="gear" data-iconpos="notext">Add</a>
</div><!-- /header -->
<?php
require 'paginastart.php';
}

function toon_wijninfo_koeler($rij, $pagina){
	global $tablesquery;
	global $resultaatqueryfleseigenschappen;
	global $vertaling;
	
	$command_beoordeling = escapeshellcmd("/usr/bin/python3 " . getenv('WORKSPACE_PATH') . "front_end_actions.py 'fetch_avg_rating_all'");
	$command_output_beoordeling = shell_exec($command_beoordeling);
	$beoordelingen_json = json_decode($command_output_beoordeling,true);
	
		?>

			<div data-role="collapsible" class="<?php echo $rij['UID']; ?> animateMe" data-content-theme="c"><h3><?php echo $rij['name']; ?> (<?php echo $rij['year']; ?>)</h3>
			<?php
			while ($table = $tablesquery->fetchArray(SQLITE3_ASSOC)) {
				if($table['name'] == "name"){
					?>
						<div style="text-align:center"><h2><?php echo $rij['name']; ?></h2></div>
						<div style="width:50%;margin:0 auto;text-align:center" class="wijnfoto"><img src="images/wijn_vb.png" style="max-height:100px;"></div>
						<table id="koelkast" style="width:100%">
										<?php
				}
				if($table['name'] != 'UID' and $table['name'] != 'name'){
					?>
							<tr>
								<td style="width:50%"><?php echo array_search($table['name'], $vertaling); ?></td>
								<td style="text-align:right;width:50%"><?php if($table['name'] == "date_in_fridge"){echo substr($rij[$table['name']],0,16); } else {echo $rij[$table['name']]; } ?></td>
							</tr>
					<?php
				}
			}
			?>		
						</table>
			
			<!-- beoordeling -->
			<div class="ui-corner-all custom-corners" style="margin-top:10px">
				<div class="ui-bar ui-bar-a">
				<h3>Beoordeling</h3>
				</div>
				<div class="ui-body ui-body-a">
					<?php
					$flesgevonden = false;
					
					// loop per fles om te kijken of er al beoordelingen zijn
					foreach ($beoordelingen_json as $flesbeoordeling){
						if($flesbeoordeling['UID'] == $rij['UID']){
							$gemscore = $flesbeoordeling['Gemiddelde waardering'];
							$aantalstemmen = $flesbeoordeling['Aantal stemmen'];
							$flesgevonden = true;
						}	
					}
					// tonen inhoud
					if($flesgevonden){
					?>
					<table class="beoordeling" style="width:100%">
						<tr>
							<td style="width:50%">Gem score:</td>
							<td style="text-align:right;width:50%"><?php echo $gemscore; ?></td>
						</tr>
						<tr>
							<td style="width:50%">Aantal stemmen:</td>
							<td style="text-align:right;width:50%"><?php echo $aantalstemmen; ?></td>
						</tr>
					</table>
					<?php
					}
					else{
					?>
						Geen beoordelingen
					<?php
					}
					if($pagina == "nu" || $pagina == "historie"){
					?>
						<a href="beoordelen.php?uid=<?php echo $rij['UID']; ?>" class="ui-btn ui-icon-star ui-btn-icon-left" data-transition="pop">Beoordelen</a>
					<?php
					}
					?>
				</div>
			</div>				
			<!-- einde beoordeling -->			
			<?php
			if($pagina == "nu" || $pagina == "historie"){
			?>
			<div class="ui-corner-all custom-corners" style="margin-top:10px">
				<div class="ui-bar ui-bar-a">
				<h3>Extra eigenschappen</h3>
				</div>
				<div class="ui-body ui-body-a">
						<table id="fleseigenschappen_tbl_<?php echo $rij['UID']; ?>" style="width:100%">
				<?php
				while ($eigenschaprij = $resultaatqueryfleseigenschappen->fetchArray()) {
					if($eigenschaprij['UID'] == $rij['UID']){
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
				<a href="#fleseigenschappen_<?php echo $rij['UID']; ?>" data-rel="popup" class="ui-btn ui-shadow" data-transition="pop">Nieuwe toevoegen..</a>
				</div>
				
			</div>
			<?php
			}
			if($pagina == "nu"){
			?>
			<div class="ui-corner-all custom-corners">
				<div class="ui-body ui-body-a">
				<a href="#flesverwijderen_<?php echo $rij['UID']; ?>" data-rel="popup" class="ui-btn ui-icon-delete ui-btn-icon-left" data-transition="pop">Uit de koelkast</a>
				</div>
				
			</div>
			<?php
			}
			if($pagina == "beoordelen"){
			?>
			<form name="flesbeoordelen_<?php echo $rij['UID']; ?>" action="acties_post.php" method="post" autocomplete="off">
			    <p>Geef je beoordeling van deze fles:</p>
			    <input type="range" name="beoordeling" class="slider-<?php echo $rij['UID']; ?>" min="1" max="5" step="1" value="1">
				<input type="hidden" name="uid" value="<?php echo $rij['UID']; ?>">
				<p>Eventuele opmerkingen:</p>
				<textarea name="opmerkingen" class="textarea"></textarea>
				<button type="submit" class="ui-btn ui-corner-all ui-shadow ui-btn-b ui-btn-icon-left ui-icon-check" name="flesbeoordelen" value="flesbeoordelen">Opslaan</button>
			</form>
			<?php
			}
			?>
			</div>
			<?php
			if($pagina == "nu" || $pagina == "historie"){
			?>
			<div data-role="popup" id="fleseigenschappen_<?php echo $rij['UID']; ?>" data-theme="a" class="ui-corner-all">
				<form name="wijneigenschappentoevoegen_<?php echo $rij['UID']; ?>" action="acties_post.php" method="post" autocomplete="off">
					<div style="padding:10px 20px;">
						<h3>Eigenschap toevoegen</h3>
						<label for="eigenschap" class="ui-hidden-accessible">Eigenschap</label>
						<input type="text" name="eigenschap" placeholder="eigenschap" data-theme="a">
						<label for="waarde" class="ui-hidden-accessible">Waarde</label>
						<input type="text" name="waarde" placeholder="waarde" data-theme="a">
						<input type="hidden" name="uid" value="<?php echo $rij['UID']; ?>">
						<button type="submit" class="ui-btn ui-corner-all ui-shadow ui-btn-b ui-btn-icon-left ui-icon-check" name="nieuwefleseigenschap" value="nieuwefleseigenschap">Opslaan</button>
					</div>
				</form>
			</div>
			<?php
			}
			if($pagina == "nu"){
			?>
			<div data-role="popup" id="flesverwijderen_<?php echo $rij['UID']; ?>" data-theme="a" class="ui-corner-all">
					<div style="padding:10px 20px;">
						<h3>Fles uit de koelkast, Opgedronken of verwijderen?</h3>
						<a href="acties_get.php?actie=flesopgedronken&uid=<?php echo $rij['UID']; ?>" class="ui-btn ui-icon-check ui-btn-icon-left" data-transition="pop">Opgedronken</a>
						<a href="acties_get.php?actie=flesverwijderen&uid=<?php echo $rij['UID']; ?>" class="ui-btn ui-icon-delete ui-btn-icon-left" data-transition="pop">Verwijderen</a>
					</div>
			</div>
			<?php
			}
			?>
		<?php
		
}

function read_intf_init_bottle_content($echo){

	$nieuweflescsvpad = "interface_files/intf_init_bottle.csv";

		$filevalid=false;
		if( file_exists($nieuweflescsvpad)){
			$fp = file($nieuweflescsvpad);
			if(count($fp) == 2){
				$bestand = file($nieuweflescsvpad,FILE_SKIP_EMPTY_LINES); 
				$bestandinhoud = array_map("str_getcsv",$bestand, array_fill(0, count($bestand), ';'));
					
				if($bestandinhoud[1][6] == "registered")
				{	
					if($echo){
						echo "Valid";
					}
					else{
						return $bestandinhoud;
					}
				}
				else
				{
					if($echo){
						echo "Invalid";
					}
					else{
						return $bestandinhoud;
					}
				}
			}
		}
	
	
}

class DotEnv
{
    /**
     * The directory where the .env file can be located.
     *
     * @var string
     */
    protected $path;


    public function __construct(string $path)
    {
        if(!file_exists($path)) {
            throw new \InvalidArgumentException(sprintf('%s does not exist', $path));
        }
        $this->path = $path;
    }

    public function load() :void
    {
        if (!is_readable($this->path)) {
            throw new \RuntimeException(sprintf('%s file is not readable', $this->path));
        }

        $lines = file($this->path, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
        foreach ($lines as $line) {

            if (strpos(trim($line), '#') === 0) {
                continue;
            }

            list($name, $value) = explode('=', $line, 2);
            $name = trim($name);
            $value = trim($value);

            if (!array_key_exists($name, $_SERVER) && !array_key_exists($name, $_ENV)) {
                putenv(sprintf('%s=%s', $name, $value));
                $_ENV[$name] = $value;
                $_SERVER[$name] = $value;
            }
        }
    }
}

(new DotEnv(__DIR__ . '/.env'))->load();

$buildnumber = file_get_contents('jenkins_build_dts.txt');
		
?>