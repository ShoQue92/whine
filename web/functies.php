<?php

$randomnummer = rand(0, 50000);

function paginaheader($paginanaam){
	
?>
<div data-role="page" id="page">
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
			$(".buildnum").css("color", "orange");
			$(".buildnum").text(intf_current_buildnum_output);
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
			$('.wijnkoeler-historie').html($('.wijnkoeler-historie-overzicht').html());
			$('.wijnkoeler-historie').show();
		}
		else if(vorigeweergave == 'opgedronken' && huidigeweergave == 'nu'){
			$('.wijnkoeler-historie').hide();
			$('.wijnkoeler-inhoud').show();
		}

})

$(document).on("click",".koelkasthistorieknop",function(){
	if($(this).attr('name')).html() == 'terug'){
		// terug naar algemene opgedronken pagina
		$('.wijnkoeler-historie').hide();
		$('.wijnkoeler-historie').html($('.wijnkoeler-historie-overzicht').html());
		$('.wijnkoeler-historie').show();
	}
	else{
		// naar specifieke maand
		$('.wijnkoeler-historie').hide();
		$('.wijnkoeler-historie').html($('.wijnkoeler-historie-maand-' + $(this).attr('name')).html());
		$('.wijnkoeler-historie').show();
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

function jquery_header_script($pagina,$locatie,$script){
	// returned de jquery functies voor header (aan te roepen met input)
	switch($pagina){
		case "Koelkast":
			?>
			<script>
			
			</script>
			<?php
			break;
	}
}

function jquery_body_script($pagina,$locatie,$script){
	// returned de jquery functies voor body (aan te roepen met input)
	switch($pagina){
		case "Koelkast":
			?>
			<script>
			
			</script>
			<?php
			break;
	}
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