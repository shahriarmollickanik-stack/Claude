<?php
/**
 * Theme Customizer settings
 */

if ( ! defined( 'ABSPATH' ) ) exit;

function drone_sark_customize_register( $wp_customize ) {

	// ─── HOMEPAGE SETTINGS ────────────────────────────────────────────────────
	$wp_customize->add_panel( 'drone_sark_homepage_panel', array(
		'title'    => __( 'Homepage Settings', 'drone-sark' ),
		'priority' => 30,
	) );

	// Homepage Version section
	$wp_customize->add_section( 'drone_sark_homepage_version_section', array(
		'title' => __( 'Homepage Version', 'drone-sark' ),
		'panel' => 'drone_sark_homepage_panel',
	) );

	$wp_customize->add_setting( 'drone_sark_homepage_version', array(
		'default'           => 'v1',
		'sanitize_callback' => 'drone_sark_sanitize_select',
		'transport'         => 'refresh',
	) );

	$wp_customize->add_control( 'drone_sark_homepage_version', array(
		'label'   => __( 'Select Homepage Version', 'drone-sark' ),
		'description' => __( 'V1: Premium brand homepage. V2: Sales-focused homepage.', 'drone-sark' ),
		'section' => 'drone_sark_homepage_version_section',
		'type'    => 'radio',
		'choices' => array(
			'v1' => __( 'Version 1 – Premium Brand (Dark Hero)', 'drone-sark' ),
			'v2' => __( 'Version 2 – Sales Focused (White/Light)', 'drone-sark' ),
		),
	) );

	// ─── HEADER SETTINGS ──────────────────────────────────────────────────────
	$wp_customize->add_section( 'drone_sark_header', array(
		'title'    => __( 'Header Settings', 'drone-sark' ),
		'priority' => 40,
	) );

	$wp_customize->add_setting( 'drone_sark_header_phone', array(
		'default'           => '',
		'sanitize_callback' => 'sanitize_text_field',
	) );
	$wp_customize->add_control( 'drone_sark_header_phone', array(
		'label'   => __( 'Header Phone Number', 'drone-sark' ),
		'section' => 'drone_sark_header',
		'type'    => 'text',
	) );

	$wp_customize->add_setting( 'drone_sark_header_announcement', array(
		'default'           => '',
		'sanitize_callback' => 'sanitize_text_field',
	) );
	$wp_customize->add_control( 'drone_sark_header_announcement', array(
		'label'   => __( 'Announcement Bar Text', 'drone-sark' ),
		'description' => __( 'Leave empty to hide the bar.', 'drone-sark' ),
		'section' => 'drone_sark_header',
		'type'    => 'text',
	) );

	// ─── FOOTER SETTINGS ──────────────────────────────────────────────────────
	$wp_customize->add_section( 'drone_sark_footer', array(
		'title'    => __( 'Footer Settings', 'drone-sark' ),
		'priority' => 50,
	) );

	$wp_customize->add_setting( 'drone_sark_footer_facebook', array(
		'default'           => '',
		'sanitize_callback' => 'esc_url_raw',
	) );
	$wp_customize->add_control( 'drone_sark_footer_facebook', array(
		'label'   => __( 'Facebook URL', 'drone-sark' ),
		'section' => 'drone_sark_footer',
		'type'    => 'url',
	) );

	$wp_customize->add_setting( 'drone_sark_footer_instagram', array(
		'default'           => '',
		'sanitize_callback' => 'esc_url_raw',
	) );
	$wp_customize->add_control( 'drone_sark_footer_instagram', array(
		'label'   => __( 'Instagram URL', 'drone-sark' ),
		'section' => 'drone_sark_footer',
		'type'    => 'url',
	) );

	$wp_customize->add_setting( 'drone_sark_footer_youtube', array(
		'default'           => '',
		'sanitize_callback' => 'esc_url_raw',
	) );
	$wp_customize->add_control( 'drone_sark_footer_youtube', array(
		'label'   => __( 'YouTube URL', 'drone-sark' ),
		'section' => 'drone_sark_footer',
		'type'    => 'url',
	) );

	$wp_customize->add_setting( 'drone_sark_footer_whatsapp', array(
		'default'           => '',
		'sanitize_callback' => 'sanitize_text_field',
	) );
	$wp_customize->add_control( 'drone_sark_footer_whatsapp', array(
		'label'   => __( 'WhatsApp Number', 'drone-sark' ),
		'section' => 'drone_sark_footer',
		'type'    => 'text',
	) );

	$wp_customize->add_setting( 'drone_sark_footer_email', array(
		'default'           => '',
		'sanitize_callback' => 'sanitize_email',
	) );
	$wp_customize->add_control( 'drone_sark_footer_email', array(
		'label'   => __( 'Footer Email Address', 'drone-sark' ),
		'section' => 'drone_sark_footer',
		'type'    => 'email',
	) );

	$wp_customize->add_setting( 'drone_sark_footer_address', array(
		'default'           => '',
		'sanitize_callback' => 'sanitize_textarea_field',
	) );
	$wp_customize->add_control( 'drone_sark_footer_address', array(
		'label'   => __( 'Footer Address', 'drone-sark' ),
		'section' => 'drone_sark_footer',
		'type'    => 'textarea',
	) );

	$wp_customize->add_setting( 'drone_sark_footer_copyright', array(
		'default'           => '© ' . gmdate( 'Y' ) . ' Drone Sark. All rights reserved.',
		'sanitize_callback' => 'sanitize_text_field',
	) );
	$wp_customize->add_control( 'drone_sark_footer_copyright', array(
		'label'   => __( 'Copyright Text', 'drone-sark' ),
		'section' => 'drone_sark_footer',
		'type'    => 'text',
	) );

	// ─── SHOP SETTINGS ────────────────────────────────────────────────────────
	$wp_customize->add_section( 'drone_sark_shop', array(
		'title'    => __( 'Shop Settings', 'drone-sark' ),
		'priority' => 60,
	) );

	$wp_customize->add_setting( 'drone_sark_shop_products_per_page', array(
		'default'           => 12,
		'sanitize_callback' => 'absint',
	) );
	$wp_customize->add_control( 'drone_sark_shop_products_per_page', array(
		'label'   => __( 'Products Per Page', 'drone-sark' ),
		'section' => 'drone_sark_shop',
		'type'    => 'number',
	) );

	$wp_customize->add_setting( 'drone_sark_shop_columns', array(
		'default'           => 3,
		'sanitize_callback' => 'absint',
	) );
	$wp_customize->add_control( 'drone_sark_shop_columns', array(
		'label'   => __( 'Shop Columns (Desktop)', 'drone-sark' ),
		'section' => 'drone_sark_shop',
		'type'    => 'select',
		'choices' => array(
			3 => '3 Columns',
			4 => '4 Columns',
		),
	) );
}
add_action( 'customize_register', 'drone_sark_customize_register' );

/**
 * Sanitize select fields
 */
function drone_sark_sanitize_select( $input, $setting ) {
	$choices = $setting->manager->get_control( $setting->id )->choices;
	return ( array_key_exists( $input, $choices ) ? $input : $setting->default );
}

/**
 * Live preview – output custom CSS
 */
function drone_sark_customizer_css() {
	// Currently no dynamic CSS needed; extend here if needed
}
add_action( 'wp_head', 'drone_sark_customizer_css' );
