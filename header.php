<?php
/**
 * Header template for MRK WP theme
 *
 * @package MRK_WP
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?><!doctype html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="theme-color" content="#0a2540">
	<link rel="icon" href="<?php echo esc_url( mrkwp_asset( 'favicon.svg' ) ); ?>" type="image/svg+xml">
	<link rel="icon" href="<?php echo esc_url( mrkwp_asset( 'mrk-square.png' ) ); ?>" sizes="any">
	<?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<?php wp_body_open(); ?>
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

	<header class="site-header">
		<div class="header-inner wrap">
			<a class="logo" href="<?php echo esc_url( home_url( '/' ) ); ?>" aria-label="<?php esc_attr_e( 'MRK WP home', 'mrkwp' ); ?>">
				<img class="square-logo" src="<?php echo esc_url( mrkwp_asset( 'mrk-square.png' ) ); ?>" width="48" height="48" alt="">
				<span>MRK WP<span class="logo-caption">with Matt Knighton</span></span>
			</a>
			<nav id="main-nav" class="main-nav" aria-label="<?php esc_attr_e( 'Main navigation', 'mrkwp' ); ?>">
				<a href="<?php echo esc_url( home_url( '/about/' ) ); ?>">About</a>
				<a href="<?php echo esc_url( home_url( '/community/' ) ); ?>">Community</a>
				<a href="<?php echo esc_url( home_url( '/advisory/' ) ); ?>">Advisory</a>
				<div class="resources-nav">
					<button class="resources-toggle" aria-expanded="false" aria-controls="resources-menu">Resources <span aria-hidden="true">⌄</span></button>
					<div id="resources-menu" class="mega-menu" hidden>
						<div class="mega-intro">
							<span class="eyebrow">The resource library</span>
							<h2>A little knowledge.<br>A lot of possibility.</h2>
							<a class="button" href="<?php echo esc_url( home_url( '/resources/' ) ); ?>">Explore all resources <span aria-hidden="true">↗</span></a>
						</div>
						<div class="mega-categories">
							<a href="<?php echo esc_url( home_url( '/resources/#video' ) ); ?>"><b>Video</b><span>Watch practical walkthroughs</span></a>
							<a href="<?php echo esc_url( home_url( '/resources/#articles' ) ); ?>"><b>Articles</b><span>Ideas you can put to work</span></a>
							<a href="<?php echo esc_url( home_url( '/resources/#client-stories' ) ); ?>"><b>Client Stories</b><span>See the work behind the websites</span></a>
							<a href="<?php echo esc_url( home_url( '/resources/#skills' ) ); ?>"><b>Skills and Snippets</b><span>Small steps. Useful shortcuts.</span></a>
						</div>
						<a class="mega-feature" href="https://www.mrkwp.com/2025/03/wp-multiple-sidebars-kadence-elements/">
							<span>From the latest articles</span>
							<strong>Make your WordPress content work harder.</strong>
							<small>Explore Kadence Elements <span aria-hidden="true">↗</span></small>
						</a>
					</div>
				</div>
				<a href="<?php echo esc_url( home_url( '/tools/' ) ); ?>">Tools</a>
				<a class="mobile-apply" href="<?php echo esc_url( home_url( '/contact/' ) ); ?>">Work With Me <span aria-hidden="true">↗</span></a>
			</nav>
			<a class="button button-small header-apply" href="<?php echo esc_url( home_url( '/contact/' ) ); ?>">Work With Me <span aria-hidden="true">↗</span></a>
			<button class="menu-toggle" type="button" aria-label="<?php esc_attr_e( 'Open navigation', 'mrkwp' ); ?>" aria-controls="main-nav" aria-expanded="false">
				<span></span>
				<span></span>
			</button>
		</div>
	</header>
