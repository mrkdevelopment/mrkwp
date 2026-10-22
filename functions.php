<?php
/**
 * MRK WP Theme functions and definitions
 *
 * @package MRK_WP
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

define( 'MRKWP_VERSION', '1.0.2' );
define( 'MRKWP_THEME_DIR', get_template_directory() );
define( 'MRKWP_THEME_URI', get_template_directory_uri() );

/**
 * Sets up theme defaults and registers support for various WordPress features.
 */
function mrkwp_setup() {
	load_theme_textdomain( 'mrkwp', MRKWP_THEME_DIR . '/languages' );

	add_theme_support( 'title-tag' );
	add_theme_support( 'post-thumbnails' );
	add_theme_support(
		'custom-logo',
		array(
			'height'      => 96,
			'width'       => 96,
			'flex-width'  => true,
			'flex-height' => true,
		)
	);

	add_theme_support(
		'html5',
		array(
			'search-form',
			'comment-form',
			'comment-list',
			'gallery',
			'caption',
			'style',
			'script',
		)
	);

	// Gutenberg Block Editor Styles & FSE Template Parts.
	add_theme_support( 'editor-styles' );
	add_editor_style( 'dist/editor-style.css' );
	add_theme_support( 'block-template-parts' );

	// Register theme color palette for Gutenberg and classic color pickers.
	add_theme_support(
		'editor-color-palette',
		array(
			array(
				'name'  => __( 'Ink (Headings & Dark BG)', 'mrkwp' ),
				'slug'  => 'ink',
				'color' => '#0a2540',
			),
			array(
				'name'  => __( 'Body Text', 'mrkwp' ),
				'slug'  => 'body',
				'color' => '#425466',
			),
			array(
				'name'  => __( 'Canvas (Light BG)', 'mrkwp' ),
				'slug'  => 'canvas',
				'color' => '#f8fafc',
			),
			array(
				'name'  => __( 'White', 'mrkwp' ),
				'slug'  => 'white',
				'color' => '#ffffff',
			),
			array(
				'name'  => __( 'Indigo (Primary Accent)', 'mrkwp' ),
				'slug'  => 'indigo',
				'color' => '#554cf0',
			),
			array(
				'name'  => __( 'Indigo Dark (Hover)', 'mrkwp' ),
				'slug'  => 'indigo-dark',
				'color' => '#463cd7',
			),
			array(
				'name'  => __( 'Indigo Subtle', 'mrkwp' ),
				'slug'  => 'indigo-subtle',
				'color' => '#eae8ff',
			),
			array(
				'name'  => __( 'Cyan (Vibrant Accent)', 'mrkwp' ),
				'slug'  => 'cyan',
				'color' => '#00d4ff',
			),
			array(
				'name'  => __( 'Deep Cyan', 'mrkwp' ),
				'slug'  => 'deep-cyan',
				'color' => '#007a99',
			),
			array(
				'name'  => __( 'Accent Cyan (Eyebrow)', 'mrkwp' ),
				'slug'  => 'accent-cyan',
				'color' => '#006c86',
			),
			array(
				'name'  => __( 'Night (Navy Section BG)', 'mrkwp' ),
				'slug'  => 'night',
				'color' => '#051322',
			),
			array(
				'name'  => __( 'Line (Border)', 'mrkwp' ),
				'slug'  => 'line',
				'color' => '#dfe5ec',
			),
			array(
				'name'  => __( 'Line Strong', 'mrkwp' ),
				'slug'  => 'line-strong',
				'color' => '#cbd6e4',
			),
			array(
				'name'  => __( 'Muted', 'mrkwp' ),
				'slug'  => 'muted',
				'color' => '#637386',
			),
			array(
				'name'  => __( 'Surface Alt (Bento BG)', 'mrkwp' ),
				'slug'  => 'surface-alt',
				'color' => '#edf1f8',
			),
			array(
				'name'  => __( 'Surface Hover', 'mrkwp' ),
				'slug'  => 'surface-hover',
				'color' => '#e9edff',
			),
		)
	);

	register_nav_menus(
		array(
			'primary' => __( 'Primary Navigation', 'mrkwp' ),
			'footer'  => __( 'Footer Navigation', 'mrkwp' ),
		)
	);
}
add_action( 'after_setup_theme', 'mrkwp_setup' );

/**
 * Enqueue scripts and styles.
 */
function mrkwp_scripts() {
	// Preconnect for Google Fonts.
	add_filter(
		'wp_resource_hints',
		function ( $urls, $relation_type ) {
			if ( 'preconnect' === $relation_type ) {
				$urls[] = array(
					'href'        => 'https://fonts.googleapis.com',
					'crossorigin' => 'anonymous',
				);
				$urls[] = array(
					'href'        => 'https://fonts.gstatic.com',
					'crossorigin' => 'anonymous',
				);
			}
			return $urls;
		},
		10,
		2
	);

	// Google Fonts.
	wp_enqueue_style(
		'mrkwp-fonts',
		'https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&family=Plus+Jakarta+Sans:wght@700&display=swap',
		array(),
		MRKWP_VERSION
	);

	// Compiled SCSS Theme Stylesheet.
	$theme_css_ver = file_exists( MRKWP_THEME_DIR . '/dist/theme.css' ) ? filemtime( MRKWP_THEME_DIR . '/dist/theme.css' ) : MRKWP_VERSION;
	wp_enqueue_style( 'mrkwp-theme', MRKWP_THEME_URI . '/dist/theme.css', array( 'mrkwp-fonts' ), $theme_css_ver );

	// Scripts.
	wp_enqueue_script( 'mrkwp-navigation', MRKWP_THEME_URI . '/js/navigation.js', array(), MRKWP_VERSION, array( 'strategy' => 'defer' ) );

	wp_enqueue_script( 'mrkwp-motion', MRKWP_THEME_URI . '/js/motion.js', array(), MRKWP_VERSION, array( 'strategy' => 'defer' ) );
	wp_localize_script(
		'mrkwp-motion',
		'mrkwpTheme',
		array(
			'themeUrl'  => MRKWP_THEME_URI,
			'vendorUrl' => MRKWP_THEME_URI . '/vendor/',
			'assetsUrl' => MRKWP_THEME_URI . '/assets/',
		)
	);

	// Load assessment script when on tools or pages using readiness assessment.
	if (
		is_page_template( 'page-tools.php' ) ||
		is_page_template( 'page-tools.html' ) ||
		is_page_template( 'page-tools' ) ||
		is_page( 'tools' ) ||
		is_page_template( 'page-advisory.php' ) ||
		is_page_template( 'page-advisory.html' ) ||
		is_page_template( 'page-advisory' ) ||
		is_page( 'advisory' )
	) {
		wp_enqueue_script( 'mrkwp-app', MRKWP_THEME_URI . '/js/app.js', array( 'mrkwp-navigation' ), MRKWP_VERSION, array( 'strategy' => 'defer' ) );
	}

	// Dequeue generic block styles on the custom coded frontend.
	wp_dequeue_style( 'wp-block-library' );
	wp_dequeue_style( 'wp-block-library-theme' );
	wp_dequeue_style( 'global-styles' );
	wp_dequeue_style( 'classic-theme-styles' );
}
add_action( 'wp_enqueue_scripts', 'mrkwp_scripts' );

/**
 * Output favicon links and theme meta in wp_head.
 */
function mrkwp_head_meta() {
	echo '<meta name="theme-color" content="#0a2540">' . "\n";
	echo '<link rel="icon" href="' . esc_url( mrkwp_asset( 'favicon.svg' ) ) . '" type="image/svg+xml">' . "\n";
	echo '<link rel="icon" href="' . esc_url( mrkwp_asset( 'mrk-square.png' ) ) . '" sizes="any">' . "\n";
}
add_action( 'wp_head', 'mrkwp_head_meta' );

/**
 * Output global SVG sprite library and skip link at body open.
 */
function mrkwp_body_open_elements() {
	?>
	<svg class="icon-library" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
		<symbol id="i-arrow" viewBox="0 0 24 24"><path d="M4 12h15m-6-6 6 6-6 6"/></symbol>
		<symbol id="i-up-right" viewBox="0 0 24 24"><path d="M6 18 18 6M6 6h12v12"/></symbol>
		<symbol id="i-check" viewBox="0 0 24 24"><path d="m5 12 4 4L19 6"/></symbol>
		<symbol id="i-spark" viewBox="0 0 24 24"><path d="m12 2 2.5 7.5L22 12l-7.5 2.5L12 22l-2.5-7.5L2 12l7.5-2.5Z"/></symbol>
		<symbol id="i-bolt" viewBox="0 0 24 24"><path d="M13 2 4 14h7l-1 8 10-13h-7l1-7Z"/></symbol>
		<symbol id="i-search" viewBox="0 0 24 24"><circle cx="10.5" cy="10.5" r="6.5"/><path d="m15.5 15.5 5 5"/></symbol>
		<symbol id="i-chat" viewBox="0 0 24 24"><path d="M20 11.5a8 8 0 0 1-8 8 9 9 0 0 1-3-.5l-5 1 1-5a9 9 0 0 1-.5-3.5 8 8 0 0 1 15.5 0Z"/><path d="M8 10h8m-8 4h5"/></symbol>
		<symbol id="i-nodes" viewBox="0 0 24 24"><rect x="9" y="2" width="6" height="6" rx="1"/><rect x="2" y="16" width="6" height="6" rx="1"/><rect x="16" y="16" width="6" height="6" rx="1"/><path d="M12 8v4H5v4m7-4h7v4"/></symbol>
		<symbol id="i-shield" viewBox="0 0 24 24"><path d="m12 2 8 3v6c0 5-8 11-8 11S4 16 4 11V5Z"/><path d="m8.5 11.5 2.5 2.5 4.5-5"/></symbol>
		<symbol id="i-play" viewBox="0 0 24 24"><path d="m8 5 11 7-11 7Z"/></symbol>
	</svg>

	<a class="skip-link" href="#main"><?php esc_html_e( 'Skip to content', 'mrkwp' ); ?></a>
	<?php
}
add_action( 'wp_body_open', 'mrkwp_body_open_elements' );

/**
 * Output floating back-to-top button in wp_footer.
 */
function mrkwp_footer_elements() {
	?>
	<a class="floating-top" href="#" aria-label="<?php esc_attr_e( 'Back to top', 'mrkwp' ); ?>" hidden><span aria-hidden="true">↑</span><span>Top</span></a>
	<?php
}
add_action( 'wp_footer', 'mrkwp_footer_elements' );

/**
 * Register post meta for page settings (e.g. title toggle).
 */
function mrkwp_register_post_meta() {
	register_post_meta(
		'page',
		'_mrkwp_show_title',
		array(
			'show_in_rest'  => true,
			'single'        => true,
			'type'          => 'string',
			'default'       => '1',
			'auth_callback' => function () {
				return current_user_can( 'edit_posts' );
			},
		)
	);

	register_post_meta(
		'post',
		'_mrkwp_show_title',
		array(
			'show_in_rest'  => true,
			'single'        => true,
			'type'          => 'string',
			'default'       => '1',
			'auth_callback' => function () {
				return current_user_can( 'edit_posts' );
			},
		)
	);
}
add_action( 'init', 'mrkwp_register_post_meta' );

/**
 * Enqueue editor assets for Gutenberg document settings panels.
 */
function mrkwp_enqueue_block_editor_assets() {
	wp_enqueue_script(
		'mrkwp-page-settings-editor',
		MRKWP_THEME_URI . '/js/page-settings-editor.js',
		array( 'wp-plugins', 'wp-edit-post', 'wp-element', 'wp-components', 'wp-data' ),
		MRKWP_VERSION,
		true
	);
}
add_action( 'enqueue_block_editor_assets', 'mrkwp_enqueue_block_editor_assets' );

/**
 * Add Page Settings meta box for classic editor / document settings fallback.
 */
function mrkwp_add_page_settings_meta_box() {
	add_meta_box(
		'mrkwp_page_settings_box',
		__( 'Page Title Display', 'mrkwp' ),
		'mrkwp_render_page_settings_meta_box',
		array( 'page', 'post' ),
		'side',
		'default'
	);
}
add_action( 'add_meta_boxes', 'mrkwp_add_page_settings_meta_box' );

/**
 * Render Page Settings meta box.
 *
 * @param \WP_Post $post Current post object.
 */
function mrkwp_render_page_settings_meta_box( $post ) {
	wp_nonce_field( 'mrkwp_save_page_settings', 'mrkwp_page_settings_nonce' );
	$show_title = get_post_meta( $post->ID, '_mrkwp_show_title', true );
	$checked    = ( '0' !== $show_title );
	?>
	<p>
		<label for="mrkwp_show_title_field" style="display:flex; align-items:center; gap:8px; cursor:pointer;">
			<input type="checkbox" id="mrkwp_show_title_field" name="mrkwp_show_title" value="1" <?php checked( $checked, true ); ?>>
			<strong><?php esc_html_e( 'Show page title', 'mrkwp' ); ?></strong>
		</label>
	</p>
	<p class="description"><?php esc_html_e( 'Uncheck to hide the title header banner on this page.', 'mrkwp' ); ?></p>
	<?php
}

/**
 * Save Page Settings meta box data.
 *
 * @param int $post_id Post ID.
 */
function mrkwp_save_page_settings_meta( $post_id ) {
	if ( ! isset( $_POST['mrkwp_page_settings_nonce'] ) || ! wp_verify_nonce( sanitize_key( $_POST['mrkwp_page_settings_nonce'] ), 'mrkwp_save_page_settings' ) ) {
		return;
	}
	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
		return;
	}
	if ( ! current_user_can( 'edit_post', $post_id ) ) {
		return;
	}
	$value = isset( $_POST['mrkwp_show_title'] ) ? '1' : '0';
	update_post_meta( $post_id, '_mrkwp_show_title', $value );
}
add_action( 'save_post', 'mrkwp_save_page_settings_meta' );

/**
 * Register Gutenberg Block Styles.
 */
function mrkwp_register_block_styles() {
	// Button variations.
	register_block_style(
		'core/button',
		array(
			'name'  => 'secondary',
			'label' => __( 'Secondary (Outline)', 'mrkwp' ),
		)
	);

	register_block_style(
		'core/button',
		array(
			'name'  => 'light',
			'label' => __( 'Light (White)', 'mrkwp' ),
		)
	);

	register_block_style(
		'core/button',
		array(
			'name'  => 'small',
			'label' => __( 'Small / Compact', 'mrkwp' ),
		)
	);

	register_block_style(
		'core/button',
		array(
			'name'  => 'text-link',
			'label' => __( 'Text Action Link', 'mrkwp' ),
		)
	);

	// Paragraph variations.
	register_block_style(
		'core/paragraph',
		array(
			'name'  => 'eyebrow',
			'label' => __( 'Eyebrow Kicker', 'mrkwp' ),
		)
	);

	register_block_style(
		'core/paragraph',
		array(
			'name'  => 'lead',
			'label' => __( 'Lead Paragraph', 'mrkwp' ),
		)
	);
}
add_action( 'init', 'mrkwp_register_block_styles' );

/**
 * Helper to retrieve an asset URL from the theme.
 *
 * @param string $path Relative path to asset.
 * @return string
 */
function mrkwp_asset( $path ) {
	return MRKWP_THEME_URI . '/assets/' . ltrim( $path, '/' );
}

/**
 * Helper to render SVG sprite icons.
 *
 * @param string $name  Icon identifier.
 * @param string $class CSS class for SVG.
 * @return string
 */
function mrkwp_icon( $name, $class = 'icon' ) {
	return sprintf(
		'<svg class="%s" aria-hidden="true"><use href="#i-%s"/></svg>',
		esc_attr( $class ),
		esc_attr( $name )
	);
}

/**
 * Add direct "Footer (Site Editor)" shortcut under Appearance menu.
 */
function mrkwp_register_footer_editor_menu() {
	add_theme_page(
		__( 'Edit Footer', 'mrkwp' ),
		__( 'Footer', 'mrkwp' ),
		'edit_theme_options',
		'site-editor.php?postType=wp_template_part&postId=' . rawurlencode( get_stylesheet() . '//footer' ) . '&canvas=edit'
	);
}
add_action( 'admin_menu', 'mrkwp_register_footer_editor_menu' );

/**
 * Use custom stroke-style SVGs for MRK WP's primary social links in core/social-link block.
 *
 * @param array $services_data Registered social link services.
 * @return array Filtered social link services.
 */
function mrkwp_custom_social_link_icons( $services_data ) {
	$custom_icons = array(
		'github'    => '<svg class="mrkwp-stroke-icon" viewBox="0 0 24 24" aria-hidden="true"><path d="M9 19c-4 1-4-2-6-2m15 4v-4c0-1-.4-2-1-2 4-.5 5-2 5-6 0-1-1-3-2-3 0-1 0-2-.5-3-2 0-3 1-3 1a12 12 0 0 0-7 0S8 3 6 3c-.5 1-.5 2-.5 3C4 7 3 8 3 10c0 3 2 5 6 5-.6.5-1 1-1 2v4"/></svg>',
		'instagram' => '<svg class="mrkwp-stroke-icon" viewBox="0 0 24 24" aria-hidden="true"><rect x="3" y="3" width="18" height="18" rx="5"/><circle cx="12" cy="12" r="4"/><circle cx="17.5" cy="6.5" r=".7" fill="currentColor"/></svg>',
		'linkedin'  => '<svg class="mrkwp-stroke-icon" viewBox="0 0 24 24" aria-hidden="true"><rect x="3" y="9" width="4" height="12" rx=".5"/><circle cx="5" cy="4.5" r="1.5"/><path d="M11 21V9h4v2c1-3 6-3 6 2v8m-6 0v-7"/></svg>',
		'x'         => '<svg class="mrkwp-stroke-icon" viewBox="0 0 24 24" aria-hidden="true"><path d="m4 3 12 18h4L8 3H4Zm0 18L20 3"/></svg>',
		'youtube'   => '<svg class="mrkwp-stroke-icon" viewBox="0 0 24 24" aria-hidden="true"><rect x="2" y="5" width="20" height="14" rx="4"/><path d="m10 9 5 3-5 3Z"/></svg>',
	);

	foreach ( $custom_icons as $service => $svg ) {
		if ( isset( $services_data[ $service ] ) ) {
			$services_data[ $service ]['icon'] = $svg;
		}
	}

	return $services_data;
}
add_filter( 'block_core_social_link_get_services', 'mrkwp_custom_social_link_icons' );

/**
 * Override core/social-link variation icons inside the Block / Site Editor so they match the frontend stroke icons.
 */
function mrkwp_enqueue_block_editor_social_icons() {
	$inline_js = <<<'JS'
( function( wp ) {
	if ( ! wp || ! wp.element || ! wp.hooks ) {
		return;
	}
	var el = wp.element.createElement;
	var customIcons = {
		github: function() {
			return el( 'svg', { className: 'mrkwp-stroke-icon', width: '24', height: '24', viewBox: '0 0 24 24', 'aria-hidden': 'true' },
				el( 'path', { d: 'M9 19c-4 1-4-2-6-2m15 4v-4c0-1-.4-2-1-2 4-.5 5-2 5-6 0-1-1-3-2-3 0-1 0-2-.5-3-2 0-3 1-3 1a12 12 0 0 0-7 0S8 3 6 3c-.5 1-.5 2-.5 3C4 7 3 8 3 10c0 3 2 5 6 5-.6.5-1 1-1 2v4' } )
			);
		},
		instagram: function() {
			return el( 'svg', { className: 'mrkwp-stroke-icon', width: '24', height: '24', viewBox: '0 0 24 24', 'aria-hidden': 'true' },
				el( 'rect', { x: '3', y: '3', width: '18', height: '18', rx: '5' } ),
				el( 'circle', { cx: '12', cy: '12', r: '4' } ),
				el( 'circle', { cx: '17.5', cy: '6.5', r: '.7', fill: 'currentColor', stroke: 'none' } )
			);
		},
		linkedin: function() {
			return el( 'svg', { className: 'mrkwp-stroke-icon', width: '24', height: '24', viewBox: '0 0 24 24', 'aria-hidden': 'true' },
				el( 'rect', { x: '3', y: '9', width: '4', height: '12', rx: '.5' } ),
				el( 'circle', { cx: '5', cy: '4.5', r: '1.5' } ),
				el( 'path', { d: 'M11 21V9h4v2c1-3 6-3 6 2v8m-6 0v-7' } )
			);
		},
		x: function() {
			return el( 'svg', { className: 'mrkwp-stroke-icon', width: '24', height: '24', viewBox: '0 0 24 24', 'aria-hidden': 'true' },
				el( 'path', { d: 'm4 3 12 18h4L8 3H4Zm0 18L20 3' } )
			);
		},
		youtube: function() {
			return el( 'svg', { className: 'mrkwp-stroke-icon', width: '24', height: '24', viewBox: '0 0 24 24', 'aria-hidden': 'true' },
				el( 'rect', { x: '2', y: '5', width: '20', height: '14', rx: '4' } ),
				el( 'path', { d: 'm10 9 5 3-5 3Z' } )
			);
		}
	};

	wp.hooks.addFilter(
		'blocks.registerBlockType',
		'mrkwp/social-link-icons',
		function( settings, name ) {
			if ( name === 'core/social-link' && Array.isArray( settings.variations ) ) {
				settings.variations = settings.variations.map( function( variation ) {
					if ( customIcons[ variation.name ] ) {
						return Object.assign( {}, variation, { icon: customIcons[ variation.name ] } );
					}
					return variation;
				} );
			}
			return settings;
		}
	);

	if ( wp.domReady && wp.blocks && wp.blocks.getBlockVariations ) {
		wp.domReady( function() {
			var variations = wp.blocks.getBlockVariations( 'core/social-link' );
			if ( Array.isArray( variations ) ) {
				variations.forEach( function( variation ) {
					if ( customIcons[ variation.name ] ) {
						variation.icon = customIcons[ variation.name ];
					}
				} );
			}
		} );
	}
} )( window.wp );
JS;
	wp_add_inline_script( 'wp-blocks', $inline_js );
}
add_action( 'enqueue_block_editor_assets', 'mrkwp_enqueue_block_editor_social_icons' );


/**
 * Register pattern categories.
 */
function pattern_categories() {

	$block_pattern_categories = array(
		'ollie/menu' => array(
			'label' => __( 'Menu', 'mrkwp' ),
		),
	);

	foreach ( $block_pattern_categories as $name => $properties ) {
		register_block_pattern_category( $name, $properties );
	}
}
add_action( 'init', __NAMESPACE__ . '\pattern_categories', 9 );