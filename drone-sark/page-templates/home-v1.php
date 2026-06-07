<?php
/**
 * Template Name: Homepage V1 – Premium Brand
 * Template Post Type: page
 *
 * Dark hero, categories grid, accessories slider,
 * repair banner, other services banner, reviews, footer.
 */

if ( ! defined( 'ABSPATH' ) ) exit;
get_header();

// If this page was built with Elementor, let Elementor render it
if ( class_exists( '\Elementor\Plugin' ) ) {
	$doc = \Elementor\Plugin::$instance->documents->get( get_the_ID() );
	if ( $doc && $doc->is_built_with_elementor() ) {
		echo \Elementor\Plugin::$instance->frontend->get_builder_content_for_display( get_the_ID() );
		get_footer();
		return;
	}
}
?>

<main id="main" class="ds-homepage ds-homepage--v1">

	<?php get_template_part( 'template-parts/home/section', 'hero-v1' ); ?>
	<?php get_template_part( 'template-parts/home/section', 'categories' ); ?>
	<?php get_template_part( 'template-parts/home/section', 'accessories' ); ?>
	<?php get_template_part( 'template-parts/home/section', 'repair' ); ?>
	<?php get_template_part( 'template-parts/home/section', 'services' ); ?>
	<?php get_template_part( 'template-parts/home/section', 'reviews' ); ?>

</main>

<?php get_footer(); ?>
