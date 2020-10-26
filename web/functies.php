<?php
function paginaheader($paginanaam){
	
?>
<div data-role="page">
<div data-role="header">
	<h1><?php echo $paginanaam; ?></h1>
	<a href="#nav-panel" data-icon="bars" data-iconpos="notext">Menu</a>
	<a href="#add-form" data-icon="gear" data-iconpos="notext">Add</a>
</div><!-- /header -->
<?php
require 'paginastart.php';
}
?>