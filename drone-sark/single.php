<?php
/**
 * Single blog post
 */

if ( ! defined( 'ABSPATH' ) ) exit;
get_header();
?>

<div class="ds-container ds-section">
	<main id="main" style="max-width:760px;margin:0 auto;">
		<?php while ( have_posts() ) : the_post(); ?>

		<article id="post-<?php the_ID(); ?>" <?php post_class( 'ds-single-post' ); ?>>
			<header class="ds-single-post__header" style="margin-bottom:2rem;">
				<?php if ( has_post_thumbnail() ) : ?>
					<div style="margin-bottom:2rem;border-radius:12px;overflow:hidden;">
						<?php the_post_thumbnail( 'drone-sark-banner', array( 'style' => 'width:100%;height:auto;' ) ); ?>
					</div>
				<?php endif; ?>

				<div style="display:flex;gap:.75rem;align-items:center;margin-bottom:1rem;flex-wrap:wrap;">
					<?php foreach ( get_the_category() as $cat ) : ?>
						<a href="<?php echo esc_url( get_category_link( $cat->term_id ) ); ?>" style="background:#000;color:#fff;padding:.25rem .75rem;border-radius:999px;font-size:.75rem;font-weight:600;text-decoration:none;">
							<?php echo esc_html( $cat->name ); ?>
						</a>
					<?php endforeach; ?>
					<span style="font-size:.8125rem;color:#707070;"><?php the_date(); ?></span>
				</div>

				<h1 style="font-size:clamp(1.75rem,3vw,2.5rem);font-weight:800;margin:0;"><?php the_title(); ?></h1>
			</header>

			<div class="entry-content" style="font-size:1rem;line-height:1.8;color:#333;">
				<?php the_content(); ?>
			</div>

			<footer style="margin-top:3rem;padding-top:1.5rem;border-top:1px solid #e8e8e8;">
				<div style="font-size:.875rem;color:#707070;">
					<?php the_tags( '<span>Tags: </span>', ', ', '' ); ?>
				</div>
			</footer>
		</article>

		<?php
		the_post_navigation( array(
			'prev_text' => '<span>← ' . __( 'Previous', 'drone-sark' ) . '</span><br>%title',
			'next_text' => '<span>' . __( 'Next', 'drone-sark' ) . ' →</span><br>%title',
		) );
		?>

		<?php if ( comments_open() || get_comments_number() ) : ?>
			<?php comments_template(); ?>
		<?php endif; ?>

		<?php endwhile; ?>
	</main>
</div>

<?php get_footer(); ?>
