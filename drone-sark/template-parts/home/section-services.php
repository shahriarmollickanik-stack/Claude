<?php
/**
 * Homepage V1 – Other Services banner
 */
$services_url = get_term_link( 'other-services', 'product_cat' );
if ( is_wp_error( $services_url ) ) {
	$page = get_page_by_path( 'services' );
	$services_url = $page ? get_permalink( $page ) : drone_sark_get_shop_url();
}
?>

<section class="ds-section ds-section--sm ds-services-banner" aria-label="<?php esc_attr_e( 'Other Services', 'drone-sark' ); ?>">
	<div class="ds-container">
		<div class="ds-services-banner__inner">

			<div class="ds-services-banner__header">
				<?php drone_sark_section_title( __( 'OTHER SERVICES', 'drone-sark' ), '', 'left' ); ?>
				<a href="<?php echo esc_url( $services_url ); ?>" class="ds-btn ds-btn--outline">
					<?php esc_html_e( 'See All Services', 'drone-sark' ); ?>
				</a>
			</div>

			<div class="ds-services-grid">
				<!-- Training -->
				<div class="ds-service-card">
					<div class="ds-service-card__icon">
						<svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M22 10v6M2 10l10-5 10 5-10 5z"/><path d="M6 12v5c3 3 9 3 12 0v-5"/></svg>
					</div>
					<div class="ds-service-card__body">
						<h3><?php esc_html_e( 'Drone Training', 'drone-sark' ); ?></h3>
						<p><?php esc_html_e( 'Professional flight training for beginners to advanced pilots. Get certified and fly with confidence.', 'drone-sark' ); ?></p>
					</div>
				</div>

				<!-- Survey -->
				<div class="ds-service-card">
					<div class="ds-service-card__icon">
						<svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polygon points="3 11 22 2 13 21 11 13 3 11"/></svg>
					</div>
					<div class="ds-service-card__body">
						<h3><?php esc_html_e( 'Aerial Survey', 'drone-sark' ); ?></h3>
						<p><?php esc_html_e( 'High-resolution aerial surveys for construction, agriculture, real estate, and infrastructure projects.', 'drone-sark' ); ?></p>
					</div>
				</div>

				<!-- Mapping -->
				<div class="ds-service-card">
					<div class="ds-service-card__icon">
						<svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polygon points="1 6 1 22 8 18 16 22 23 18 23 2 16 6 8 2 1 6"/><line x1="8" y1="2" x2="8" y2="18"/><line x1="16" y1="6" x2="16" y2="22"/></svg>
					</div>
					<div class="ds-service-card__body">
						<h3><?php esc_html_e( '3D Mapping', 'drone-sark' ); ?></h3>
						<p><?php esc_html_e( 'Precise 3D photogrammetry mapping for land development, urban planning, and GIS applications.', 'drone-sark' ); ?></p>
					</div>
				</div>

				<!-- Consultation -->
				<div class="ds-service-card">
					<div class="ds-service-card__icon">
						<svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 15a2 2 0 01-2 2H7l-4 4V5a2 2 0 012-2h14a2 2 0 012 2z"/></svg>
					</div>
					<div class="ds-service-card__body">
						<h3><?php esc_html_e( 'Consultation', 'drone-sark' ); ?></h3>
						<p><?php esc_html_e( 'Expert drone consulting for businesses looking to integrate drone technology into their workflow.', 'drone-sark' ); ?></p>
					</div>
				</div>
			</div>

		</div>
	</div>
</section>
