<?php
/**
 * Template Name: About Matt
 * Description: About Matt Page Template
 *
 * @package MRK_WP
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

get_header();
?>

<main id="main">
<section class="page-intro wrap"><p class="eyebrow">Hello, I’m Matt Knighton</p><h1>Technology changes.<br><span>People still matter.</span></h1><p>Educator, community builder, advisor, and the founder of MRK WP.</p></section><section class="about-detail wrap"><figure><img src="<?php echo esc_url( mrkwp_asset( 'matt-knighton.jpg' ) ); ?>" width="600" height="650" alt="Matt Knighton" loading="lazy"></figure><div><h2>I make the complicated<br>feel a little clearer.</h2><p>My work brings together software development, business advice, WordPress, and education. The common thread is helping people get more value from the technology they already use.</p><p>With MRK WP, I help businesses build faster websites, organize their knowledge for AI search, and create practical workflows their teams can own.</p><p>I share what I learn through videos, articles, and community. If you’re curious about what comes next, you’re in the right place.</p><a class="button" href="<?php echo esc_url( home_url( '/contact/' ) ); ?>">Let’s meet ↗</a></div></section><section class="community-invite wrap"><div><p class="eyebrow">Let’s figure it out together</p><h2>You don’t have to<br>build alone.</h2><p>A little guidance. A generous community. A better next step.</p><a class="button button-light" href="<?php echo esc_url( home_url( '/community/' ) ); ?>">Explore the free community ↗</a></div><div class="community-word" aria-hidden="true">Better<br><span>together.</span><i>↗</i></div></section>
</main>

<?php
get_footer();
