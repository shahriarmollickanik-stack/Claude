<?php
/**
 * Homepage V1 – Hero Section (dark/premium)
 */
?>
<section class="ds-hero ds-hero--v1" aria-label="<?php esc_attr_e( 'Hero', 'drone-sark' ); ?>">
	<div class="ds-hero__bg">
		<?php
		$hero_image = get_theme_mod( 'drone_sark_hero_v1_image', '' );
		if ( $hero_image ) :
		?>
			<img src="<?php echo esc_url( $hero_image ); ?>" alt="" class="ds-hero__bg-img" loading="eager" decoding="async">
		<?php endif; ?>
		<div class="ds-hero__overlay"></div>
	</div>

	<div class="ds-container">
		<div class="ds-hero__content">
			<p class="ds-hero__pretitle"><?php echo esc_html( get_theme_mod( 'drone_sark_hero_v1_pretitle', __( 'EXPLORE. CAPTURE. ELEVATE.', 'drone-sark' ) ) ); ?></p>
			<h1 class="ds-hero__title">
				<?php echo wp_kses_post( get_theme_mod( 'drone_sark_hero_v1_title', __( 'Elevate Your<br>Perspective', 'drone-sark' ) ) ); ?>
			</h1>
			<p class="ds-hero__subtitle">
				<?php echo esc_html( get_theme_mod( 'drone_sark_hero_v1_subtitle', __( 'Premium drones, accessories, repair, and professional drone services — all in one place.', 'drone-sark' ) ) ); ?>
			</p>
			<div class="ds-hero__actions">
				<a href="<?php echo esc_url( drone_sark_get_shop_url() ); ?>" class="ds-btn ds-btn--white">
					<?php esc_html_e( 'Shop Now', 'drone-sark' ); ?>
				</a>
				<a href="<?php echo esc_url( get_permalink( get_page_by_path( 'contact' ) ) ); ?>" class="ds-btn ds-btn--outline-white">
					<?php esc_html_e( 'Get In Touch', 'drone-sark' ); ?>
				</a>
			</div>

			<!-- Feature pills -->
			<div class="ds-hero__features">
				<div class="ds-hero__feature">
					<svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"/></svg>
					<span><?php esc_html_e( 'Free Delivery', 'drone-sark' ); ?></span>
				</div>
				<div class="ds-hero__feature">
					<svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"/></svg>
					<span><?php esc_html_e( 'Expert Support', 'drone-sark' ); ?></span>
				</div>
				<div class="ds-hero__feature">
					<svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"/></svg>
					<span><?php esc_html_e( 'Genuine Products', 'drone-sark' ); ?></span>
				</div>
			</div>
		</div>
	</div>
</section>
