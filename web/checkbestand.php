<?php
require 'functies.php'; 

	$actie=htmlspecialchars($_GET["actie"]);
	
	switch ($actie) {
    case "intf_init_bottle_status":
		// aanroepen functie met echo = ja
		read_intf_init_bottle_content(true);
		
        break;
    case 1:
        echo "i equals 1";
        break;
    case 2:
        echo "i equals 2";
        break;
}
	
	
	?>