<?php
/**
 * Single product content – gallery + details + tabs + related
 */

defined( 'ABSPATH' ) || exit;

global $product;
?>

<div id="product-<?php the_ID(); ?>" <?php wc_product_class( 'ds-single-product', $product ); ?>>

	<!-- ── PRODUCT MAIN AREA ──────────────────────────────── -->
	<div class="ds-single-product__main">

		<!-- Gallery -->
		<div class="ds-single-product__gallery">
			<?php
			do_action( 'woocommerce_before_single_product_summary' );
			?>
		</div>

		<!-- Details / Summary -->
		<div class="ds-single-product__summary" itemscope itemtype="http://schema.org/Product">
			<div class="summary entry-summary">
				<!-- Title -->
				<h1 class="ds-single-product__title" itemprop="name"><?php the_title(); ?></h1>

				<!-- Rating + reviews count -->
				<?php if ( wc_review_ratings_enabled() ) : ?>
				<div class="ds-single-product__rating">
					<?php
					$rating = $product->get_average_rating();
					$count  = $product->get_review_count();
					echo drone_sark_star_rating( round( $rating ) );
					?>
					<a href="#reviews" class="ds-single-product__review-link">
						<?php echo esc_html( sprintf( _n( '%s review', '%s reviews', $count, 'drone-sark' ), $count ) ); ?>
					</a>
					<?php if ( $product->get_sku() ) : ?>
						<span class="ds-single-product__sku"><?php esc_html_e( 'SKU:', 'drone-sark' ); ?> <?php echo esc_html( $product->get_sku() ); ?></span>
					<?php endif; ?>
				</div>
				<?php endif; ?>

				<!-- Price -->
				<div class="ds-single-product__price">
					<?php woocommerce_template_single_price(); ?>
				</div>

				<!-- Stock status -->
				<div class="ds-single-product__stock">
					<?php woocommerce_template_single_availability(); ?>
				</div>

				<!-- Short description -->
				<div class="ds-single-product__excerpt">
					<?php woocommerce_template_single_excerpt(); ?>
				</div>

				<!-- Key specs snippet -->
				<?php
				$specs = get_post_meta( get_the_ID(), '_drone_sark_key_specs', true );
				if ( $specs ) :
				?>
				<div class="ds-single-product__key-specs">
					<h4><?php esc_html_e( 'Key Specifications', 'drone-sark' ); ?></h4>
					<div class="ds-key-specs"><?php echo wp_kses_post( $specs ); ?></div>
				</div>
				<?php endif; ?>

				<!-- Add to cart form -->
				<div class="ds-single-product__cart-form">
					<?php woocommerce_template_single_add_to_cart(); ?>
				</div>

				<!-- Buy Now -->
				<?php if ( $product->is_in_stock() && $product->is_purchasable() ) : ?>
				<button
					class="ds-btn ds-btn--outline ds-buy-now"
					data-product-id="<?php echo esc_attr( $product->get_id() ); ?>"
					data-nonce="<?php echo esc_attr( wp_create_nonce( 'drone-sark-nonce' ) ); ?>"
				>
					<?php esc_html_e( 'Buy Now', 'drone-sark' ); ?>
				</button>
				<?php endif; ?>

				<!-- Meta (categories, tags) -->
				<div class="ds-single-product__meta">
					<?php woocommerce_template_single_meta(); ?>
				</div>

				<!-- Shipping notice -->
				<div class="ds-single-product__shipping">
					<div class="ds-shipping-info">
						<svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="1" y="3" width="15" height="13"/><polygon points="16,8 20,8 23,11 23,16 16,16 16,8"/><circle cx="5.5" cy="18.5" r="2.5"/><circle cx="18.5" cy="18.5" r="2.5"/></svg>
						<span><?php esc_html_e( 'Fast delivery via Steadfast Courier', 'drone-sark' ); ?></span>
					</div>
					<div class="ds-shipping-info">
						<svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="1" y="4" width="22" height="16" rx="2"/><line x1="1" y1="10" x2="23" y2="10"/></svg>
						<span><?php esc_html_e( 'Cash on Delivery available', 'drone-sark' ); ?></span>
					</div>
				</div>
			</div>
		</div>

	</div><!-- .ds-single-product__main -->

	<!-- ── PRODUCT TABS ───────────────────────────────────── -->
	<div class="ds-single-product__tabs">
		<?php woocommerce_output_product_data_tabs(); ?>
	</div>

	<!-- ── UPSELLS ────────────────────────────────────────── -->
	<?php woocommerce_upsell_display(); ?>

	<!-- ── RELATED PRODUCTS ──────────────────────────────── -->
	<?php woocommerce_output_related_products(); ?>

</div><!-- .ds-single-product -->
