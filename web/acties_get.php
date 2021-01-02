<?php

session_start();

require 'functies.php'; 

$nieuweflescsvpad = "interface_files/intf_init_bottle.csv";
$headerregel=array("UID","name","main_grape","year","type","date_in_fridge","status");

if('GET' === $_SERVER['REQUEST_METHOD']){
	if(isset($_GET["actie"])){
		switch ($_GET["actie"]) {
		case "flesverwijderen":
		
			$uid = $_GET["uid"];
			
			if(is_numeric($uid)){
			
				$command = escapeshellcmd("/usr/bin/python3 " . getenv('WORKSPACE_PATH') . "front_end_actions.py 'deleted_ind_UID' '" . $uid . "'");
				$command_output = shell_exec($command);
				
				$redirecthome = true;
			
			}
			else{
				$redirecthome = false;
				$foutmelding = "uid geen int";
			}
			break;
			
		case "flesopgedronken":
		
			$uid = $_GET["uid"];
			
			if(is_numeric($uid)){
			
				$command = escapeshellcmd("/usr/bin/python3 " . getenv('WORKSPACE_PATH') . "front_end_actions.py 'opgedronken_ind_UID' '" . $uid . "'");
				$command_output = shell_exec($command);
				
				$redirecthome = true;
			
			}
			else{
				$redirecthome = false;
				$foutmelding = "uid geen int";
			}
			break;	
		
		case "fleseigenschapverwijderen":
		
			$id = $_GET["id"];
			
			if(is_numeric($id)){
			
				$command = escapeshellcmd("/usr/bin/python3 " . getenv('WORKSPACE_PATH') . "front_end_actions.py 'delete_bottle_property' '" . $id . "'");
				$command_output = shell_exec($command);
				
				$redirecthome = true;
			
			}
			else{
				$redirecthome = false;
				$foutmelding = "id geen int";
			}
			break;
		
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
		case "cleantemptable":
			$command = escapeshellcmd("/usr/bin/python3 " . getenv('WORKSPACE_PATH') . "front_end_actions.py 'clear_temps'");
			$command_output = shell_exec($command);
			$redirecthome = true;
			$fp = fopen($nieuweflescsvpad, "w");
			fputcsv($fp, $headerregel, ";", '"');
			fclose($fp);
			break;	
		
		case "naamverwijderen":
			unset($_SESSION['naam']);
			$redirecthome = true;
			$redirectto = "beoordelen.php"
			break;	
		
		}
	}

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
		
		if(isset($command_output)){
			echo $command_output;
		}
		?>
		<script type="text/javascript">
			setTimeout(function(){
				<?php
				if(isset($redirectto)){
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