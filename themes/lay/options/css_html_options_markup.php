<div class="wrap">
    <h2>Custom CSS &amp; HTML</h2>

    <?php if(isset( $_GET['settings-updated'])) { ?>
    <div class="updated">
        <p>Custom CSS &amp; HTML updated.</p>
    </div>
	<?php } ?>

	<form method="POST" action="options.php">
	<?php submit_button(); ?>
	<?php settings_fields( 'manage-htmlcssoptions' );	//pass slug name of page, also referred
	                                        //to in Settings API as option group name
	do_settings_sections( 'manage-htmlcssoptions' ); 	//pass slug name of page
	echo CSSHTMLOptions::getCustomCSSEditorMarkup();
	echo CSSHTMLOptions::getCustomDesktopCSSEditorMarkup();
	echo CSSHTMLOptions::getCustomMobileCSSEditorMarkup();
	echo CSSHTMLOptions::getCustomHeadContentEditorMarkup();
	echo CSSHTMLOptions::getCustomHTMLTopEditorMarkup();
	echo CSSHTMLOptions::getCustomHTMLBottomEditorMarkup();
	submit_button();
	?>
	</form>
</div>