<?php
/**
 * Default page template
 */

if ( ! defined( 'ABSPATH' ) ) exit;
get_header();

// Elementor full-width check
if ( class_exists( '\Elementor\Plugin' ) ) {
	$doc = \Elementor\Plugin::$instance->documents->get( get_the_ID() );
	if ( $doc && $doc->is_built_with_elementor() ) {
		while ( have_posts() ) { the_post(); the_content(); }
		get_footer();
		return;
	}
}
?>

<div class="ds-container ds-section">
	<main id="main" class="ds-page-main">
		<?php while ( have_posts() ) : the_post(); ?>
		<article id="post-<?php the_ID(); ?>" <?php post_class( 'ds-page-content' ); ?>>
			<header class="ds-page-header">
				<h1 class="ds-page-header__title"><?php the_title(); ?></h1>
			</header>
			<div class="ds-page-body entry-content">
				<?php the_content(); ?>
			</div>
		</article>
		<?php endwhile; ?>
	</main>
</div>

<?php get_footer(); ?>
