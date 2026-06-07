<?php
/**
 * Default post content partial
 */

if ( ! defined( 'ABSPATH' ) ) exit;
?>

<article id="post-<?php the_ID(); ?>" <?php post_class( 'ds-post-card' ); ?>>
	<?php if ( has_post_thumbnail() ) : ?>
	<a href="<?php the_permalink(); ?>" class="ds-post-card__image-link" style="display:block;border-radius:8px 8px 0 0;overflow:hidden;aspect-ratio:16/9;">
		<?php the_post_thumbnail( 'drone-sark-banner', array( 'style' => 'width:100%;height:100%;object-fit:cover;' ) ); ?>
	</a>
	<?php endif; ?>

	<div style="padding:1.25rem;border:1px solid #e8e8e8;border-top:none;border-radius:0 0 8px 8px;">
		<div style="display:flex;gap:.5rem;margin-bottom:.75rem;">
			<?php foreach ( get_the_category() as $cat ) : ?>
				<a href="<?php echo esc_url( get_category_link( $cat->term_id ) ); ?>" style="font-size:.7rem;font-weight:700;letter-spacing:.08em;text-transform:uppercase;color:#707070;text-decoration:none;"><?php echo esc_html( $cat->name ); ?></a>
			<?php endforeach; ?>
			<span style="font-size:.75rem;color:#a0a0a0;margin-left:auto;"><?php the_date(); ?></span>
		</div>

		<h2 style="font-size:1rem;font-weight:700;margin:0 0 .625rem;line-height:1.4;">
			<a href="<?php the_permalink(); ?>" style="color:#000;text-decoration:none;"><?php the_title(); ?></a>
		</h2>

		<p style="font-size:.875rem;color:#505050;line-height:1.6;margin:0 0 1rem;">
			<?php echo wp_trim_words( get_the_excerpt(), 20, '...' ); ?>
		</p>

		<a href="<?php the_permalink(); ?>" style="font-size:.8125rem;font-weight:600;color:#000;text-decoration:none;">
			<?php esc_html_e( 'Read more →', 'drone-sark' ); ?>
		</a>
	</div>
</article>
