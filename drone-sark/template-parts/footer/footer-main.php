<?php
/**
 * Main site footer
 */
$facebook  = get_theme_mod( 'drone_sark_footer_facebook', '' );
$instagram = get_theme_mod( 'drone_sark_footer_instagram', '' );
$youtube   = get_theme_mod( 'drone_sark_footer_youtube', '' );
$whatsapp  = get_theme_mod( 'drone_sark_footer_whatsapp', '' );
$email     = get_theme_mod( 'drone_sark_footer_email', '' );
$address   = get_theme_mod( 'drone_sark_footer_address', '' );
$phone     = get_theme_mod( 'drone_sark_header_phone', '' );
$copyright = get_theme_mod( 'drone_sark_footer_copyright', '© ' . gmdate( 'Y' ) . ' Drone Sark. All rights reserved.' );
?>

<footer class="ds-footer" role="contentinfo">
	<div class="ds-footer-main">
		<div class="ds-container">
			<div class="ds-footer-grid">

				<!-- ── SOCIAL ──────────────────────────────────────── -->
				<div class="ds-footer-col ds-footer-col--social">
					<div class="ds-footer__logo">
						<?php drone_sark_logo(); ?>
					</div>
					<p class="ds-footer__tagline"><?php esc_html_e( 'Elevate Your Perspective', 'drone-sark' ); ?></p>
					<div class="ds-social-links">
						<?php if ( $facebook ) : ?>
						<a href="<?php echo esc_url( $facebook ); ?>" class="ds-social-link" target="_blank" rel="noopener noreferrer" aria-label="Facebook">
							<svg width="20" height="20" viewBox="0 0 24 24" fill="currentColor"><path d="M18 2h-3a5 5 0 00-5 5v3H7v4h3v8h4v-8h3l1-4h-4V7a1 1 0 011-1h3z"/></svg>
						</a>
						<?php endif; ?>
						<?php if ( $instagram ) : ?>
						<a href="<?php echo esc_url( $instagram ); ?>" class="ds-social-link" target="_blank" rel="noopener noreferrer" aria-label="Instagram">
							<svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="2" y="2" width="20" height="20" rx="5" ry="5"/><path d="M16 11.37A4 4 0 1112.63 8 4 4 0 0116 11.37z"/><line x1="17.5" y1="6.5" x2="17.51" y2="6.5"/></svg>
						</a>
						<?php endif; ?>
						<?php if ( $youtube ) : ?>
						<a href="<?php echo esc_url( $youtube ); ?>" class="ds-social-link" target="_blank" rel="noopener noreferrer" aria-label="YouTube">
							<svg width="20" height="20" viewBox="0 0 24 24" fill="currentColor"><path d="M22.54 6.42a2.78 2.78 0 00-1.95-1.96C18.88 4 12 4 12 4s-6.88 0-8.59.46a2.78 2.78 0 00-1.95 1.96A29 29 0 001 12a29 29 0 00.46 5.58A2.78 2.78 0 003.41 19.54C5.12 20 12 20 12 20s6.88 0 8.59-.46a2.78 2.78 0 001.95-1.96A29 29 0 0023 12a29 29 0 00-.46-5.58zM9.75 15.02V8.98L15.5 12l-5.75 3.02z"/></svg>
						</a>
						<?php endif; ?>
						<?php if ( $whatsapp ) : ?>
						<a href="https://wa.me/<?php echo esc_attr( preg_replace( '/\D/', '', $whatsapp ) ); ?>" class="ds-social-link" target="_blank" rel="noopener noreferrer" aria-label="WhatsApp">
							<svg width="20" height="20" viewBox="0 0 24 24" fill="currentColor"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.890-5.335 11.893-11.893A11.821 11.821 0 0020.885 3.488"/></svg>
						</a>
						<?php endif; ?>
					</div>
				</div>

				<!-- ── CONTACT US ────────────────────────────────── -->
				<div class="ds-footer-col ds-footer-col--contact">
					<h4 class="ds-footer-col__title"><?php esc_html_e( 'Contact Us', 'drone-sark' ); ?></h4>
					<ul class="ds-footer-contact">
						<?php if ( $phone ) : ?>
						<li>
							<svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M22 16.92v3a2 2 0 01-2.18 2 19.79 19.79 0 01-8.63-3.07A19.5 19.5 0 014.33 14a19.79 19.79 0 01-3.07-8.67A2 2 0 013.25 3h3a2 2 0 012 1.72c.127.96.361 1.903.7 2.81a2 2 0 01-.45 2.11L7.91 10.1a16 16 0 006 6l.62-.62a2 2 0 012.11-.45c.907.339 1.85.573 2.81.7A2 2 0 0122 16.92z"/></svg>
							<a href="tel:<?php echo esc_attr( preg_replace( '/\D/', '', $phone ) ); ?>"><?php echo esc_html( $phone ); ?></a>
						</li>
						<?php endif; ?>
						<?php if ( $email ) : ?>
						<li>
							<svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/><polyline points="22,6 12,13 2,6"/></svg>
							<a href="mailto:<?php echo esc_attr( $email ); ?>"><?php echo esc_html( $email ); ?></a>
						</li>
						<?php endif; ?>
						<?php if ( $address ) : ?>
						<li>
							<svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 10c0 7-9 13-9 13S3 17 3 10a9 9 0 0118 0z"/><circle cx="12" cy="10" r="3"/></svg>
							<address><?php echo nl2br( esc_html( $address ) ); ?></address>
						</li>
						<?php endif; ?>
					</ul>

					<!-- Quick links -->
					<h4 class="ds-footer-col__title" style="margin-top:1.5rem;"><?php esc_html_e( 'Quick Links', 'drone-sark' ); ?></h4>
					<ul class="ds-footer-links">
						<li><a href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php esc_html_e( 'Home', 'drone-sark' ); ?></a></li>
						<?php if ( class_exists( 'WooCommerce' ) ) : ?>
						<li><a href="<?php echo esc_url( drone_sark_get_shop_url() ); ?>"><?php esc_html_e( 'Shop', 'drone-sark' ); ?></a></li>
						<?php endif; ?>
						<li><a href="<?php echo esc_url( get_permalink( get_page_by_path( 'contact' ) ) ); ?>"><?php esc_html_e( 'Contact', 'drone-sark' ); ?></a></li>
						<li><a href="<?php echo esc_url( get_permalink( get_page_by_path( 'track-order' ) ) ); ?>"><?php esc_html_e( 'Track Order', 'drone-sark' ); ?></a></li>
					</ul>
				</div>

				<!-- ── PAYMENT PARTNER ───────────────────────────── -->
				<div class="ds-footer-col ds-footer-col--payment">
					<h4 class="ds-footer-col__title"><?php esc_html_e( 'Payment Partner', 'drone-sark' ); ?></h4>
					<div class="ds-footer-payment-badge">
						<div class="ds-cod-badge">
							<svg class="ds-cod-badge__icon" width="40" height="40" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
								<rect x="1" y="4" width="22" height="16" rx="2" ry="2"/>
								<line x1="1" y1="10" x2="23" y2="10"/>
							</svg>
							<div>
								<strong><?php esc_html_e( 'Cash on Delivery', 'drone-sark' ); ?></strong>
								<span><?php esc_html_e( 'Safe & Secure', 'drone-sark' ); ?></span>
							</div>
						</div>
					</div>
				</div>

				<!-- ── DELIVERY PARTNER ──────────────────────────── -->
				<div class="ds-footer-col ds-footer-col--delivery">
					<h4 class="ds-footer-col__title"><?php esc_html_e( 'Delivery Partner', 'drone-sark' ); ?></h4>
					<div class="ds-footer-delivery-badge">
						<div class="ds-steadfast-badge">
							<svg class="ds-steadfast-badge__icon" width="40" height="40" viewBox="0 0 100 100" fill="none" xmlns="http://www.w3.org/2000/svg">
								<rect width="100" height="100" rx="8" fill="#fff"/>
								<text x="50" y="58" font-size="14" font-weight="800" fill="#000" text-anchor="middle" font-family="Arial,sans-serif">STEADFAST</text>
								<path d="M15 72 L85 72" stroke="#000" stroke-width="3"/>
								<path d="M20 40 L50 20 L80 40" stroke="#000" stroke-width="3" fill="none" stroke-linecap="round"/>
								<rect x="30" y="40" width="40" height="30" rx="2" fill="none" stroke="#000" stroke-width="2"/>
							</svg>
							<div>
								<strong><?php esc_html_e( 'Steadfast', 'drone-sark' ); ?></strong>
								<span><?php esc_html_e( 'Courier Service', 'drone-sark' ); ?></span>
							</div>
						</div>
					</div>
				</div>

			</div><!-- .ds-footer-grid -->
		</div><!-- .ds-container -->
	</div><!-- .ds-footer-main -->

	<!-- Footer bottom bar -->
	<div class="ds-footer-bottom">
		<div class="ds-container">
			<div class="ds-footer-bottom__inner">
				<p class="ds-footer-bottom__copyright"><?php echo wp_kses_post( $copyright ); ?></p>
				<div class="ds-footer-bottom__links">
					<a href="<?php echo esc_url( get_privacy_policy_url() ); ?>"><?php esc_html_e( 'Privacy Policy', 'drone-sark' ); ?></a>
					<a href="#"><?php esc_html_e( 'Terms of Service', 'drone-sark' ); ?></a>
					<a href="<?php echo esc_url( get_permalink( get_page_by_path( 'track-order' ) ) ); ?>"><?php esc_html_e( 'Track Order', 'drone-sark' ); ?></a>
				</div>
			</div>
		</div>
	</div>
</footer>
