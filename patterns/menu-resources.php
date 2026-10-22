<?php
/**
 * Title: Resources Dropdown Menu
 * Slug: mrkwp/menu-resources
 * Description: Rich dropdown menu for resources with intro, categories, and featured article
 * Categories: ollie/menu
 * Keywords: menu, dropdown, resources, mega menu
 * Viewport Width: 1150
 * Block Types: core/template-part/menu
 * Inserter: true
 *
 * @package MRK_WP
 */

?>
<!-- wp:group {"metadata":{"name":"Resources Dropdown Menu"},"className":"mega-menu mrkwp-resources-dropdown","layout":{"type":"default"}} -->
<div class="wp-block-group mega-menu mrkwp-resources-dropdown">
	<!-- wp:group {"className":"mega-intro","layout":{"type":"default"}} -->
	<div class="wp-block-group mega-intro">
		<!-- wp:paragraph {"className":"eyebrow"} -->
		<p class="eyebrow"><?php esc_html_e( 'The resource library', 'mrkwp' ); ?></p>
		<!-- /wp:paragraph -->

		<!-- wp:heading {"level":2} -->
		<h2><?php echo wp_kses( __( 'A little knowledge.<br>A lot of possibility.', 'mrkwp' ), array( 'br' => array() ) ); ?></h2>
		<!-- /wp:heading -->

		<!-- wp:buttons -->
		<div class="wp-block-buttons">
			<!-- wp:button -->
			<div class="wp-block-button"><a class="wp-block-button__link wp-element-button" href="/resources/"><?php esc_html_e( 'Explore all resources', 'mrkwp' ); ?> <span aria-hidden="true">↗</span></a></div>
			<!-- /wp:button -->
		</div>
		<!-- /wp:buttons -->
	</div>
	<!-- /wp:group -->

	<!-- wp:group {"className":"mega-categories","layout":{"type":"default"}} -->
	<div class="wp-block-group mega-categories">
		<!-- wp:html -->
		<a href="/resources/#video"><b><?php esc_html_e( 'Video', 'mrkwp' ); ?></b><span><?php esc_html_e( 'Watch practical walkthroughs', 'mrkwp' ); ?></span></a>
		<a href="/resources/#articles"><b><?php esc_html_e( 'Articles', 'mrkwp' ); ?></b><span><?php esc_html_e( 'Ideas you can put to work', 'mrkwp' ); ?></span></a>
		<a href="/resources/#client-stories"><b><?php esc_html_e( 'Client Stories', 'mrkwp' ); ?></b><span><?php esc_html_e( 'See the work behind the websites', 'mrkwp' ); ?></span></a>
		<a href="/resources/#skills"><b><?php esc_html_e( 'Skills and Snippets', 'mrkwp' ); ?></b><span><?php esc_html_e( 'Small steps. Useful shortcuts.', 'mrkwp' ); ?></span></a>
		<!-- /wp:html -->
	</div>
	<!-- /wp:group -->

	<!-- wp:group {"className":"mega-feature-wrap","layout":{"type":"default"}} -->
	<div class="wp-block-group mega-feature-wrap">
		<!-- wp:html -->
		<a class="mega-feature" href="https://www.mrkwp.com/2025/03/wp-multiple-sidebars-kadence-elements/">
			<span><?php esc_html_e( 'From the latest articles', 'mrkwp' ); ?></span>
			<strong><?php esc_html_e( 'Make your WordPress content work harder.', 'mrkwp' ); ?></strong>
			<small><?php esc_html_e( 'Explore Kadence Elements', 'mrkwp' ); ?> <span aria-hidden="true">↗</span></small>
		</a>
		<!-- /wp:html -->
	</div>
	<!-- /wp:group -->
</div>
<!-- /wp:group -->
