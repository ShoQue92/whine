<?php
require 'functies.php'; 

$redirecthome = false;

$nieuweflescsvpad = "interface_files/intf_init_bottle.csv";
$headerregel=array("UID","name","main_grape","year","type","date_in_fridge","status");
	
if(isset($_GET["actie"])){
	switch ($_GET["actie"]) {
		case "clear_db":
			// aanroepen functie met echo = ja
			$command = escapeshellcmd("/usr/bin/python3 " . getenv('WORKSPACE_PATH') . "front_end_actions.py 'clear_db'");
			$command_output = shell_exec($command);
			$fp = fopen($nieuweflescsvpad, "w");
			fputcsv($fp, $headerregel, ";", '"');
			$redirecthome = true;
			fclose($fp);
			break;
		case "recreate_db":
			$command = escapeshellcmd("/usr/bin/python3 " . getenv('WORKSPACE_PATH') . "front_end_actions.py 'recreate_db'");
			$command_output = shell_exec($command);
			$redirecthome = true;
			$fp = fopen($nieuweflescsvpad, "w");
			fputcsv($fp, $headerregel, ";", '"');
			fclose($fp);
			break;
	}
}

?>

<html>
<head>
<?php require 'headers.php'; ?>
</head>
<body>

<?php paginaheader("Wijnkoeler"); 

if($redirecthome){
	echo $command_output;
	
	
?>
<script type="text/javascript">
	setTimeout(function(){
	window.location.href = 'index.php';
	}, 1000);
</script>

<?php 
}

require 'paginaeind.php'; ?>

</body>
</html>