<?php
/**
 * Template Name: Advisory
 * Description: Advisory Page Template
 *
 * @package MRK_WP
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

get_header();
?>

<main id="main">
<section class="page-intro wrap"><p class="eyebrow">A fresh pair of eyes</p><h1>One hour.<br><span>A clearer next move.</span></h1><p>A focused advisory session with Matt Knighton. Bring your WordPress, AI, or workflow questions and we’ll work through them together.</p></section><section class="wrap advisory-layout"><div><h2>Let’s untangle the<br>question behind the question.</h2><p>Maybe your site has become hard to maintain. Maybe AI feels like another thing to keep up with. Or maybe you have a plan and want an experienced second opinion.</p><ul class="plain-list"><li><span>01</span>Bring your website, questions, and priorities.</li><li><span>02</span>We explore your options together.</li><li><span>03</span>Leave with a practical direction for your next step.</li></ul></div><div class="price-panel"><span>1:1 with Matt Knighton</span><strong>$299<small> / 60 minutes</small></strong><h3>Your business.<br>Your questions. Our focus.</h3><p>One dedicated hour to work on the decisions that matter to you.</p><a class="button" href="<?php echo esc_url( home_url( '/contact/?interest=advisory#enquiry' ) ); ?>">Enquire about a session ↗</a><small>Online booking will open with the WordPress launch. No payment is collected in this preview.</small></div></section>
</main>

<?php
get_footer();
