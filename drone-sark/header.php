<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="profile" href="https://gmpg.org/xfn/11">
<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<?php wp_body_open(); ?>

<a class="skip-link screen-reader-text" href="#main"><?php esc_html_e( 'Skip to content', 'drone-sark' ); ?></a>

<?php
// Try Elementor Pro header first
if ( ! drone_sark_elementor_header() ) :
	get_template_part( 'template-parts/header/header', 'main' );
endif;
?>

<div id="page" class="site">
<div id="content" class="site-content<?php echo wp_is_mobile() ? ' has-mobile-nav' : ''; ?>">
