<?php
/**
 * Homepage V2 – All Products grid with AJAX load more
 */

if ( ! class_exists( 'WooCommerce' ) ) return;

$per_page = 12;

$args = array(
	'post_type'      => 'product',
	'posts_per_page' => $per_page,
	'post_status'    => 'publish',
	'orderby'        => 'date',
	'order'          => 'DESC',
);

$products = new WP_Query( $args );
$max_pages = $products->max_num_pages;
?>

<section class="ds-section ds-all-products" aria-label="<?php esc_attr_e( 'All Products', 'drone-sark' ); ?>">
	<div class="ds-container">
		<?php drone_sark_section_title( __( 'ALL PRODUCTS', 'drone-sark' ), '', 'left' ); ?>

		<ul class="ds-products-grid ds-products-grid--home" id="ds-products-grid">
			<?php
			if ( $products->have_posts() ) :
				woocommerce_product_loop_start();
				while ( $products->have_posts() ) :
					$products->the_post();
					wc_get_template_part( 'content', 'product' );
				endwhile;
				woocommerce_product_loop_end();
				wp_reset_postdata();
			endif;
			?>
		</ul>

		<?php if ( $max_pages > 1 ) : ?>
		<div class="ds-load-more-wrap">
			<button
				class="ds-btn ds-btn--outline ds-load-more"
				id="ds-load-more"
				data-page="2"
				data-per-page="<?php echo esc_attr( $per_page ); ?>"
				data-max-pages="<?php echo esc_attr( $max_pages ); ?>"
				data-nonce="<?php echo esc_attr( wp_create_nonce( 'drone-sark-nonce' ) ); ?>"
			>
				<span class="ds-load-more__text"><?php esc_html_e( 'Show More Products', 'drone-sark' ); ?></span>
				<span class="ds-load-more__loading" hidden>
					<svg class="ds-spinner" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 2v4m0 12v4m-7.07-14.07 2.83 2.83M16.24 16.24l2.83 2.83M2 12h4m12 0h4M4.93 19.07l2.83-2.83M16.24 7.76l2.83-2.83"/></svg>
					<?php esc_html_e( 'Loading...', 'drone-sark' ); ?>
				</span>
			</button>
		</div>
		<?php endif; ?>

	</div>
</section>
