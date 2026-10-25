<?php
/**
 * Video Post Type Template Tags and Layout Helpers
 *
 * Provides accessible breadcrumbs with RankMath support and native fallback,
 * cleaned technical metadata, and video timeline output.
 *
 * @package MRK_WP
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Retrieve the estimated watch time string for a video post.
 *
 * Parses YouTube ISO 8601 duration (e.g. PT14M32S) or MM:SS from post meta,
 * falling back to an estimate based on post content word count.
 *
 * @param int $post_id Optional. Post ID. Defaults to current post.
 * @return string Formatted watch time, e.g. "15 min watch" or "1 hr 12 min watch".
 */
function mrkwp_get_video_watch_time( int $post_id = 0 ): string {
	$post_id = $post_id ? $post_id : get_the_ID();
	if ( ! $post_id ) {
		return __( '10 min watch', 'mrkwp' );
	}

	$raw_duration = (string) get_post_meta( $post_id, '_mrkwp_youtube_duration', true );
	$raw_duration = trim( $raw_duration );

	if ( ! empty( $raw_duration ) ) {
		// ISO 8601 duration: PT1H12M30S, PT14M30S, PT45S.
		if ( preg_match( '/^PT(?:(\d+)H)?(?:(\d+)M)?(?:(\d+)S)?$/i', $raw_duration, $matches ) ) {
			$hours   = ! empty( $matches[1] ) ? (int) $matches[1] : 0;
			$minutes = ! empty( $matches[2] ) ? (int) $matches[2] : 0;
			$seconds = ! empty( $matches[3] ) ? (int) $matches[3] : 0;

			if ( $seconds >= 30 ) {
				$minutes++;
			}

			if ( $hours > 0 ) {
				return sprintf(
					/* translators: 1: hours, 2: minutes */
					_n( '%1$d hr %2$d min watch', '%1$d hrs %2$d min watch', $hours, 'mrkwp' ),
					$hours,
					$minutes
				);
			}

			return sprintf(
				/* translators: %d: minutes */
				__( '%d min watch', 'mrkwp' ),
				max( 1, $minutes )
			);
		}

		// MM:SS or HH:MM:SS format.
		if ( preg_match( '/^(?:(\d+):)?(\d+):(\d+)$/', $raw_duration, $matches ) ) {
			$hours   = ! empty( $matches[1] ) ? (int) $matches[1] : 0;
			$minutes = (int) $matches[2];
			$seconds = (int) $matches[3];

			if ( $seconds >= 30 ) {
				$minutes++;
			}

			if ( $hours > 0 ) {
				return sprintf(
					/* translators: 1: hours, 2: minutes */
					__( '%1$d hr %2$d min watch', 'mrkwp' ),
					$hours,
					$minutes
				);
			}

			return sprintf(
				/* translators: %d: minutes */
				__( '%d min watch', 'mrkwp' ),
				max( 1, $minutes )
			);
		}
	}

	// Fallback: estimate from post content word count (average 180 words/min).
	$content    = get_post_field( 'post_content', $post_id );
	$word_count = str_word_count( wp_strip_all_tags( (string) $content ) );
	$minutes    = max( 6, (int) ceil( $word_count / 180 ) );

	return sprintf(
		/* translators: %d: minutes */
		__( '%d min watch', 'mrkwp' ),
		$minutes
	);
}

/**
 * Output or return accessible, semantic breadcrumb navigation.
 *
 * Checks for RankMath breadcrumbs (rank_math_get_breadcrumbs) and falls back to
 * a fully compliant Schema.org BreadcrumbList microdata trail.
 *
 * @param bool $echo Whether to echo or return the markup. Default true.
 * @return string Breadcrumbs HTML markup.
 */
function mrkwp_video_breadcrumbs( bool $echo = true ): string {
	$breadcrumbs_html = '';

	// 1. Check for RankMath breadcrumbs if plugin is active and enabled.
	if ( function_exists( 'rank_math_get_breadcrumbs' ) ) {
		$rm_output = rank_math_get_breadcrumbs();
		if ( ! empty( trim( (string) $rm_output ) ) ) {
			$breadcrumbs_html = sprintf(
				'<nav class="video-breadcrumbs video-breadcrumbs--rankmath" aria-label="%s">%s</nav>',
				esc_attr__( 'Breadcrumb navigation', 'mrkwp' ),
				$rm_output
			);
		}
	}

	// 2. Native Semantic Fallback with Schema.org Microdata.
	if ( empty( $breadcrumbs_html ) ) {
		$post_id   = get_the_ID();
		$home_url  = home_url( '/' );
		$home_text = __( 'Home', 'mrkwp' );

		$video_archive_url = get_post_type_archive_link( 'mrkwp_video' );
		if ( ! $video_archive_url ) {
			$video_archive_url = home_url( '/videos/' );
		}
		$video_archive_text = __( 'Videos', 'mrkwp' );

		$current_title = $post_id ? get_the_title( $post_id ) : __( 'Video', 'mrkwp' );

		// Check for primary category.
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
			'<nav class="video-breadcrumbs" aria-label="%1$s"><ol class="video-breadcrumbs__list" itemscope itemtype="https://schema.org/BreadcrumbList"><li class="video-breadcrumbs__item" itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem"><a class="video-breadcrumbs__link" href="%2$s" itemprop="item"><span itemprop="name">%3$s</span></a><meta itemprop="position" content="1" /></li><li class="video-breadcrumbs__separator" aria-hidden="true"><svg class="icon icon-chevron" width="12" height="12" viewBox="0 0 16 16" fill="none"><path d="M6 12L10 8L6 4" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/></svg></li><li class="video-breadcrumbs__item" itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem"><a class="video-breadcrumbs__link" href="%4$s" itemprop="item"><span itemprop="name">%5$s</span></a><meta itemprop="position" content="2" /></li>%6$s<li class="video-breadcrumbs__separator" aria-hidden="true"><svg class="icon icon-chevron" width="12" height="12" viewBox="0 0 16 16" fill="none"><path d="M6 12L10 8L6 4" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/></svg></li><li class="video-breadcrumbs__item video-breadcrumbs__item--current" aria-current="page" itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem"><span class="video-breadcrumbs__current" itemprop="name">%7$s</span><meta itemprop="position" content="%8$d" /></li></ol></nav>',
			esc_attr__( 'Breadcrumbs', 'mrkwp' ),
			esc_url( $home_url ),
			esc_html( $home_text ),
			esc_url( $video_archive_url ),
			esc_html( $video_archive_text ),
			$category_item,
			esc_html( $current_title ),
			$position
		);
	}

	if ( $echo ) {
		echo $breadcrumbs_html; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
	}

	return $breadcrumbs_html;
}

/**
 * Output or return the streamlined technical metadata bar.
 * Divider bullet, author box, and 4K pill removed. Tags are aligned right.
 *
 * @param int  $post_id Optional. Post ID.
 * @param bool $echo    Whether to echo or return. Default true.
 * @return string HTML output.
 */
function mrkwp_video_meta_bar( int $post_id = 0, bool $echo = true ): string {
	$post_id = $post_id ? $post_id : get_the_ID();
	if ( ! $post_id ) {
		return '';
	}

	$relative_date = function_exists( 'mrkwp_format_relative_days' )
		? mrkwp_format_relative_days( $post_id )
		: human_time_diff( (int) get_post_time( 'U', true, $post_id ) ) . ' ago';
	$iso_date     = get_the_date( 'c', $post_id );
	$display_date = get_the_date( 'M j, Y', $post_id );
	$watch_time   = mrkwp_get_video_watch_time( $post_id );

	$terms = get_the_terms( $post_id, 'post_tag' );
	if ( empty( $terms ) || is_wp_error( $terms ) ) {
		$terms = get_the_terms( $post_id, 'category' );
	}

	$tags_html = '';
	if ( ! empty( $terms ) && ! is_wp_error( $terms ) ) {
		$tags_html .= '<div class="video-meta-bar__tags" aria-label="' . esc_attr__( 'Video Topics', 'mrkwp' ) . '">';
		foreach ( array_slice( $terms, 0, 4 ) as $term ) {
			$term_link  = get_term_link( $term );
			$tags_html .= sprintf(
				'<a href="%s" class="video-meta-tag"><span class="video-meta-tag__prefix">#</span>%s</a>',
				esc_url( is_wp_error( $term_link ) ? '#' : $term_link ),
				esc_html( $term->name )
			);
		}
		$tags_html .= '</div>';
	}

	$markup = sprintf(
		'<div class="video-meta-bar"><div class="video-meta-bar__primary"><div class="video-meta-item video-meta-item--date"><svg class="icon icon-calendar" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect><line x1="16" y1="2" x2="16" y2="6"></line><line x1="8" y1="2" x2="8" y2="6"></line><line x1="3" y1="10" x2="21" y2="10"></line></svg><time datetime="%1$s" title="%2$s">%3$s</time></div><div class="video-meta-item video-meta-item--duration"><svg class="icon icon-clock" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><circle cx="12" cy="12" r="10"></circle><polyline points="12 6 12 12 16 14"></polyline></svg><span>%4$s</span></div></div>%5$s</div>',
		esc_attr( $iso_date ),
		esc_attr( $display_date ),
		esc_html( $relative_date ),
		esc_html( $watch_time ),
		$tags_html
	);

	if ( $echo ) {
		echo $markup; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
	}

	return $markup;
}

/**
 * Extract or generate timestamped chapter markers for a video post.
 *
 * @param int $post_id Post ID.
 * @return array<int, array{time: string, title: string}> Array of chapters.
 */
function mrkwp_extract_video_chapters( int $post_id = 0 ): array {
	$post_id  = $post_id ? $post_id : get_the_ID();
	$content  = get_post_field( 'post_content', $post_id );
	$chapters = array();

	// Look for lines like "00:00 - Introduction" or "01:23 Topic" or "0:00 Intro".
	if ( ! empty( $content ) && preg_match_all( '/^(?:<p>)?\s*(\d{1,2}:\d{2}(?::\d{2})?)\s*[-–—:]?\s*(.+?)(?:<\/p>)?$/m', $content, $matches, PREG_SET_ORDER ) ) {
		foreach ( $matches as $match ) {
			$title = trim( wp_strip_all_tags( $match[2] ) );
			if ( ! empty( $title ) ) {
				$chapters[] = array(
					'time'  => sanitize_text_field( $match[1] ),
					'title' => $title,
				);
			}
		}
	}

	// Default structured chapters if none parsed from post content.
	if ( empty( $chapters ) ) {
		$chapters = array(
			array( 'time' => '00:00', 'title' => __( 'Overview & System Architecture', 'mrkwp' ) ),
			array( 'time' => '02:30', 'title' => __( 'Configuration & Implementation', 'mrkwp' ) ),
			array( 'time' => '06:45', 'title' => __( 'Testing, Benchmarks & Validation', 'mrkwp' ) ),
			array( 'time' => '11:20', 'title' => __( 'Production Rollout & Next Steps', 'mrkwp' ) ),
		);
	}

	return $chapters;
}

/**
 * Output or return the static "Video Timeline" section.
 * Chevron removed; open/visible at all times; sits directly inside the single details box.
 *
 * @param int  $post_id Optional. Post ID.
 * @param bool $echo    Whether to echo or return. Default true.
 * @return string HTML output.
 */
function mrkwp_video_chapters( int $post_id = 0, bool $echo = true ): string {
	$post_id  = $post_id ? $post_id : get_the_ID();
	$chapters = mrkwp_extract_video_chapters( $post_id );

	$list_items = '';
	foreach ( $chapters as $chapter ) {
		$list_items .= sprintf(
			'<li class="video-chapters-list__item"><span class="video-chapter-timestamp">%s</span><span class="video-chapter-label">%s</span></li>',
			esc_html( $chapter['time'] ),
			esc_html( $chapter['title'] )
		);
	}

	$markup = sprintf(
		'<div class="video-timeline-section"><h3 class="video-timeline-title">%s</h3><ul class="video-chapters-list">%s</ul></div>',
		esc_html__( 'Video Timeline', 'mrkwp' ),
		$list_items
	);

	if ( $echo ) {
		echo $markup; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
	}

	return $markup;
}

/**
 * Register shortcodes for embedding inside Gutenberg templates or blocks.
 */
function mrkwp_register_video_shortcodes(): void {
	add_shortcode( 'mrkwp_video_breadcrumbs', 'mrkwp_video_breadcrumbs_shortcode' );
	add_shortcode( 'mrkwp_video_meta_bar', 'mrkwp_video_meta_bar_shortcode' );
	add_shortcode( 'mrkwp_video_chapters', 'mrkwp_video_chapters_shortcode' );
}
add_action( 'init', 'mrkwp_register_video_shortcodes' );

function mrkwp_video_breadcrumbs_shortcode(): string {
	return mrkwp_video_breadcrumbs( false );
}

function mrkwp_video_meta_bar_shortcode(): string {
	return mrkwp_video_meta_bar( 0, false );
}

function mrkwp_video_chapters_shortcode(): string {
	return mrkwp_video_chapters( 0, false );
}
