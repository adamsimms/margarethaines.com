<?php if(isset( $_GET['settings-updated'])) { ?>
	<?php 
	// need this so "news" permalinks will be refreshed
	global $wp_rewrite;
	$wp_rewrite->flush_rules(true);
	?>
<?php } ?>
<div class="wrap">
    <style>
        html {
			scroll-behavior: smooth;
		}
    </style>
	<form method="POST" action="options.php">
        <div class="top-layoptions-submit-button-wrap">
            <h1>Lay Options</h1><?php submit_button(); ?>
        </div>
        <div class="layoptions-quickjump-wrap">
            <div class="layoptions-quickjump">
                <a href="#lay-extra-features">Extra Features</a>
                <a href="#lay-transition">Transitions when Navigating</a>
                <a href="#lay-textformats">Textformats Settings</a>
                <a href="#lay-lazyloading">Lazy Loading</a>
                <a href="#lay-images">Images</a>
                <a href="#lay-appearance">Appearance</a>
                <a href="#lay-meta">Meta Tags</a>
                <a href="#lay-horizontal-lines">Horizontal Lines</a>
                <a href="#lay-vertical-lines">Vertical Lines</a>
                <a href="#lay-other">Other</a>
            </div>
        </div>
        <?php
        settings_fields( 'manage-miscoptions' );	//pass slug name of page, also referred
                                                //to in Settings API as option group name
        do_settings_sections( 'manage-miscoptions' ); 	//pass slug name of page
        ?>
        <div class="bottom-layoptions-submit-button-wrap">
            <?php submit_button(); ?>
        </div>
	</form>
</div>