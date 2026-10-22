<?php
/**
 * Title: Path Section
 * Slug: mrkwp/path-section
 * Categories: featured, call-to-action
 * Description: Three pathways: Community, Advisory, and Resources.
 * Keywords: path, steps, community, advisory, resources
 *
 * @package MRK_WP
 */

?>
<!-- wp:group {"tagName":"section","metadata":{"name":"Path Section"},"className":"path-section wrap","layout":{"type":"default"}} -->
<section class="wp-block-group path-section wrap">
	<!-- wp:group {"className":"section-heading","layout":{"type":"flex","flexWrap":"nowrap","justifyContent":"space-between","verticalAlignment":"bottom"}} -->
	<div class="wp-block-group section-heading">
		<!-- wp:group {"layout":{"type":"default"}} -->
		<div class="wp-block-group">
			<!-- wp:paragraph {"className":"eyebrow"} -->
			<p class="eyebrow"><?php esc_html_e( 'Choose your next step', 'mrkwp' ); ?></p>
			<!-- /wp:paragraph -->

			<!-- wp:heading {"level":2} -->
			<h2><?php echo wp_kses( __( 'Learn together.<br>Build with purpose.', 'mrkwp' ), array( 'br' => array() ) ); ?></h2>
			<!-- /wp:heading -->
		</div>
		<!-- /wp:group -->

		<!-- wp:paragraph -->
		<p><?php echo wp_kses( __( 'Some days you need a useful tutorial.<br>Other days, a fresh pair of eyes.<br>There’s a place for both here.', 'mrkwp' ), array( 'br' => array() ) ); ?></p>
		<!-- /wp:paragraph -->
	</div>
	<!-- /wp:group -->

	<!-- wp:group {"className":"path-grid","layout":{"type":"default"}} -->
	<div class="wp-block-group path-grid">
		<!-- wp:html -->
		<a class="path-card path-community" href="<?php echo esc_url( home_url( '/community/' ) ); ?>">
			<div class="path-symbol" aria-hidden="true"><span>you</span><span>+</span><span>us</span></div>
			<h3><?php esc_html_e( 'Find your people.', 'mrkwp' ); ?></h3>
			<p><?php esc_html_e( 'A free community for curious people making WordPress and AI work in the real world.', 'mrkwp' ); ?></p>
			<b><?php esc_html_e( 'Explore the community', 'mrkwp' ); ?> <span>↗</span></b>
		</a>
		<a class="path-card path-advisory" href="<?php echo esc_url( home_url( '/advisory/' ) ); ?>">
			<div class="advisory-art" aria-hidden="true"><span><?php esc_html_e( 'One conversation.', 'mrkwp' ); ?></span><strong><?php echo wp_kses( __( 'A clearer<br>way forward.', 'mrkwp' ), array( 'br' => array() ) ); ?></strong></div>
			<h3><?php esc_html_e( 'Let’s think it through.', 'mrkwp' ); ?></h3>
			<p><?php esc_html_e( 'Bring your questions. We’ll spend one focused hour finding your next move.', 'mrkwp' ); ?></p>
			<b><?php esc_html_e( 'Explore 1:1 advisory', 'mrkwp' ); ?> <span>↗</span></b>
		</a>
		<a class="path-card path-resources" href="<?php echo esc_url( home_url( '/resources/' ) ); ?>">
			<div class="resource-art" aria-hidden="true"><span>↗</span><span>▶</span><span>{ }</span></div>
			<h3><?php esc_html_e( 'Borrow what I’ve learned.', 'mrkwp' ); ?></h3>
			<p><?php esc_html_e( 'Videos, articles, client stories, and practical skills you can put to work today.', 'mrkwp' ); ?></p>
			<b><?php esc_html_e( 'Open the resource library', 'mrkwp' ); ?> <span>↗</span></b>
		</a>
		<!-- /wp:html -->
	</div>
	<!-- /wp:group -->
</section>
<!-- /wp:group -->
