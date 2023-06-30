<?php
// todo: can i delete this? 
// todo: i think woocommerce needs a sidebar right?
// i removed inserting the sidebar from the markup earlier

// i think this file is needed now for every wordpress theme?
/**
 * The sidebar containing the main widget area.
 *
 * @package storefront
 */

if ( ! is_active_sidebar( 'sidebar-1' ) ) {
	return;
}
?>

<div id="secondary" class="widget-area" role="complementary">
	<?php dynamic_sidebar( 'sidebar-1' ); ?>
</div><!-- #secondary -->
