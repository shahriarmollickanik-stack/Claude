<?php
/**
 * Homepage V1 – Accessories slider
 */

if ( ! class_exists( 'WooCommerce' ) ) return;

$args = array(
	'post_type'      => 'product',
	'posts_per_page' => 12,
	'post_status'    => 'publish',
	'tax_query'      => array(
		array(
			'taxonomy' => 'product_cat',
			'field'    => 'slug',
			'terms'    => array( 'accessories-parts', 'accessories', 'parts' ),
		),
	),
);

$products = new WP_Query( $args );

if ( ! $products->have_posts() ) {
	// Fallback: show recent products
	$args = array(
		'post_type'      => 'product',
		'posts_per_page' => 12,
		'post_status'    => 'publish',
		'orderby'        => 'date',
		'order'          => 'DESC',
	);
	$products = new WP_Query( $args );
}

if ( ! $products->have_posts() ) return;
?>

<section class="ds-section ds-accessories" aria-label="<?php esc_attr_e( 'Accessories & Parts', 'drone-sark' ); ?>">
	<div class="ds-container">
		<div class="ds-section-header">
			<?php drone_sark_section_title( __( 'ACCESSORIES & PARTS', 'drone-sark' ), '', 'left' ); ?>
			<a href="<?php echo esc_url( get_term_link( 'accessories-parts', 'product_cat' ) ); ?>" class="ds-section-header__link">
				<?php esc_html_e( 'View All', 'drone-sark' ); ?> →
			</a>
		</div>

		<div class="swiper ds-accessories-slider">
			<div class="swiper-wrapper">
				<?php while ( $products->have_posts() ) : $products->the_post();
					global $product;
					$product = wc_get_product( get_the_ID() );
					if ( ! $product ) continue;
				?>
				<div class="swiper-slide">
					<?php get_template_part( 'template-parts/woocommerce/product', 'card' ); ?>
				</div>
				<?php endwhile; wp_reset_postdata(); ?>
			</div>
			<div class="swiper-button-prev ds-slider-prev"></div>
			<div class="swiper-button-next ds-slider-next"></div>
		</div>
	</div>
</section>
