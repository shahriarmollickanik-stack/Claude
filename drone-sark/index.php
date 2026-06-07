<?php
/**
 * The main template file – front-page dispatcher
 *
 * If no static front page is set, this renders based on the
 * homepage version chosen in the Customizer.
 */

if ( ! defined( 'ABSPATH' ) ) exit;

// Front page: dispatch to correct version
if ( is_front_page() && ! is_home() ) {
	$version = get_theme_mod( 'drone_sark_homepage_version', 'v1' );
	get_template_part( 'page-templates/home-v' . ( $version === 'v2' ? '2' : '1' ) );
	return;
}

get_header();
?>

<div class="ds-container ds-section">
	<main id="main" class="ds-archive-layout">

		<?php if ( have_posts() ) : ?>

			<?php if ( is_home() && ! is_front_page() ) : ?>
				<header class="ds-page-header">
					<h1 class="ds-page-header__title"><?php single_post_title(); ?></h1>
				</header>
			<?php endif; ?>

			<div class="ds-post-grid">
				<?php while ( have_posts() ) : the_post(); ?>
					<?php get_template_part( 'template-parts/content/content', get_post_format() ); ?>
				<?php endwhile; ?>
			</div>

			<?php the_posts_navigation( array(
				'prev_text' => __( '← Older posts', 'drone-sark' ),
				'next_text' => __( 'Newer posts →', 'drone-sark' ),
			) ); ?>

		<?php else : ?>
			<p><?php esc_html_e( 'No posts found.', 'drone-sark' ); ?></p>
		<?php endif; ?>

	</main>
</div>

<?php get_footer(); ?>
