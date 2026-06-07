<?php
/**
 * Customer Reviews slider – shared V1 and V2
 *
 * Pulls WooCommerce product reviews. Falls back to static
 * demo reviews when no real reviews exist yet.
 */

$reviews = array();

if ( class_exists( 'WooCommerce' ) ) {
	$comments = get_comments( array(
		'post_type' => 'product',
		'status'    => 'approve',
		'number'    => 12,
		'meta_key'  => 'rating',
		'orderby'   => 'comment_date_gmt',
		'order'     => 'DESC',
	) );

	foreach ( $comments as $c ) {
		$rating = intval( get_comment_meta( $c->comment_ID, 'rating', true ) );
		if ( ! $rating ) $rating = 5;
		$reviews[] = array(
			'author' => $c->comment_author,
			'rating' => $rating,
			'text'   => wp_trim_words( $c->comment_content, 30 ),
			'date'   => mysql2date( get_option( 'date_format' ), $c->comment_date ),
			'avatar' => get_avatar_url( $c->comment_author_email, array( 'size' => 48 ) ),
		);
	}
}

// Demo reviews fallback
if ( empty( $reviews ) ) {
	$reviews = array(
		array( 'author' => 'Rahim Ahmed',     'rating' => 5, 'text' => 'Absolutely love my new DJI Mavic 3 Pro from Drone Sark! Delivery was super fast and the team helped me pick the perfect drone for my needs.',    'date' => '2025-05-10', 'avatar' => '' ),
		array( 'author' => 'Priya Sharma',    'rating' => 5, 'text' => 'Best drone shop in the country. Got my Mini 4 Pro with all accessories. The repair service is also top-notch — they fixed my old drone in 2 days!', 'date' => '2025-04-22', 'avatar' => '' ),
		array( 'author' => 'Tanvir Khan',     'rating' => 4, 'text' => 'Excellent customer service and genuine products. The Steadfast delivery was quick and well-packaged. Will definitely order again.',               'date' => '2025-04-15', 'avatar' => '' ),
		array( 'author' => 'Nadia Begum',     'rating' => 5, 'text' => 'I enrolled in the drone training program — absolutely worth it! The instructors are knowledgeable and patient. Highly recommended!',               'date' => '2025-03-30', 'avatar' => '' ),
		array( 'author' => 'Sajid Islam',     'rating' => 5, 'text' => 'Professional mapping service exceeded our expectations. The aerial data was precise and the delivery was on time. Great team!',                    'date' => '2025-03-18', 'avatar' => '' ),
		array( 'author' => 'Farida Hossain',  'rating' => 5, 'text' => 'Bought accessories for my old DJI Phantom. Very fair prices and the parts were exactly as described. Fast shipping too!',                          'date' => '2025-02-28', 'avatar' => '' ),
	);
}
?>

<section class="ds-section ds-reviews" aria-label="<?php esc_attr_e( 'Customer Reviews', 'drone-sark' ); ?>">
	<div class="ds-container">
		<div class="ds-section-header">
			<?php drone_sark_section_title( __( 'WHAT OUR CUSTOMERS SAY', 'drone-sark' ), '', 'left' ); ?>
		</div>

		<div class="swiper ds-reviews-slider">
			<div class="swiper-wrapper">
				<?php foreach ( $reviews as $review ) : ?>
				<div class="swiper-slide">
					<div class="ds-review-card">
						<div class="ds-review-card__rating">
							<?php echo drone_sark_star_rating( $review['rating'] ); ?>
						</div>
						<p class="ds-review-card__text">"<?php echo esc_html( $review['text'] ); ?>"</p>
						<div class="ds-review-card__author">
							<?php if ( $review['avatar'] ) : ?>
								<img src="<?php echo esc_url( $review['avatar'] ); ?>" alt="<?php echo esc_attr( $review['author'] ); ?>" class="ds-review-card__avatar" width="40" height="40">
							<?php else : ?>
								<div class="ds-review-card__avatar ds-review-card__avatar--placeholder">
									<?php echo esc_html( mb_substr( $review['author'], 0, 1 ) ); ?>
								</div>
							<?php endif; ?>
							<div>
								<strong class="ds-review-card__name"><?php echo esc_html( $review['author'] ); ?></strong>
								<span class="ds-review-card__date"><?php echo esc_html( $review['date'] ); ?></span>
							</div>
						</div>
					</div>
				</div>
				<?php endforeach; ?>
			</div>
			<div class="swiper-button-prev ds-slider-prev"></div>
			<div class="swiper-button-next ds-slider-next"></div>
			<div class="swiper-pagination ds-reviews-pagination"></div>
		</div>
	</div>
</section>
