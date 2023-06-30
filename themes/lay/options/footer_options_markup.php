<div class="wrap">
    <h2>Footers</h2>

    <?php if(isset( $_GET['settings-updated'])) { ?>
    <div class="updated">
        <p>Footers updated.</p>
    </div>
    <?php } ?>

    <div class="lay-explanation">
        <div class="lay-explanation-inner">
            <p>When the Fullscreen Slider Addon is active the footer will not show up for that page at the moment.</p>
        </div>
    </div>

	<form method="POST" action="options.php">
	<?php settings_fields( 'manage-footer' );	//pass slug name of page, also referred
	                                        //to in Settings API as option group name
	do_settings_sections( 'manage-footer' ); 	//pass slug name of page
	submit_button('Save');
	?>
	</form>
</div>