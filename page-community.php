<?php
/**
 * Template Name: Community
 * Description: Community Page Template
 *
 * @package MRK_WP
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

get_header();
?>

<main id="main">
<section class="page-intro wrap"><p class="eyebrow">The free MRK WP community</p><h1>Curious people.<br><span>Better possibilities.</span></h1><p>A place to learn, share, and make WordPress and AI useful: one practical step at a time.</p></section><section class="wrap community-landing"><div class="community-manifesto"><span aria-hidden="true">✳</span><h2>Bring your questions.<br>Share your discoveries.<br>Keep moving forward.</h2></div><div class="simple-panel"><h2>Good knowledge<br>should be shared.</h2><p>Self-audit checklists, prompt packs, and video tutorials to help you build a faster, smarter WordPress site.</p><div class="resource-list"><span>Learn at your pace</span><span>Build useful skills</span><span>Meet fellow builders</span></div><p class="preview-note">Community registration is coming with the WordPress launch. For now, explore the free resource library.</p><a class="button" href="<?php echo esc_url( home_url( '/resources/' ) ); ?>">Start learning ↗</a></div></section>
</main>

<?php
get_footer();
