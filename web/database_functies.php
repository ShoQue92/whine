<?php
// alle database functies in 1 bestand zodat die vaker included kan worden

$db = new SQLite3('db/whine_inventory.db');

$tablesquery = $db->query("PRAGMA table_info(whine_bottles);");
//$query = $db->prepare("SELECT * FROM whine_bottles order by date_in_fridge;");
$aantalflessen = $db->querySingle("SELECT count(1) FROM whine_bottles where type in('Rood','Wit','Rosé') and deleted_ind = 'N' and opgedronken_ind = 'N';");
$aantalflessenhistorie = $db->querySingle("SELECT count(1) FROM whine_bottles where type in('Rood','Wit','Rosé') and deleted_ind = 'N' and opgedronken_ind = 'J';");

$queryrood = $db->prepare("SELECT * FROM whine_bottles where type = 'Rood' and deleted_ind = 'N' and opgedronken_ind = 'N' order by date_in_fridge;");
$querywit = $db->prepare("SELECT * FROM whine_bottles where type = 'Wit' and deleted_ind = 'N' and opgedronken_ind = 'N' order by date_in_fridge;");
$queryrose = $db->prepare("SELECT * FROM whine_bottles where type = 'Rosé' and deleted_ind = 'N' and opgedronken_ind = 'N' order by date_in_fridge;");

$resultaatrood = $queryrood->execute();
$resultaatwit = $querywit->execute();
$resultaatrose = $queryrose->execute();

$queryalleflessenbehalveverwijderd = $db->prepare("SELECT * FROM whine_bottles where deleted_ind = 'N' order by date_in_fridge;");
$resultaatalleflessenbehalveverwijderd = $queryalleflessenbehalveverwijderd->execute();

$queryopgedronken = $db->prepare("SELECT *, strftime('%Y %m',date_in_fridge) as jaarmaand FROM whine_bottles where deleted_ind = 'N' and opgedronken_ind = 'J' order by date_in_fridge desc;");
$resultaatopgedronken = $queryopgedronken->execute();

$queryopgedronkenmaanden = $db->prepare("SELECT distinct strftime('%Y %m',date_in_fridge) as jaarmaand FROM whine_bottles where deleted_ind = 'N' and opgedronken_ind = 'J' order by date_in_fridge desc;");
$resultaatopgedronkenmaanden = $queryopgedronkenmaanden->execute();

$queryfleseigenschappen = $db->prepare("SELECT * FROM bottle_properties order by property_id;");
$resultaatqueryfleseigenschappen = $queryfleseigenschappen->execute();

$querygrapesoorten = $db->prepare("SELECT grape FROM grapes order by grape asc;");
$resultaatgrapesoorten = $querygrapesoorten->execute();

$vertaling = array('Druifsoort' => 'main_grape', 'Jaar' => 'year', 'Datum in koelkast' => 'date_in_fridge', 'Soort wijn' => 'type', 'Fles opgedronken' => 'opgedronken_ind', 'Fles verwijderd' => 'deleted_ind');


?>