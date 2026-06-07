<?php
/**
 * 404 page
 */

if ( ! defined( 'ABSPATH' ) ) exit;
get_header();
?>

<div class="ds-container">
	<div class="ds-404">
		<div>
			<span class="ds-404__code">404</span>
			<h1 class="ds-404__title"><?php esc_html_e( 'Page Not Found', 'drone-sark' ); ?></h1>
			<p class="ds-404__text"><?php esc_html_e( "The page you're looking for doesn't exist or has been moved.", 'drone-sark' ); ?></p>
			<div style="display:flex;gap:1rem;justify-content:center;flex-wrap:wrap;">
				<a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="ds-btn ds-btn--primary">
					<?php esc_html_e( 'Go Home', 'drone-sark' ); ?>
				</a>
				<?php if ( class_exists( 'WooCommerce' ) ) : ?>
				<a href="<?php echo esc_url( drone_sark_get_shop_url() ); ?>" class="ds-btn ds-btn--outline">
					<?php esc_html_e( 'Browse Shop', 'drone-sark' ); ?>
				</a>
				<?php endif; ?>
			</div>
		</div>
	</div>
</div>

<?php get_footer(); ?>
