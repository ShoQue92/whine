<?php

if('POST' === $_SERVER['REQUEST_METHOD']){
	if(isset($_POST["submit"])){
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
	
	# hier nog python script aanroepen.
	
	$command = escapeshellcmd("/usr/bin/python3 /home/jenkins/workspace/Whine_main/front_end_actions.py 'process_bottle' 'intf_init_bottle.csv' '/var/www/html/interface_files'");
	$command_output = shell_exec($command);

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
		
		?>
		<script type="text/javascript">
			setTimeout(function(){
				window.location.href = 'index.php';
			}, 1000);
		</script>
		<?php
	}
?>

<?php require 'paginaeind.php'; ?>

</body>
</html>