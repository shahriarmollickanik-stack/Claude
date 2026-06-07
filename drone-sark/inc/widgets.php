<?php
/**
 * Widget areas
 */

if ( ! defined( 'ABSPATH' ) ) exit;

function drone_sark_widgets_init() {
	$defaults = array(
		'before_widget' => '<div id="%1$s" class="widget %2$s">',
		'after_widget'  => '</div>',
		'before_title'  => '<h3 class="widget-title">',
		'after_title'   => '</h3>',
	);

	// Shop sidebar
	register_sidebar( array_merge( $defaults, array(
		'name'        => __( 'Shop Sidebar', 'drone-sark' ),
		'id'          => 'sidebar-shop',
		'description' => __( 'Add widgets here to appear in the shop filter sidebar.', 'drone-sark' ),
	) ) );

	// Blog sidebar
	register_sidebar( array_merge( $defaults, array(
		'name'        => __( 'Blog Sidebar', 'drone-sark' ),
		'id'          => 'sidebar-blog',
		'description' => __( 'Add widgets here to appear in the blog sidebar.', 'drone-sark' ),
	) ) );

	// Footer columns
	for ( $i = 1; $i <= 4; $i++ ) {
		register_sidebar( array_merge( $defaults, array(
			'name'        => sprintf( __( 'Footer Column %d', 'drone-sark' ), $i ),
			'id'          => 'footer-col-' . $i,
			'description' => sprintf( __( 'Footer column %d widget area.', 'drone-sark' ), $i ),
		) ) );
	}
}
add_action( 'widgets_init', 'drone_sark_widgets_init' );
