<?php
/**
 * Shop page template
 */

defined( 'ABSPATH' ) || exit;
get_header();
?>

<div class="ds-shop-page">
	<?php
	/**
	 * woocommerce_before_main_content hooks:
	 * - drone_sark_breadcrumb() (priority 5)
	 * - drone_sark_woocommerce_wrapper_before() (priority 10) → opens wrapper + sidebar + main
	 */
	do_action( 'woocommerce_before_main_content' );
	?>

		<?php do_action( 'woocommerce_archive_description' ); ?>

		<div class="ds-shop-toolbar">
			<div class="ds-shop-toolbar__left">
				<h1 class="ds-shop-toolbar__title">
					<?php woocommerce_page_title(); ?>
				</h1>
				<?php if ( function_exists( 'woocommerce_result_count' ) ) {
					woocommerce_result_count();
				} ?>
			</div>
			<div class="ds-shop-toolbar__right">
				<!-- Mobile filter toggle -->
				<button class="ds-filter-drawer-toggle ds-btn ds-btn--outline ds-btn--sm" aria-label="<?php esc_attr_e( 'Filter', 'drone-sark' ); ?>">
					<svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="4" y1="21" x2="4" y2="14"/><line x1="4" y1="10" x2="4" y2="3"/><line x1="12" y1="21" x2="12" y2="12"/><line x1="12" y1="8" x2="12" y2="3"/><line x1="20" y1="21" x2="20" y2="16"/><line x1="20" y1="12" x2="20" y2="3"/><line x1="1" y1="14" x2="7" y2="14"/><line x1="9" y1="8" x2="15" y2="8"/><line x1="17" y1="16" x2="23" y2="16"/></svg>
					<?php esc_html_e( 'Filter', 'drone-sark' ); ?>
				</button>
				<?php woocommerce_catalog_ordering(); ?>
			</div>
		</div>

		<?php if ( woocommerce_product_loop() ) : ?>

			<?php woocommerce_product_loop_start(); ?>

				<?php woocommerce_product_subcategories(); ?>

				<?php while ( have_posts() ) : the_post(); ?>
					<?php wc_get_template_part( 'content', 'product' ); ?>
				<?php endwhile; ?>

			<?php woocommerce_product_loop_end(); ?>

			<?php
			woocommerce_pagination();
			?>

		<?php else : ?>
			<?php do_action( 'woocommerce_no_products_found' ); ?>
		<?php endif; ?>

	<?php do_action( 'woocommerce_after_main_content' ); ?>
</div>

<!-- Mobile filter drawer -->
<div class="ds-filter-drawer" id="ds-filter-drawer" aria-hidden="true">
	<div class="ds-filter-drawer__header">
		<span><?php esc_html_e( 'Filter', 'drone-sark' ); ?></span>
		<button class="ds-filter-drawer__close" aria-label="<?php esc_attr_e( 'Close filter', 'drone-sark' ); ?>">
			<svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
		</button>
	</div>
	<div class="ds-filter-drawer__body">
		<?php if ( is_active_sidebar( 'sidebar-shop' ) ) {
			dynamic_sidebar( 'sidebar-shop' );
		} ?>
	</div>
</div>
<div class="ds-mobile-overlay ds-filter-overlay" id="ds-filter-overlay"></div>

<?php get_footer(); ?>
