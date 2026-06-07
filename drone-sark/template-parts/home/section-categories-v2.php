<?php
/**
 * Homepage V2 – Categories row (4 white cards)
 */

if ( ! class_exists( 'WooCommerce' ) ) return;

$categories = array(
	array( 'slug' => 'drones',            'label' => __( 'Drones', 'drone-sark' ),            'icon' => 'drone' ),
	array( 'slug' => 'accessories-parts', 'label' => __( 'Accessories & Parts', 'drone-sark' ), 'icon' => 'parts' ),
	array( 'slug' => 'repair',            'label' => __( 'Repair', 'drone-sark' ),             'icon' => 'repair' ),
	array( 'slug' => 'other-services',    'label' => __( 'Other Services', 'drone-sark' ),     'icon' => 'services' ),
);
?>

<section class="ds-section ds-section--sm ds-categories-v2" aria-label="<?php esc_attr_e( 'Categories', 'drone-sark' ); ?>">
	<div class="ds-container">
		<div class="ds-category-row">
			<?php foreach ( $categories as $cat ) :
				$term     = get_term_by( 'slug', $cat['slug'], 'product_cat' );
				$thumb_id = $term ? get_term_meta( $term->term_id, 'thumbnail_id', true ) : 0;
				$img_url  = $thumb_id ? wp_get_attachment_image_url( $thumb_id, 'drone-sark-category' ) : '';
				$url      = $term ? get_term_link( $term ) : drone_sark_get_shop_url();
			?>
			<a href="<?php echo esc_url( $url ); ?>" class="ds-category-row-card">
				<div class="ds-category-row-card__image">
					<?php if ( $img_url ) : ?>
						<img src="<?php echo esc_url( $img_url ); ?>" alt="<?php echo esc_attr( $cat['label'] ); ?>" loading="lazy">
					<?php else : ?>
						<div class="ds-category-row-card__icon">
							<?php if ( $cat['icon'] === 'drone' ) : ?>
								<svg width="50" height="50" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="3"/><line x1="6" y1="6" x2="9" y2="9"/><line x1="18" y1="6" x2="15" y2="9"/><line x1="6" y1="18" x2="9" y2="15"/><line x1="18" y1="18" x2="15" y2="15"/><circle cx="5" cy="5" r="2"/><circle cx="19" cy="5" r="2"/><circle cx="5" cy="19" r="2"/><circle cx="19" cy="19" r="2"/></svg>
							<?php elseif ( $cat['icon'] === 'parts' ) : ?>
								<svg width="50" height="50" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><path d="M14.7 6.3a1 1 0 000 1.4l1.6 1.6a1 1 0 001.4 0l3.77-3.77a6 6 0 01-7.94 7.94l-6.91 6.91a2.12 2.12 0 01-3-3l6.91-6.91a6 6 0 017.94-7.94l-3.76 3.76z"/></svg>
							<?php elseif ( $cat['icon'] === 'repair' ) : ?>
								<svg width="50" height="50" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/></svg>
							<?php else : ?>
								<svg width="50" height="50" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="22,12 18,12 15,21 9,3 6,12 2,12"/></svg>
							<?php endif; ?>
						</div>
					<?php endif; ?>
				</div>
				<span class="ds-category-row-card__label"><?php echo esc_html( $cat['label'] ); ?></span>
			</a>
			<?php endforeach; ?>
		</div>
	</div>
</section>
