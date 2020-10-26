<?php

$db = new SQLite3('db/whine_inventory.db');
$wijnflessen = $db->query('SELECT * FROM whine_bottles order by date_in_fridge');

?>

<div role="main" class="ui-content jqm-content jqm-fullwidth">