<div class="wrap">
    <h2>Cover Options</h2>

    <?php if(isset( $_GET['settings-updated'])) { ?>
    <div class="updated">
        <p>Cover Options updated.</p>
    </div>
    <?php } ?>

    
    <div class="lay-explanation">
        <div class="lay-explanation-inner">
        	<p>The first row of your layout will be your cover. A cover is like an introduction to your project, page or category.<br>The cover will disappear underneath your content when you scroll down. A Cover is always browser filling.</p>
            <p>For example you can have a <a href="http://laytheme.com/documentation.html#full-bleed-images" target="_blank">full-bleed image</a> (row background image) and some text on top as a cover for a project.</p>
            <p>When the Fullscreen Slider Addon is active the cover will behave like a default row for that page at the moment.</p>
        </div>
    </div>

	<form method="POST" action="options.php">
	<?php settings_fields( 'manage-coveroptions' );	//pass slug name of page, also referred
	                                        //to in Settings API as option group name
	do_settings_sections( 'manage-coveroptions' ); 	//pass slug name of page
	submit_button('Save');
	?>
	</form>
</div>