<?php
session_start();

require 'functies.php'; 

if('POST' === $_SERVER['REQUEST_METHOD']){
	if(isset($_POST["nieuwefles"])){
	# fles gegevens opslaan in csv
	$nieuweflescsvpad = "interface_files/intf_init_bottle.csv";
	
	$headerregel=array("UID","name","main_grape","year","type","date_in_fridge","status");
	$inhoudregel=array($_POST["UID"],$_POST["name"],$_POST["main_grape"],$_POST["year"],$_POST["type"],$_POST["date_in_fridge"],"enriched");
	$completecsv=array($headerregel,$inhoudregel);
	
	$fp = fopen($nieuweflescsvpad, "w");
	
	foreach ($completecsv as $fields) {
		fputcsv($fp, $fields, ";", '"');
	}
	
	fclose($fp);
	
	$redirecthome = true;
		
	$command = escapeshellcmd("/usr/bin/python3 " . getenv('WORKSPACE_PATH') . "front_end_actions.py 'process_bottle' 'intf_init_bottle.csv' '" . getenv('INTF_ENV') . "'");
	$command_output = shell_exec($command);
	
	}
	elseif(isset($_POST["nieuwefleseigenschap"])){
			$eigenschap = $_POST["eigenschap"];
			$waarde = $_POST["waarde"];
			
			$nieuwefleseigenschapcsvpad = "interface_files/intf_prop_bottle.csv";
			
			$headerregel=array("UID","property","value");
			$inhoudregel=array($_POST["uid"],$eigenschap,$waarde);
			$completecsv=array($headerregel,$inhoudregel);
			
			$fp = fopen($nieuwefleseigenschapcsvpad, "w");
	
			foreach ($completecsv as $fields) {
				fputcsv($fp, $fields, ";", '"');
			}
			
			fclose($fp);
			
			$redirecthome = true;
				
			$command = escapeshellcmd("/usr/bin/python3 " . getenv('WORKSPACE_PATH') . "front_end_actions.py 'process_bottle_properties' 'intf_prop_bottle.csv' '" . getenv('INTF_ENV') . "'");
			$command_output = shell_exec($command);
			

	}
	elseif(isset($_POST["naamdoorgeven"])){
		// naamdoorgeven bij beoordelen
			$naam = strip_tags($_POST['naam']);
			$_SESSION['name'] = $naam;
			$redirecthome = true;
			$redirectto = 'beoordelen.php';
	}
	else {
			$foutmelding = "nee2";
			$redirecthome = false;
	}
}
else {
	$foutmelding = "nee";	
	$redirecthome = false;
}
?>

<html>
<head>
<?php require 'headers.php'; ?>
</head>
<body>

<?php paginaheader("Wijnkoeler"); ?>

<?php 
	if(!$redirecthome){
		echo $foutmelding;
	}
	else{
		echo "Succesvol aangepast..";
		echo "<br>";
		echo $command_output;
		?>
		<script type="text/javascript">
			setTimeout(function(){
				<?php
				if(isset($redirectto){
					echo "window.location.href = '" . $redirectto . "';";
				}
				else{
					echo "window.location.href = 'index.php';";
				}
				?>
			}, 1000);
		</script>
		<?php
	}
?>

<?php require 'paginaeind.php'; ?>

</body>
</html>