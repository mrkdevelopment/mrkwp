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
	$home_url  = home_url( '/' );
	$home_text = __( 'Home', 'mrkwp' );
	$post_type = $post_id ? get_post_type( $post_id ) : get_post_type();

	if ( 'wp-product' === $post_type ) {
		$parent_url   = get_post_type_archive_link( 'wp-product' );
		if ( ! $parent_url ) {
			$parent_url = home_url( '/wp-products/' );
		}
		$parent_title = __( 'Products', 'mrkwp' );
	} elseif ( 'post' === $post_type || empty( $post_type ) ) {
		$blog_page_id = (int) get_option( 'page_for_posts' );
		$parent_url   = $blog_page_id ? get_permalink( $blog_page_id ) : home_url( '/articles/' );
		$parent_title = $blog_page_id ? get_the_title( $blog_page_id ) : __( 'Articles', 'mrkwp' );
	} else {
		$type_obj     = get_post_type_object( $post_type );
		$parent_url   = get_post_type_archive_link( $post_type );
		if ( ! $parent_url ) {
			$parent_url = home_url( '/' . $post_type . '/' );
		}
		$parent_title = $type_obj ? $type_obj->labels->name : __( 'Archive', 'mrkwp' );
	}

	$current_title = $post_id ? get_the_title( $post_id ) : '';
	if ( mb_strlen( $current_title ) > 42 ) {
		$current_title = mb_substr( $current_title, 0, 40 ) . '…';
	}

	$breadcrumbs_html = sprintf(
		'<nav class="video-breadcrumbs breadcrumbs post-breadcrumbs" aria-label="%1$s"><ol class="video-breadcrumbs__list" itemscope itemtype="https://schema.org/BreadcrumbList"><li class="video-breadcrumbs__item" itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem"><a class="video-breadcrumbs__link" href="%2$s" itemprop="item"><span itemprop="name">%3$s</span></a><meta itemprop="position" content="1" /></li><li class="video-breadcrumbs__separator" aria-hidden="true"><svg class="icon icon-chevron" width="12" height="12" viewBox="0 0 16 16" fill="none"><path d="M6 12L10 8L6 4" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/></svg></li><li class="video-breadcrumbs__item" itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem"><a class="video-breadcrumbs__link" href="%4$s" itemprop="item"><span itemprop="name">%5$s</span></a><meta itemprop="position" content="2" /></li><li class="video-breadcrumbs__separator" aria-hidden="true"><svg class="icon icon-chevron" width="12" height="12" viewBox="0 0 16 16" fill="none"><path d="M6 12L10 8L6 4" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/></svg></li><li class="video-breadcrumbs__item video-breadcrumbs__item--current" aria-current="page" itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem"><span class="video-breadcrumbs__current" itemprop="name">%6$s</span><meta itemprop="position" content="3" /></li></ol></nav>',
		esc_attr__( 'Breadcrumbs', 'mrkwp' ),
		esc_url( $home_url ),
		esc_html( $home_text ),
		esc_url( $parent_url ),
		esc_html( $parent_title ),
		esc_html( $current_title )
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
			$tags_html .= sprintf(
				'<span class="video-meta-tag post-meta-tag"><span class="video-meta-tag__prefix">#</span>%s</span>',
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
 * Output or return the Related Posts section markup for single blog posts.
 * Matches the design language and grid structure of the Related Videos section.
 *
 * @param int  $post_id Optional. Post ID. Defaults to current post.
 * @param bool $echo    Whether to echo or return HTML. Default true.
 * @return string HTML output.
 */
function mrkwp_related_posts( int $post_id = 0, bool $echo = true ): string {
	$current_id = $post_id ? $post_id : get_the_ID();
	if ( ! $current_id ) {
		return '';
	}

	$category_ids = wp_get_post_categories( $current_id );
	if ( is_wp_error( $category_ids ) ) {
		$category_ids = array();
	}

	$tag_ids = wp_get_post_tags( $current_id, array( 'fields' => 'ids' ) );
	if ( is_wp_error( $tag_ids ) ) {
		$tag_ids = array();
	}

	$related_ids = array();

	// 1. Primary query: Posts sharing category OR post_tag, ordered by date DESC.
	if ( ! empty( $category_ids ) || ! empty( $tag_ids ) ) {
		$tax_query = array();

		if ( ! empty( $category_ids ) ) {
			$tax_query[] = array(
				'taxonomy' => 'category',
				'field'    => 'term_id',
				'terms'    => $category_ids,
			);
		}

		if ( ! empty( $tag_ids ) ) {
			$tax_query[] = array(
				'taxonomy' => 'post_tag',
				'field'    => 'term_id',
				'terms'    => $tag_ids,
			);
		}

		if ( count( $tax_query ) > 1 ) {
			$tax_query['relation'] = 'OR';
		}

		$rel_query = new WP_Query(
			array(
				'post_type'      => 'post',
				'post_status'    => 'publish',
				'posts_per_page' => 3,
				'post__not_in'   => array( $current_id ),
				'tax_query'      => $tax_query, // phpcs:ignore WordPress.DB.SlowDBQuery.slow_db_query_tax_query
				'orderby'        => 'date',
				'order'          => 'DESC',
				'fields'         => 'ids',
				'no_found_rows'  => true,
			)
		);

		if ( ! empty( $rel_query->posts ) ) {
			$related_ids = array_map( 'intval', $rel_query->posts );
		}
	}

	// 2. Backfill query: Most recent published posts if fewer than 3 were found.
	$needed = 3 - count( $related_ids );
	if ( $needed > 0 ) {
		$exclude        = array_merge( array( $current_id ), $related_ids );
		$backfill_query = new WP_Query(
			array(
				'post_type'      => 'post',
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
			'post_type'      => 'post',
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
	<section class="wrap section related-posts-section" aria-label="<?php esc_attr_e( 'Related Posts', 'mrkwp' ); ?>">
		<div class="section-heading">
			<div>
				<p class="eyebrow"><?php esc_html_e( 'More Articles', 'mrkwp' ); ?></p>
				<h2><?php esc_html_e( 'Related Posts', 'mrkwp' ); ?></h2>
			</div>
			<p><?php esc_html_e( 'Continue reading tutorials, guides, and engineering insights related to this article.', 'mrkwp' ); ?></p>
		</div>

		<div class="content-grid posts-grid">
			<?php
			while ( $related_query->have_posts() ) :
				$related_query->the_post();
				if ( class_exists( '\MrkWp\Core\Blocks\PostCardBlock' ) ) {
					echo \MrkWp\Core\Blocks\PostCardBlock::render_card( (int) get_the_ID() ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- Pre-escaped post card component.
				} else {
					$fallback_id    = (int) get_the_ID();
					$fallback_title = get_the_title( $fallback_id );
					$fallback_link  = get_permalink( $fallback_id );
					$fallback_thumb = has_post_thumbnail( $fallback_id ) ? get_the_post_thumbnail_url( $fallback_id, 'large' ) : '';
					$fallback_cats  = get_the_category( $fallback_id );
					$fallback_cat   = ! empty( $fallback_cats ) && ! is_wp_error( $fallback_cats ) ? strtoupper( $fallback_cats[0]->name ) : 'WORDPRESS';
					$fallback_diff  = human_time_diff( (int) get_the_time( 'U', $fallback_id ), (int) current_time( 'timestamp' ) );
					?>
					<article class="mrkwp-post-card">
						<a href="<?php echo esc_url( $fallback_link ); ?>" class="mrkwp-post-card__thumb" aria-label="<?php echo esc_attr( $fallback_title ); ?>">
							<?php if ( ! empty( $fallback_thumb ) ) : ?>
								<img class="mrkwp-post-card__img" src="<?php echo esc_url( $fallback_thumb ); ?>" alt="<?php echo esc_attr( $fallback_title ); ?>" loading="lazy" decoding="async">
							<?php else : ?>
								<div class="mrkwp-post-card__thumb-fallback" aria-hidden="true"><?php echo esc_html( mb_substr( $fallback_title, 0, 2 ) ); ?></div>
							<?php endif; ?>
						</a>
						<div class="mrkwp-post-card__body">
							<span class="mrkwp-post-card__chip"><?php echo esc_html( $fallback_cat ); ?></span>
							<h3 class="mrkwp-post-card__title">
								<a href="<?php echo esc_url( $fallback_link ); ?>"><?php echo esc_html( $fallback_title ); ?></a>
							</h3>
							<hr class="mrkwp-post-card__divider" aria-hidden="true">
							<div class="mrkwp-post-card__footer">
								<a href="<?php echo esc_url( $fallback_link ); ?>" class="mrkwp-post-card__action">
									<?php esc_html_e( 'Read article', 'mrkwp' ); ?>
									<svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><line x1="7" y1="17" x2="17" y2="7"/><polyline points="7 7 17 7 17 17"/></svg>
								</a>
								<span class="mrkwp-post-card__date"><?php echo esc_html( sprintf( /* translators: %s: relative time */ __( 'Posted %s ago', 'mrkwp' ), $fallback_diff ) ); ?></span>
							</div>
						</div>
					</article>
					<?php
				}
			endwhile;
			wp_reset_postdata();
			?>
		</div>
	</section>
	<?php
	$output = (string) ob_get_clean();

	// Clean whitespace between HTML tags to prevent wpautop from injecting stray <p> or <br> tags.
	$output = preg_replace( '/>\s+</', '><', $output );

	if ( $echo ) {
		echo $output; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
	}

	return $output;
}

/**
 * Register shortcodes for embedding inside Gutenberg templates or patterns.
 */
function mrkwp_register_post_shortcodes(): void {
	add_shortcode( 'mrkwp_post_breadcrumbs', 'mrkwp_post_breadcrumbs_shortcode' );
	add_shortcode( 'mrkwp_product_breadcrumbs', 'mrkwp_post_breadcrumbs_shortcode' );
	add_shortcode( 'mrkwp_post_meta_bar', 'mrkwp_post_meta_bar_shortcode' );
	add_shortcode( 'mrkwp_post_toc', 'mrkwp_post_toc_shortcode' );
	add_shortcode( 'mrkwp_related_posts', 'mrkwp_related_posts_shortcode' );

	if ( function_exists( 'register_block_type' ) && class_exists( 'WP_Block_Type_Registry' ) ) {
		if ( ! \WP_Block_Type_Registry::get_instance()->is_registered( 'mrkwp/related-posts' ) ) {
			register_block_type(
				'mrkwp/related-posts',
				array(
					'title'           => __( 'Related Posts', 'mrkwp' ),
					'category'        => 'theme',
					'render_callback' => 'mrkwp_related_posts_shortcode',
					'supports'        => array(
						'html' => false,
					),
				)
			);
		}
	}
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

function mrkwp_related_posts_shortcode(): string {
	return mrkwp_related_posts( 0, false );
}

/**
 * Filter Rank Math breadcrumbs for wp-product to ensure the crumb resolves to "Products".
 *
 * @param array $crumbs Breadcrumb items.
 * @return array Filtered breadcrumb items.
 */
function mrkwp_filter_rank_math_product_breadcrumbs( array $crumbs ): array {
	if ( is_singular( 'wp-product' ) ) {
		$archive_url = get_post_type_archive_link( 'wp-product' );
		if ( ! $archive_url ) {
			$archive_url = home_url( '/wp-products/' );
		}
		$archive_title = __( 'Products', 'mrkwp' );

		if ( count( $crumbs ) === 2 ) {
			// [0 => Home, 1 => Product Title] -> insert Products in the middle.
			array_splice( $crumbs, 1, 0, array( array( $archive_title, $archive_url ) ) );
		} elseif ( count( $crumbs ) >= 3 ) {
			// [0 => Home, 1 => Archive/Tax, 2 => Product Title] -> ensure label is "Products" and url is archive.
			$crumbs[1][0] = $archive_title;
			$crumbs[1][1] = $archive_url;
		}
	}

	return $crumbs;
}
add_filter( 'rank_math/frontend/breadcrumb/items', 'mrkwp_filter_rank_math_product_breadcrumbs', 10, 1 );

/**
 * Filter Yoast SEO breadcrumbs for wp-product to ensure the crumb resolves to "Products".
 *
 * @param array $links Breadcrumb links.
 * @return array Filtered breadcrumb links.
 */
function mrkwp_filter_yoast_product_breadcrumbs( array $links ): array {
	if ( is_singular( 'wp-product' ) ) {
		$archive_url = get_post_type_archive_link( 'wp-product' );
		if ( ! $archive_url ) {
			$archive_url = home_url( '/wp-products/' );
		}
		$archive_title = __( 'Products', 'mrkwp' );

		if ( count( $links ) === 2 ) {
			array_splice( $links, 1, 0, array( array( 'text' => $archive_title, 'url' => $archive_url ) ) );
		} elseif ( count( $links ) >= 3 ) {
			$links[1]['text'] = $archive_title;
			$links[1]['url']  = $archive_url;
		}
	}

	return $links;
}
add_filter( 'wpseo_breadcrumb_links', 'mrkwp_filter_yoast_product_breadcrumbs', 10, 1 );

