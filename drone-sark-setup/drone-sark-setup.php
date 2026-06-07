<?php
/**
 * Plugin Name: Drone Sark – One Click Setup
 * Plugin URI:  https://dronesark.com
 * Description: Activates all pre-built Elementor pages, menus, and settings for the Drone Sark theme in one click.
 * Version:     1.0.0
 * Author:      Drone Sark
 * Text Domain: drone-sark-setup
 *
 * HOW TO USE:
 *  1. Upload this plugin folder to /wp-content/plugins/
 *  2. Activate it from Plugins screen
 *  3. Go to Tools → Drone Sark Setup → Click "Run Setup"
 *  4. Done! All pages are created with full Elementor layouts.
 */

defined( 'ABSPATH' ) || exit;

define( 'DSS_DIR',  plugin_dir_path( __FILE__ ) );
define( 'DSS_URI',  plugin_dir_url( __FILE__ ) );
define( 'DSS_VER',  '1.0.0' );

/* ─────────────────────────────────────────────────────────
   1. ADMIN PAGE
───────────────────────────────────────────────────────── */
add_action( 'admin_menu', function () {
	add_management_page(
		'Drone Sark Setup',
		'Drone Sark Setup',
		'manage_options',
		'drone-sark-setup',
		'dss_admin_page'
	);
} );

function dss_admin_page() {
	$done = get_option( 'dss_setup_done', false );
	?>
	<div class="wrap">
		<h1 style="font-size:24px;font-weight:800;margin-bottom:4px;">🚁 Drone Sark – One Click Setup</h1>
		<p style="color:#555;margin-bottom:24px;">Creates all pages with full Elementor Pro layouts, menus, and WooCommerce settings.</p>

		<?php if ( $done ) : ?>
		<div class="notice notice-success" style="padding:12px 16px;border-left:4px solid #000;">
			<strong>✅ Setup complete!</strong> All pages have been created.
			<a href="<?php echo esc_url( home_url( '/' ) ); ?>" target="_blank" style="margin-left:12px;font-weight:600;">Visit Site →</a>
		</div>
		<p style="margin-top:16px;">
			<a href="<?php echo esc_url( admin_url( 'tools.php?page=drone-sark-setup&rerun=1' ) ); ?>" class="button">Re-run Setup</a>
		</p>
		<?php else : ?>
		<div style="background:#fff;border:1px solid #e8e8e8;border-radius:8px;padding:24px;max-width:620px;">
			<h2 style="font-size:16px;margin:0 0 12px;">What will be created:</h2>
			<ul style="line-height:1.9;padding-left:16px;">
				<li>🏠 <strong>Home V1</strong> – Premium brand dark homepage (Elementor)</li>
				<li>🛒 <strong>Home V2</strong> – Sales-focused white homepage (Elementor)</li>
				<li>📞 <strong>Contact Us</strong> page (Elementor)</li>
				<li>📦 <strong>Track Order</strong> page</li>
				<li>🎨 <strong>Primary + Mobile menu</strong> with all categories</li>
				<li>⚙️ <strong>WooCommerce</strong> pages + homepage reading settings</li>
				<li>🎨 <strong>Elementor Global Colors &amp; Fonts</strong> (Inter, black/white palette)</li>
			</ul>
			<form method="post" action="<?php echo esc_url( admin_url( 'admin-post.php' ) ); ?>">
				<?php wp_nonce_field( 'dss_run_setup', 'dss_nonce' ); ?>
				<input type="hidden" name="action" value="dss_run_setup">
				<button type="submit" class="button button-primary" style="background:#000;border-color:#000;padding:8px 24px;font-size:14px;font-weight:700;height:auto;margin-top:8px;">
					▶ Run Setup Now
				</button>
			</form>
		</div>
		<?php endif; ?>
	</div>
	<?php
}

/* ─────────────────────────────────────────────────────────
   2. SETUP HANDLER
───────────────────────────────────────────────────────── */
add_action( 'admin_post_dss_run_setup', function () {
	if ( ! current_user_can( 'manage_options' ) ) wp_die( 'Unauthorized' );
	check_admin_referer( 'dss_run_setup', 'dss_nonce' );

	dss_create_pages();
	dss_setup_menus();
	dss_setup_elementor_globals();
	dss_set_reading_settings();
	update_option( 'dss_setup_done', true );

	wp_redirect( admin_url( 'tools.php?page=drone-sark-setup' ) );
	exit;
} );

/* ─────────────────────────────────────────────────────────
   3. CREATE PAGES
───────────────────────────────────────────────────────── */
function dss_create_pages() {
	$pages = array(
		'home-v1'     => array( 'title' => 'Home – Premium Brand',   'data_fn' => 'dss_home_v1_data' ),
		'home-v2'     => array( 'title' => 'Home – Sales Focus',     'data_fn' => 'dss_home_v2_data' ),
		'contact'     => array( 'title' => 'Contact Us',             'data_fn' => 'dss_contact_data' ),
		'track-order' => array( 'title' => 'Track Order',            'data_fn' => 'dss_track_order_data' ),
	);

	foreach ( $pages as $slug => $info ) {
		// Skip if already exists
		$existing = get_page_by_path( $slug );
		if ( $existing ) {
			$post_id = $existing->ID;
		} else {
			$post_id = wp_insert_post( array(
				'post_title'   => $info['title'],
				'post_name'    => $slug,
				'post_status'  => 'publish',
				'post_type'    => 'page',
				'post_content' => '',
			) );
		}

		if ( $post_id && ! is_wp_error( $post_id ) && function_exists( $info['data_fn'] ) ) {
			$data = call_user_func( $info['data_fn'] );
			update_post_meta( $post_id, '_elementor_edit_mode', 'builder' );
			update_post_meta( $post_id, '_elementor_template_type', 'wp-page' );
			update_post_meta( $post_id, '_elementor_version', '3.21.0' );
			update_post_meta( $post_id, '_elementor_data', wp_slash( wp_json_encode( $data ) ) );
			update_post_meta( $post_id, '_wp_page_template', 'elementor_header_footer' );

			// Store page IDs for later
			update_option( 'dss_page_' . $slug, $post_id );
		}
	}
}

/* ─────────────────────────────────────────────────────────
   4. READING SETTINGS
───────────────────────────────────────────────────────── */
function dss_set_reading_settings() {
	// Set homepage to Home V1 by default
	$home_id = get_option( 'dss_page_home-v1' );
	if ( $home_id ) {
		update_option( 'show_on_front', 'page' );
		update_option( 'page_on_front', $home_id );
	}

	// Blog page (create if needed)
	$blog = get_page_by_path( 'blog' );
	if ( ! $blog ) {
		$blog_id = wp_insert_post( array(
			'post_title'  => 'Blog',
			'post_name'   => 'blog',
			'post_status' => 'publish',
			'post_type'   => 'page',
		) );
		if ( $blog_id ) update_option( 'page_for_posts', $blog_id );
	}
}

/* ─────────────────────────────────────────────────────────
   5. MENUS
───────────────────────────────────────────────────────── */
function dss_setup_menus() {
	// Primary menu
	$primary = wp_get_nav_menu_object( 'Primary Menu' );
	if ( ! $primary ) {
		$primary_id = wp_create_nav_menu( 'Primary Menu' );
	} else {
		$primary_id = $primary->term_id;
		// Clear existing items
		$items = wp_get_nav_menu_items( $primary_id );
		if ( $items ) {
			foreach ( $items as $item ) { wp_delete_post( $item->ID, true ); }
		}
	}

	if ( $primary_id && ! is_wp_error( $primary_id ) ) {
		$home_id = get_option( 'dss_page_home-v1', 0 );
		$shop_id = class_exists( 'WooCommerce' ) ? wc_get_page_id( 'shop' ) : 0;

		wp_update_nav_menu_item( $primary_id, 0, array( 'menu-item-title' => 'Home',    'menu-item-url' => home_url( '/' ),    'menu-item-status' => 'publish', 'menu-item-object' => 'custom', 'menu-item-type' => 'custom' ) );
		if ( $shop_id ) {
			wp_update_nav_menu_item( $primary_id, 0, array( 'menu-item-title' => 'Shop',    'menu-item-url' => get_permalink( $shop_id ),  'menu-item-status' => 'publish', 'menu-item-object' => 'page',   'menu-item-type' => 'post_type', 'menu-item-object-id' => $shop_id ) );
		}
		wp_update_nav_menu_item( $primary_id, 0, array( 'menu-item-title' => 'Drones',          'menu-item-url' => home_url( '/product-category/drones/' ),            'menu-item-status' => 'publish', 'menu-item-object' => 'custom', 'menu-item-type' => 'custom' ) );
		wp_update_nav_menu_item( $primary_id, 0, array( 'menu-item-title' => 'Accessories',     'menu-item-url' => home_url( '/product-category/accessories-parts/' ),  'menu-item-status' => 'publish', 'menu-item-object' => 'custom', 'menu-item-type' => 'custom' ) );
		wp_update_nav_menu_item( $primary_id, 0, array( 'menu-item-title' => 'Repair',          'menu-item-url' => home_url( '/product-category/repair/' ),             'menu-item-status' => 'publish', 'menu-item-object' => 'custom', 'menu-item-type' => 'custom' ) );
		wp_update_nav_menu_item( $primary_id, 0, array( 'menu-item-title' => 'Other Services',  'menu-item-url' => home_url( '/product-category/other-services/' ),     'menu-item-status' => 'publish', 'menu-item-object' => 'custom', 'menu-item-type' => 'custom' ) );
		$contact_id = get_option( 'dss_page_contact', 0 );
		if ( $contact_id ) {
			wp_update_nav_menu_item( $primary_id, 0, array( 'menu-item-title' => 'Contact', 'menu-item-url' => get_permalink( $contact_id ), 'menu-item-status' => 'publish', 'menu-item-object' => 'page', 'menu-item-type' => 'post_type', 'menu-item-object-id' => $contact_id ) );
		}

		// Assign to theme locations
		$locations = get_theme_mod( 'nav_menu_locations', array() );
		$locations['primary'] = $primary_id;
		$locations['mobile']  = $primary_id;
		set_theme_mod( 'nav_menu_locations', $locations );
	}
}

/* ─────────────────────────────────────────────────────────
   6. ELEMENTOR GLOBAL SETTINGS
───────────────────────────────────────────────────────── */
function dss_setup_elementor_globals() {
	// System colors
	$system_colors = array(
		array( '_id' => 'ds_black',    'title' => 'DS Black',    'color' => '#000000' ),
		array( '_id' => 'ds_white',    'title' => 'DS White',    'color' => '#ffffff' ),
		array( '_id' => 'ds_gray_100', 'title' => 'DS Gray 100', 'color' => '#f3f3f3' ),
		array( '_id' => 'ds_gray_300', 'title' => 'DS Gray 300', 'color' => '#d1d1d1' ),
		array( '_id' => 'ds_gray_500', 'title' => 'DS Gray 500', 'color' => '#707070' ),
		array( '_id' => 'ds_star',     'title' => 'DS Star Gold','color' => '#f5a623' ),
	);

	$kit = get_option( 'elementor_active_kit', 0 );
	if ( $kit ) {
		$existing = get_post_meta( $kit, '_elementor_page_settings', true );
		if ( ! is_array( $existing ) ) $existing = array();
		$existing['system_colors'] = $system_colors;
		// Typography
		$existing['system_typography'] = array(
			array( '_id' => 'primary', 'title' => 'Primary', 'typography_typography' => 'custom', 'typography_font_family' => 'Inter', 'typography_font_weight' => '400' ),
			array( '_id' => 'secondary', 'title' => 'Secondary', 'typography_typography' => 'custom', 'typography_font_family' => 'Inter', 'typography_font_weight' => '600' ),
			array( '_id' => 'text', 'title' => 'Text', 'typography_typography' => 'custom', 'typography_font_family' => 'Inter', 'typography_font_weight' => '400' ),
			array( '_id' => 'accent', 'title' => 'Accent', 'typography_typography' => 'custom', 'typography_font_family' => 'Inter', 'typography_font_weight' => '700' ),
		);
		// Body font
		$existing['body_typography_typography']   = 'custom';
		$existing['body_typography_font_family']  = 'Inter';
		$existing['body_typography_font_weight']  = '400';
		$existing['body_color_color']             = '#1a1a1a';

		// Button
		$existing['button_background_color']      = '#000000';
		$existing['button_text_color']            = '#ffffff';
		$existing['button_hover_background_color']= '#333333';
		$existing['button_hover_text_color']      = '#ffffff';
		$existing['button_border_radius']         = array( 'unit' => 'px', 'top' => '8', 'right' => '8', 'bottom' => '8', 'left' => '8', 'isLinked' => true );
		$existing['button_typography_font_family']= 'Inter';
		$existing['button_typography_font_weight']= '700';
		$existing['button_padding']               = array( 'unit' => 'px', 'top' => '14', 'right' => '28', 'bottom' => '14', 'left' => '28', 'isLinked' => false );

		update_post_meta( $kit, '_elementor_page_settings', $existing );
	}
}

/* ══════════════════════════════════════════════════════════
   PAGE DATA FUNCTIONS
   Each returns an array that becomes _elementor_data JSON
══════════════════════════════════════════════════════════ */

// ── Helpers ─────────────────────────────────────────────

function dss_id( $str = '' ) {
	return $str ?: substr( md5( uniqid() ), 0, 7 );
}

function dss_container( $id, $settings = array(), $elements = array() ) {
	return array(
		'id'        => $id,
		'elType'    => 'container',
		'isInner'   => false,
		'settings'  => $settings,
		'elements'  => $elements,
	);
}

function dss_widget( $id, $type, $settings = array() ) {
	return array(
		'id'         => $id,
		'elType'     => 'widget',
		'widgetType' => $type,
		'settings'   => $settings,
		'elements'   => array(),
	);
}

function dss_heading( $id, $title, $tag = 'h2', $extra = array() ) {
	return dss_widget( $id, 'heading', array_merge( array(
		'title'       => $title,
		'header_size' => $tag,
	), $extra ) );
}

function dss_text( $id, $html, $extra = array() ) {
	return dss_widget( $id, 'text-editor', array_merge( array(
		'editor' => $html,
	), $extra ) );
}

function dss_btn( $id, $text, $url, $extra = array() ) {
	return dss_widget( $id, 'button', array_merge( array(
		'text'        => $text,
		'link'        => array( 'url' => $url, 'is_external' => false ),
		'button_type' => 'default',
	), $extra ) );
}

function dss_image( $id, $extra = array() ) {
	return dss_widget( $id, 'image', array_merge( array(
		'image'      => array( 'url' => DSS_URI . 'assets/placeholder.png', 'id' => '' ),
		'image_size' => 'full',
	), $extra ) );
}

function dss_shortcode( $id, $code ) {
	return dss_widget( $id, 'shortcode', array( 'shortcode' => $code ) );
}

function dss_spacer( $id, $px = 40 ) {
	return dss_widget( $id, 'spacer', array( 'space' => array( 'unit' => 'px', 'size' => $px ) ) );
}

function dss_divider( $id ) {
	return dss_widget( $id, 'divider', array( 'color' => '#e8e8e8' ) );
}

// ── Common section wrapper (full width outer + boxed inner) ──
function dss_full_section( $id, $bg_settings, $inner_elements, $min_height = '' ) {
	$outer_settings = array_merge( array(
		'content_width'  => 'full',
		'flex_direction' => 'column',
		'align_items'    => 'center',
	), $bg_settings );
	if ( $min_height ) {
		$outer_settings['min_height'] = array( 'unit' => 'px', 'size' => intval( $min_height ) );
	}

	return dss_container( $id, $outer_settings, array(
		dss_container( $id . '_inner', array(
			'content_width'  => 'boxed',
			'flex_direction' => 'column',
			'padding'        => array( 'unit' => 'px', 'top' => '80', 'right' => '24', 'bottom' => '80', 'left' => '24', 'isLinked' => false ),
			'width'          => array( 'unit' => '%', 'size' => 100 ),
			'max_width'      => array( 'unit' => 'px', 'size' => 1280 ),
		), $inner_elements ),
	) );
}

/* ══════════════════════════════════════════════════════════
   HOME V1 DATA  (Dark / Premium Brand)
══════════════════════════════════════════════════════════ */
function dss_home_v1_data() {
	return array(

		/* ── 1. HERO ──────────────────────────────────────── */
		dss_container( 'v1_hero', array(
			'content_width'          => 'full',
			'flex_direction'         => 'row',
			'align_items'            => 'center',
			'background_background'  => 'classic',
			'background_color'       => '#0d0d0d',
			'padding'                => array( 'unit' => 'px', 'top' => '100', 'right' => '80', 'bottom' => '100', 'left' => '80', 'isLinked' => false ),
			'min_height'             => array( 'unit' => 'vh', 'size' => 85 ),
			'gap'                    => array( 'unit' => 'px', 'column' => '60', 'row' => '0' ),
			// Responsive
			'padding_tablet'         => array( 'unit' => 'px', 'top' => '80', 'right' => '40', 'bottom' => '80', 'left' => '40', 'isLinked' => false ),
			'padding_mobile'         => array( 'unit' => 'px', 'top' => '60', 'right' => '24', 'bottom' => '60', 'left' => '24', 'isLinked' => false ),
		), array(
			// Left text col
			dss_container( 'v1_hero_txt', array(
				'content_width'  => 'full',
				'flex_direction' => 'column',
				'align_items'    => 'flex-start',
				'width'          => array( 'unit' => '%', 'size' => 55 ),
				'gap'            => array( 'unit' => 'px', 'column' => '24', 'row' => '24' ),
				'width_tablet'   => array( 'unit' => '%', 'size' => 100 ),
			), array(
				dss_heading( 'v1_pre', 'EXPLORE. CAPTURE. ELEVATE.', 'p', array(
					'title_color'                       => 'rgba(255,255,255,0.5)',
					'typography_typography'             => 'custom',
					'typography_font_size'              => array( 'unit' => 'px', 'size' => 11 ),
					'typography_font_weight'            => '700',
					'typography_letter_spacing'         => array( 'unit' => 'px', 'size' => 3 ),
					'typography_text_transform'         => 'uppercase',
				) ),
				dss_heading( 'v1_h1', 'Next Level<br>Drone Experience', 'h1', array(
					'title_color'                       => '#ffffff',
					'typography_typography'             => 'custom',
					'typography_font_size'              => array( 'unit' => 'px', 'size' => 64 ),
					'typography_font_size_tablet'       => array( 'unit' => 'px', 'size' => 48 ),
					'typography_font_size_mobile'       => array( 'unit' => 'px', 'size' => 36 ),
					'typography_font_weight'            => '800',
					'typography_line_height'            => array( 'unit' => 'em', 'size' => 1.1 ),
				) ),
				dss_text( 'v1_sub', '<p>Premium drones, accessories, repair services, and professional drone solutions — all in one place.</p>', array(
					'text_color'                        => 'rgba(255,255,255,0.7)',
					'typography_typography'             => 'custom',
					'typography_font_size'              => array( 'unit' => 'px', 'size' => 18 ),
					'typography_line_height'            => array( 'unit' => 'em', 'size' => 1.75 ),
				) ),
				// CTA buttons row
				dss_container( 'v1_btns', array(
					'content_width'  => 'full',
					'flex_direction' => 'row',
					'flex_wrap'      => 'wrap',
					'gap'            => array( 'unit' => 'px', 'column' => '16', 'row' => '12' ),
				), array(
					dss_btn( 'v1_btn1', 'Shop Now', '/shop/', array(
						'background_color'               => '#ffffff',
						'button_text_color'              => '#000000',
						'hover_background_color'         => '#f3f3f3',
						'hover_color'                    => '#000000',
						'border_radius'                  => array( 'unit' => 'px', 'top' => '8', 'right' => '8', 'bottom' => '8', 'left' => '8', 'isLinked' => true ),
						'typography_font_weight'         => '700',
						'padding'                        => array( 'unit' => 'px', 'top' => '16', 'right' => '32', 'bottom' => '16', 'left' => '32', 'isLinked' => false ),
					) ),
					dss_btn( 'v1_btn2', 'Get In Touch', '/contact/', array(
						'background_color'               => 'rgba(0,0,0,0)',
						'button_text_color'              => '#ffffff',
						'hover_background_color'         => 'rgba(255,255,255,0.12)',
						'hover_color'                    => '#ffffff',
						'border_border'                  => 'solid',
						'border_color'                   => 'rgba(255,255,255,0.5)',
						'border_width'                   => array( 'unit' => 'px', 'top' => '2', 'right' => '2', 'bottom' => '2', 'left' => '2', 'isLinked' => true ),
						'border_radius'                  => array( 'unit' => 'px', 'top' => '8', 'right' => '8', 'bottom' => '8', 'left' => '8', 'isLinked' => true ),
						'typography_font_weight'         => '700',
						'padding'                        => array( 'unit' => 'px', 'top' => '16', 'right' => '32', 'bottom' => '16', 'left' => '32', 'isLinked' => false ),
					) ),
				) ),
				// Feature pills
				dss_widget( 'v1_pills', 'html', array(
					'html' => '<div style="display:flex;flex-wrap:wrap;gap:20px;margin-top:8px;">
						<span style="display:flex;align-items:center;gap:8px;color:rgba(255,255,255,0.7);font-size:13px;font-weight:500;">
							<svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"/></svg> Free Delivery</span>
						<span style="display:flex;align-items:center;gap:8px;color:rgba(255,255,255,0.7);font-size:13px;font-weight:500;">
							<svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"/></svg> Expert Support</span>
						<span style="display:flex;align-items:center;gap:8px;color:rgba(255,255,255,0.7);font-size:13px;font-weight:500;">
							<svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"/></svg> Genuine Products</span>
					</div>',
				) ),
			) ),
			// Right image col
			dss_container( 'v1_hero_img', array(
				'content_width'  => 'full',
				'flex_direction' => 'column',
				'align_items'    => 'center',
				'justify_content'=> 'center',
				'width'          => array( 'unit' => '%', 'size' => 45 ),
				'width_tablet'   => array( 'unit' => '%', 'size' => 100 ),
			), array(
				dss_image( 'v1_hero_img_wgt', array(
					'align'  => 'center',
					'width'  => array( 'unit' => '%', 'size' => 100 ),
					'_label' => '🔁 Replace with your hero drone image',
				) ),
			) ),
		) ),

		/* ── 2. SHOP BY CATEGORY ─────────────────────────── */
		dss_full_section( 'v1_cats', array(
			'background_background' => 'classic',
			'background_color'      => '#ffffff',
		), array(
			// Section header row
			dss_container( 'v1_cats_hdr', array(
				'content_width'  => 'full',
				'flex_direction' => 'row',
				'align_items'    => 'flex-end',
				'justify_content'=> 'space-between',
				'padding'        => array( 'unit' => 'px', 'top' => '0', 'right' => '0', 'bottom' => '28', 'left' => '0', 'isLinked' => false ),
			), array(
				dss_widget( 'v1_cats_lbl', 'html', array(
					'html' => '<div style="display:flex;flex-direction:column;gap:4px;">
						<h2 style="font-size:12px;font-weight:700;letter-spacing:0.12em;text-transform:uppercase;color:#000;margin:0;display:flex;flex-direction:column;gap:6px;">
							SHOP BY CATEGORY
							<span style="display:block;width:28px;height:2px;background:#000;"></span>
						</h2>
					</div>',
				) ),
				dss_btn( 'v1_cats_all', 'View All', '/shop/', array(
					'background_color'   => 'rgba(0,0,0,0)',
					'button_text_color'  => '#000',
					'border_border'      => 'solid',
					'border_color'       => '#000',
					'border_width'       => array( 'unit' => 'px', 'top' => '1.5', 'right' => '1.5', 'bottom' => '1.5', 'left' => '1.5', 'isLinked' => true ),
					'border_radius'      => array( 'unit' => 'px', 'top' => '8', 'right' => '8', 'bottom' => '8', 'left' => '8', 'isLinked' => true ),
					'padding'            => array( 'unit' => 'px', 'top' => '10', 'right' => '20', 'bottom' => '10', 'left' => '20', 'isLinked' => false ),
					'typography_font_size'   => array( 'unit' => 'px', 'size' => 13 ),
					'typography_font_weight' => '600',
				) ),
			) ),
			// Main 4 category cards using WC shortcode
			dss_shortcode( 'v1_cats_grid', '[product_categories number="4" columns="4" hide_empty="0"]' ),
			dss_spacer( 'v1_cats_sp1', 32 ),
			// Drone subcategories heading
			dss_widget( 'v1_drones_lbl', 'html', array(
				'html' => '<p style="font-size:11px;font-weight:700;letter-spacing:0.14em;text-transform:uppercase;color:#a0a0a0;margin:0 0 16px;">DRONES</p>',
			) ),
			// Drone subcategories - 4 cards
			dss_shortcode( 'v1_drones_grid', '[product_categories number="4" columns="4" parent="drones" hide_empty="0"]' ),
		) ),

		/* ── 3. ACCESSORIES SLIDER ───────────────────────── */
		dss_full_section( 'v1_acc', array(
			'background_background' => 'classic',
			'background_color'      => '#f9f9f9',
		), array(
			dss_container( 'v1_acc_hdr', array(
				'content_width'  => 'full',
				'flex_direction' => 'row',
				'align_items'    => 'flex-end',
				'justify_content'=> 'space-between',
				'padding'        => array( 'unit' => 'px', 'top' => '0', 'right' => '0', 'bottom' => '28', 'left' => '0', 'isLinked' => false ),
			), array(
				dss_widget( 'v1_acc_lbl', 'html', array(
					'html' => '<h2 style="font-size:12px;font-weight:700;letter-spacing:0.12em;text-transform:uppercase;color:#000;margin:0;">ACCESSORIES & PARTS</h2>',
				) ),
				dss_btn( 'v1_acc_all', 'View All', '/product-category/accessories-parts/', array(
					'background_color'  => 'rgba(0,0,0,0)',
					'button_text_color' => '#000',
					'border_border'     => 'solid',
					'border_color'      => '#000',
					'border_width'      => array( 'unit' => 'px', 'top' => '1.5', 'right' => '1.5', 'bottom' => '1.5', 'left' => '1.5', 'isLinked' => true ),
					'border_radius'     => array( 'unit' => 'px', 'top' => '8', 'right' => '8', 'bottom' => '8', 'left' => '8', 'isLinked' => true ),
					'padding'           => array( 'unit' => 'px', 'top' => '10', 'right' => '20', 'bottom' => '10', 'left' => '20', 'isLinked' => false ),
					'typography_font_size'   => array( 'unit' => 'px', 'size' => 13 ),
					'typography_font_weight' => '600',
				) ),
			) ),
			dss_shortcode( 'v1_acc_grid', '[products category="accessories-parts" limit="6" columns="6" orderby="date" order="DESC"]' ),
		) ),

		/* ── 4. ALL PRODUCTS ─────────────────────────────── */
		dss_full_section( 'v1_prods', array(
			'background_background' => 'classic',
			'background_color'      => '#ffffff',
		), array(
			dss_widget( 'v1_prods_lbl', 'html', array(
				'html' => '<h2 style="font-size:12px;font-weight:700;letter-spacing:0.12em;text-transform:uppercase;color:#000;margin:0 0 28px;display:flex;flex-direction:column;gap:8px;">ALL PRODUCTS<span style="display:block;width:28px;height:2px;background:#000;"></span></h2>',
			) ),
			dss_shortcode( 'v1_prods_grid', '[products limit="8" columns="4" orderby="date" order="DESC"]' ),
			dss_spacer( 'v1_prods_sp', 24 ),
			dss_container( 'v1_prods_more', array(
				'content_width'   => 'full',
				'flex_direction'  => 'row',
				'justify_content' => 'center',
			), array(
				dss_btn( 'v1_more_btn', 'View All Products', '/shop/', array(
					'background_color'   => 'rgba(0,0,0,0)',
					'button_text_color'  => '#000',
					'border_border'      => 'solid',
					'border_color'       => '#000',
					'border_width'       => array( 'unit' => 'px', 'top' => '2', 'right' => '2', 'bottom' => '2', 'left' => '2', 'isLinked' => true ),
					'border_radius'      => array( 'unit' => 'px', 'top' => '8', 'right' => '8', 'bottom' => '8', 'left' => '8', 'isLinked' => true ),
					'padding'            => array( 'unit' => 'px', 'top' => '14', 'right' => '40', 'bottom' => '14', 'left' => '40', 'isLinked' => false ),
					'typography_font_weight' => '700',
				) ),
			) ),
		) ),

		/* ── 5. REPAIR BANNER ────────────────────────────── */
		dss_full_section( 'v1_repair', array(
			'background_background' => 'classic',
			'background_color'      => '#f9f9f9',
		), array(
			dss_container( 'v1_repair_card', array(
				'content_width'         => 'full',
				'flex_direction'        => 'row',
				'align_items'           => 'center',
				'background_background' => 'classic',
				'background_color'      => '#0d0d0d',
				'border_radius'         => array( 'unit' => 'px', 'top' => '24', 'right' => '24', 'bottom' => '24', 'left' => '24', 'isLinked' => true ),
				'padding'               => array( 'unit' => 'px', 'top' => '56', 'right' => '56', 'bottom' => '56', 'left' => '56', 'isLinked' => false ),
				'gap'                   => array( 'unit' => 'px', 'column' => '48', 'row' => '0' ),
				'padding_mobile'        => array( 'unit' => 'px', 'top' => '40', 'right' => '28', 'bottom' => '40', 'left' => '28', 'isLinked' => false ),
				'overflow' => 'hidden',
			), array(
				dss_container( 'v1_rep_txt', array(
					'content_width'  => 'full',
					'flex_direction' => 'column',
					'align_items'    => 'flex-start',
					'width'          => array( 'unit' => '%', 'size' => 55 ),
					'gap'            => array( 'unit' => 'px', 'column' => '20', 'row' => '20' ),
				), array(
					dss_widget( 'v1_rep_tag', 'html', array(
						'html' => '<span style="display:inline-block;font-size:10px;font-weight:700;letter-spacing:0.18em;text-transform:uppercase;color:rgba(255,255,255,0.45);border:1px solid rgba(255,255,255,0.2);border-radius:4px;padding:5px 12px;">REPAIR SERVICE</span>',
					) ),
					dss_heading( 'v1_rep_h2', 'Drone Repair &amp; Maintenance', 'h2', array(
						'title_color'               => '#ffffff',
						'typography_font_size'      => array( 'unit' => 'px', 'size' => 38 ),
						'typography_font_size_mobile'=> array( 'unit' => 'px', 'size' => 28 ),
						'typography_font_weight'    => '800',
						'typography_line_height'    => array( 'unit' => 'em', 'size' => 1.2 ),
					) ),
					dss_text( 'v1_rep_desc', '<p>Fast, professional drone repair service by certified technicians. We fix all makes and models — from minor sensor calibrations to complete motor overhauls.</p>', array(
						'text_color'           => 'rgba(255,255,255,0.7)',
						'typography_font_size' => array( 'unit' => 'px', 'size' => 15 ),
						'typography_line_height'=> array( 'unit' => 'em', 'size' => 1.75 ),
					) ),
					dss_widget( 'v1_rep_feat', 'html', array(
						'html' => '<ul style="list-style:none;margin:0;padding:0;display:grid;grid-template-columns:1fr 1fr;gap:8px 16px;">
							<li style="color:rgba(255,255,255,0.75);font-size:14px;padding-left:18px;position:relative;"><span style="position:absolute;left:0;font-weight:700;">✓</span> All brands &amp; models</li>
							<li style="color:rgba(255,255,255,0.75);font-size:14px;padding-left:18px;position:relative;"><span style="position:absolute;left:0;font-weight:700;">✓</span> Genuine spare parts</li>
							<li style="color:rgba(255,255,255,0.75);font-size:14px;padding-left:18px;position:relative;"><span style="position:absolute;left:0;font-weight:700;">✓</span> Quick turnaround</li>
							<li style="color:rgba(255,255,255,0.75);font-size:14px;padding-left:18px;position:relative;"><span style="position:absolute;left:0;font-weight:700;">✓</span> Service warranty</li>
						</ul>',
					) ),
					dss_btn( 'v1_rep_btn', 'Book Repair', '/product-category/repair/', array(
						'background_color'   => '#ffffff',
						'button_text_color'  => '#000000',
						'hover_background_color'=> '#f3f3f3',
						'border_radius'      => array( 'unit' => 'px', 'top' => '8', 'right' => '8', 'bottom' => '8', 'left' => '8', 'isLinked' => true ),
						'padding'            => array( 'unit' => 'px', 'top' => '16', 'right' => '32', 'bottom' => '16', 'left' => '32', 'isLinked' => false ),
						'typography_font_weight' => '700',
					) ),
				) ),
				dss_container( 'v1_rep_img', array(
					'content_width'  => 'full',
					'flex_direction' => 'column',
					'align_items'    => 'center',
					'width'          => array( 'unit' => '%', 'size' => 45 ),
				), array(
					dss_image( 'v1_rep_img_wgt', array(
						'border_radius' => array( 'unit' => 'px', 'top' => '16', 'right' => '16', 'bottom' => '16', 'left' => '16', 'isLinked' => true ),
						'_label'        => '🔁 Replace with repair/workshop image',
					) ),
				) ),
			) ),
		) ),

		/* ── 6. OTHER SERVICES ───────────────────────────── */
		dss_full_section( 'v1_svcs', array(
			'background_background' => 'classic',
			'background_color'      => '#ffffff',
		), array(
			dss_container( 'v1_svcs_hdr', array(
				'content_width'  => 'full',
				'flex_direction' => 'row',
				'align_items'    => 'flex-end',
				'justify_content'=> 'space-between',
				'padding'        => array( 'unit' => 'px', 'top' => '0', 'right' => '0', 'bottom' => '28', 'left' => '0', 'isLinked' => false ),
			), array(
				dss_widget( 'v1_svcs_lbl', 'html', array(
					'html' => '<h2 style="font-size:12px;font-weight:700;letter-spacing:0.12em;text-transform:uppercase;color:#000;margin:0;">OTHER SERVICES</h2>',
				) ),
				dss_btn( 'v1_svcs_all', 'See All Services', '/product-category/other-services/', array(
					'background_color'  => 'rgba(0,0,0,0)',
					'button_text_color' => '#000',
					'border_border'     => 'solid',
					'border_color'      => '#000',
					'border_width'      => array( 'unit' => 'px', 'top' => '1.5', 'right' => '1.5', 'bottom' => '1.5', 'left' => '1.5', 'isLinked' => true ),
					'border_radius'     => array( 'unit' => 'px', 'top' => '8', 'right' => '8', 'bottom' => '8', 'left' => '8', 'isLinked' => true ),
					'padding'           => array( 'unit' => 'px', 'top' => '10', 'right' => '20', 'bottom' => '10', 'left' => '20', 'isLinked' => false ),
					'typography_font_size'   => array( 'unit' => 'px', 'size' => 13 ),
					'typography_font_weight' => '600',
				) ),
			) ),
			dss_container( 'v1_svcs_grid', array(
				'content_width'  => 'full',
				'flex_direction' => 'row',
				'flex_wrap'      => 'wrap',
				'gap'            => array( 'unit' => 'px', 'column' => '20', 'row' => '20' ),
			), array_map( function( $svc ) {
				return dss_widget( 'svc_' . $svc['id'], 'icon-box', array(
					'selected_icon'    => array( 'value' => $svc['icon'], 'library' => 'fa-solid' ),
					'title_text'       => $svc['title'],
					'description_text' => $svc['desc'],
					'position'         => 'top',
					'icon_size'        => array( 'unit' => 'px', 'size' => 28 ),
					'icon_color'       => '#ffffff',
					'icon_padding'     => array( 'unit' => 'px', 'top' => '14', 'right' => '14', 'bottom' => '14', 'left' => '14', 'isLinked' => true ),
					'icon_background_color' => '#000000',
					'icon_border_radius'    => array( 'unit' => 'px', 'top' => '12', 'right' => '12', 'bottom' => '12', 'left' => '12', 'isLinked' => true ),
					'title_typography_font_weight' => '700',
					'title_typography_font_size'   => array( 'unit' => 'px', 'size' => 15 ),
					'description_typography_font_size' => array( 'unit' => 'px', 'size' => 14 ),
					'description_color' => '#707070',
					'_element_width'   => 'initial',
					'width'            => array( 'unit' => '%', 'size' => 23 ),
					'background_background' => 'classic',
					'background_color'  => '#ffffff',
					'border_border'     => 'solid',
					'border_width'      => array( 'unit' => 'px', 'top' => '1', 'right' => '1', 'bottom' => '1', 'left' => '1', 'isLinked' => true ),
					'border_color'      => '#e8e8e8',
					'border_radius'     => array( 'unit' => 'px', 'top' => '16', 'right' => '16', 'bottom' => '16', 'left' => '16', 'isLinked' => true ),
					'padding'           => array( 'unit' => 'px', 'top' => '28', 'right' => '24', 'bottom' => '28', 'left' => '24', 'isLinked' => false ),
				) );
			}, array(
				array( 'id' => 'train', 'icon' => 'fas fa-graduation-cap', 'title' => 'Drone Training',   'desc' => 'Professional flight training for beginners to advanced pilots. Get certified and fly with confidence.' ),
				array( 'id' => 'surv',  'icon' => 'fas fa-crosshairs',     'title' => 'Aerial Survey',    'desc' => 'High-resolution aerial surveys for construction, agriculture, and real estate.' ),
				array( 'id' => 'map',   'icon' => 'fas fa-map',            'title' => '3D Mapping',       'desc' => 'Precise 3D photogrammetry mapping for GIS, land development, and urban planning.' ),
				array( 'id' => 'cons',  'icon' => 'fas fa-comments',       'title' => 'Consultation',     'desc' => 'Expert drone consulting for businesses integrating drone technology into their workflow.' ),
			) ) ),
		) ),

		/* ── 7. CUSTOMER REVIEWS ─────────────────────────── */
		dss_full_section( 'v1_revs', array(
			'background_background' => 'classic',
			'background_color'      => '#f9f9f9',
		), array(
			dss_widget( 'v1_revs_lbl', 'html', array(
				'html' => '<h2 style="font-size:12px;font-weight:700;letter-spacing:0.12em;text-transform:uppercase;color:#000;margin:0 0 28px;display:flex;flex-direction:column;gap:8px;">WHAT OUR CUSTOMERS SAY<span style="display:block;width:28px;height:2px;background:#000;"></span></h2>',
			) ),
			dss_widget( 'v1_revs_car', 'testimonial-carousel', array(
				'skin'              => 'default',
				'slides_per_view'   => 4,
				'slides_per_view_tablet' => 2,
				'slides_per_view_mobile' => 1,
				'autoplay'          => 'yes',
				'autoplay_speed'    => 4500,
				'pause_on_hover'    => 'yes',
				'loop'              => 'yes',
				'navigation'        => 'arrows',
				'slides' => array(
					array( '_id' => 'r1', 'content' => '"Absolutely love my new DJI Mavic 3 Pro from Drone Sark! Delivery was super fast and the team helped me pick the perfect drone for my needs."', 'name' => 'Rahim Ahmed',    'title' => 'Verified Buyer', 'rating_icon' => array( 'value' => 'fas fa-star', 'library' => 'fa-solid' ) ),
					array( '_id' => 'r2', 'content' => '"Best drone shop. Got my Mini 4 Pro with all accessories. The repair service is also top-notch — they fixed my old drone in 2 days!"',              'name' => 'Priya Sharma',   'title' => 'Verified Buyer', 'rating_icon' => array( 'value' => 'fas fa-star', 'library' => 'fa-solid' ) ),
					array( '_id' => 'r3', 'content' => '"Excellent customer service and genuine products. The Steadfast delivery was quick and well-packaged. Will definitely order again."',                'name' => 'Tanvir Khan',    'title' => 'Verified Buyer', 'rating_icon' => array( 'value' => 'fas fa-star', 'library' => 'fa-solid' ) ),
					array( '_id' => 'r4', 'content' => '"I enrolled in the drone training program — absolutely worth it! The instructors are very knowledgeable and patient. Highly recommended!"',          'name' => 'Nadia Begum',    'title' => 'Training Student','rating_icon' => array( 'value' => 'fas fa-star', 'library' => 'fa-solid' ) ),
					array( '_id' => 'r5', 'content' => '"Professional mapping service exceeded our expectations. Aerial data was precise and delivered on time. Great team to work with!"',                  'name' => 'Sajid Islam',    'title' => 'Business Client', 'rating_icon' => array( 'value' => 'fas fa-star', 'library' => 'fa-solid' ) ),
					array( '_id' => 'r6', 'content' => '"Bought accessories for my old DJI Phantom. Very fair prices and the parts were exactly as described. Fast shipping too!"',                        'name' => 'Farida Hossain', 'title' => 'Verified Buyer', 'rating_icon' => array( 'value' => 'fas fa-star', 'library' => 'fa-solid' ) ),
				),
				'star_color'  => '#f5a623',
			) ),
		) ),

	);
}

/* ══════════════════════════════════════════════════════════
   HOME V2 DATA  (White / Sales Focused)
══════════════════════════════════════════════════════════ */
function dss_home_v2_data() {
	return array(

		/* ── 1. HERO (White split) ────────────────────────── */
		dss_full_section( 'v2_hero', array(
			'background_background' => 'classic',
			'background_color'      => '#ffffff',
		), array(
			dss_container( 'v2_hero_row', array(
				'content_width'  => 'full',
				'flex_direction' => 'row',
				'align_items'    => 'center',
				'gap'            => array( 'unit' => 'px', 'column' => '60', 'row' => '40' ),
				'flex_wrap_tablet' => 'wrap',
			), array(
				// Left text
				dss_container( 'v2_hero_txt', array(
					'content_width'  => 'full',
					'flex_direction' => 'column',
					'align_items'    => 'flex-start',
					'width'          => array( 'unit' => '%', 'size' => 50 ),
					'width_tablet'   => array( 'unit' => '%', 'size' => 100 ),
					'gap'            => array( 'unit' => 'px', 'column' => '20', 'row' => '20' ),
				), array(
					dss_heading( 'v2_pre', 'NEXT LEVEL DRONE TECHNOLOGY', 'p', array(
						'title_color'                   => '#a0a0a0',
						'typography_font_size'          => array( 'unit' => 'px', 'size' => 11 ),
						'typography_font_weight'        => '700',
						'typography_letter_spacing'     => array( 'unit' => 'px', 'size' => 3 ),
						'typography_text_transform'     => 'uppercase',
					) ),
					dss_heading( 'v2_h1', 'Next Level<br>Drone Experience', 'h1', array(
						'title_color'                   => '#000000',
						'typography_font_size'          => array( 'unit' => 'px', 'size' => 56 ),
						'typography_font_size_tablet'   => array( 'unit' => 'px', 'size' => 44 ),
						'typography_font_size_mobile'   => array( 'unit' => 'px', 'size' => 34 ),
						'typography_font_weight'        => '800',
						'typography_line_height'        => array( 'unit' => 'em', 'size' => 1.1 ),
					) ),
					dss_text( 'v2_sub', '<p>Discover top-rated drones for every skill level. From beginner fun flyers to industrial workhorses — we have the perfect drone for you.</p>', array(
						'text_color'            => '#707070',
						'typography_font_size'  => array( 'unit' => 'px', 'size' => 17 ),
						'typography_line_height'=> array( 'unit' => 'em', 'size' => 1.75 ),
					) ),
					dss_container( 'v2_btns', array(
						'content_width'  => 'full',
						'flex_direction' => 'row',
						'flex_wrap'      => 'wrap',
						'gap'            => array( 'unit' => 'px', 'column' => '16', 'row' => '12' ),
					), array(
						dss_btn( 'v2_btn1', 'Shop All Drones', '/product-category/drones/', array(
							'background_color'   => '#000000',
							'button_text_color'  => '#ffffff',
							'hover_background_color' => '#333333',
							'border_radius'      => array( 'unit' => 'px', 'top' => '8', 'right' => '8', 'bottom' => '8', 'left' => '8', 'isLinked' => true ),
							'padding'            => array( 'unit' => 'px', 'top' => '16', 'right' => '32', 'bottom' => '16', 'left' => '32', 'isLinked' => false ),
							'typography_font_weight' => '700',
						) ),
						dss_btn( 'v2_btn2', 'View Categories', '/shop/', array(
							'background_color'   => 'rgba(0,0,0,0)',
							'button_text_color'  => '#000',
							'border_border'      => 'solid',
							'border_color'       => '#000',
							'border_width'       => array( 'unit' => 'px', 'top' => '2', 'right' => '2', 'bottom' => '2', 'left' => '2', 'isLinked' => true ),
							'border_radius'      => array( 'unit' => 'px', 'top' => '8', 'right' => '8', 'bottom' => '8', 'left' => '8', 'isLinked' => true ),
							'padding'            => array( 'unit' => 'px', 'top' => '16', 'right' => '32', 'bottom' => '16', 'left' => '32', 'isLinked' => false ),
							'typography_font_weight' => '700',
						) ),
					) ),
					// Stats row
					dss_widget( 'v2_stats', 'html', array(
						'html' => '<div style="display:flex;gap:32px;margin-top:8px;padding-top:24px;border-top:1px solid #e8e8e8;">
							<div><strong style="display:block;font-size:28px;font-weight:800;color:#000;line-height:1;margin-bottom:4px;">500+</strong><span style="font-size:13px;color:#a0a0a0;font-weight:500;">Products</span></div>
							<div><strong style="display:block;font-size:28px;font-weight:800;color:#000;line-height:1;margin-bottom:4px;">2000+</strong><span style="font-size:13px;color:#a0a0a0;font-weight:500;">Happy Clients</span></div>
							<div><strong style="display:block;font-size:28px;font-weight:800;color:#000;line-height:1;margin-bottom:4px;">5★</strong><span style="font-size:13px;color:#a0a0a0;font-weight:500;">Rated Service</span></div>
						</div>',
					) ),
				) ),
				// Right image
				dss_container( 'v2_hero_img', array(
					'content_width'  => 'full',
					'flex_direction' => 'column',
					'align_items'    => 'center',
					'width'          => array( 'unit' => '%', 'size' => 50 ),
					'width_tablet'   => array( 'unit' => '%', 'size' => 100 ),
				), array(
					dss_image( 'v2_img_wgt', array(
						'border_radius' => array( 'unit' => 'px', 'top' => '24', 'right' => '24', 'bottom' => '24', 'left' => '24', 'isLinked' => true ),
						'_label'        => '🔁 Replace with your hero drone image',
					) ),
				) ),
			) ),
		) ),

		/* ── 2. CATEGORY ROW (4 cards) ────────────────────── */
		dss_full_section( 'v2_cats', array(
			'background_background' => 'classic',
			'background_color'      => '#f9f9f9',
		), array(
			dss_shortcode( 'v2_cats_sc', '[product_categories number="4" columns="4" hide_empty="0"]' ),
		) ),

		/* ── 3. ALL PRODUCTS + LOAD MORE ──────────────────── */
		dss_full_section( 'v2_prods', array(
			'background_background' => 'classic',
			'background_color'      => '#ffffff',
		), array(
			dss_widget( 'v2_prods_lbl', 'html', array(
				'html' => '<h2 style="font-size:12px;font-weight:700;letter-spacing:0.12em;text-transform:uppercase;color:#000;margin:0 0 28px;display:flex;flex-direction:column;gap:8px;">ALL PRODUCTS<span style="display:block;width:28px;height:2px;background:#000;"></span></h2>',
			) ),
			dss_shortcode( 'v2_prods_grid', '[products limit="12" columns="4" orderby="date" order="DESC"]' ),
			dss_spacer( 'v2_prods_sp', 24 ),
			dss_container( 'v2_more_wrap', array(
				'content_width'   => 'full',
				'flex_direction'  => 'row',
				'justify_content' => 'center',
			), array(
				dss_btn( 'v2_more_btn', 'Show More Products', '/shop/', array(
					'background_color'   => 'rgba(0,0,0,0)',
					'button_text_color'  => '#000',
					'border_border'      => 'solid',
					'border_color'       => '#000',
					'border_width'       => array( 'unit' => 'px', 'top' => '2', 'right' => '2', 'bottom' => '2', 'left' => '2', 'isLinked' => true ),
					'border_radius'      => array( 'unit' => 'px', 'top' => '8', 'right' => '8', 'bottom' => '8', 'left' => '8', 'isLinked' => true ),
					'padding'            => array( 'unit' => 'px', 'top' => '14', 'right' => '48', 'bottom' => '14', 'left' => '48', 'isLinked' => false ),
					'typography_font_weight' => '700',
				) ),
			) ),
		) ),

		/* ── 4. REVIEWS ───────────────────────────────────── */
		dss_full_section( 'v2_revs', array(
			'background_background' => 'classic',
			'background_color'      => '#f9f9f9',
		), array(
			dss_widget( 'v2_revs_lbl', 'html', array(
				'html' => '<h2 style="font-size:12px;font-weight:700;letter-spacing:0.12em;text-transform:uppercase;color:#000;margin:0 0 28px;display:flex;flex-direction:column;gap:8px;">WHAT OUR CUSTOMERS SAY<span style="display:block;width:28px;height:2px;background:#000;"></span></h2>',
			) ),
			dss_widget( 'v2_revs_car', 'testimonial-carousel', array(
				'skin'            => 'default',
				'slides_per_view' => 4,
				'slides_per_view_tablet' => 2,
				'slides_per_view_mobile' => 1,
				'autoplay'        => 'yes',
				'autoplay_speed'  => 4500,
				'pause_on_hover'  => 'yes',
				'loop'            => 'yes',
				'navigation'      => 'arrows',
				'slides'          => array(
					array( '_id' => 'r1', 'content' => '"Absolutely love my new DJI Mavic 3 Pro! Delivery was super fast and the team helped me pick the perfect drone."',         'name' => 'Rahim Ahmed',    'title' => 'Verified Buyer', 'rating_icon' => array( 'value' => 'fas fa-star', 'library' => 'fa-solid' ) ),
					array( '_id' => 'r2', 'content' => '"Best drone shop. Got my Mini 4 Pro with all accessories. The repair service fixed my old drone in just 2 days!"',          'name' => 'Priya Sharma',   'title' => 'Verified Buyer', 'rating_icon' => array( 'value' => 'fas fa-star', 'library' => 'fa-solid' ) ),
					array( '_id' => 'r3', 'content' => '"Excellent customer service and genuine products. Steadfast delivery was quick and well-packaged. Will order again!"',       'name' => 'Tanvir Khan',    'title' => 'Verified Buyer', 'rating_icon' => array( 'value' => 'fas fa-star', 'library' => 'fa-solid' ) ),
					array( '_id' => 'r4', 'content' => '"The drone training program was absolutely worth it! Instructors are knowledgeable and patient. Highly recommended!"',       'name' => 'Nadia Begum',    'title' => 'Training Student','rating_icon' => array( 'value' => 'fas fa-star', 'library' => 'fa-solid' ) ),
				),
				'star_color' => '#f5a623',
			) ),
		) ),
	);
}

/* ── Contact page ───────────────────────────────────────────── */
function dss_contact_data() {
	$phone   = get_theme_mod( 'drone_sark_header_phone', '+880 1234 567890' );
	$email   = get_theme_mod( 'drone_sark_footer_email', 'info@dronesark.com' );
	$address = get_theme_mod( 'drone_sark_footer_address', 'Dhaka, Bangladesh' );

	return array(
		dss_full_section( 'con_hero', array(
			'background_background' => 'classic',
			'background_color'      => '#ffffff',
		), array(
			dss_container( 'con_hdr', array(
				'content_width'   => 'full',
				'flex_direction'  => 'column',
				'align_items'     => 'center',
				'padding'         => array( 'unit' => 'px', 'top' => '0', 'right' => '0', 'bottom' => '48', 'left' => '0', 'isLinked' => false ),
			), array(
				dss_heading( 'con_h1', 'Contact Us', 'h1', array(
					'title_color'           => '#000',
					'typography_font_size'  => array( 'unit' => 'px', 'size' => 52 ),
					'typography_font_weight'=> '800',
					'align'                 => 'center',
				) ),
				dss_text( 'con_sub', "<p>We'd love to hear from you. Fill in the form or reach us directly.</p>", array(
					'text_color'            => '#707070',
					'typography_font_size'  => array( 'unit' => 'px', 'size' => 17 ),
					'align'                 => 'center',
				) ),
			) ),
			dss_container( 'con_row', array(
				'content_width'  => 'full',
				'flex_direction' => 'row',
				'align_items'    => 'flex-start',
				'gap'            => array( 'unit' => 'px', 'column' => '48', 'row' => '40' ),
				'flex_wrap_tablet' => 'wrap',
			), array(
				dss_container( 'con_info', array(
					'content_width'  => 'full',
					'flex_direction' => 'column',
					'width'          => array( 'unit' => '%', 'size' => 40 ),
					'width_tablet'   => array( 'unit' => '%', 'size' => 100 ),
					'gap'            => array( 'unit' => 'px', 'column' => '20', 'row' => '20' ),
				), array(
					dss_widget( 'con_info_html', 'html', array(
						'html' => '<div style="display:flex;flex-direction:column;gap:20px;">
							<div style="display:flex;align-items:center;gap:14px;"><div style="width:48px;height:48px;border-radius:12px;background:#000;color:#fff;display:flex;align-items:center;justify-content:center;flex-shrink:0;"><svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M22 16.92v3a2 2 0 01-2.18 2 19.79 19.79 0 01-8.63-3.07A19.5 19.5 0 014.33 14a19.79 19.79 0 01-3.07-8.67A2 2 0 013.25 3h3a2 2 0 012 1.72c.127.96.361 1.903.7 2.81a2 2 0 01-.45 2.11L7.91 10.1a16 16 0 006 6l.62-.62a2 2 0 012.11-.45c.907.339 1.85.573 2.81.7A2 2 0 0122 16.92z"/></svg></div><div><div style="font-size:11px;font-weight:700;letter-spacing:.1em;text-transform:uppercase;color:#a0a0a0;margin-bottom:4px;">Phone</div><a href="tel:' . esc_attr( preg_replace('/\D/','', $phone) ) . '" style="font-weight:600;color:#000;text-decoration:none;">' . esc_html( $phone ) . '</a></div></div>
							<div style="display:flex;align-items:center;gap:14px;"><div style="width:48px;height:48px;border-radius:12px;background:#000;color:#fff;display:flex;align-items:center;justify-content:center;flex-shrink:0;"><svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/><polyline points="22,6 12,13 2,6"/></svg></div><div><div style="font-size:11px;font-weight:700;letter-spacing:.1em;text-transform:uppercase;color:#a0a0a0;margin-bottom:4px;">Email</div><a href="mailto:' . esc_attr( $email ) . '" style="font-weight:600;color:#000;text-decoration:none;">' . esc_html( $email ) . '</a></div></div>
							<div style="display:flex;align-items:flex-start;gap:14px;"><div style="width:48px;height:48px;border-radius:12px;background:#000;color:#fff;display:flex;align-items:center;justify-content:center;flex-shrink:0;"><svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 10c0 7-9 13-9 13S3 17 3 10a9 9 0 0118 0z"/><circle cx="12" cy="10" r="3"/></svg></div><div><div style="font-size:11px;font-weight:700;letter-spacing:.1em;text-transform:uppercase;color:#a0a0a0;margin-bottom:4px;">Address</div><address style="font-style:normal;font-weight:500;color:#000;line-height:1.6;">' . nl2br( esc_html( $address ) ) . '</address></div></div>
						</div>',
					) ),
				) ),
				dss_container( 'con_form', array(
					'content_width'         => 'full',
					'flex_direction'        => 'column',
					'width'                 => array( 'unit' => '%', 'size' => 60 ),
					'width_tablet'          => array( 'unit' => '%', 'size' => 100 ),
					'background_background' => 'classic',
					'background_color'      => '#f9f9f9',
					'border_border'         => 'solid',
					'border_width'          => array( 'unit' => 'px', 'top' => '1', 'right' => '1', 'bottom' => '1', 'left' => '1', 'isLinked' => true ),
					'border_color'          => '#e8e8e8',
					'border_radius'         => array( 'unit' => 'px', 'top' => '16', 'right' => '16', 'bottom' => '16', 'left' => '16', 'isLinked' => true ),
					'padding'               => array( 'unit' => 'px', 'top' => '40', 'right' => '40', 'bottom' => '40', 'left' => '40', 'isLinked' => false ),
				), array(
					dss_shortcode( 'con_cf7', '[contact-form-7 id="" title="Contact Form"]' ),
					// Fallback note
					dss_widget( 'con_note', 'html', array(
						'html' => '<p style="font-size:12px;color:#a0a0a0;margin-top:8px;">⚙️ Replace the shortcode above with your Contact Form 7 shortcode after creating the form.</p>',
					) ),
				) ),
			) ),
		) ),
	);
}

/* ── Track Order page ───────────────────────────────────────── */
function dss_track_order_data() {
	return array(
		dss_full_section( 'trk_sec', array(
			'background_background' => 'classic',
			'background_color'      => '#ffffff',
		), array(
			dss_container( 'trk_inner', array(
				'content_width'   => 'full',
				'flex_direction'  => 'column',
				'align_items'     => 'center',
				'max_width'       => array( 'unit' => 'px', 'size' => 600 ),
			), array(
				dss_heading( 'trk_h1', 'Track Your Order', 'h1', array(
					'title_color'            => '#000',
					'typography_font_size'   => array( 'unit' => 'px', 'size' => 44 ),
					'typography_font_weight' => '800',
					'align'                  => 'center',
				) ),
				dss_text( 'trk_sub', '<p>Enter your order ID and email address to track your delivery status.</p>', array(
					'text_color'            => '#707070',
					'typography_font_size'  => array( 'unit' => 'px', 'size' => 17 ),
					'align'                 => 'center',
				) ),
				dss_spacer( 'trk_sp', 24 ),
				dss_shortcode( 'trk_wc', '[woocommerce_order_tracking]' ),
			) ),
		) ),
	);
}
