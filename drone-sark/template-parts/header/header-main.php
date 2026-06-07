<?php
/**
 * Main site header – desktop and mobile
 */
$announcement = get_theme_mod( 'drone_sark_header_announcement', '' );
$phone        = get_theme_mod( 'drone_sark_header_phone', '' );
?>

<?php if ( $announcement ) : ?>
<div class="ds-announcement-bar">
	<div class="ds-container">
		<p><?php echo wp_kses_post( $announcement ); ?></p>
	</div>
</div>
<?php endif; ?>

<header class="ds-header" id="site-header" role="banner">
	<div class="ds-container">
		<div class="ds-header-inner">

			<!-- ── DESKTOP HEADER ────────────────────────────── -->
			<div class="ds-header-desktop">

				<!-- Logo -->
				<div class="ds-header__logo">
					<?php drone_sark_logo(); ?>
				</div>

				<!-- Search -->
				<div class="ds-header__search">
					<?php if ( class_exists( 'WooCommerce' ) ) : ?>
					<form role="search" method="get" class="ds-search-form" action="<?php echo esc_url( home_url( '/' ) ); ?>">
						<div class="ds-search-form__inner">
							<input
								type="search"
								class="ds-search-form__input"
								placeholder="<?php esc_attr_e( 'Search for drones, parts, accessories...', 'drone-sark' ); ?>"
								value="<?php echo esc_attr( get_search_query() ); ?>"
								name="s"
								autocomplete="off"
							/>
							<input type="hidden" name="post_type" value="product" />
							<button type="submit" class="ds-search-form__btn" aria-label="<?php esc_attr_e( 'Search', 'drone-sark' ); ?>">
								<svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>
							</button>
						</div>
					</form>
					<?php endif; ?>
				</div>

				<!-- Actions -->
				<div class="ds-header__actions">
					<?php drone_sark_wishlist_icon(); ?>
					<?php drone_sark_cart_icon(); ?>
					<?php drone_sark_account_icon(); ?>
				</div>
			</div>

			<!-- ── MOBILE HEADER ─────────────────────────────── -->
			<div class="ds-header-mobile">

				<!-- Hamburger -->
				<button class="ds-mobile-menu-toggle" aria-label="<?php esc_attr_e( 'Open menu', 'drone-sark' ); ?>" aria-expanded="false" aria-controls="ds-mobile-drawer">
					<span class="ds-hamburger">
						<span></span><span></span><span></span>
					</span>
				</button>

				<!-- Logo -->
				<div class="ds-header__logo ds-header__logo--mobile">
					<?php drone_sark_logo(); ?>
				</div>

				<!-- Search icon -->
				<button class="ds-mobile-search-toggle" aria-label="<?php esc_attr_e( 'Open search', 'drone-sark' ); ?>" aria-expanded="false">
					<svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>
				</button>
			</div>

		</div><!-- .ds-header-inner -->
	</div><!-- .ds-container -->

	<!-- Mobile search bar (slides down) -->
	<div class="ds-mobile-search" id="ds-mobile-search" hidden>
		<div class="ds-container">
			<form role="search" method="get" class="ds-search-form ds-search-form--mobile" action="<?php echo esc_url( home_url( '/' ) ); ?>">
				<div class="ds-search-form__inner">
					<input
						type="search"
						class="ds-search-form__input"
						placeholder="<?php esc_attr_e( 'Search products...', 'drone-sark' ); ?>"
						value="<?php echo esc_attr( get_search_query() ); ?>"
						name="s"
						autocomplete="off"
					/>
					<input type="hidden" name="post_type" value="product" />
					<button type="submit" class="ds-search-form__btn" aria-label="<?php esc_attr_e( 'Search', 'drone-sark' ); ?>">
						<svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>
					</button>
				</div>
			</form>
		</div>
	</div>

</header><!-- #site-header -->

<!-- Navigation bar below header -->
<nav class="ds-nav-bar" aria-label="<?php esc_attr_e( 'Primary navigation', 'drone-sark' ); ?>">
	<div class="ds-container">
		<?php
		wp_nav_menu( array(
			'theme_location' => 'primary',
			'menu_class'     => 'ds-nav-bar__menu',
			'container'      => false,
			'depth'          => 3,
			'fallback_cb'    => 'drone_sark_nav_fallback',
		) );
		?>
	</div>
</nav>

<!-- Mobile slide-in drawer -->
<div class="ds-mobile-drawer" id="ds-mobile-drawer" aria-label="<?php esc_attr_e( 'Mobile navigation', 'drone-sark' ); ?>" aria-hidden="true">
	<div class="ds-mobile-drawer__header">
		<span class="ds-mobile-drawer__title"><?php esc_html_e( 'Menu', 'drone-sark' ); ?></span>
		<button class="ds-mobile-drawer__close" aria-label="<?php esc_attr_e( 'Close menu', 'drone-sark' ); ?>">
			<svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
		</button>
	</div>
	<div class="ds-mobile-drawer__body">
		<?php
		wp_nav_menu( array(
			'theme_location' => 'mobile',
			'menu_class'     => 'ds-mobile-nav-menu',
			'container'      => false,
			'depth'          => 3,
			'fallback_cb'    => 'drone_sark_mobile_nav_fallback',
		) );
		?>
	</div>
</div>
<div class="ds-mobile-overlay" id="ds-mobile-overlay"></div>

<!-- Mobile bottom nav -->
<nav class="ds-mobile-bottom-nav" aria-label="<?php esc_attr_e( 'Quick navigation', 'drone-sark' ); ?>">
	<a href="tel:<?php echo esc_attr( preg_replace( '/\D/', '', get_theme_mod( 'drone_sark_header_phone', '' ) ) ); ?>" class="ds-mobile-bottom-nav__item">
		<svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M22 16.92v3a2 2 0 01-2.18 2 19.79 19.79 0 01-8.63-3.07A19.5 19.5 0 014.33 14a19.79 19.79 0 01-3.07-8.67A2 2 0 013.25 3h3a2 2 0 012 1.72c.127.96.361 1.903.7 2.81a2 2 0 01-.45 2.11L7.91 10.1a16 16 0 006 6l.62-.62a2 2 0 012.11-.45c.907.339 1.85.573 2.81.7A2 2 0 0122 16.92z"/></svg>
		<span><?php esc_html_e( 'Call', 'drone-sark' ); ?></span>
	</a>

	<?php $wishlist_url = function_exists( 'YITH_WCWL' ) ? YITH_WCWL()->get_wishlist_url() : '#'; ?>
	<a href="<?php echo esc_url( $wishlist_url ); ?>" class="ds-mobile-bottom-nav__item">
		<svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M20.84 4.61a5.5 5.5 0 00-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 00-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 000-7.78z"/></svg>
		<span><?php esc_html_e( 'Wishlist', 'drone-sark' ); ?></span>
	</a>

	<a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="ds-mobile-bottom-nav__item ds-mobile-bottom-nav__item--home">
		<svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M3 9l9-7 9 7v11a2 2 0 01-2 2H5a2 2 0 01-2-2z"/><polyline points="9,22 9,12 15,12 15,22"/></svg>
		<span><?php esc_html_e( 'Home', 'drone-sark' ); ?></span>
	</a>

	<?php if ( class_exists( 'WooCommerce' ) ) : ?>
	<a href="<?php echo esc_url( wc_get_cart_url() ); ?>" class="ds-mobile-bottom-nav__item ds-mobile-bottom-nav__cart">
		<span class="ds-mobile-cart-wrap">
			<svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M6 2 3 6v14a2 2 0 002 2h14a2 2 0 002-2V6l-3-4z"/><line x1="3" y1="6" x2="21" y2="6"/><path d="M16 10a4 4 0 01-8 0"/></svg>
			<span class="ds-cart-count"><?php echo esc_html( WC()->cart ? WC()->cart->get_cart_contents_count() : 0 ); ?></span>
		</span>
		<span><?php esc_html_e( 'Cart', 'drone-sark' ); ?></span>
	</a>
	<?php endif; ?>

	<a href="<?php echo esc_url( class_exists( 'WooCommerce' ) ? get_permalink( get_option( 'woocommerce_myaccount_page_id' ) ) : wp_login_url() ); ?>" class="ds-mobile-bottom-nav__item">
		<svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M20 21v-2a4 4 0 00-4-4H8a4 4 0 00-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
		<span><?php esc_html_e( 'Account', 'drone-sark' ); ?></span>
	</a>
</nav>

<?php
/**
 * Nav fallback when no menu is assigned
 */
function drone_sark_nav_fallback() {
	echo '<ul class="ds-nav-bar__menu">';
	echo '<li><a href="' . esc_url( home_url( '/' ) ) . '">' . esc_html__( 'Home', 'drone-sark' ) . '</a></li>';
	if ( class_exists( 'WooCommerce' ) ) {
		echo '<li><a href="' . esc_url( drone_sark_get_shop_url() ) . '">' . esc_html__( 'Shop', 'drone-sark' ) . '</a></li>';
	}
	echo '</ul>';
}

function drone_sark_mobile_nav_fallback() {
	drone_sark_nav_fallback();
}
