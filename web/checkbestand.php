<?php
require 'functies.php'; 

	$actie=htmlspecialchars($_GET["actie"]);
	
	switch ($actie) {
    case "intf_init_bottle_status":
		// aanroepen functie met echo = ja
		read_intf_init_bottle_content(true);
		
        break;
    case "fetch_latest_temp":
		echo "actie = fetch latest temp";
		
		echo "<br>";
        
		
		$command = escapeshellcmd("/usr/bin/python3 " . getenv('WORKSPACE_PATH') . "front_end_actions.py 'fetch_cur_temp'");
		echo "uitvoeren command " . $command . " en uitvoer parsen";
		
		$command_output = shell_exec($command);
		
		
		echo "command output:";
		echo "<br>";
		echo $command_output;
		
		$temp_json = json_decode($command_output);
		
		print_r($temp_json);
		
		
		break;
    case 2:
        echo "i equals 2";
        break;
}
	
	
	?>