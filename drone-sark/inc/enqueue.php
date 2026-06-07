<?php
/**
 * Enqueue scripts and styles
 */

if ( ! defined( 'ABSPATH' ) ) exit;

function drone_sark_scripts() {
	// Google Fonts – Inter
	wp_enqueue_style(
		'drone-sark-google-fonts',
		'https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap',
		array(),
		null
	);

	// Main stylesheet
	wp_enqueue_style(
		'drone-sark-style',
		DRONE_SARK_URI . '/assets/css/main.css',
		array(),
		DRONE_SARK_VERSION
	);

	// Swiper CSS
	wp_enqueue_style(
		'swiper',
		'https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css',
		array(),
		'11.0'
	);

	// Main JS
	wp_enqueue_script(
		'drone-sark-main',
		DRONE_SARK_URI . '/assets/js/main.js',
		array( 'jquery' ),
		DRONE_SARK_VERSION,
		true
	);

	// Swiper JS
	wp_enqueue_script(
		'swiper',
		'https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js',
		array(),
		'11.0',
		true
	);

	// Slider
	wp_enqueue_script(
		'drone-sark-slider',
		DRONE_SARK_URI . '/assets/js/slider.js',
		array( 'swiper' ),
		DRONE_SARK_VERSION,
		true
	);

	// Mobile menu
	wp_enqueue_script(
		'drone-sark-mobile-menu',
		DRONE_SARK_URI . '/assets/js/mobile-menu.js',
		array( 'jquery' ),
		DRONE_SARK_VERSION,
		true
	);

	// Shop filter (shop pages only)
	if ( is_shop() || is_product_category() || is_product_tag() ) {
		wp_enqueue_script(
			'drone-sark-shop-filter',
			DRONE_SARK_URI . '/assets/js/shop-filter.js',
			array( 'jquery' ),
			DRONE_SARK_VERSION,
			true
		);
	}

	// Comments
	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}

	// Localise JS vars
	$wc_active = class_exists( 'WooCommerce' );
	wp_localize_script( 'drone-sark-main', 'DroneSark', array(
		'ajaxUrl'    => admin_url( 'admin-ajax.php' ),
		'nonce'      => wp_create_nonce( 'drone-sark-nonce' ),
		'cartUrl'    => $wc_active ? wc_get_cart_url()      : home_url( '/cart/' ),
		'checkoutUrl'=> $wc_active ? wc_get_checkout_url()  : home_url( '/checkout/' ),
		'currency'   => $wc_active ? get_woocommerce_currency_symbol() : '৳',
		'siteUrl'    => get_site_url(),
		'isMobile'   => wp_is_mobile() ? 'true' : 'false',
	) );
}
add_action( 'wp_enqueue_scripts', 'drone_sark_scripts' );

/**
 * Admin styles
 */
function drone_sark_admin_styles() {
	wp_enqueue_style(
		'drone-sark-admin',
		DRONE_SARK_URI . '/assets/css/admin.css',
		array(),
		DRONE_SARK_VERSION
	);
}
add_action( 'admin_enqueue_scripts', 'drone_sark_admin_styles' );

/**
 * Elementor: enqueue extra styles when Elementor is active
 */
function drone_sark_elementor_styles() {
	if ( did_action( 'elementor/loaded' ) ) {
		wp_enqueue_style(
			'drone-sark-elementor',
			DRONE_SARK_URI . '/assets/css/elementor-compat.css',
			array( 'drone-sark-style' ),
			DRONE_SARK_VERSION
		);
	}
}
add_action( 'wp_enqueue_scripts', 'drone_sark_elementor_styles', 20 );
