<?php

if('POST' === $_SERVER['REQUEST_METHOD']){
	if(isset($_POST["submit"])){
	# fles gegevens opslaan in csv
	$nieuweflescsvpad = "workdir/nieuwefles.csv";
	
	$headerregel=array("status","UID","name","main_grape","year","date_in_fridge");
	$inhoudregel=array("enriched",$_POST["UID"],$_POST["name"],$_POST["main_grape"],$_POST["year"],$_POST["date_in_fridge"]);
	$completecsv=array($headerregel,$inhoudregel);
	
	$fp = fopen($nieuweflescsvpad, "w");
	
	foreach ($completecsv as $fields) {
		fputcsv($fp, $fields, ";", '"');
	}
	
	fclose($fp);
	
	$redirecthome = true;
	
	# hier nog python script aanroepen.
	
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
<body>
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
			}, 5000);
		</script>
		<?php
	}
?>
</body>
</html>