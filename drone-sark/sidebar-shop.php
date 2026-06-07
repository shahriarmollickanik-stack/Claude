<?php
/**
 * Shop sidebar – loaded inside woo layout grid
 */

if ( ! defined( 'ABSPATH' ) ) exit;
if ( ! is_active_sidebar( 'sidebar-shop' ) ) return;
?>

<aside class="ds-sidebar sidebar-shop" aria-label="<?php esc_attr_e( 'Shop Filter', 'drone-sark' ); ?>">
	<?php dynamic_sidebar( 'sidebar-shop' ); ?>
</aside>
