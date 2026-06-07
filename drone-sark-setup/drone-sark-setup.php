<?php
/**
 * Plugin Name: Drone Sark – One Click Setup
 * Plugin URI:  https://dronesark.com
 * Description: ThemeForest-style one-click demo import. Creates all pages with Elementor layouts, header/footer templates, navigation menu, and homepage — automatically.
 * Version:     2.0.0
 * Author:      Drone Sark
 * Requires at least: 6.0
 * Requires PHP: 7.4
 */

defined( 'ABSPATH' ) || exit;

define( 'DSS_DIR', plugin_dir_path( __FILE__ ) );
define( 'DSS_VER', '2.0.0' );

/* ─────────────────────────────────────────────────────────────────────────────
   ADMIN NOTICE — appears until setup is run
───────────────────────────────────────────────────────────────────────────── */
add_action( 'admin_notices', function () {
	if ( get_option( 'dss_setup_complete' ) || ! current_user_can( 'manage_options' ) ) return;
	$url = admin_url( 'tools.php?page=drone-sark-setup' );
	echo '<div class="notice notice-info" style="border-left-color:#0a0a0a;padding:14px 16px;">
		<strong>🚁 Drone Sark</strong> — Your site is ready for demo import.
		<a href="' . esc_url( $url ) . '" style="margin-left:12px;font-weight:700;color:#0a0a0a;text-decoration:underline;">Click here to import demo data →</a>
	</div>';
} );

/* ─────────────────────────────────────────────────────────────────────────────
   ADMIN MENU
───────────────────────────────────────────────────────────────────────────── */
add_action( 'admin_menu', function () {
	add_management_page(
		'Drone Sark Setup',
		'Drone Sark Setup',
		'manage_options',
		'drone-sark-setup',
		'dss_render_page'
	);
} );

/* ─────────────────────────────────────────────────────────────────────────────
   SETUP PAGE
───────────────────────────────────────────────────────────────────────────── */
function dss_render_page() {
	$done    = get_option( 'dss_setup_complete' );
	$has_ep  = class_exists( '\ElementorPro\Plugin' );
	$has_el  = class_exists( '\Elementor\Plugin' );
	$has_wc  = class_exists( 'WooCommerce' );
	?>
	<style>
	.dss-wrap{max-width:720px;font-family:-apple-system,BlinkMacSystemFont,"Segoe UI",sans-serif;}
	.dss-card{background:#fff;border:1px solid #e0e0e0;border-radius:12px;padding:32px;margin-bottom:24px;}
	.dss-checks{display:flex;flex-direction:column;gap:8px;margin:16px 0;}
	.dss-check{display:flex;align-items:center;gap:10px;font-size:14px;}
	.dss-check .ok{color:#00a32a;font-size:18px;}
	.dss-check .no{color:#d63638;font-size:18px;}
	.dss-btn{display:inline-block;background:#0a0a0a;color:#fff;padding:14px 32px;border-radius:8px;font-size:16px;font-weight:700;border:none;cursor:pointer;text-decoration:none;}
	.dss-btn:hover{background:#333;color:#fff;}
	.dss-btn:disabled{background:#999;cursor:not-allowed;}
	.dss-list{list-style:none;padding:0;margin:16px 0;}
	.dss-list li{padding:6px 0;border-bottom:1px solid #f0f0f0;font-size:14px;color:#333;}
	.dss-list li:before{content:"✓ ";color:#00a32a;font-weight:700;}
	.dss-success{background:#f0fdf0;border:2px solid #00a32a;border-radius:10px;padding:20px 24px;}
	</style>

	<div class="wrap dss-wrap">
		<h1 style="font-size:26px;font-weight:800;margin-bottom:4px;">🚁 Drone Sark – Demo Import</h1>
		<p style="color:#666;margin-bottom:24px;">Like ThemeForest — one click sets up everything.</p>

		<?php if ( $done ) : ?>

		<div class="dss-success">
			<h2 style="margin:0 0 12px;font-size:20px;">✅ Setup Complete!</h2>
			<p style="margin:0 0 16px;color:#333;">Your Drone Sark site is ready. Everything has been created and configured.</p>
			<a href="<?php echo esc_url( home_url( '/' ) ); ?>" target="_blank" class="dss-btn">View Your Site →</a>
		</div>

		<div class="dss-card" style="margin-top:24px;">
			<h3 style="margin-top:0;">What was created:</h3>
			<ul class="dss-list">
				<li>Home – Premium Brand page (dark hero layout)</li>
				<li>Home – Sales Focus page (white/bright layout)</li>
				<li>Contact Us page</li>
				<li>Track Order page (with WooCommerce order tracking)</li>
				<li>Elementor header template → applied to ALL pages</li>
				<li>Elementor footer template → applied to ALL pages</li>
				<li>Navigation menu (Home / Shop / Drones / Accessories / Repair / Contact)</li>
				<li>Homepage set to "Home – Premium Brand"</li>
				<li>Elementor global colors and typography (Inter font)</li>
			</ul>
			<p style="margin-bottom:0;font-size:13px;color:#666;">
				<strong>Next steps:</strong>
				<a href="<?php echo admin_url( 'customize.php' ); ?>">Appearance → Customize</a> to update phone, email, social links.
				Replace placeholder images by editing each page in Elementor.
			</p>
		</div>

		<div class="dss-card">
			<h3 style="margin-top:0;">Switch Homepage Version</h3>
			<p style="font-size:14px;color:#555;">
				<strong>V1 (Dark / Premium Brand):</strong>
				<a href="<?php echo admin_url( 'options-reading.php' ); ?>">Settings → Reading</a> → Homepage → "Home – Premium Brand"<br>
				<strong>V2 (White / Sales Focus):</strong>
				<a href="<?php echo admin_url( 'options-reading.php' ); ?>">Settings → Reading</a> → Homepage → "Home – Sales Focus"
			</p>
		</div>

		<form method="post" action="<?php echo admin_url( 'admin-post.php' ); ?>">
			<?php wp_nonce_field( 'dss_run' ); ?>
			<input type="hidden" name="action" value="dss_run_setup">
			<button type="submit" class="button button-secondary" onclick="return confirm('This will re-run setup. Existing pages will be updated. Continue?')">↺ Re-run Setup</button>
		</form>

		<?php else : ?>

		<div class="dss-card">
			<h2 style="margin-top:0;">Requirements Check</h2>
			<div class="dss-checks">
				<div class="dss-check">
					<span class="<?php echo $has_el ? 'ok' : 'no'; ?>"><?php echo $has_el ? '✓' : '✗'; ?></span>
					Elementor <?php echo $has_el ? 'installed ✓' : '<strong>not found</strong> — install Elementor (free) first'; ?>
				</div>
				<div class="dss-check">
					<span class="<?php echo $has_ep ? 'ok' : 'no'; ?>"><?php echo $has_ep ? '✓' : '✗'; ?></span>
					Elementor Pro <?php echo $has_ep ? 'installed ✓' : '<strong>not found</strong> — header/footer require Elementor Pro'; ?>
				</div>
				<div class="dss-check">
					<span class="<?php echo $has_wc ? 'ok' : 'no'; ?>"><?php echo $has_wc ? '✓' : '✗'; ?></span>
					WooCommerce <?php echo $has_wc ? 'installed ✓' : '<strong>not found</strong> — install WooCommerce first'; ?>
				</div>
			</div>

			<?php if ( ! $has_el || ! $has_wc ) : ?>
			<div class="notice notice-warning inline" style="margin:12px 0 0;"><p>⚠️ Install missing plugins above before running setup.</p></div>
			<?php endif; ?>
		</div>

		<div class="dss-card">
			<h2 style="margin-top:0;">One Click Import</h2>
			<p style="color:#555;">Click the button below — everything will be set up automatically:</p>
			<ul class="dss-list">
				<li>Home – Premium Brand (dark hero layout)</li>
				<li>Home – Sales Focus (white/bright layout)</li>
				<li>Contact Us page</li>
				<li>Track Order page</li>
				<li>Header &amp; Footer Elementor templates (auto-applied to all pages)</li>
				<li>Navigation menu with all links</li>
				<li>Homepage configured automatically</li>
			</ul>
			<p style="font-size:13px;color:#d63638;background:#fff8f8;padding:10px 14px;border-radius:6px;border-left:3px solid #d63638;">
				⚠️ Pages with the same slug will be updated, not duplicated.
			</p>
			<form method="post" action="<?php echo admin_url( 'admin-post.php' ); ?>">
				<?php wp_nonce_field( 'dss_run' ); ?>
				<input type="hidden" name="action" value="dss_run_setup">
				<button type="submit" class="dss-btn" <?php echo ( ! $has_el || ! $has_wc ) ? 'disabled onclick="return false;"' : ''; ?>>
					▶ Import Demo Data Now
				</button>
			</form>
		</div>

		<?php endif; ?>
	</div>
	<?php
}

/* ─────────────────────────────────────────────────────────────────────────────
   MAIN SETUP HANDLER
───────────────────────────────────────────────────────────────────────────── */
add_action( 'admin_post_dss_run_setup', 'dss_run_setup' );
function dss_run_setup() {
	if ( ! wp_verify_nonce( $_POST['_wpnonce'] ?? '', 'dss_run' ) || ! current_user_can( 'manage_options' ) ) {
		wp_die( 'Unauthorized' );
	}

	// 1. Pages
	$home_v1_id = dss_create_page( 'Home – Premium Brand', 'home-premium-brand', 'homepage-template.json' );
	$home_v2_id = dss_create_page( 'Home – Sales Focus',   'home-sales-focus',   'home-v2-template.json' );
	$contact_id = dss_create_page( 'Contact Us',           'contact',            'contact-template.json' );
	$track_id   = dss_create_page( 'Track Order',          'track-order',        'track-order-template.json' );

	// 2. Elementor Theme Builder: Header & Footer
	dss_create_elementor_template( 'header', 'Drone Sark Header', 'elementor-header.json' );
	dss_create_elementor_template( 'footer', 'Drone Sark Footer', 'elementor-footer.json' );

	// 3. Elementor Kit — global colors + typography
	dss_setup_elementor_kit();

	// 4. Navigation menu
	dss_create_menu( $home_v1_id, $contact_id, $track_id );

	// 5. Set homepage
	if ( $home_v1_id ) {
		update_option( 'show_on_front', 'page' );
		update_option( 'page_on_front', $home_v1_id );
	}

	// 6. Flush rewrite rules
	flush_rewrite_rules();

	update_option( 'dss_setup_complete', true );

	wp_redirect( admin_url( 'tools.php?page=drone-sark-setup' ) );
	exit;
}

/* ─────────────────────────────────────────────────────────────────────────────
   HELPER: Load template content from JSON file
───────────────────────────────────────────────────────────────────────────── */
function dss_load_content( string $filename ): string {
	$path = DSS_DIR . $filename;
	if ( ! file_exists( $path ) ) return '[]';

	$json = json_decode( file_get_contents( $path ), true );
	if ( ! $json || ! isset( $json[0]['content'] ) ) return '[]';

	return wp_json_encode( $json[0]['content'] );
}

/* ─────────────────────────────────────────────────────────────────────────────
   HELPER: Create or update a page
───────────────────────────────────────────────────────────────────────────── */
function dss_create_page( string $title, string $slug, string $json_file ): ?int {
	$existing = get_page_by_path( $slug );
	$page_id  = $existing ? $existing->ID : null;

	$data = [
		'post_title'   => $title,
		'post_name'    => $slug,
		'post_status'  => 'publish',
		'post_type'    => 'page',
	];

	if ( $page_id ) {
		$data['ID'] = $page_id;
		wp_update_post( $data );
	} else {
		$page_id = wp_insert_post( $data );
	}

	if ( ! $page_id || is_wp_error( $page_id ) ) return null;

	$elementor_data = dss_load_content( $json_file );

	update_post_meta( $page_id, '_elementor_edit_mode',   'builder' );
	update_post_meta( $page_id, '_wp_page_template',      'elementor_header_footer' );
	update_post_meta( $page_id, '_elementor_version',     '3.0.0' );
	update_post_meta( $page_id, '_elementor_data',        wp_slash( $elementor_data ) );

	dss_flush_css( $page_id );

	return $page_id;
}

/* ─────────────────────────────────────────────────────────────────────────────
   HELPER: Create or update Elementor Theme Builder template (header / footer)
───────────────────────────────────────────────────────────────────────────── */
function dss_create_elementor_template( string $type, string $title, string $json_file ): ?int {
	// Check if already exists
	$existing = get_posts( [
		'post_type'   => 'elementor_library',
		'post_status' => 'any',
		'meta_query'  => [
			[ 'key' => '_elementor_template_type', 'value' => $type ],
		],
		'title'       => $title,
		'numberposts' => 1,
	] );

	$template_id = null;

	if ( $existing ) {
		$template_id = $existing[0]->ID;
		wp_update_post( [ 'ID' => $template_id, 'post_status' => 'publish' ] );
	} else {
		$template_id = wp_insert_post( [
			'post_title'  => $title,
			'post_type'   => 'elementor_library',
			'post_status' => 'publish',
		] );
	}

	if ( ! $template_id || is_wp_error( $template_id ) ) return null;

	$elementor_data = dss_load_content( $json_file );

	update_post_meta( $template_id, '_elementor_template_type', $type );
	update_post_meta( $template_id, '_elementor_edit_mode',     'builder' );
	update_post_meta( $template_id, '_elementor_version',       '3.0.0' );
	update_post_meta( $template_id, '_elementor_data',          wp_slash( $elementor_data ) );

	// "Display on: All Pages" condition
	update_post_meta( $template_id, '_elementor_conditions', [ 'include/general' ] );

	// Register in Elementor Pro's global conditions cache
	dss_set_template_condition( $template_id, $type );

	dss_flush_css( $template_id );

	return $template_id;
}

/* ─────────────────────────────────────────────────────────────────────────────
   HELPER: Register display condition in Elementor Pro's option cache
───────────────────────────────────────────────────────────────────────────── */
function dss_set_template_condition( int $id, string $type ): void {
	$conditions         = get_option( 'elementor_pro_theme_builder_conditions', array() );
	$existing           = isset( $conditions[ $type ] ) ? $conditions[ $type ] : array();
	$conditions[ $type ] = array_filter(
		$existing,
		function( $k ) use ( $id ) { return $k !== $id; },
		ARRAY_FILTER_USE_KEY
	);
	$conditions[ $type ][ $id ] = array( array(
		'type'     => 'include',
		'name'     => 'general',
		'sub_name' => '',
		'sub_id'   => '',
	) );
	update_option( 'elementor_pro_theme_builder_conditions', $conditions );
}

/* ─────────────────────────────────────────────────────────────────────────────
   HELPER: Elementor Kit — global colors + Inter typography
───────────────────────────────────────────────────────────────────────────── */
function dss_setup_elementor_kit(): void {
	// Try active kit from Elementor option
	$kit_id = (int) get_option( 'elementor_active_kit' );

	// Fallback: find kit post
	if ( ! $kit_id ) {
		$kits = get_posts( [
			'post_type'   => 'elementor_library',
			'post_status' => 'publish',
			'numberposts' => 1,
			'meta_query'  => [ [ 'key' => '_elementor_template_type', 'value' => 'kit' ] ],
		] );
		$kit_id = $kits ? $kits[0]->ID : 0;
	}

	if ( ! $kit_id ) return;

	$current = get_post_meta( $kit_id, '_elementor_page_settings', true ) ?: [];

	$current['system_colors'] = [
		[ '_id' => 'ds_black', 'title' => 'DS Black',   'color' => '#0a0a0a' ],
		[ '_id' => 'ds_white', 'title' => 'DS White',   'color' => '#ffffff' ],
		[ '_id' => 'ds_gray',  'title' => 'DS Gray',    'color' => '#f8f8f8' ],
		[ '_id' => 'ds_text',  'title' => 'DS Text',    'color' => '#333333' ],
		[ '_id' => 'ds_gold',  'title' => 'DS Gold',    'color' => '#f5a623' ],
	];

	$current['system_typography'] = [
		[ '_id' => 'primary',   'title' => 'Primary',   'typography_font_family' => 'Inter', 'typography_font_weight' => '700' ],
		[ '_id' => 'secondary', 'title' => 'Secondary', 'typography_font_family' => 'Inter', 'typography_font_weight' => '600' ],
		[ '_id' => 'text',      'title' => 'Text',      'typography_font_family' => 'Inter', 'typography_font_weight' => '400' ],
		[ '_id' => 'accent',    'title' => 'Accent',    'typography_font_family' => 'Inter', 'typography_font_weight' => '800' ],
	];

	$current['button_typography_typography']   = 'custom';
	$current['button_typography_font_family']  = 'Inter';
	$current['button_typography_font_weight']  = '600';
	$current['button_border_radius']           = [ 'unit' => 'px', 'top' => '8', 'right' => '8', 'bottom' => '8', 'left' => '8', 'isLinked' => true ];

	update_post_meta( $kit_id, '_elementor_page_settings', $current );
	delete_post_meta( $kit_id, '_elementor_css' );

	// Flush Elementor CSS file cache
	if ( class_exists( '\Elementor\Core\Files\Manager' ) ) {
		\Elementor\Core\Files\Manager::instance()->clear_cache();
	}
}

/* ─────────────────────────────────────────────────────────────────────────────
   HELPER: Flush Elementor CSS for a single post
───────────────────────────────────────────────────────────────────────────── */
function dss_flush_css( int $post_id ): void {
	delete_post_meta( $post_id, '_elementor_css' );

	if ( class_exists( '\Elementor\Core\Files\CSS\Post' ) ) {
		$css = new \Elementor\Core\Files\CSS\Post( $post_id );
		$css->update();
	}
}

/* ─────────────────────────────────────────────────────────────────────────────
   HELPER: Create navigation menu
───────────────────────────────────────────────────────────────────────────── */
function dss_create_menu( ?int $home_id, ?int $contact_id, ?int $track_id ): void {
	$name = 'Drone Sark Menu';
	$obj  = wp_get_nav_menu_object( $name );

	if ( $obj ) {
		$menu_id = $obj->term_id;
		// Remove old items
		foreach ( wp_get_nav_menu_items( $menu_id ) ?: [] as $item ) {
			wp_delete_post( $item->ID, true );
		}
	} else {
		$menu_id = wp_create_nav_menu( $name );
	}

	if ( is_wp_error( $menu_id ) ) return;

	$shop_url = function_exists( 'wc_get_page_id' ) && wc_get_page_id( 'shop' ) > 0
		? get_permalink( wc_get_page_id( 'shop' ) )
		: home_url( '/shop/' );

	$items = [
		[ 'Home',        home_url( '/' ),                      $home_id    ],
		[ 'Shop',        $shop_url,                            0           ],
		[ 'Drones',      home_url( '/product-category/drones/' ), 0        ],
		[ 'Accessories', home_url( '/product-category/accessories/' ), 0   ],
		[ 'Repair',      home_url( '/repair/' ),               0           ],
		[ 'Contact Us',  $contact_id ? get_permalink( $contact_id ) : home_url( '/contact/' ), $contact_id ],
	];

	foreach ( $items as [ $label, $url, $page_id ] ) {
		$args = [
			'menu-item-title'  => $label,
			'menu-item-url'    => $url,
			'menu-item-status' => 'publish',
		];
		if ( $page_id ) {
			$args['menu-item-type']      = 'post_type';
			$args['menu-item-object']    = 'page';
			$args['menu-item-object-id'] = $page_id;
		} else {
			$args['menu-item-type']   = 'custom';
			$args['menu-item-object'] = 'custom';
		}
		wp_update_nav_menu_item( $menu_id, 0, $args );
	}

	// Assign to theme locations
	$locs               = get_theme_mod( 'nav_menu_locations', [] );
	$locs['primary']    = $menu_id;
	$locs['mobile']     = $menu_id;
	set_theme_mod( 'nav_menu_locations', $locs );
}
