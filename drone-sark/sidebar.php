<?php
/**
 * Sidebar template – wraps both shop and blog sidebars
 */

if ( ! defined( 'ABSPATH' ) ) exit;

if ( is_shop() || is_product_category() || is_product_tag() ) {
	$sidebar = 'sidebar-shop';
} else {
	$sidebar = 'sidebar-blog';
}

if ( ! is_active_sidebar( $sidebar ) ) return;
?>

<aside class="ds-sidebar sidebar-<?php echo esc_attr( str_replace( 'sidebar-', '', $sidebar ) ); ?>" aria-label="<?php esc_attr_e( 'Sidebar', 'drone-sark' ); ?>">
	<?php dynamic_sidebar( $sidebar ); ?>
</aside>
