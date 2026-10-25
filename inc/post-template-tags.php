<?php
/**
 * Single Blog Post Template Tags and Layout Helpers
 *
 * Provides accessible breadcrumbs, technical editorial metadata bar (reading time,
 * date, category/tags), and Table of Contents container markup matching the
 * video header segment design language.
 *
 * @package MRK_WP
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Calculate the estimated reading time string for a post based on word count.
 *
 * @param int $post_id Optional. Post ID. Defaults to current post.
 * @return string Formatted reading time, e.g. "4 min read".
 */
function mrkwp_get_post_reading_time( int $post_id = 0 ): string {
	$post_id = $post_id ? $post_id : get_the_ID();
	if ( ! $post_id ) {
		return __( '3 min read', 'mrkwp' );
	}

	$content = get_post_field( 'post_content', $post_id );
	if ( empty( $content ) ) {
		return __( '1 min read', 'mrkwp' );
	}

	$clean_content = wp_strip_all_tags( $content );
	$word_count    = str_word_count( $clean_content );
	$minutes       = (int) ceil( $word_count / 200 );

	return sprintf(
		/* translators: %d: number of minutes */
		_n( '%d min read', '%d min read', max( 1, $minutes ), 'mrkwp' ),
		max( 1, $minutes )
	);
}

/**
 * Output or return accessible schema.org breadcrumbs for blog articles.
 * Matches the video header breadcrumbs markup and class hierarchy.
 *
 * @param bool $echo Whether to echo or return HTML. Default true.
 * @return string Breadcrumbs HTML markup.
 */
function mrkwp_post_breadcrumbs( bool $echo = true ): string {
	$post_id = get_the_ID();

	// Support Rank Math breadcrumbs if enabled.
	if ( function_exists( 'rank_math_the_breadcrumbs' ) ) {
		ob_start();
		rank_math_the_breadcrumbs();
		$rank_math_html = ob_get_clean();
		if ( ! empty( $rank_math_html ) ) {
			if ( $echo ) {
				echo $rank_math_html; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
			}
			return $rank_math_html;
		}
	}

	// Support Yoast breadcrumbs if enabled.
	if ( function_exists( 'yoast_breadcrumb' ) ) {
		$yoast_html = yoast_breadcrumb( '<nav class="video-breadcrumbs breadcrumbs post-breadcrumbs" aria-label="' . esc_attr__( 'Breadcrumbs', 'mrkwp' ) . '">', '</nav>', false );
		if ( ! empty( $yoast_html ) ) {
			if ( $echo ) {
				echo $yoast_html; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
			}
			return $yoast_html;
		}
	}

	// Native MRK WP accessible breadcrumbs fallback (identical structure to video-template-tags.php).
	$home_url     = home_url( '/' );
	$home_text    = __( 'Home', 'mrkwp' );
	$blog_page_id = (int) get_option( 'page_for_posts' );
	$blog_url     = $blog_page_id ? get_permalink( $blog_page_id ) : home_url( '/articles/' );
	$blog_title   = $blog_page_id ? get_the_title( $blog_page_id ) : __( 'Articles', 'mrkwp' );

	$current_title = $post_id ? get_the_title( $post_id ) : '';
	if ( mb_strlen( $current_title ) > 42 ) {
		$current_title = mb_substr( $current_title, 0, 40 ) . '…';
	}

	$category_item = '';
	$position      = 3;

	if ( $post_id ) {
		$categories = get_the_category( $post_id );
		if ( ! empty( $categories ) && ! is_wp_error( $categories ) ) {
			$primary_cat   = $categories[0];
			$category_link = get_category_link( $primary_cat->term_id );
			$category_name = $primary_cat->name;

			$category_item = sprintf(
				'<li class="video-breadcrumbs__separator" aria-hidden="true"><svg class="icon icon-chevron" width="12" height="12" viewBox="0 0 16 16" fill="none"><path d="M6 12L10 8L6 4" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/></svg></li><li class="video-breadcrumbs__item" itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem"><a class="video-breadcrumbs__link" href="%s" itemprop="item"><span itemprop="name">%s</span></a><meta itemprop="position" content="3" /></li>',
				esc_url( $category_link ),
				esc_html( $category_name )
			);
			$position = 4;
		}
	}

	$breadcrumbs_html = sprintf(
		'<nav class="video-breadcrumbs breadcrumbs post-breadcrumbs" aria-label="%1$s"><ol class="video-breadcrumbs__list" itemscope itemtype="https://schema.org/BreadcrumbList"><li class="video-breadcrumbs__item" itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem"><a class="video-breadcrumbs__link" href="%2$s" itemprop="item"><span itemprop="name">%3$s</span></a><meta itemprop="position" content="1" /></li><li class="video-breadcrumbs__separator" aria-hidden="true"><svg class="icon icon-chevron" width="12" height="12" viewBox="0 0 16 16" fill="none"><path d="M6 12L10 8L6 4" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/></svg></li><li class="video-breadcrumbs__item" itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem"><a class="video-breadcrumbs__link" href="%4$s" itemprop="item"><span itemprop="name">%5$s</span></a><meta itemprop="position" content="2" /></li>%6$s<li class="video-breadcrumbs__separator" aria-hidden="true"><svg class="icon icon-chevron" width="12" height="12" viewBox="0 0 16 16" fill="none"><path d="M6 12L10 8L6 4" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/></svg></li><li class="video-breadcrumbs__item video-breadcrumbs__item--current" aria-current="page" itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem"><span class="video-breadcrumbs__current" itemprop="name">%7$s</span><meta itemprop="position" content="%8$d" /></li></ol></nav>',
		esc_attr__( 'Breadcrumbs', 'mrkwp' ),
		esc_url( $home_url ),
		esc_html( $home_text ),
		esc_url( $blog_url ),
		esc_html( $blog_title ),
		$category_item,
		esc_html( $current_title ),
		$position
	);

	if ( $echo ) {
		echo $breadcrumbs_html; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
	}

	return $breadcrumbs_html;
}

/**
 * Output or return the technical metadata bar for blog articles.
 * Matches the video header metadata bar structure, SVGs, and classes.
 *
 * @param int  $post_id Optional. Post ID.
 * @param bool $echo    Whether to echo or return. Default true.
 * @return string HTML output.
 */
function mrkwp_post_meta_bar( int $post_id = 0, bool $echo = true ): string {
	$post_id = $post_id ? $post_id : get_the_ID();
	if ( ! $post_id ) {
		return '';
	}

	$relative_date = function_exists( 'mrkwp_format_relative_days' )
		? mrkwp_format_relative_days( $post_id )
		: human_time_diff( (int) get_post_time( 'U', true, $post_id ) ) . ' ' . __( 'ago', 'mrkwp' );
	$iso_date     = get_the_date( 'c', $post_id );
	$display_date = get_the_date( 'M j, Y', $post_id );
	$reading_time = mrkwp_get_post_reading_time( $post_id );

	$terms = get_the_terms( $post_id, 'post_tag' );
	if ( empty( $terms ) || is_wp_error( $terms ) ) {
		$terms = get_the_terms( $post_id, 'category' );
	}

	$tags_html = '';
	if ( ! empty( $terms ) && ! is_wp_error( $terms ) ) {
		$tags_html .= '<div class="video-meta-bar__tags post-meta-bar__tags" aria-label="' . esc_attr__( 'Article Topics', 'mrkwp' ) . '">';
		foreach ( array_slice( $terms, 0, 4 ) as $term ) {
			$term_link  = get_term_link( $term );
			$tags_html .= sprintf(
				'<a href="%s" class="video-meta-tag post-meta-tag"><span class="video-meta-tag__prefix">#</span>%s</a>',
				esc_url( is_wp_error( $term_link ) ? '#' : $term_link ),
				esc_html( $term->name )
			);
		}
		$tags_html .= '</div>';
	}

	$markup = sprintf(
		'<div class="video-meta-bar post-meta-bar"><div class="video-meta-bar__primary post-meta-bar__primary"><div class="video-meta-item video-meta-item--date"><svg class="icon icon-calendar" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect><line x1="16" y1="2" x2="16" y2="6"></line><line x1="8" y1="2" x2="8" y2="6"></line><line x1="3" y1="10" x2="21" y2="10"></line></svg><time datetime="%1$s" title="%2$s">%3$s</time></div><div class="video-meta-item video-meta-item--duration post-meta-item--reading-time"><svg class="icon icon-clock" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><circle cx="12" cy="12" r="10"></circle><polyline points="12 6 12 12 16 14"></polyline></svg><span>%4$s</span></div></div>%5$s</div>',
		esc_attr( $iso_date ),
		esc_attr( $display_date ),
		esc_html( $relative_date ),
		esc_html( $reading_time ),
		$tags_html
	);

	if ( $echo ) {
		echo $markup; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
	}

	return $markup;
}

/**
 * Output or return the Table of Contents container widget.
 * Self-populated dynamically via JavaScript.
 *
 * @param bool $echo Whether to echo or return. Default true.
 * @return string HTML output.
 */
function mrkwp_post_toc_widget( bool $echo = true ): string {
	$markup = '<nav id="post-toc" class="post-toc-widget" aria-label="' . esc_attr__( 'Table of Contents', 'mrkwp' ) . '">
		<div class="post-toc-header">
			<button type="button" class="post-toc-toggle" aria-expanded="false" aria-controls="post-toc-body">
				<span class="post-toc-header-main">
					<svg class="icon icon-toc" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
						<line x1="8" y1="6" x2="21" y2="6"></line>
						<line x1="8" y1="12" x2="21" y2="12"></line>
						<line x1="8" y1="18" x2="21" y2="18"></line>
						<line x1="3" y1="6" x2="3.01" y2="6"></line>
						<line x1="3" y1="12" x2="3.01" y2="12"></line>
						<line x1="3" y1="18" x2="3.01" y2="18"></line>
					</svg>
					<span class="post-toc-title">' . esc_html__( 'Table of Contents', 'mrkwp' ) . '</span>
				</span>
				<span class="post-toc-badge" aria-hidden="true"></span>
				<svg class="icon icon-chevron-down" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
					<polyline points="6 9 12 15 18 9"></polyline>
				</svg>
			</button>
		</div>
		<div id="post-toc-body" class="post-toc-body">
			<ol class="post-toc-list" id="post-toc-list"></ol>
		</div>
	</nav>';

	if ( $echo ) {
		echo $markup; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
	}

	return $markup;
}

/**
 * Register shortcodes for embedding inside Gutenberg templates or patterns.
 */
function mrkwp_register_post_shortcodes(): void {
	add_shortcode( 'mrkwp_post_breadcrumbs', 'mrkwp_post_breadcrumbs_shortcode' );
	add_shortcode( 'mrkwp_post_meta_bar', 'mrkwp_post_meta_bar_shortcode' );
	add_shortcode( 'mrkwp_post_toc', 'mrkwp_post_toc_shortcode' );
}
add_action( 'init', 'mrkwp_register_post_shortcodes' );

function mrkwp_post_breadcrumbs_shortcode(): string {
	return mrkwp_post_breadcrumbs( false );
}

function mrkwp_post_meta_bar_shortcode(): string {
	return mrkwp_post_meta_bar( 0, false );
}

function mrkwp_post_toc_shortcode(): string {
	return mrkwp_post_toc_widget( false );
}
