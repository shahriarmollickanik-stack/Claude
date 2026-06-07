<?php
/**
 * Archive page (blog, category, tag, etc.)
 */

if ( ! defined( 'ABSPATH' ) ) exit;
get_header();
?>

<div class="ds-container ds-section">
	<main id="main">
		<?php if ( have_posts() ) : ?>

			<header class="ds-page-header" style="margin-bottom:2rem;">
				<?php the_archive_title( '<h1 class="ds-page-header__title">', '</h1>' ); ?>
				<?php the_archive_description( '<p class="ds-page-header__desc">', '</p>' ); ?>
			</header>

			<div class="ds-post-grid">
				<?php while ( have_posts() ) : the_post(); ?>
					<?php get_template_part( 'template-parts/content/content', get_post_format() ); ?>
				<?php endwhile; ?>
			</div>

			<?php the_posts_navigation(); ?>

		<?php else : ?>
			<p><?php esc_html_e( 'Nothing found.', 'drone-sark' ); ?></p>
		<?php endif; ?>
	</main>
</div>

<?php get_footer(); ?>
