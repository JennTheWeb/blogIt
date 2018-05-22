<?php
/**
 * BlogIt Theme Customizer
 *
 * @package BlogIt
 */

/**
 * Add postMessage support for site title and description for the Theme Customizer.
 *
 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
 */
function blogit_customize_register( $wp_customize ) {
	$wp_customize->get_setting( 'blogname' )->transport = 'postMessage';
	$wp_customize->get_setting( 'blogdescription' )->transport = 'postMessage';
	$wp_customize->remove_section('colors');
	$wp_customize->remove_section('background_image');

	if ( isset( $wp_customize->selective_refresh ) ) {
		$wp_customize->selective_refresh->add_partial( 'blogname', array(
			'selector'        => '.site-title a',
			'render_callback' => 'blogit_customize_partial_blogname',
		) );
		$wp_customize->selective_refresh->add_partial( 'blogdescription', array(
			'selector'        => '.site-description',
			'render_callback' => 'blogit_customize_partial_blogdescription',
		) );
	}
}
add_action( 'customize_register', 'blogit_customize_register' );

/**
 * Render the site title for the selective refresh partial.
 *
 * @return void
 */
function blogit_customize_partial_blogname() {
	bloginfo( 'name' );
}

/**
 * Render the site tagline for the selective refresh partial.
 *
 * @return void
 */
function blogit_customize_partial_blogdescription() {
	bloginfo( 'description' );
}

/**
 * Binds JS handlers to make Theme Customizer preview reload changes asynchronously.
 */
function customize_preview_js() {
	wp_enqueue_script( 'customizer', get_template_directory_uri() . '/js/customizer.js', array( 'customize-preview' ), '20151215', true );
}
add_action( 'customize_preview_init', 'customize_preview_js' );

/**
 * Add layout option.
 */
function layout_customize_register( $wp_customize ) {
	$wp_customize->add_section( 'layout' , array(
		'title'					=> 'Layout',
		'priority'				=> 50,
	) );
	$wp_customize->add_setting( 'layout', array(
		'default'				=> 'right',
		'transport' 			=> 'refresh',
		'sanitize_callback'		=> 'sanitize_choices',
	) );
	$wp_customize->add_control( 'layout', array(
		'type' 			=> 'radio',
		'section' 		=> 'layout',
		'label' 		=> 'Layout',
		'description' 	=> 'Pick a layout.',
		'choices' 		=> array(
			'left' 		=> 'Left Sidebar',
			'right' 	=> 'Right Sidebar',
		),
	) );
}
add_action( 'customize_register', 'layout_customize_register' );

/**
 * Add excerpt option.
 */
function excerpt_customize_register( $wp_customize ) {
	$wp_customize->add_setting( 'auto-excerpt', array(
		'default'				=> 'auto-excerpt',
		'transport' 			=> 'refresh',
		'sanitize_callback'		=> 'sanitize_choices',
	) );
	$wp_customize->add_control( 'auto-excerpt', array(
		'type' 			=> 'radio',
		'section' 		=> 'layout',
		'label' 		=> 'Automatically generate excerpts?',
		'choices' 				=> array(
			'auto-excerpt' 		=> 'Yes',
			'manual-excerpt' 	=> 'No',
		),
	) );
}
add_action( 'customize_register', 'excerpt_customize_register' );

/**
 * Sanitizes choices (selects / radios)
 * Checks that the input matches one of the available choices
 *
 * @param array $input the available choices.
 * @param array $setting the setting object.
 * @since  1.0.0
 */
function sanitize_choices( $input, $setting ) {
	// Ensure input is a slug.
	$input = sanitize_key( $input );

	// Get list of choices from the control associated with the setting.
	$choices = $setting->manager->get_control( $setting->id )->choices;

	// If the input is a valid key, return it; otherwise, return the default.
	return ( array_key_exists( $input, $choices ) ? $input : $setting->default );
}


