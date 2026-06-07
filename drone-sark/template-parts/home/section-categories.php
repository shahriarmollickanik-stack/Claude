<?php
/**
 * Homepage V1 – Categories Section (Drones + subcategories)
 */

if ( ! class_exists( 'WooCommerce' ) ) return;

$main_categories = array(
	array( 'slug' => 'drones',              'label' => __( 'Drones', 'drone-sark' ) ),
	array( 'slug' => 'accessories-parts',   'label' => __( 'Accessories & Parts', 'drone-sark' ) ),
	array( 'slug' => 'repair',              'label' => __( 'Repair', 'drone-sark' ) ),
	array( 'slug' => 'other-services',      'label' => __( 'Other Services', 'drone-sark' ) ),
);

$drone_sub = array(
	array( 'slug' => 'toy-drones',          'label' => __( 'Toy', 'drone-sark' ) ),
	array( 'slug' => 'beginner-drones',     'label' => __( 'Beginner', 'drone-sark' ) ),
	array( 'slug' => 'professional-drones', 'label' => __( 'Professional', 'drone-sark' ) ),
	array( 'slug' => 'industrial-drones',   'label' => __( 'Industrial', 'drone-sark' ) ),
);
?>

<section class="ds-section ds-categories" aria-label="<?php esc_attr_e( 'Shop by Category', 'drone-sark' ); ?>">
	<div class="ds-container">
		<?php drone_sark_section_title( __( 'SHOP BY CATEGORY', 'drone-sark' ), '', 'left' ); ?>

		<!-- Main 4 categories -->
		<div class="ds-category-grid ds-category-grid--main">
			<?php foreach ( $main_categories as $cat ) :
				$term = get_term_by( 'slug', $cat['slug'], 'product_cat' );
				$thumb_id  = $term ? get_term_meta( $term->term_id, 'thumbnail_id', true ) : 0;
				$thumb_url = $thumb_id ? wp_get_attachment_image_url( $thumb_id, 'drone-sark-category' ) : '';
				$term_url  = $term ? get_term_link( $term ) : get_permalink( wc_get_page_id( 'shop' ) );
			?>
			<a href="<?php echo esc_url( $term_url ); ?>" class="ds-category-card">
				<div class="ds-category-card__image">
					<?php if ( $thumb_url ) : ?>
						<img src="<?php echo esc_url( $thumb_url ); ?>" alt="<?php echo esc_attr( $cat['label'] ); ?>" loading="lazy" decoding="async">
					<?php else : ?>
						<div class="ds-category-card__placeholder">
							<svg width="40" height="40" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="3"/><path d="M4 8l2-4h12l2 4"/><rect x="2" y="8" width="20" height="12" rx="2"/></svg>
						</div>
					<?php endif; ?>
				</div>
				<div class="ds-category-card__label">
					<span><?php echo esc_html( $cat['label'] ); ?></span>
					<?php if ( $term ) : ?>
						<small><?php echo esc_html( $term->count . ' ' . __( 'Products', 'drone-sark' ) ); ?></small>
					<?php endif; ?>
				</div>
			</a>
			<?php endforeach; ?>
		</div>

		<!-- Drone subcategories -->
		<div class="ds-subcategories">
			<h3 class="ds-subcategories__title"><?php esc_html_e( 'DRONES', 'drone-sark' ); ?></h3>
			<div class="ds-category-grid ds-category-grid--sub">
				<?php foreach ( $drone_sub as $sub ) :
					$term = get_term_by( 'slug', $sub['slug'], 'product_cat' );
					$thumb_id  = $term ? get_term_meta( $term->term_id, 'thumbnail_id', true ) : 0;
					$thumb_url = $thumb_id ? wp_get_attachment_image_url( $thumb_id, 'drone-sark-category' ) : '';
					$term_url  = $term ? get_term_link( $term ) : get_permalink( wc_get_page_id( 'shop' ) );
				?>
				<a href="<?php echo esc_url( $term_url ); ?>" class="ds-sub-category-card">
					<div class="ds-sub-category-card__image">
						<?php if ( $thumb_url ) : ?>
							<img src="<?php echo esc_url( $thumb_url ); ?>" alt="<?php echo esc_attr( $sub['label'] ); ?>" loading="lazy" decoding="async">
						<?php else : ?>
							<div class="ds-sub-category-card__placeholder"></div>
						<?php endif; ?>
					</div>
					<span class="ds-sub-category-card__label"><?php echo esc_html( $sub['label'] ); ?></span>
				</a>
				<?php endforeach; ?>
			</div>
		</div>

	</div>
</section>
