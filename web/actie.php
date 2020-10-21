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
<head>
<title>Wijnkoeler</title>
<meta name="viewport" content="width=device-width, initial-scale=1"> 
<link rel="stylesheet" href="https://code.jquery.com/mobile/1.4.5/jquery.mobile-1.4.5.min.css" />
<script src="https://code.jquery.com/jquery-1.11.1.min.js"></script>
<script src="https://code.jquery.com/mobile/1.4.5/jquery.mobile-1.4.5.min.js"></script>
<link rel="stylesheet" href="style.css">
<script type="text/javascript" src="code.js"></script>
</head>
<body>

<div data-role="page">

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

</div><!-- /page -->

</body>
</html>