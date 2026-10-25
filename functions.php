<?php
/**
 * MRK WP Theme functions and definitions
 *
 * @package MRK_WP
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

define( 'MRKWP_VERSION', '1.0.6' );
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

	// Gutenberg Block Editor Styles, Align Wide & FSE Template Parts.
	add_theme_support( 'align-wide' );
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

	// Enqueue dynamic Table of Contents script on single blog articles.
	if ( is_singular( 'post' ) || is_singular( 'wp-product' ) ) {
		wp_enqueue_script( 'mrkwp-toc', MRKWP_THEME_URI . '/js/toc.js', array(), MRKWP_VERSION, array( 'strategy' => 'defer' ) );
	}

	// Archive progressive pagination (Load More on Desktop / Infinite Scroll on Mobile).
	if ( is_archive() || is_home() || is_search() || is_post_type_archive( 'mrkwp_video' ) || is_post_type_archive( 'mrkwp_short' ) ) {
		wp_enqueue_script( 'mrkwp-archive-pagination', MRKWP_THEME_URI . '/js/archive-pagination.js', array(), MRKWP_VERSION, array( 'strategy' => 'defer' ) );
	}

	// Dequeue generic block styles on the custom coded frontend.
	wp_dequeue_style( 'wp-block-library' );
	wp_dequeue_style( 'wp-block-library-theme' );
	wp_dequeue_style( 'classic-theme-styles' );
}
add_action( 'wp_enqueue_scripts', 'mrkwp_scripts' );



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
 * Set default posts per page to 15 across all main queries (3-column layout standard)
 * and ensure video posts are included in category/tag archive queries.
 *
 * @param \WP_Query $query The WP_Query instance.
 */
function mrkwp_set_default_posts_per_page( \WP_Query $query ): void {
	if ( ! is_admin() && $query->is_main_query() ) {
		$query->set( 'posts_per_page', 15 );

		if ( $query->is_category() || $query->is_tag() ) {
			$post_types = (array) $query->get( 'post_type' );
			if ( empty( $post_types ) || array( 'post' ) === $post_types ) {
				$query->set( 'post_type', array( 'post', 'mrkwp_video' ) );
			}
		}
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

/**
 * Load video template tags and layout helpers.
 */
require_once MRKWP_THEME_DIR . '/inc/video-template-tags.php';

/**
 * Load single post template tags and layout helpers.
 */
require_once MRKWP_THEME_DIR . '/inc/post-template-tags.php';


