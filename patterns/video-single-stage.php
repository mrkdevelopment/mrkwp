<?php
/**
 * Title: Video Single Stage
 * Slug: mrkwp/video-single-stage
 * Categories: featured
 * Description: Editorial single video hero stage, technical metadata, chapter markers, and narrow reading layout.
 *
 * @package MRK_WP
 */

?>
<!-- wp:group {"tagName":"article","className":"video-single-narrow-wrap"} -->
<article class="wp-block-group video-single-narrow-wrap">
	<!-- wp:shortcode -->
	[mrkwp_video_breadcrumbs]
	<!-- /wp:shortcode -->

	<!-- wp:group {"tagName":"header","className":"video-hero-header"} -->
	<header class="wp-block-group video-hero-header">
		<!-- wp:post-title {"level":1,"className":"video-hero-header__title"} /-->

		<!-- wp:shortcode -->
		[mrkwp_video_meta_bar]
		<!-- /wp:shortcode -->
	</header>
	<!-- /wp:group -->

	<!-- wp:group {"tagName":"div","className":"video-hero-stage"} -->
	<div class="wp-block-group video-hero-stage">
		<!-- wp:mrkwp/video-player /-->
	</div>
	<!-- /wp:group -->

	<!-- wp:shortcode -->
	[mrkwp_video_chapters]
	<!-- /wp:shortcode -->

	<!-- wp:heading {"level":2,"className":"video-description-title"} -->
	<h2 class="wp-block-heading video-description-title">Video Description</h2>
	<!-- /wp:heading -->

	<!-- wp:post-content {"className":"video-description","layout":{"type":"constrained"}} /-->

	<!-- wp:mrkwp/youtube-channel-cta {"variation":"horizontal"} /-->
</article>
<!-- /wp:group -->

<!-- wp:mrkwp/related-videos /-->
