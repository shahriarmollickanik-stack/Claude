<?php
/**
 * Template Name: Homepage V2 – Sales Focused
 * Template Post Type: page
 *
 * Light/white hero, category cards, all-products grid
 * with load-more, reviews, footer.
 */

if ( ! defined( 'ABSPATH' ) ) exit;
get_header();

if ( class_exists( '\Elementor\Plugin' ) ) {
	$doc = \Elementor\Plugin::$instance->documents->get( get_the_ID() );
	if ( $doc && $doc->is_built_with_elementor() ) {
		echo \Elementor\Plugin::$instance->frontend->get_builder_content_for_display( get_the_ID() );
		get_footer();
		return;
	}
}
?>

<main id="main" class="ds-homepage ds-homepage--v2">

	<?php get_template_part( 'template-parts/home/section', 'hero-v2' ); ?>
	<?php get_template_part( 'template-parts/home/section', 'categories-v2' ); ?>
	<?php get_template_part( 'template-parts/home/section', 'all-products' ); ?>
	<?php get_template_part( 'template-parts/home/section', 'reviews' ); ?>

</main>

<?php get_footer(); ?>
