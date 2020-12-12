<?php
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

</script>
<?php
}
?>
<div data-role="header">
	<h1><?php echo $paginanaam; ?></h1>
	<a href="#nav-panel" data-icon="bars" data-iconpos="notext">Menu</a>
	<a href="#add-form" data-icon="gear" data-iconpos="notext">Add</a>
</div><!-- /header -->
<?php
require 'paginastart.php';
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
?>