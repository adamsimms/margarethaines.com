<?php

if( class_exists('WP_Customize_Site_Icon_Control') ){
	$section = 'siteicon_option';

	$wp_customize->add_section( $section, 
	   array(
	      'title' => 'Favicon',
	      'priority' => 0,
	      'capability' => 'edit_theme_options',
	   ) 
	);

	$wp_customize->add_setting( 'site_icon', array(
		'type'       => 'option',
		'capability' => 'manage_options',
		'transport'  => 'postMessage', // Previewed with JS in the Customizer controls window.
	) );

	$wp_customize->add_control( new WP_Customize_Site_Icon_Control( $wp_customize, 'site_icon', array(
		'label'       => 'Favicon',
		'description' => 'The Favicon is used as a browser and app icon for your site. Icons must be square, and at least 512px wide and tall.',
		'section'     => $section,
		'priority'    => 60,
		'height'      => 512,
		'width'       => 512,
	) ) );
}