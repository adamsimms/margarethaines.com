<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>">
<meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=5.0, user-scalable=yes">

<?php wp_head();
Frontend::get_meta();
Frontend::get_custom_head_content();
Frontend::get_max_width_option_css();
Frontend::get_custom_lay_css();

$theme = wp_get_theme();
echo '<!-- Thank you for using Lay Theme '.$theme->get( 'Version' ).'-->';
echo '<!-- Fix for flash of unstyled content on Chrome -->';
echo '<style>.sitetitle, .laynav, .project-arrow, .mobile-title{visibility:hidden;}</style>';
?>
</head>

<body <?php body_class(); ?> <?php echo Frontend::get_body_data(); ?>>
<?php

do_action('laytheme_after_bodytag');

Frontend::get_header();
Frontend::get_project_arrows();