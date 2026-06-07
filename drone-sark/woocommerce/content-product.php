<?php
/**
 * Product card – used in shop loops
 */

defined( 'ABSPATH' ) || exit;
global $product;
?>

<li <?php wc_product_class( 'ds-product-card', $product ); ?>>
	<?php
	/**
	 * Hooks for product card content
	 */
	do_action( 'woocommerce_before_shop_loop_item' );
	?>

	<div class="ds-product-card__image-wrap">
		<a href="<?php the_permalink(); ?>" class="ds-product-card__image-link">
			<?php
			$image_id  = $product->get_image_id();
			$image_url = $image_id
				? wp_get_attachment_image_url( $image_id, 'drone-sark-product-card' )
				: wc_placeholder_img_src( 'drone-sark-product-card' );
			$image_alt = $image_id ? get_post_meta( $image_id, '_wp_attachment_image_alt', true ) : $product->get_name();
			?>
			<img
				src="<?php echo esc_url( $image_url ); ?>"
				alt="<?php echo esc_attr( $image_alt ); ?>"
				class="ds-product-card__image"
				loading="lazy"
				decoding="async"
				width="400"
				height="400"
			/>
		</a>

		<?php if ( $product->is_on_sale() ) : ?>
			<span class="ds-product-card__badge ds-product-card__badge--sale"><?php esc_html_e( 'Sale', 'drone-sark' ); ?></span>
		<?php endif; ?>
		<?php if ( ! $product->is_in_stock() ) : ?>
			<span class="ds-product-card__badge ds-product-card__badge--oos"><?php esc_html_e( 'Out of Stock', 'drone-sark' ); ?></span>
		<?php endif; ?>

		<div class="ds-product-card__actions">
			<?php do_action( 'drone_sark_product_card_actions', $product ); ?>
		</div>
	</div>

	<div class="ds-product-card__body">
		<?php do_action( 'woocommerce_before_shop_loop_item_title' ); ?>

		<h2 class="ds-product-card__title">
			<a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
		</h2>

		<?php
		$rating       = $product->get_average_rating();
		$review_count = $product->get_review_count();
		if ( $rating > 0 ) :
		?>
		<div class="ds-product-card__rating">
			<?php echo drone_sark_star_rating( round( $rating ) ); ?>
			<span class="ds-product-card__review-count">(<?php echo esc_html( $review_count ); ?>)</span>
		</div>
		<?php endif; ?>

		<div class="ds-product-card__price">
			<?php woocommerce_template_loop_price(); ?>
		</div>

		<div class="ds-product-card__footer">
			<?php woocommerce_template_loop_add_to_cart(); ?>
		</div>
	</div>

	<?php do_action( 'woocommerce_after_shop_loop_item' ); ?>
</li>
