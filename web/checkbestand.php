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
		
		echo round($temp_json['celsius'],1);
		
		break;
    case "buildnumber":
		$buildnumber = file_get_contents('jenkins_build_dts.txt');
		echo $buildnumber;
		break;
}
?>