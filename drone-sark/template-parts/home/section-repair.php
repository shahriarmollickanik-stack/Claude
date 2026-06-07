<?php
/**
 * Homepage V1 – Repair banner section
 */
$repair_page = get_page_by_path( 'repair' );
$repair_url  = $repair_page ? get_permalink( $repair_page ) : get_term_link( 'repair', 'product_cat' );
if ( is_wp_error( $repair_url ) ) $repair_url = drone_sark_get_shop_url();

$bg = get_theme_mod( 'drone_sark_repair_bg', '' );
?>

<section class="ds-section ds-section--sm ds-repair-banner" aria-label="<?php esc_attr_e( 'Drone Repair', 'drone-sark' ); ?>">
	<div class="ds-container">
		<div class="ds-repair-banner__inner" <?php if ( $bg ) echo 'style="--repair-bg: url(' . esc_url( $bg ) . ')"'; ?>>
			<div class="ds-repair-banner__content">
				<span class="ds-repair-banner__tag"><?php esc_html_e( 'REPAIR SERVICE', 'drone-sark' ); ?></span>
				<h2 class="ds-repair-banner__title"><?php esc_html_e( 'Drone Repair & Maintenance', 'drone-sark' ); ?></h2>
				<p class="ds-repair-banner__text">
					<?php esc_html_e( 'Fast, professional drone repair service by certified technicians. We fix all makes and models — from minor sensor calibrations to complete overhauls.', 'drone-sark' ); ?>
				</p>
				<ul class="ds-repair-banner__features">
					<li><?php esc_html_e( 'All brands & models', 'drone-sark' ); ?></li>
					<li><?php esc_html_e( 'Genuine spare parts', 'drone-sark' ); ?></li>
					<li><?php esc_html_e( 'Quick turnaround', 'drone-sark' ); ?></li>
					<li><?php esc_html_e( 'Service warranty', 'drone-sark' ); ?></li>
				</ul>
				<a href="<?php echo esc_url( $repair_url ); ?>" class="ds-btn ds-btn--primary">
					<?php esc_html_e( 'Book Repair', 'drone-sark' ); ?>
				</a>
			</div>
			<div class="ds-repair-banner__image">
				<?php
				$img = get_theme_mod( 'drone_sark_repair_image', '' );
				if ( $img ) :
				?>
					<img src="<?php echo esc_url( $img ); ?>" alt="<?php esc_attr_e( 'Drone repair', 'drone-sark' ); ?>" loading="lazy" decoding="async">
				<?php else : ?>
					<div class="ds-repair-banner__image-placeholder">
						<svg viewBox="0 0 200 160" fill="none" xmlns="http://www.w3.org/2000/svg" width="100%" height="100%">
							<rect width="200" height="160" fill="#1a1a1a"/>
							<circle cx="100" cy="80" r="30" fill="none" stroke="#fff" stroke-width="2"/>
							<path d="M100 50 L100 35 M100 110 L100 125 M70 80 L55 80 M130 80 L145 80" stroke="#fff" stroke-width="2" stroke-linecap="round"/>
							<path d="M14.7 6.3a1 1 0 000 1.4l1.6 1.6a1 1 0 001.4 0l3.77-3.77a6 6 0 01-7.94 7.94" stroke="#fff" stroke-width="2" transform="translate(86,66) scale(1.4)"/>
						</svg>
					</div>
				<?php endif; ?>
			</div>
		</div>
	</div>
</section>
