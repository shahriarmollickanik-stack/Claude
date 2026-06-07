<?php
/**
 * WooCommerce customizations
 */

if ( ! defined( 'ABSPATH' ) ) exit;
if ( ! class_exists( 'WooCommerce' ) ) return;

// Remove default WooCommerce wrappers (theme provides its own)
remove_action( 'woocommerce_before_main_content', 'woocommerce_output_content_wrapper', 10 );
remove_action( 'woocommerce_after_main_content', 'woocommerce_output_content_wrapper_end', 10 );
remove_action( 'woocommerce_sidebar', 'woocommerce_get_sidebar', 10 );

// Add theme wrappers
add_action( 'woocommerce_before_main_content', 'drone_sark_woocommerce_wrapper_before' );
add_action( 'woocommerce_after_main_content', 'drone_sark_woocommerce_wrapper_after' );

function drone_sark_woocommerce_wrapper_before() {
	echo '<div class="ds-woocommerce-wrapper"><div class="ds-container"><div class="ds-woo-layout">';
	if ( ( is_shop() || is_product_category() || is_product_tag() ) && is_active_sidebar( 'sidebar-shop' ) ) {
		get_sidebar( 'shop' );
	}
	echo '<main class="ds-woo-main" id="main">';
}

function drone_sark_woocommerce_wrapper_after() {
	echo '</main></div></div></div>';
}

// Products per page
add_filter( 'loop_shop_per_page', function() {
	return get_theme_mod( 'drone_sark_shop_products_per_page', 12 );
} );

// Shop columns
add_filter( 'loop_shop_columns', function() {
	return get_theme_mod( 'drone_sark_shop_columns', 3 );
} );

// Remove breadcrumbs from default position (theme re-adds them)
remove_action( 'woocommerce_before_main_content', 'woocommerce_breadcrumb', 20 );

// Move breadcrumbs above the shop wrapper
add_action( 'woocommerce_before_main_content', 'drone_sark_breadcrumb', 5 );
function drone_sark_breadcrumb() {
	woocommerce_breadcrumb( array(
		'wrap_before' => '<nav class="ds-breadcrumb ds-container" aria-label="' . esc_attr__( 'Breadcrumb', 'drone-sark' ) . '">',
		'wrap_after'  => '</nav>',
		'delimiter'   => '<span class="ds-breadcrumb__sep"> / </span>',
	) );
}

// Remove related products title duplication fix
add_filter( 'woocommerce_product_related_posts_relate_by_category', '__return_true' );

// Related products count
add_filter( 'woocommerce_output_related_products_args', function( $args ) {
	$args['posts_per_page'] = 4;
	$args['columns']        = 4;
	return $args;
} );

// Remove review form rating requirement if needed
add_filter( 'woocommerce_review_rating_required', '__return_false' );

// Disable quantity field on cart page product loop
add_filter( 'woocommerce_loop_add_to_cart_args', function( $args ) {
	return $args;
} );

// Enable product quick view hook placeholder
do_action( 'drone_sark_quick_view_init' );

// Product gallery image count
add_filter( 'woocommerce_product_thumbnails_columns', function() { return 4; } );

// Add custom classes to WC product
add_filter( 'post_class', function( $classes ) {
	if ( is_product() || is_shop() || is_product_category() ) {
		$classes[] = 'ds-product-card';
	}
	return $classes;
} );

// AJAX add to cart (ensure enabled)
add_filter( 'woocommerce_loop_add_to_cart_link', 'drone_sark_loop_add_to_cart', 10, 3 );
function drone_sark_loop_add_to_cart( $html, $product, $args ) {
	return $html;
}

// Mini cart fragments for header update via AJAX
add_filter( 'woocommerce_add_to_cart_fragments', function( $fragments ) {
	ob_start();
	?>
	<span class="ds-cart-count"><?php echo esc_html( WC()->cart->get_cart_contents_count() ); ?></span>
	<?php
	$fragments['.ds-cart-count'] = ob_get_clean();
	return $fragments;
} );

// Custom Buy Now redirect
add_action( 'wp_ajax_drone_sark_buy_now', 'drone_sark_buy_now_handler' );
add_action( 'wp_ajax_nopriv_drone_sark_buy_now', 'drone_sark_buy_now_handler' );
function drone_sark_buy_now_handler() {
	check_ajax_referer( 'drone-sark-nonce', 'nonce' );
	$product_id = isset( $_POST['product_id'] ) ? absint( $_POST['product_id'] ) : 0;
	$quantity   = isset( $_POST['quantity'] ) ? absint( $_POST['quantity'] ) : 1;
	if ( $product_id ) {
		WC()->cart->empty_cart();
		WC()->cart->add_to_cart( $product_id, $quantity );
		wp_send_json_success( array( 'redirect' => wc_get_checkout_url() ) );
	}
	wp_send_json_error();
}

// Stock status labels
add_filter( 'woocommerce_get_availability_text', function( $availability, $product ) {
	if ( $product->is_in_stock() ) {
		$availability = __( 'In Stock', 'drone-sark' );
	}
	return $availability;
}, 10, 2 );
