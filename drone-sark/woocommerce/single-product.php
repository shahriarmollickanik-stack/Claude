<?php
/**
 * Single product page
 */

defined( 'ABSPATH' ) || exit;
get_header();
?>

<div class="ds-product-page">
	<div class="ds-container">

		<?php woocommerce_breadcrumb( array(
			'wrap_before' => '<nav class="ds-breadcrumb" aria-label="' . esc_attr__( 'Breadcrumb', 'drone-sark' ) . '">',
			'wrap_after'  => '</nav>',
			'delimiter'   => '<span class="ds-breadcrumb__sep"> / </span>',
		) ); ?>

		<?php while ( have_posts() ) : the_post(); ?>

			<?php wc_get_template_part( 'content', 'single-product' ); ?>

		<?php endwhile; ?>

	</div>
</div>

<?php get_footer(); ?>
