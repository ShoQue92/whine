<!-- menu -->
<div data-role="panel" data-display="push" data-theme="b" id="nav-panel">
		<ul data-role="listview">
			<li data-icon="delete"><a href="#" data-rel="close">&nbsp;</a></li>
			<li data-icon="home"><a href="index.php">Startpagina</a></li>
			<?php 
			
			$bestandinhoud = read_intf_init_bottle_content(false);
			if($bestandinhoud[1][6] == "registered"){
			?>
			<li data-icon="alert"><a href="nieuwefles.php">Nieuwe fles</a></li>
			<?php
			}
			?>			
			<li><a href="koelkast.php">Koelkast</a></li>    
		</ul>
</div><!-- /menu -->

<!-- rechterscherm -->
<div data-role="panel" data-position="right" data-display="reveal" data-theme="a" id="add-form">
		<form class="userform">
			<h2>Acties</h2>
				<?php
					$randomnummer = rand(0, 5000);
				?>
				<a href="#popupDialog_clear_<?php echo $randomnummer; ?>" data-rel="popup" data-position-to="window" data-transition="pop" class="ui-btn ui-corner-all ui-shadow ui-btn-inline ui-icon-delete ui-btn-icon-left ui-btn-b">DB Schonen</a>
				<div data-role="popup" id="popupDialog_clear_<?php echo $randomnummer; ?>" data-overlay-theme="b" data-theme="b" data-dismissible="false" style="max-width:400px;">
				    <div role="main" class="ui-content">
				        <h3 class="ui-title">Weet je zeker dat je de DB wilt schonen (wine bottles legen?)</h3>
				    	<p>Dit kan niet terugedraait worden.</p>
				        <a href="#" class="ui-btn ui-corner-all ui-shadow ui-btn-inline ui-btn-b" data-rel="back">Terug</a>
				        <a href="acties_get.php?actie=clear_db" class="ui-btn ui-corner-all ui-shadow ui-btn-inline ui-btn-b">Schonen</a>
				    </div>
				</div>
				<a href="#popupDialog_recreate_<?php echo $randomnummer; ?>" data-rel="popup" data-position-to="window" data-transition="pop" class="ui-btn ui-corner-all ui-shadow ui-btn-inline ui-icon-delete ui-btn-icon-left ui-btn-b">DB Recreaten</a>
				<div data-role="popup" id="popupDialog_recreate_<?php echo $randomnummer; ?>" data-overlay-theme="b" data-theme="b" data-dismissible="false" style="max-width:400px;">
				    <div role="main" class="ui-content">
				        <h3 class="ui-title">Weet je zeker dat je de DB wilt recreaten?</h3>
				    	<p>Dit kan niet terugedraait worden.</p>
				        <a href="#" class="ui-btn ui-corner-all ui-shadow ui-btn-inline ui-btn-b" data-rel="back">Terug</a>
				        <a href="acties_get.php?actie=recreate_db" class="ui-btn ui-corner-all ui-shadow ui-btn-inline ui-btn-b">Schonen</a>
				    </div>
				</div>
		</form>

</div><!-- /rechterscherm -->
<?php
// checken welke omgeving we zitten
if(substr(dirname(__FILE__),-4,4) == 'test'){
	$omgeving = "Test";
}
else{
	$omgeving = "Prod";
}
?>
<div data-role="footer" data-position="fixed"> 
	<h4>Build number (<?php echo $omgeving; ?>): <?php echo $buildnumber; ?></h4> 
</div> 
</div><!-- /page -->