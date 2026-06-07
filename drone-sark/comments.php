<?php
/**
 * Comments template
 */

if ( ! defined( 'ABSPATH' ) ) exit;
if ( post_password_required() ) return;
?>

<section class="ds-comments" id="comments" style="margin-top:3rem;">

	<?php if ( have_comments() ) : ?>

		<h2 class="ds-comments__title" style="font-size:1.25rem;font-weight:700;margin-bottom:1.5rem;">
			<?php
			printf(
				esc_html( _nx( '%1$s comment on "%2$s"', '%1$s comments on "%2$s"', get_comments_number(), 'comments title', 'drone-sark' ) ),
				number_format_i18n( get_comments_number() ),
				get_the_title()
			);
			?>
		</h2>

		<ol class="comment-list" style="list-style:none;padding:0;display:flex;flex-direction:column;gap:1.5rem;">
			<?php wp_list_comments( array( 'style' => 'ol', 'short_ping' => true, 'avatar_size' => 48 ) ); ?>
		</ol>

		<?php the_comments_navigation(); ?>

	<?php endif; ?>

	<?php if ( ! comments_open() && get_comments_number() && post_type_supports( get_post_type(), 'comments' ) ) : ?>
		<p class="no-comments"><?php esc_html_e( 'Comments are closed.', 'drone-sark' ); ?></p>
	<?php endif; ?>

	<?php comment_form( array(
		'title_reply'         => __( 'Leave a Comment', 'drone-sark' ),
		'title_reply_before'  => '<h3 id="reply-title" class="comment-reply-title" style="font-size:1.25rem;font-weight:700;margin:2rem 0 1rem;">',
		'title_reply_after'   => '</h3>',
		'submit_button'       => '<button name="%1$s" type="submit" id="%2$s" class="ds-btn ds-btn--primary %3$s">%4$s</button>',
	) ); ?>

</section>
