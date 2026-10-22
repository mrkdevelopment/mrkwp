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

	wp_enqueue_script( 'mrkwp-video-lightbox', MRKWP_THEME_URI . '/js/video-lightbox.js', array(), MRKWP_VERSION, array( 'strategy' => 'defer' ) );

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
		is_post_type_archive( 'mrkwp_tool' ) ||
		is_singular( 'mrkwp_tool' ) ||
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
add_action( 'init', 'pattern_categories', 9 );

/**
 * Render callback for dynamic tools directory block (mrkwp/tools-directory).
 *
 * @param array  $attributes Block attributes.
 * @param string $content    Block inner content.
 * @return string HTML output.
 */
function mrkwp_render_tools_directory( $attributes = array(), $content = '' ) {
	unset( $attributes, $content );
	$categories = array(
		'all'         => __( 'All tools', 'mrkwp' ),
		'assistants'  => __( 'AI assistants', 'mrkwp' ),
		'social'      => __( 'Social media AI', 'mrkwp' ),
		'video'       => __( 'Video', 'mrkwp' ),
		'coding'      => __( 'AI coding', 'mrkwp' ),
		'creative'    => __( 'Creative', 'mrkwp' ),
		'development' => __( 'Development', 'mrkwp' ),
	);

	$tools_query = new WP_Query(
		array(
			'post_type'      => 'mrkwp_tool',
			'post_status'    => 'publish',
			'posts_per_page' => -1,
			'orderby'        => array(
				'menu_order' => 'ASC',
				'title'      => 'ASC',
			),
		)
	);

	$total_tools = $tools_query->found_posts;

	ob_start();
	?>
	<section class="wrap" aria-label="<?php esc_attr_e( 'Matt’s tool directory', 'mrkwp' ); ?>">
		<div class="tool-controls" aria-label="<?php esc_attr_e( 'Filter tools', 'mrkwp' ); ?>">
			<?php foreach ( $categories as $slug => $label ) : ?>
				<button class="tool-filter" data-category="<?php echo esc_attr( $slug ); ?>" aria-pressed="<?php echo 'all' === $slug ? 'true' : 'false'; ?>"><?php echo esc_html( $label ); ?></button>
			<?php endforeach; ?>
		</div>

		<p id="tool-count" role="status"><?php echo esc_html( sprintf( /* translators: %d: number of tools. */ _n( '%d tool', '%d tools', $total_tools, 'mrkwp' ), $total_tools ) ); ?></p>

		<div class="tool-grid">
			<?php
			if ( $tools_query->have_posts() ) :
				while ( $tools_query->have_posts() ) :
					$tools_query->the_post();
					$post_id   = get_the_ID();
					$title     = get_the_title();
					$permalink = get_permalink();
					$initial   = get_post_meta( $post_id, '_mrkwp_tool_initial', true );
					if ( empty( $initial ) ) {
						$initial = mb_substr( $title, 0, 1 );
					}
					$terms    = get_the_terms( $post_id, 'mrkwp_tool_cat' );
					$cat_slug = 'other';
					$cat_name = '';
					if ( ! empty( $terms ) && ! is_wp_error( $terms ) ) {
						$first_term = reset( $terms );
						$cat_slug   = $first_term->slug;
						$cat_name   = $first_term->name;
					}
					?>
					<a class="tool-card" href="<?php echo esc_url( $permalink ); ?>" data-category="<?php echo esc_attr( $cat_slug ); ?>">
						<span class="tool-initial" aria-hidden="true"><?php echo esc_html( $initial ); ?></span>
						<h3><?php echo esc_html( $title ); ?></h3>
						<p><?php echo esc_html( $cat_name ); ?></p>
					</a>
					<?php
				endwhile;
				wp_reset_postdata();
			endif;
			?>
		</div>
	</section>
	<?php
	return ob_get_clean();
}

/**
 * Register dynamic blocks for the theme.
 */
function mrkwp_register_theme_blocks() {
	register_block_type(
		'mrkwp/tools-directory',
		array(
			'title'           => __( 'Tools Directory', 'mrkwp' ),
			'category'        => 'theme',
			'render_callback' => 'mrkwp_render_tools_directory',
			'supports'        => array(
				'html' => false,
			),
		)
	);

	register_block_type(
		'mrkwp/related-videos',
		array(
			'title'           => __( 'Related Videos', 'mrkwp' ),
			'category'        => 'theme',
			'render_callback' => 'mrkwp_render_related_videos',
			'supports'        => array(
				'html' => false,
			),
		)
	);

	register_block_type(
		'mrkwp/video-player',
		array(
			'title'           => __( 'Video Player', 'mrkwp' ),
			'category'        => 'theme',
			'render_callback' => 'mrkwp_render_video_player',
			'supports'        => array(
				'html' => false,
			),
		)
	);
}
add_action( 'init', 'mrkwp_register_theme_blocks' );

/**
 * Render callback for dynamic video player block (mrkwp/video-player).
 *
 * Extracts the video player from the post content (or builds it from post meta)
 * and renders it with the lightbox trigger.
 *
 * @param array<string, mixed> $attributes Block attributes.
 * @param string               $content    Block inner content.
 * @return string HTML output of the video player.
 */
function mrkwp_render_video_player( $attributes = array(), $content = '' ) {
	unset( $attributes, $content );

	$post_id = get_the_ID();
	if ( ! $post_id ) {
		return '';
	}

	global $mrkwp_rendering_video_player;
	$mrkwp_rendering_video_player = true;

	$post = get_post( $post_id );
	if ( ! $post ) {
		$mrkwp_rendering_video_player = false;
		return '';
	}

	$video_html = '';
	$blocks     = parse_blocks( $post->post_content );
	foreach ( $blocks as $block ) {
		if ( ! empty( $block['blockName'] ) && 'greenshift-blocks/video' === $block['blockName'] ) {
			$video_html = render_block( $block );
			break;
		}
	}

	// Fallback if no GreenShift video block in content: build from post meta.
	if ( empty( trim( $video_html ) ) ) {
		$youtube_id    = get_post_meta( $post_id, '_mrkwp_youtube_id', true );
		$thumbnail_url = get_post_meta( $post_id, '_mrkwp_youtube_thumbnail_url', true );
		if ( empty( $thumbnail_url ) && has_post_thumbnail( $post_id ) ) {
			$maxres        = get_the_post_thumbnail_url( $post_id, 'maxresdefault' );
			$thumbnail_url = $maxres ? $maxres : get_the_post_thumbnail_url( $post_id, 'full' );
		}

		if ( ! empty( $youtube_id ) ) {
			$video_url  = 'https://youtu.be/' . $youtube_id;
			$video_html = sprintf(
				'<div class="wp-block-greenshift-blocks-video gs-video youtube">' .
					'<div class="gs-video-wrapper" itemscope>' .
						'<iframe class="gs-video-element" data-src="%1$s" data-provider="youtube" data-autoplay="true" frameborder="0" allowfullscreen></iframe>' .
						'<div class="gs-video-overlay" style="background-image:url(%2$s)" data-type="youtube" data-lightbox="true" data-video-id="%3$s" data-video-url="%1$s" role="button" aria-label="%4$s" tabindex="0">' .
							'<div class="gs-play-icon" style="background-color:#cc0000" aria-hidden="true">' .
								'<div style="content:\'\';display:block;position:absolute;border-radius:50%;border:1px solid #cc0000;left:-20px;right:-20px;bottom:-20px;top:-20px;animation:pulsevideobutton 1.5s linear infinite;opacity:0"></div>' .
								'<span></span>' .
								'<div style="content:\'\';display:block;position:absolute;border-radius:50%;border:1px solid #cc0000;left:-20px;right:-20px;bottom:-20px;top:-20px;animation:pulsevideobutton 1.5s linear infinite;opacity:0;animation-delay:0.5s"></div>' .
							'</div>' .
							'<div class="gs-overlay-color" style="background-color:var(--wp--preset--color--palette-color-12, var(--theme-palette-color-12, #111518));opacity:0.5"></div>' .
						'</div>' .
					'</div>' .
				'</div>',
				esc_url( $video_url ),
				esc_url( $thumbnail_url ),
				esc_attr( $youtube_id ),
				esc_attr__( 'Play video', 'mrkwp' )
			);
		}
	}

	$mrkwp_rendering_video_player = false;

	if ( empty( trim( $video_html ) ) ) {
		return '';
	}

	return '<div class="video-player-frame">' . $video_html . '</div>';
}

/**
 * Suppress duplicate greenshift video block in the post-content area on single video posts,
 * since the video player is rendered via mrkwp/video-player above.
 *
 * @param string               $block_content The block content.
 * @param array<string, mixed> $block         The parsed block.
 * @return string Filtered block content.
 */
function mrkwp_filter_greenshift_video_block( $block_content, $block ) {
	unset( $block );
	global $mrkwp_rendering_video_player;
	if ( ! empty( $mrkwp_rendering_video_player ) ) {
		return $block_content;
	}

	if ( is_singular( 'mrkwp_video' ) ) {
		return '';
	}

	return $block_content;
}
add_filter( 'render_block_greenshift-blocks/video', 'mrkwp_filter_greenshift_video_block', 10, 2 );

/**
 * Calculate relative post date in days.
 *
 * @param int $post_id Optional. Post ID. Defaults to current post.
 * @return string Relative date string, e.g. "Posted today", "Posted 1 day ago", "Posted 5 days ago".
 */
function mrkwp_format_relative_days( $post_id = 0 ) {
	$post_id   = $post_id ? $post_id : get_the_ID();
	$post_time = get_post_time( 'U', true, $post_id );
	$diff_sec  = max( 0, time() - (int) $post_time );
	$days      = (int) floor( $diff_sec / DAY_IN_SECONDS );

	if ( $days <= 0 ) {
		return __( 'Posted today', 'mrkwp' );
	} elseif ( 1 === $days ) {
		return __( 'Posted 1 day ago', 'mrkwp' );
	}

	/* translators: %d: number of days. */
	return sprintf( __( 'Posted %d days ago', 'mrkwp' ), $days );
}

/**
 * Filter core/post-date block to show relative days for mrkwp_video post type.
 *
 * @param string        $block_content The block content.
 * @param array         $block         The parsed block.
 * @param WP_Block|null $instance      The block instance.
 * @return string Filtered block content.
 */
function mrkwp_filter_video_post_date( $block_content, $block, $instance = null ) {
	$post_id = 0;
	if ( ! empty( $instance->context['postId'] ) ) {
		$post_id = (int) $instance->context['postId'];
	} elseif ( ! empty( $block['attrs']['postId'] ) ) {
		$post_id = (int) $block['attrs']['postId'];
	} else {
		$post_id = get_the_ID();
	}

	if ( ! $post_id || 'mrkwp_video' !== get_post_type( $post_id ) ) {
		return $block_content;
	}

	$relative_text = mrkwp_format_relative_days( $post_id );
	$updated       = preg_replace( '/(<time[^>]*>).*?(<\/time>)/is', '$1' . esc_html( $relative_text ) . '$2', $block_content );

	return $updated ? $updated : $block_content;
}
add_filter( 'render_block_core/post-date', 'mrkwp_filter_video_post_date', 10, 3 );

/**
 * Render callback for dynamic related videos block (mrkwp/related-videos).
 *
 * @param array  $attributes Block attributes.
 * @param string $content    Block inner content.
 * @return string HTML output.
 */
function mrkwp_render_related_videos( $attributes = array(), $content = '' ) {
	unset( $attributes, $content );

	$current_id = get_the_ID();
	if ( ! $current_id ) {
		return '';
	}

	$tag_ids = wp_get_post_terms( $current_id, 'post_tag', array( 'fields' => 'ids' ) );
	if ( is_wp_error( $tag_ids ) ) {
		$tag_ids = array();
	}

	$related_ids = array();

	// 1. Primary query: Same post_tag ordered by date DESC.
	if ( ! empty( $tag_ids ) ) {
		$tag_query = new WP_Query(
			array(
				'post_type'      => 'mrkwp_video',
				'post_status'    => 'publish',
				'posts_per_page' => 3,
				'post__not_in'   => array( $current_id ),
				'tax_query'      => array( // phpcs:ignore WordPress.DB.SlowDBQuery.slow_db_query_tax_query
					array(
						'taxonomy' => 'post_tag',
						'field'    => 'term_id',
						'terms'    => $tag_ids,
					),
				),
				'orderby'        => 'date',
				'order'          => 'DESC',
				'fields'         => 'ids',
				'no_found_rows'  => true,
			)
		);

		if ( ! empty( $tag_query->posts ) ) {
			$related_ids = array_map( 'intval', $tag_query->posts );
		}
	}

	// 2. Backfill query: Most recent videos if fewer than 3 were found.
	$needed = 3 - count( $related_ids );
	if ( $needed > 0 ) {
		$exclude        = array_merge( array( $current_id ), $related_ids );
		$backfill_query = new WP_Query(
			array(
				'post_type'      => 'mrkwp_video',
				'post_status'    => 'publish',
				'posts_per_page' => $needed,
				'post__not_in'   => $exclude,
				'orderby'        => 'date',
				'order'          => 'DESC',
				'fields'         => 'ids',
				'no_found_rows'  => true,
			)
		);

		if ( ! empty( $backfill_query->posts ) ) {
			$related_ids = array_merge( $related_ids, array_map( 'intval', $backfill_query->posts ) );
		}
	}

	if ( empty( $related_ids ) ) {
		return '';
	}

	$related_query = new WP_Query(
		array(
			'post_type'      => 'mrkwp_video',
			'post_status'    => 'publish',
			'post__in'       => $related_ids,
			'orderby'        => 'post__in',
			'posts_per_page' => count( $related_ids ),
			'no_found_rows'  => true,
		)
	);

	if ( ! $related_query->have_posts() ) {
		return '';
	}

	ob_start();
	?>
	<section class="wrap section related-videos-section" aria-label="<?php esc_attr_e( 'Related Videos', 'mrkwp' ); ?>">
		<div class="section-heading">
			<div>
				<p class="eyebrow"><?php esc_html_e( 'More Walkthroughs', 'mrkwp' ); ?></p>
				<h2><?php esc_html_e( 'Related Videos', 'mrkwp' ); ?></h2>
			</div>
			<p><?php esc_html_e( 'Continue learning with tutorials and workflows related to this walkthrough.', 'mrkwp' ); ?></p>
		</div>

		<div class="content-grid videos-grid">
			<?php
			while ( $related_query->have_posts() ) :
				$related_query->the_post();
				$video_id      = get_the_ID();
				$video_title   = get_the_title();
				$permalink     = get_permalink();
				$video_tags    = get_the_terms( $video_id, 'post_tag' );
				$youtube_thumb = get_post_meta( $video_id, '_mrkwp_youtube_thumbnail_url', true );
				?>
				<article class="content-card">
					<?php if ( has_post_thumbnail( $video_id ) ) : ?>
						<a href="<?php echo esc_url( $permalink ); ?>" class="wp-block-post-featured-image" aria-label="<?php echo esc_attr( $video_title ); ?>">
							<?php
							echo get_the_post_thumbnail(
								$video_id,
								'medium_large',
								array(
									'loading' => 'lazy',
									'alt'     => esc_attr( $video_title ),
								)
							);
							?>
						</a>
					<?php elseif ( ! empty( $youtube_thumb ) ) : ?>
						<a href="<?php echo esc_url( $permalink ); ?>" class="wp-block-post-featured-image" aria-label="<?php echo esc_attr( $video_title ); ?>">
							<img src="<?php echo esc_url( $youtube_thumb ); ?>" alt="<?php echo esc_attr( $video_title ); ?>" loading="lazy" />
						</a>
					<?php else : ?>
						<a href="<?php echo esc_url( $permalink ); ?>" class="content-art art-video" aria-hidden="true">
							<span class="play-circle">▶</span>
						</a>
					<?php endif; ?>

					<div class="content-card-copy">
						<?php if ( ! empty( $video_tags ) && ! is_wp_error( $video_tags ) ) : ?>
							<div class="video-tags-row">
								<?php foreach ( array_slice( $video_tags, 0, 3 ) as $tag ) : ?>
									<a href="<?php echo esc_url( get_tag_link( $tag ) ); ?>"><?php echo esc_html( $tag->name ); ?></a>
								<?php endforeach; ?>
							</div>
						<?php endif; ?>

						<h3><a href="<?php echo esc_url( $permalink ); ?>"><?php echo esc_html( $video_title ); ?></a></h3>

						<div class="wp-block-post-date video-date">
							<time datetime="<?php echo esc_attr( (string) get_the_date( 'c', $video_id ) ); ?>"><?php echo esc_html( mrkwp_format_relative_days( $video_id ) ); ?></time>
						</div>

						<b><a href="<?php echo esc_url( $permalink ); ?>"><?php esc_html_e( 'Watch walkthrough', 'mrkwp' ); ?> <span aria-hidden="true">↗</span></a></b>
					</div>
				</article>
				<?php
			endwhile;
			wp_reset_postdata();
			?>
		</div>
	</section>
	<?php
	return ob_get_clean();
}

/**
 * Set default posts per page to 15 across all main queries (3-column layout standard).
 *
 * @param \WP_Query $query The WP_Query instance.
 */
function mrkwp_set_default_posts_per_page( \WP_Query $query ): void {
	if ( ! is_admin() && $query->is_main_query() ) {
		$query->set( 'posts_per_page', 15 );
	}
}
add_action( 'pre_get_posts', 'mrkwp_set_default_posts_per_page' );

/**
 * Filter pagination link arrows to ensure standard "← Previous" and "Next →" display.
 *
 * @param string               $block_content The block content.
 * @param array<string, mixed> $block         The parsed block.
 * @return string Filtered block content.
 */
function mrkwp_filter_pagination_arrows( string $block_content, array $block ): string {
	if ( empty( $block['blockName'] ) ) {
		return $block_content;
	}

	if ( 'core/query-pagination-previous' === $block['blockName'] ) {
		if ( false === strpos( $block_content, '←' ) && false === strpos( $block_content, '&larr;' ) ) {
			$block_content = preg_replace( '/(<a[^>]*class="[^"]*wp-block-query-pagination-previous[^"]*"[^>]*>)(.*?)(<\/a>)/i', '$1← $2$3', $block_content );
		}
	} elseif ( 'core/query-pagination-next' === $block['blockName'] ) {
		if ( false === strpos( $block_content, '→' ) && false === strpos( $block_content, '&rarr;' ) ) {
			$block_content = preg_replace( '/(<a[^>]*class="[^"]*wp-block-query-pagination-next[^"]*"[^>]*>)(.*?)(<\/a>)/i', '$1$2 →$3', $block_content );
		}
	}

	return $block_content;
}
add_filter( 'render_block', 'mrkwp_filter_pagination_arrows', 10, 2 );
