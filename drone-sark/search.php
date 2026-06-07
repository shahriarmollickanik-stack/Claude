<?php
/**
 * Search results page
 */

if ( ! defined( 'ABSPATH' ) ) exit;
get_header();
?>

<div class="ds-container ds-section">
	<main id="main">
		<header class="ds-page-header" style="margin-bottom:2rem;">
			<h1 class="ds-page-header__title">
				<?php
				printf(
					esc_html__( 'Search results for: %s', 'drone-sark' ),
					'<span class="search-term">' . esc_html( get_search_query() ) . '</span>'
				);
				?>
			</h1>
		</header>

		<?php if ( have_posts() ) : ?>

			<?php if ( class_exists( 'WooCommerce' ) && is_search() ) : ?>
			<ul class="ds-products-grid" style="grid-template-columns:repeat(4,1fr);">
				<?php while ( have_posts() ) : the_post(); ?>
					<?php if ( get_post_type() === 'product' ) {
						wc_get_template_part( 'content', 'product' );
					} else {
						get_template_part( 'template-parts/content/content', get_post_format() );
					} ?>
				<?php endwhile; ?>
			</ul>
			<?php else : ?>
			<div class="ds-post-grid">
				<?php while ( have_posts() ) : the_post(); ?>
					<?php get_template_part( 'template-parts/content/content', get_post_format() ); ?>
				<?php endwhile; ?>
			</div>
			<?php endif; ?>

			<?php the_posts_navigation(); ?>

		<?php else : ?>

			<div style="text-align:center;padding:4rem 0;">
				<p style="font-size:1.125rem;color:#707070;margin-bottom:1.5rem;">
					<?php esc_html_e( 'No results found. Try a different search term.', 'drone-sark' ); ?>
				</p>
				<?php get_search_form(); ?>
			</div>

		<?php endif; ?>
	</main>
</div>

<?php get_footer(); ?>
