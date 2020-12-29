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
		if(isset($_SESSION['curr_buildnumber']){
			// sessie waarde bestaat, kijken of huidige waarde hoger is dan sessie waarde
			if($_SESSION['curr_buildnumber'] == $buildnumber){
				// huidige waarde is gelijk, dus buildnumber gewoon teruggeven
				echo $buildnumber;
			}
			else{
				// huidige waarde is hoger, dus buildnumber met N ervoor
				$_SESSION['curr_buildnumber'] = $buildnumber;
				echo "N" . $buildnumber;
			}
		}
		else{
			// sessie waarde bestaat niet, teruggeven huidige waarde en instellen sessie
			$_SESSION['curr_buildnumber'] = $buildnumber;
			echo $buildnumber;
		}
        
}
?>