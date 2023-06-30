<?php
get_header(); 
?>
	<div id="intro-region"></div>
	<div id="search-region"></div>
	<?php
	if ( class_exists('WooCommerce') && have_posts() ) {
		global $post;
		if(empty($post->post_password)){
			$content = get_the_content();
			if(trim($content) != '') {
				?>
				<div id="lay-woocommerce" class="lay-textformat-parent">
				<?php
					the_content();
				?>
				</div><!-- #lay-woocommerce -->
				<?php
			}		
		}
	}
	?>
<?php
echo Lay_Layout::getLayoutInit();
// if(is_front_page()){
//     echo '<noscript><a href="http://laytheme.com">Designer Websites for free Lay Theme</a></noscript>';
// }
get_footer();
