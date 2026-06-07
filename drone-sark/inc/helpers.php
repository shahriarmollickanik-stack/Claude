<?php
/**
 * Helper functions
 */

if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * Get the site logo with fallback
 */
function drone_sark_logo() {
	if ( has_custom_logo() ) {
		the_custom_logo();
	} else {
		echo '<a href="' . esc_url( home_url( '/' ) ) . '" class="ds-logo-text" rel="home">';
		echo '<span class="ds-logo-text__name">Drone</span><span class="ds-logo-text__accent">Sark</span>';
		echo '</a>';
	}
}

/**
 * Get WooCommerce cart icon with count
 */
function drone_sark_cart_icon() {
	if ( ! class_exists( 'WooCommerce' ) ) return;
	$count = WC()->cart ? WC()->cart->get_cart_contents_count() : 0;
	?>
	<a href="<?php echo esc_url( wc_get_cart_url() ); ?>" class="ds-header-icon ds-header-cart" aria-label="<?php esc_attr_e( 'Cart', 'drone-sark' ); ?>">
		<svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M6 2 3 6v14a2 2 0 002 2h14a2 2 0 002-2V6l-3-4z"/><line x1="3" y1="6" x2="21" y2="6"/><path d="M16 10a4 4 0 01-8 0"/></svg>
		<?php if ( $count > 0 ) : ?>
			<span class="ds-cart-count"><?php echo esc_html( $count ); ?></span>
		<?php endif; ?>
	</a>
	<?php
}

/**
 * Get wishlist icon
 */
function drone_sark_wishlist_icon() {
	$wishlist_url = function_exists( 'YITH_WCWL' ) ? YITH_WCWL()->get_wishlist_url() : '#';
	$count = function_exists( 'yith_wcwl_count_products' ) ? yith_wcwl_count_products() : 0;
	?>
	<a href="<?php echo esc_url( $wishlist_url ); ?>" class="ds-header-icon ds-header-wishlist" aria-label="<?php esc_attr_e( 'Wishlist', 'drone-sark' ); ?>">
		<svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M20.84 4.61a5.5 5.5 0 00-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 00-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 000-7.78z"/></svg>
		<?php if ( $count > 0 ) : ?>
			<span class="ds-wishlist-count"><?php echo esc_html( $count ); ?></span>
		<?php endif; ?>
	</a>
	<?php
}

/**
 * Get account icon
 */
function drone_sark_account_icon() {
	$account_url = class_exists( 'WooCommerce' ) ? get_permalink( get_option( 'woocommerce_myaccount_page_id' ) ) : wp_login_url();
	$label = is_user_logged_in() ? __( 'My Account', 'drone-sark' ) : __( 'Sign In', 'drone-sark' );
	?>
	<a href="<?php echo esc_url( $account_url ); ?>" class="ds-header-icon ds-header-account" aria-label="<?php echo esc_attr( $label ); ?>">
		<svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M20 21v-2a4 4 0 00-4-4H8a4 4 0 00-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
	</a>
	<?php
}

/**
 * Star rating HTML
 */
function drone_sark_star_rating( $rating = 5, $max = 5 ) {
	$output = '<span class="ds-stars" aria-label="' . esc_attr( sprintf( __( '%s out of %s stars', 'drone-sark' ), $rating, $max ) ) . '">';
	for ( $i = 1; $i <= $max; $i++ ) {
		if ( $i <= $rating ) {
			$output .= '<span class="ds-star ds-star--filled">★</span>';
		} elseif ( $i - 0.5 <= $rating ) {
			$output .= '<span class="ds-star ds-star--half">★</span>';
		} else {
			$output .= '<span class="ds-star ds-star--empty">★</span>';
		}
	}
	$output .= '</span>';
	return $output;
}

/**
 * Section title HTML
 */
function drone_sark_section_title( $title, $subtitle = '', $align = 'left' ) {
	echo '<div class="ds-section-title ds-section-title--' . esc_attr( $align ) . '">';
	echo '<h2 class="ds-section-title__heading">' . esc_html( $title ) . '</h2>';
	if ( $subtitle ) {
		echo '<p class="ds-section-title__sub">' . esc_html( $subtitle ) . '</p>';
	}
	echo '</div>';
}

/**
 * Button HTML
 */
function drone_sark_button( $text, $url = '#', $variant = 'primary', $extra_classes = '' ) {
	$classes = 'ds-btn ds-btn--' . esc_attr( $variant );
	if ( $extra_classes ) $classes .= ' ' . esc_attr( $extra_classes );
	return '<a href="' . esc_url( $url ) . '" class="' . esc_attr( $classes ) . '">' . esc_html( $text ) . '</a>';
}

/**
 * Get WooCommerce product URL safely
 */
function drone_sark_get_shop_url() {
	return class_exists( 'WooCommerce' ) ? get_permalink( wc_get_page_id( 'shop' ) ) : home_url( '/shop/' );
}

/**
 * Format price
 */
function drone_sark_format_price( $price ) {
	return class_exists( 'WooCommerce' ) ? wc_price( $price ) : number_format( $price, 2 );
}

/**
 * AJAX: load more products (for homepage V2 and shop)
 */
function drone_sark_load_more_products() {
	check_ajax_referer( 'drone-sark-nonce', 'nonce' );

	$page     = isset( $_POST['page'] ) ? absint( $_POST['page'] ) : 1;
	$per_page = isset( $_POST['per_page'] ) ? absint( $_POST['per_page'] ) : 12;
	$category = isset( $_POST['category'] ) ? sanitize_text_field( $_POST['category'] ) : '';

	$args = array(
		'post_type'      => 'product',
		'posts_per_page' => $per_page,
		'paged'          => $page,
		'post_status'    => 'publish',
		'orderby'        => 'date',
		'order'          => 'DESC',
	);

	if ( $category ) {
		$args['tax_query'] = array(
			array(
				'taxonomy' => 'product_cat',
				'field'    => 'slug',
				'terms'    => $category,
			),
		);
	}

	$query = new WP_Query( $args );

	if ( $query->have_posts() ) {
		ob_start();
		while ( $query->have_posts() ) {
			$query->the_post();
			wc_get_template_part( 'content', 'product' );
		}
		wp_reset_postdata();
		$html = ob_get_clean();
		wp_send_json_success( array(
			'html'      => $html,
			'max_pages' => $query->max_num_pages,
		) );
	} else {
		wp_send_json_error( array( 'message' => __( 'No more products.', 'drone-sark' ) ) );
	}
}
add_action( 'wp_ajax_drone_sark_load_more', 'drone_sark_load_more_products' );
add_action( 'wp_ajax_nopriv_drone_sark_load_more', 'drone_sark_load_more_products' );

/**
 * Check if current page uses Elementor
 */
function drone_sark_is_elementor_page() {
	if ( ! class_exists( '\Elementor\Plugin' ) ) return false;
	$doc = \Elementor\Plugin::$instance->documents->get( get_the_ID() );
	return $doc && $doc->is_built_with_elementor();
}
