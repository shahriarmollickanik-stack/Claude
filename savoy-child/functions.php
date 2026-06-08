<?php
/**
 * Drone Sark – Savoy Child Theme
 * functions.php
 */

defined( 'ABSPATH' ) || exit;

define( 'DS_CHILD_VERSION', '1.0.0' );
define( 'DS_CHILD_DIR',     get_stylesheet_directory() );
define( 'DS_CHILD_URI',     get_stylesheet_directory_uri() );

/* ─── Enqueue parent + child styles ───────────────────────── */
add_action( 'wp_enqueue_scripts', 'ds_child_enqueue', 20 );
function ds_child_enqueue() {
    // Parent theme stylesheet
    wp_enqueue_style(
        'savoy-parent-style',
        get_template_directory_uri() . '/style.css',
        array(),
        wp_get_theme( 'savoy' )->get( 'Version' )
    );

    // Child theme overrides
    wp_enqueue_style(
        'drone-sark-child',
        get_stylesheet_uri(),
        array( 'savoy-parent-style' ),
        DS_CHILD_VERSION
    );

    // Mobile JS
    wp_enqueue_script(
        'drone-sark-mobile',
        DS_CHILD_URI . '/assets/mobile-nav.js',
        array( 'jquery' ),
        DS_CHILD_VERSION,
        true
    );

    // Pass data to JS
    wp_localize_script( 'drone-sark-mobile', 'DroneSarkChild', array(
        'ajaxUrl'  => admin_url( 'admin-ajax.php' ),
        'cartUrl'  => class_exists( 'WooCommerce' ) ? wc_get_cart_url() : home_url( '/cart/' ),
        'phone'    => get_theme_mod( 'drone_sark_phone', '' ),
        'cartCount'=> class_exists( 'WooCommerce' ) && WC()->cart ? WC()->cart->get_cart_contents_count() : 0,
    ) );
}

/* ─── Theme supports ──────────────────────────────────────── */
add_action( 'after_setup_theme', 'ds_child_setup' );
function ds_child_setup() {
    // Additional nav location for mobile bottom nav
    register_nav_menus( array(
        'mobile-bottom' => __( 'Mobile Bottom Navigation', 'drone-sark' ),
    ) );
}

/* ─── Mobile bottom nav ───────────────────────────────────── */
add_action( 'wp_footer', 'ds_mobile_bottom_nav', 99 );
function ds_mobile_bottom_nav() {
    $phone       = get_theme_mod( 'drone_sark_phone', '' );
    $phone_clean = preg_replace( '/\D/', '', $phone );
    $wishlist_url = function_exists( 'YITH_WCWL' ) ? YITH_WCWL()->get_wishlist_url() : home_url( '/wishlist/' );
    $cart_url    = class_exists( 'WooCommerce' ) ? wc_get_cart_url() : home_url( '/cart/' );
    $account_url = class_exists( 'WooCommerce' ) ? get_permalink( get_option( 'woocommerce_myaccount_page_id' ) ) : wp_login_url();
    $cart_count  = class_exists( 'WooCommerce' ) && WC()->cart ? WC()->cart->get_cart_contents_count() : 0;
    ?>
    <nav class="ds-mobile-bottom-nav" aria-label="<?php esc_attr_e( 'Quick navigation', 'drone-sark' ); ?>">

        <?php if ( $phone_clean ) : ?>
        <a href="tel:<?php echo esc_attr( $phone_clean ); ?>" class="ds-mobile-bottom-nav__item" aria-label="Call us">
            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M22 16.92v3a2 2 0 01-2.18 2 19.79 19.79 0 01-8.63-3.07A19.5 19.5 0 014.33 14a19.79 19.79 0 01-3.07-8.67A2 2 0 013.25 3h3a2 2 0 012 1.72c.127.96.361 1.903.7 2.81a2 2 0 01-.45 2.11L7.91 10.1a16 16 0 006 6"/></svg>
            <span><?php esc_html_e( 'Call', 'drone-sark' ); ?></span>
        </a>
        <?php else : ?>
        <a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="ds-mobile-bottom-nav__item" aria-label="Home">
            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M3 9l9-7 9 7v11a2 2 0 01-2 2H5a2 2 0 01-2-2z"/><polyline points="9,22 9,12 15,12 15,22"/></svg>
            <span><?php esc_html_e( 'Home', 'drone-sark' ); ?></span>
        </a>
        <?php endif; ?>

        <a href="<?php echo esc_url( $wishlist_url ); ?>" class="ds-mobile-bottom-nav__item" aria-label="Wishlist">
            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M20.84 4.61a5.5 5.5 0 00-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 00-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 000-7.78z"/></svg>
            <span><?php esc_html_e( 'Wishlist', 'drone-sark' ); ?></span>
        </a>

        <a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="ds-mobile-bottom-nav__item ds-mobile-bottom-nav__item--home" aria-label="Home">
            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M3 9l9-7 9 7v11a2 2 0 01-2 2H5a2 2 0 01-2-2z"/><polyline points="9,22 9,12 15,12 15,22"/></svg>
            <span><?php esc_html_e( 'Home', 'drone-sark' ); ?></span>
        </a>

        <a href="<?php echo esc_url( $cart_url ); ?>" class="ds-mobile-bottom-nav__item" aria-label="Cart">
            <span style="position:relative;display:inline-flex;">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M6 2 3 6v14a2 2 0 002 2h14a2 2 0 002-2V6l-3-4z"/><line x1="3" y1="6" x2="21" y2="6"/><path d="M16 10a4 4 0 01-8 0"/></svg>
                <span class="ds-mobile-cart-count nm-cart-contents-count" style="<?php echo $cart_count > 0 ? '' : 'display:none;'; ?>"><?php echo esc_html( $cart_count ); ?></span>
            </span>
            <span><?php esc_html_e( 'Cart', 'drone-sark' ); ?></span>
        </a>

        <a href="<?php echo esc_url( $account_url ); ?>" class="ds-mobile-bottom-nav__item" aria-label="Account">
            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M20 21v-2a4 4 0 00-4-4H8a4 4 0 00-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
            <span><?php esc_html_e( 'Account', 'drone-sark' ); ?></span>
        </a>

    </nav>
    <?php
}

/* ─── WooCommerce cart fragment for mobile nav count ─────── */
add_filter( 'woocommerce_add_to_cart_fragments', 'ds_child_cart_fragment' );
function ds_child_cart_fragment( $fragments ) {
    if ( ! class_exists( 'WooCommerce' ) || ! WC()->cart ) return $fragments;
    $count = WC()->cart->get_cart_contents_count();
    ob_start();
    ?>
    <span class="ds-mobile-cart-count nm-cart-contents-count" style="<?php echo $count > 0 ? '' : 'display:none;'; ?>"><?php echo esc_html( $count ); ?></span>
    <?php
    $fragments['span.ds-mobile-cart-count'] = ob_get_clean();
    return $fragments;
}

/* ─── Customizer: Phone number ────────────────────────────── */
add_action( 'customize_register', 'ds_child_customizer' );
function ds_child_customizer( $wp_customize ) {
    $wp_customize->add_section( 'ds_contact_section', array(
        'title'    => __( 'Drone Sark – Contact', 'drone-sark' ),
        'priority' => 30,
    ) );

    $wp_customize->add_setting( 'drone_sark_phone', array(
        'default'           => '',
        'sanitize_callback' => 'sanitize_text_field',
    ) );

    $wp_customize->add_control( 'drone_sark_phone', array(
        'label'   => __( 'Phone / WhatsApp Number', 'drone-sark' ),
        'section' => 'ds_contact_section',
        'type'    => 'text',
    ) );
}

/* ─── Remove Savoy's page header on Elementor pages ─────── */
add_filter( 'nm_show_page_header', function( $show ) {
    if ( function_exists( 'elementor_theme_do_location' ) ) return false;
    return $show;
} );

/* ─── PHP syntax check guard ─────────────────────────────── */
if ( ! defined( 'ABSPATH' ) ) exit;
