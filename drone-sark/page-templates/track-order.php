<?php
/**
 * Template Name: Track Order
 * Template Post Type: page
 */

if ( ! defined( 'ABSPATH' ) ) exit;
get_header();
?>

<div class="ds-container ds-section">
	<main id="main" style="max-width:640px;margin:0 auto;text-align:center;">

		<header style="margin-bottom:3rem;">
			<h1 style="font-size:clamp(1.75rem,3.5vw,2.5rem);font-weight:800;margin:0 0 1rem;"><?php the_title(); ?></h1>
			<p style="color:#707070;font-size:1rem;">
				<?php esc_html_e( 'Enter your order ID to track your delivery status.', 'drone-sark' ); ?>
			</p>
		</header>

		<?php
		// WooCommerce order tracking form
		if ( class_exists( 'WooCommerce' ) ) {
			echo do_shortcode( '[woocommerce_order_tracking]' );
		}

		while ( have_posts() ) : the_post();
			the_content();
		endwhile;
		?>

	</main>
</div>

<?php get_footer(); ?>
