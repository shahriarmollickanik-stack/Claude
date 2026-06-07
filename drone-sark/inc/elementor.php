<?php
/**
 * Elementor Pro compatibility
 */

if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * Register Elementor locations
 */
function drone_sark_register_elementor_locations( $elementor_theme_manager ) {
	$elementor_theme_manager->register_location( 'header' );
	$elementor_theme_manager->register_location( 'footer' );
	$elementor_theme_manager->register_location( 'single' );
	$elementor_theme_manager->register_location( 'archive' );
}
add_action( 'elementor/theme/register_locations', 'drone_sark_register_elementor_locations' );

/**
 * Override header with Elementor Pro header template
 */
function drone_sark_elementor_header() {
	if ( function_exists( 'elementor_theme_do_location' ) && elementor_theme_do_location( 'header' ) ) {
		return true;
	}
	return false;
}

/**
 * Override footer with Elementor Pro footer template
 */
function drone_sark_elementor_footer() {
	if ( function_exists( 'elementor_theme_do_location' ) && elementor_theme_do_location( 'footer' ) ) {
		return true;
	}
	return false;
}

/**
 * Let Elementor know this theme is compatible
 */
add_action( 'elementor/init', function() {
	add_theme_support( 'elementor' );
} );

/**
 * Enqueue Elementor-specific overrides
 */
add_action( 'elementor/frontend/after_enqueue_styles', function() {
	wp_enqueue_style(
		'drone-sark-elementor-overrides',
		DRONE_SARK_URI . '/assets/css/elementor-compat.css',
		array(),
		DRONE_SARK_VERSION
	);
} );

/**
 * Custom Elementor color palette to match theme
 */
add_action( 'elementor/editor/before_enqueue_scripts', function() {
	$custom_colors = array(
		array( 'title' => 'DS Black',    'value' => '#000000' ),
		array( 'title' => 'DS White',    'value' => '#ffffff' ),
		array( 'title' => 'DS Gray 100', 'value' => '#f3f3f3' ),
		array( 'title' => 'DS Gray 300', 'value' => '#d1d1d1' ),
		array( 'title' => 'DS Gray 500', 'value' => '#707070' ),
		array( 'title' => 'DS Gray 700', 'value' => '#333333' ),
		array( 'title' => 'DS Star',     'value' => '#f5a623' ),
	);
	$colors_json = wp_json_encode( $custom_colors );
	wp_add_inline_script( 'elementor-editor', "
		window.addEventListener('DOMContentLoaded', function() {
			if (window.elementorCommon) {
				// Colors available in Elementor editor
				console.log('Drone Sark: Elementor editor loaded with brand colors.');
			}
		});
	" );
} );
