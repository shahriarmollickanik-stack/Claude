<?php
/**
 * Drone Sark Theme Functions
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

define( 'DRONE_SARK_VERSION', '1.0.0' );
define( 'DRONE_SARK_DIR', get_template_directory() );
define( 'DRONE_SARK_URI', get_template_directory_uri() );

/**
 * Load theme includes
 */
require_once DRONE_SARK_DIR . '/inc/enqueue.php';
require_once DRONE_SARK_DIR . '/inc/customizer.php';
require_once DRONE_SARK_DIR . '/inc/helpers.php';
require_once DRONE_SARK_DIR . '/inc/widgets.php';
require_once DRONE_SARK_DIR . '/inc/woocommerce.php';
require_once DRONE_SARK_DIR . '/inc/elementor.php';

/**
 * Theme setup
 */
function drone_sark_setup() {
	load_theme_textdomain( 'drone-sark', DRONE_SARK_DIR . '/languages' );

	add_theme_support( 'automatic-feed-links' );
	add_theme_support( 'title-tag' );
	add_theme_support( 'post-thumbnails' );
	add_theme_support( 'html5', array(
		'search-form', 'comment-form', 'comment-list', 'gallery', 'caption', 'style', 'script',
	) );
	add_theme_support( 'custom-logo', array(
		'height'      => 60,
		'width'       => 200,
		'flex-height' => true,
		'flex-width'  => true,
	) );
	add_theme_support( 'custom-background' );
	add_theme_support( 'responsive-embeds' );
	add_theme_support( 'align-wide' );
	add_theme_support( 'wp-block-styles' );

	// WooCommerce support
	add_theme_support( 'woocommerce', array(
		'thumbnail_image_width' => 500,
		'gallery_thumbnail_image_width' => 100,
		'single_image_width' => 700,
	) );
	add_theme_support( 'wc-product-gallery-zoom' );
	add_theme_support( 'wc-product-gallery-lightbox' );
	add_theme_support( 'wc-product-gallery-slider' );

	// Elementor compatibility
	add_theme_support( 'elementor' );

	// Image sizes
	add_image_size( 'drone-sark-product-card', 400, 400, true );
	add_image_size( 'drone-sark-category', 300, 300, true );
	add_image_size( 'drone-sark-hero', 1920, 900, true );
	add_image_size( 'drone-sark-banner', 1280, 500, true );

	// Navigation menus
	register_nav_menus( array(
		'primary'       => __( 'Primary Menu', 'drone-sark' ),
		'mobile'        => __( 'Mobile Menu', 'drone-sark' ),
		'footer-col-1'  => __( 'Footer Column 1', 'drone-sark' ),
		'footer-col-2'  => __( 'Footer Column 2', 'drone-sark' ),
	) );
}
add_action( 'after_setup_theme', 'drone_sark_setup' );

/**
 * Content width
 */
function drone_sark_content_width() {
	$GLOBALS['content_width'] = 1280;
}
add_action( 'after_setup_theme', 'drone_sark_content_width', 0 );

/**
 * Body classes
 */
function drone_sark_body_classes( $classes ) {
	if ( ! is_singular() ) {
		$classes[] = 'hfeed';
	}
	if ( is_active_sidebar( 'sidebar-1' ) ) {
		$classes[] = 'has-sidebar';
	}
	if ( wp_is_mobile() ) {
		$classes[] = 'is-mobile';
	}

	// Homepage version
	$homepage_version = get_theme_mod( 'drone_sark_homepage_version', 'v1' );
	if ( is_front_page() ) {
		$classes[] = 'homepage-' . $homepage_version;
	}

	return $classes;
}
add_action( 'body_class', 'drone_sark_body_classes' );

/**
 * Defer non-critical scripts
 */
function drone_sark_defer_scripts( $tag, $handle, $src ) {
	$defer = array( 'drone-sark-slider', 'drone-sark-shop-filter' );
	if ( in_array( $handle, $defer ) ) {
		return str_replace( '<script ', '<script defer ', $tag );
	}
	return $tag;
}
add_filter( 'script_loader_tag', 'drone_sark_defer_scripts', 10, 3 );

/**
 * Elementor: make theme work without Elementor active
 */
function drone_sark_elementor_check() {
	if ( ! did_action( 'elementor/loaded' ) ) {
		// Theme still works without Elementor
	}
}
add_action( 'init', 'drone_sark_elementor_check' );
