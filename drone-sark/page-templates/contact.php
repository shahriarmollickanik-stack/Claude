<?php
/**
 * Template Name: Contact Us
 * Template Post Type: page
 */

if ( ! defined( 'ABSPATH' ) ) exit;
get_header();

// Elementor check
if ( class_exists( '\Elementor\Plugin' ) ) {
	$doc = \Elementor\Plugin::$instance->documents->get( get_the_ID() );
	if ( $doc && $doc->is_built_with_elementor() ) {
		while ( have_posts() ) { the_post(); the_content(); }
		get_footer();
		return;
	}
}

$phone   = get_theme_mod( 'drone_sark_header_phone', '' );
$email   = get_theme_mod( 'drone_sark_footer_email', '' );
$address = get_theme_mod( 'drone_sark_footer_address', '' );
?>

<div class="ds-container ds-section">
	<main id="main">

		<header class="ds-page-header" style="margin-bottom:3rem;text-align:center;">
			<h1 style="font-size:clamp(2rem,4vw,3rem);font-weight:800;margin:0 0 1rem;"><?php the_title(); ?></h1>
			<p style="color:#707070;font-size:1.0625rem;max-width:500px;margin:0 auto;">
				<?php esc_html_e( "We'd love to hear from you. Fill in the form or reach us directly.", 'drone-sark' ); ?>
			</p>
		</header>

		<div style="display:grid;grid-template-columns:1fr 1.2fr;gap:4rem;align-items:start;">

			<!-- Contact info -->
			<div>
				<h2 style="font-size:1.25rem;font-weight:700;margin:0 0 1.5rem;"><?php esc_html_e( 'Get In Touch', 'drone-sark' ); ?></h2>

				<div style="display:flex;flex-direction:column;gap:1.25rem;">
					<?php if ( $phone ) : ?>
					<div style="display:flex;align-items:center;gap:.875rem;">
						<div style="width:48px;height:48px;border-radius:12px;background:#000;color:#fff;display:flex;align-items:center;justify-content:center;flex-shrink:0;">
							<svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M22 16.92v3a2 2 0 01-2.18 2 19.79 19.79 0 01-8.63-3.07A19.5 19.5 0 014.33 14a19.79 19.79 0 01-3.07-8.67A2 2 0 013.25 3h3a2 2 0 012 1.72c.127.96.361 1.903.7 2.81a2 2 0 01-.45 2.11L7.91 10.1a16 16 0 006 6l.62-.62a2 2 0 012.11-.45c.907.339 1.85.573 2.81.7A2 2 0 0122 16.92z"/></svg>
						</div>
						<div>
							<div style="font-size:.75rem;font-weight:700;letter-spacing:.08em;text-transform:uppercase;color:#a0a0a0;margin-bottom:.2rem;"><?php esc_html_e( 'Phone', 'drone-sark' ); ?></div>
							<a href="tel:<?php echo esc_attr( preg_replace( '/\D/', '', $phone ) ); ?>" style="font-weight:600;color:#000;text-decoration:none;"><?php echo esc_html( $phone ); ?></a>
						</div>
					</div>
					<?php endif; ?>

					<?php if ( $email ) : ?>
					<div style="display:flex;align-items:center;gap:.875rem;">
						<div style="width:48px;height:48px;border-radius:12px;background:#000;color:#fff;display:flex;align-items:center;justify-content:center;flex-shrink:0;">
							<svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/><polyline points="22,6 12,13 2,6"/></svg>
						</div>
						<div>
							<div style="font-size:.75rem;font-weight:700;letter-spacing:.08em;text-transform:uppercase;color:#a0a0a0;margin-bottom:.2rem;"><?php esc_html_e( 'Email', 'drone-sark' ); ?></div>
							<a href="mailto:<?php echo esc_attr( $email ); ?>" style="font-weight:600;color:#000;text-decoration:none;"><?php echo esc_html( $email ); ?></a>
						</div>
					</div>
					<?php endif; ?>

					<?php if ( $address ) : ?>
					<div style="display:flex;align-items:flex-start;gap:.875rem;">
						<div style="width:48px;height:48px;border-radius:12px;background:#000;color:#fff;display:flex;align-items:center;justify-content:center;flex-shrink:0;">
							<svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 10c0 7-9 13-9 13S3 17 3 10a9 9 0 0118 0z"/><circle cx="12" cy="10" r="3"/></svg>
						</div>
						<div>
							<div style="font-size:.75rem;font-weight:700;letter-spacing:.08em;text-transform:uppercase;color:#a0a0a0;margin-bottom:.2rem;"><?php esc_html_e( 'Address', 'drone-sark' ); ?></div>
							<address style="font-style:normal;font-weight:500;color:#000;line-height:1.6;"><?php echo nl2br( esc_html( $address ) ); ?></address>
						</div>
					</div>
					<?php endif; ?>
				</div>
			</div>

			<!-- Contact form (CF7 shortcode or native form) -->
			<div style="background:#f9f9f9;border:1px solid #e8e8e8;border-radius:16px;padding:2.5rem;">
				<?php
				while ( have_posts() ) : the_post();
					the_content();
				endwhile;

				// If no shortcode, show a fallback form
				if ( ! strpos( get_the_content(), '[contact-form' ) ) :
				?>
				<form class="ds-contact-form" method="post" style="display:flex;flex-direction:column;gap:1.25rem;">
					<?php wp_nonce_field( 'ds_contact_form', 'ds_contact_nonce' ); ?>
					<div>
						<label for="cf-name" style="display:block;font-size:.8125rem;font-weight:600;margin-bottom:.4rem;"><?php esc_html_e( 'Your Name', 'drone-sark' ); ?></label>
						<input type="text" id="cf-name" name="name" required style="width:100%;border:1.5px solid #d1d1d1;border-radius:8px;padding:.75rem 1rem;font-family:inherit;font-size:.9375rem;outline:none;transition:border-color .2s;" placeholder="John Doe">
					</div>
					<div>
						<label for="cf-email" style="display:block;font-size:.8125rem;font-weight:600;margin-bottom:.4rem;"><?php esc_html_e( 'Email Address', 'drone-sark' ); ?></label>
						<input type="email" id="cf-email" name="email" required style="width:100%;border:1.5px solid #d1d1d1;border-radius:8px;padding:.75rem 1rem;font-family:inherit;font-size:.9375rem;outline:none;transition:border-color .2s;" placeholder="you@email.com">
					</div>
					<div>
						<label for="cf-subject" style="display:block;font-size:.8125rem;font-weight:600;margin-bottom:.4rem;"><?php esc_html_e( 'Subject', 'drone-sark' ); ?></label>
						<input type="text" id="cf-subject" name="subject" style="width:100%;border:1.5px solid #d1d1d1;border-radius:8px;padding:.75rem 1rem;font-family:inherit;font-size:.9375rem;outline:none;" placeholder="How can we help?">
					</div>
					<div>
						<label for="cf-message" style="display:block;font-size:.8125rem;font-weight:600;margin-bottom:.4rem;"><?php esc_html_e( 'Message', 'drone-sark' ); ?></label>
						<textarea id="cf-message" name="message" rows="5" required style="width:100%;border:1.5px solid #d1d1d1;border-radius:8px;padding:.75rem 1rem;font-family:inherit;font-size:.9375rem;outline:none;resize:vertical;" placeholder="Write your message..."></textarea>
					</div>
					<button type="submit" class="ds-btn ds-btn--primary" style="justify-content:center;">
						<?php esc_html_e( 'Send Message', 'drone-sark' ); ?>
					</button>
				</form>
				<?php endif; ?>
			</div>

		</div>
	</main>
</div>

<?php get_footer(); ?>
