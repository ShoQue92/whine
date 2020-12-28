<?php
require 'functies.php'; 
?>
<html>
<head>
<?php require 'headers.php'; ?>
</head>
<body>

<?php paginaheader("Nieuwe fles"); ?>

<a href="index.php" class="ui-btn ui-shadow" data-transition="pop">Terug</a>

<?php

$bestandinhoud = read_intf_init_bottle_content(false);

$db = new SQLite3('db/whine_inventory.db');
$querygrapesoorten = $db->prepare("SELECT grape FROM grapes order by grape asc;");
$resultaatgrapesoorten = $querygrapesoorten->execute();

?>
<h3 class="ui-bar ui-bar-a ui-corner-all" style="text-align:center">Toevoegen nieuwe wijnfles</h3>

<div data-corners="true" data-shadow="true" data-iconshadow="true" data-wrapperels="span" data-icon="null" data-iconpos="null" data-theme="b" class="ui-btn ui-btn-up-b ui-shadow ui-btn-corner-all ui-submit" aria-disabled="false">
<form name="wijnflestoevoegen" action="actie.php" method="post" autocomplete="off">
	<input type="hidden" name="actie" value="toevoegenfles" />
	<span class="ui-btn-inner ui-btn-corner-all">
		<div data-role="fieldcontain">
		
			<?php
			$disabledvelden = array("UID","date_in_fridge");
			
			$kolomnr=0;
			foreach($bestandinhoud[0] as $header){
				if($header != "status" && $header != "type" && $header != "year" && $header != "main_grape"){
					if(in_array($header,$disabledvelden)){
					?>
					<input type="hidden" name="<?php echo $header; ?>" value="<?php echo $bestandinhoud[1][$kolomnr]; ?>" />
					<?php
					}
					?>
					<label for="<?php echo $header; ?>"><?php echo str_replace("_"," ",ucfirst($header)); ?></label>
					<input required <?php if(in_array($header,$disabledvelden)){echo "disabled=\"disabled\""; } ?> type="text" name="<?php echo $header; ?>" value="<?php if($header == "date_in_fridge"){echo substr($bestandinhoud[1][$kolomnr],0,16); } else {echo $bestandinhoud[1][$kolomnr]; } ?>" style="text-align:center" />
					<?php
				}
					elseif($header == "main_grape"){
					?>
					
					    <label for="select-custom-1">Basis druif:</label>
					    <select name="main_grape" id="select-custom-1" data-native-menu="false" data-mini="true">
							<option value="Kies" data-placeholder="true">Kies...</option>
							<?php
							while ($row = $resultaatgrapesoorten->fetchArray()) {
							?>
					        <option value="<?php echo $row['grape'];; ?>"><?php echo $row['grape']; ?></option>
							<?php
							}
							?>
					    </select>
					
					<?php
					}
					elseif($header == "year"){
					?>
					
					    <label for="select-custom-2">Jaar:</label>
					    <select name="year" id="select-custom-2" data-native-menu="false" data-mini="true">
							<option value="Kies" data-placeholder="true">Kies...</option>
							<?php
							for($x = date("Y"); $x >= date("Y")-15; $x--){
							?>
					        <option value="<?php echo $x; ?>"><?php echo $x; ?></option>
							<?php
							}
							?>
					    </select>
					
					<?php
					}
				
					elseif($header == "type"){
					?>
					
					    <label for="select-custom-3">Soort wijn:</label>
					    <select name="type" id="select-custom-3" data-native-menu="false" data-mini="true">
							<option value="Kies" data-placeholder="true">Kies...</option>
					        <option value="Rood">Rood</option>
					        <option value="Wit">Wit</option>
					        <option value="Rosé">Rosé</option>
					    </select>
					
					<?php
					}
				
				
			$kolomnr++;
			}
			?>
		</div>	
	</span>
	<button type="submit" data-theme="b" name="submit" value="submit" class="ui-btn-hidden" aria-disabled="false">Opslaan</button>
</form>	
</div>

<?php require 'paginaeind.php'; ?>

</body>
</html>
