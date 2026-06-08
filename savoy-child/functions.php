<?php
/**
 * Drone Sark – Savoy Child Theme
 */

defined( 'ABSPATH' ) || exit;

/* ─── Enqueue styles ──────────────────────────────────────── */
add_action( 'wp_enqueue_scripts', 'ds_enqueue_styles', 20 );
function ds_enqueue_styles() {
	wp_enqueue_style(
		'savoy-parent',
		get_template_directory_uri() . '/style.css',
		array(),
		wp_get_theme( 'savoy' )->get( 'Version' )
	);

	wp_enqueue_style(
		'drone-sark-child',
		get_stylesheet_uri(),
		array( 'savoy-parent' ),
		'1.0.0'
	);
}

/* ─── Customizer: Phone number ────────────────────────────── */
add_action( 'customize_register', 'ds_customizer_settings' );
function ds_customizer_settings( $wp_customize ) {
	$wp_customize->add_section( 'ds_contact', array(
		'title'    => 'Drone Sark Contact',
		'priority' => 30,
	) );
	$wp_customize->add_setting( 'ds_phone', array(
		'default'           => '',
		'sanitize_callback' => 'sanitize_text_field',
	) );
	$wp_customize->add_control( 'ds_phone', array(
		'label'   => 'Phone / WhatsApp Number',
		'section' => 'ds_contact',
		'type'    => 'text',
	) );
}

/* ─── Mobile bottom navigation ───────────────────────────── */
add_action( 'wp_footer', 'ds_mobile_nav', 99 );
function ds_mobile_nav() {
	$phone = sanitize_text_field( get_theme_mod( 'ds_phone', '' ) );
	$phone_href = $phone ? 'tel:' . preg_replace( '/\D/', '', $phone ) : '';

	$wishlist_url = '#';
	if ( function_exists( 'YITH_WCWL' ) ) {
		$wishlist_url = YITH_WCWL()->get_wishlist_url();
	} elseif ( class_exists( 'YITH_WCWL' ) ) {
		$wishlist_url = home_url( '/wishlist/' );
	}

	$cart_url    = home_url( '/cart/' );
	$account_url = home_url( '/my-account/' );
	$cart_count  = 0;

	if ( class_exists( 'WooCommerce' ) ) {
		$cart_url    = wc_get_cart_url();
		$account_url = get_permalink( get_option( 'woocommerce_myaccount_page_id' ) );
		if ( function_exists( 'WC' ) && WC()->cart ) {
			$cart_count = (int) WC()->cart->get_cart_contents_count();
		}
	}
	?>
	<nav class="ds-mobile-bottom-nav">

		<?php if ( $phone_href ) : ?>
		<a href="<?php echo esc_url( $phone_href ); ?>" class="ds-mobile-bottom-nav__item">
			<svg width="20" height="20" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M22 16.92v3a2 2 0 01-2.18 2 19.79 19.79 0 01-8.63-3.07A19.5 19.5 0 014.33 14a19.79 19.79 0 01-3.07-8.67A2 2 0 013.25 3h3a2 2 0 012 1.72 12.84 12.84 0 00.7 2.81 2 2 0 01-.45 2.11L7.91 10.1a16 16 0 006 6"/></svg>
			<span>Call</span>
		</a>
		<?php endif; ?>

		<a href="<?php echo esc_url( $wishlist_url ); ?>" class="ds-mobile-bottom-nav__item">
			<svg width="20" height="20" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M20.84 4.61a5.5 5.5 0 00-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 00-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 000-7.78z"/></svg>
			<span>Wishlist</span>
		</a>

		<a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="ds-mobile-bottom-nav__item">
			<svg width="20" height="20" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M3 9l9-7 9 7v11a2 2 0 01-2 2H5a2 2 0 01-2-2z"/><polyline points="9,22 9,12 15,12 15,22"/></svg>
			<span>Home</span>
		</a>

		<a href="<?php echo esc_url( $cart_url ); ?>" class="ds-mobile-bottom-nav__item" id="ds-cart-nav">
			<span style="position:relative;display:inline-flex;">
				<svg width="20" height="20" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M6 2 3 6v14a2 2 0 002 2h14a2 2 0 002-2V6l-3-4z"/><line x1="3" y1="6" x2="21" y2="6"/><path d="M16 10a4 4 0 01-8 0"/></svg>
				<span class="ds-cart-badge" style="<?php echo $cart_count > 0 ? '' : 'display:none;'; ?>"><?php echo esc_html( $cart_count ); ?></span>
			</span>
			<span>Cart</span>
		</a>

		<a href="<?php echo esc_url( $account_url ); ?>" class="ds-mobile-bottom-nav__item">
			<svg width="20" height="20" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M20 21v-2a4 4 0 00-4-4H8a4 4 0 00-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
			<span>Account</span>
		</a>

	</nav>

	<script>
	(function(){
		// Update cart badge when WooCommerce refreshes fragments
		document.addEventListener('DOMContentLoaded', function(){
			if (typeof jQuery !== 'undefined') {
				jQuery(document.body).on('wc_fragments_refreshed added_to_cart', function(){
					var count = jQuery('.nm-cart-count-number').text() || 0;
					var badge = document.querySelector('.ds-cart-badge');
					if (badge) {
						if (parseInt(count) > 0) {
							badge.textContent = count;
							badge.style.display = '';
						} else {
							badge.style.display = 'none';
						}
					}
				});
			}
		});
	})();
	</script>
	<?php
}
