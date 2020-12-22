<?php

if('GET' === $_SERVER['REQUEST_METHOD']){
	if(isset($_GET["actie"])){
		
		if($_GET["actie"] == "flesverwijderen"){
				
			$uid = $_GET["uid"];
			
			if(is_int($uid)){
			
				$command = escapeshellcmd("/usr/bin/python3 /home/jenkins/workspace/Whine_main/front_end_actions.py 'delete_bottle' '" . $uid . "' 2>&1");
				$command_output = shell_exec($command);
			
			}
			
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