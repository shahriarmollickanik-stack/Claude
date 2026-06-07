<?php
/**
 * Reusable product card component
 * Used in sliders and custom grids.
 */

global $product;

if ( ! $product ) {
	$product = wc_get_product( get_the_ID() );
}
if ( ! $product ) return;

$price        = $product->get_price_html();
$image_id     = $product->get_image_id();
$image_url    = $image_id ? wp_get_attachment_image_url( $image_id, 'drone-sark-product-card' ) : wc_placeholder_img_src( 'drone-sark-product-card' );
$image_alt    = $image_id ? get_post_meta( $image_id, '_wp_attachment_image_alt', true ) : $product->get_name();
$permalink    = $product->get_permalink();
$rating       = $product->get_average_rating();
$review_count = $product->get_review_count();
$in_stock     = $product->is_in_stock();
$is_on_sale   = $product->is_on_sale();
$regular      = $product->get_regular_price();
$sale         = $product->get_sale_price();
?>

<div class="ds-product-card" data-product-id="<?php echo esc_attr( $product->get_id() ); ?>">
	<div class="ds-product-card__image-wrap">
		<a href="<?php echo esc_url( $permalink ); ?>" class="ds-product-card__image-link" aria-label="<?php echo esc_attr( $product->get_name() ); ?>">
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

		<?php if ( $is_on_sale ) : ?>
			<span class="ds-product-card__badge ds-product-card__badge--sale"><?php esc_html_e( 'Sale', 'drone-sark' ); ?></span>
		<?php endif; ?>

		<?php if ( ! $in_stock ) : ?>
			<span class="ds-product-card__badge ds-product-card__badge--oos"><?php esc_html_e( 'Out of Stock', 'drone-sark' ); ?></span>
		<?php endif; ?>

		<!-- Quick actions overlay -->
		<div class="ds-product-card__actions">
			<?php if ( function_exists( 'YITH_WCWL' ) ) : ?>
			<button class="ds-product-card__action ds-wishlist-btn" data-product-id="<?php echo esc_attr( $product->get_id() ); ?>" aria-label="<?php esc_attr_e( 'Add to Wishlist', 'drone-sark' ); ?>">
				<svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M20.84 4.61a5.5 5.5 0 00-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 00-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 000-7.78z"/></svg>
			</button>
			<?php endif; ?>
		</div>
	</div>

	<div class="ds-product-card__body">
		<h3 class="ds-product-card__title">
			<a href="<?php echo esc_url( $permalink ); ?>"><?php echo esc_html( $product->get_name() ); ?></a>
		</h3>

		<?php if ( $rating > 0 ) : ?>
		<div class="ds-product-card__rating">
			<?php echo drone_sark_star_rating( round( $rating ) ); ?>
			<span class="ds-product-card__review-count">(<?php echo esc_html( $review_count ); ?>)</span>
		</div>
		<?php endif; ?>

		<div class="ds-product-card__price">
			<?php echo wp_kses_post( $price ); ?>
		</div>

		<div class="ds-product-card__footer">
			<?php if ( $in_stock ) : ?>
				<button
					class="ds-btn ds-btn--primary ds-btn--sm ds-add-to-cart"
					data-product-id="<?php echo esc_attr( $product->get_id() ); ?>"
					data-nonce="<?php echo esc_attr( wp_create_nonce( 'drone-sark-nonce' ) ); ?>"
					aria-label="<?php echo esc_attr( sprintf( __( 'Add %s to cart', 'drone-sark' ), $product->get_name() ) ); ?>"
				>
					<svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M6 2 3 6v14a2 2 0 002 2h14a2 2 0 002-2V6l-3-4z"/><line x1="3" y1="6" x2="21" y2="6"/><path d="M16 10a4 4 0 01-8 0"/></svg>
					<?php esc_html_e( 'Add to Cart', 'drone-sark' ); ?>
				</button>
			<?php else : ?>
				<span class="ds-product-card__oos-text"><?php esc_html_e( 'Out of Stock', 'drone-sark' ); ?></span>
			<?php endif; ?>
		</div>
	</div>
</div>
