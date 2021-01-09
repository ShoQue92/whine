<?php
require 'functies.php'; 

	$actie=htmlspecialchars($_GET["actie"]);
	
	switch ($actie) {
    case "intf_init_bottle_status":
		// aanroepen functie met echo = ja
		read_intf_init_bottle_content(true);
		
        break;
    case "fetch_latest_temp":
		$command = escapeshellcmd("/usr/bin/python3 " . getenv('WORKSPACE_PATH') . "front_end_actions.py 'fetch_cur_temp'");
		$command_output = shell_exec($command);
		
		$temp_json = json_decode($command_output,true);
		
		echo $temp_json['celsius'];
		
		break;
    case "buildnumber":
		$buildnumber = file_get_contents('jenkins_build_dts.txt');
		echo $buildnumber;
		break;
	case "fetch_avg_rating":
		// uid opgeven
		$command = escapeshellcmd("/usr/bin/python3 " . getenv('WORKSPACE_PATH') . "front_end_actions.py 'fetch_avg_rating_all'");
		$command_output = shell_exec($command);
		
		$avg_rating_all = json_decode($command_output,true);
		
		echo $avg_rating_all;
		
		break;
	case "fetch_avg_rating_all":
		// zonder uid opgeven
		break;
}
?>