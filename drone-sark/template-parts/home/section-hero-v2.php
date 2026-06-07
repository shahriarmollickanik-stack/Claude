<?php
/**
 * Homepage V2 – Hero Section (light/sales-focused)
 */
?>
<section class="ds-hero ds-hero--v2" aria-label="<?php esc_attr_e( 'Hero', 'drone-sark' ); ?>">
	<div class="ds-container">
		<div class="ds-hero--v2__inner">

			<div class="ds-hero--v2__text">
				<p class="ds-hero__pretitle"><?php echo esc_html( get_theme_mod( 'drone_sark_hero_v2_pretitle', __( 'NEXT LEVEL DRONE TECHNOLOGY', 'drone-sark' ) ) ); ?></p>
				<h1 class="ds-hero--v2__title">
					<?php echo wp_kses_post( get_theme_mod( 'drone_sark_hero_v2_title', __( 'Next Level<br>Drone Experience', 'drone-sark' ) ) ); ?>
				</h1>
				<p class="ds-hero--v2__subtitle">
					<?php echo esc_html( get_theme_mod( 'drone_sark_hero_v2_subtitle', __( 'Discover top-rated drones for every skill level. From beginner fun flyers to industrial workhorses.', 'drone-sark' ) ) ); ?>
				</p>
				<div class="ds-hero__actions">
					<a href="<?php echo esc_url( drone_sark_get_shop_url() ); ?>" class="ds-btn ds-btn--primary">
						<?php esc_html_e( 'Shop All Drones', 'drone-sark' ); ?>
					</a>
					<a href="<?php echo esc_url( get_term_link( 'drones', 'product_cat' ) ); ?>" class="ds-btn ds-btn--outline">
						<?php esc_html_e( 'View Categories', 'drone-sark' ); ?>
					</a>
				</div>

				<div class="ds-hero--v2__stats">
					<div class="ds-stat">
						<strong>500+</strong>
						<span><?php esc_html_e( 'Products', 'drone-sark' ); ?></span>
					</div>
					<div class="ds-stat">
						<strong>2000+</strong>
						<span><?php esc_html_e( 'Happy Clients', 'drone-sark' ); ?></span>
					</div>
					<div class="ds-stat">
						<strong>5★</strong>
						<span><?php esc_html_e( 'Rated Service', 'drone-sark' ); ?></span>
					</div>
				</div>
			</div>

			<div class="ds-hero--v2__image">
				<?php
				$hero_img = get_theme_mod( 'drone_sark_hero_v2_image', '' );
				if ( $hero_img ) :
				?>
					<img src="<?php echo esc_url( $hero_img ); ?>" alt="<?php esc_attr_e( 'Premium drone', 'drone-sark' ); ?>" loading="eager" decoding="async">
				<?php else : ?>
					<div class="ds-hero--v2__image-placeholder">
						<svg viewBox="0 0 200 140" fill="none" xmlns="http://www.w3.org/2000/svg" width="100%" height="100%">
							<rect width="200" height="140" fill="#f3f3f3"/>
							<!-- Drone illustration placeholder -->
							<circle cx="100" cy="70" r="12" fill="#333"/>
							<line x1="60" y1="50" x2="80" y2="65" stroke="#333" stroke-width="3" stroke-linecap="round"/>
							<line x1="140" y1="50" x2="120" y2="65" stroke="#333" stroke-width="3" stroke-linecap="round"/>
							<line x1="60" y1="90" x2="80" y2="75" stroke="#333" stroke-width="3" stroke-linecap="round"/>
							<line x1="140" y1="90" x2="120" y2="75" stroke="#333" stroke-width="3" stroke-linecap="round"/>
							<circle cx="55" cy="47" r="10" fill="none" stroke="#333" stroke-width="2"/>
							<circle cx="145" cy="47" r="10" fill="none" stroke="#333" stroke-width="2"/>
							<circle cx="55" cy="93" r="10" fill="none" stroke="#333" stroke-width="2"/>
							<circle cx="145" cy="93" r="10" fill="none" stroke="#333" stroke-width="2"/>
						</svg>
					</div>
				<?php endif; ?>
			</div>

		</div>
	</div>
</section>
