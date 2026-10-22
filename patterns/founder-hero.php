<?php
/**
 * Title: Founder Hero
 * Slug: mrkwp/founder-hero
 * Categories: featured, banner
 * Description: Founder hero section with portrait and action buttons.
 *
 * @package MRK_WP
 */

?>
<!-- wp:group {"tagName":"section","className":"founder-hero wrap"} -->
<section class="wp-block-group founder-hero wrap">
	<div class="hero-copy">
		<p class="eyebrow">Educator. Community builder. Advisor.</p>
		<h1>Hi, I’m Matt.<br>Let’s make<br><span>what’s next.</span></h1>
		<p class="hero-description">I help you turn WordPress and AI into something useful. A faster website. A clearer voice. And the confidence to move your business forward.</p>
		<div class="hero-actions">
			<a class="button" href="<?php echo esc_url( home_url( '/contact/' ) ); ?>">Work With Me <span aria-hidden="true">↗</span></a>
			<a class="button button-secondary" href="<?php echo esc_url( home_url( '/community/' ) ); ?>">Find your community <span aria-hidden="true">↗</span></a>
		</div>
		<p class="hero-footnote">
			<span class="info-symbol" aria-hidden="true">i</span>
			<span>A conversation is a good place to start.<strong>20 minutes. Let’s talk.</strong></span>
		</p>
	</div>
	<div class="portrait-stage">
		<div class="portrait-backplate" aria-hidden="true">
			<span class="portrait-watermark">Make<br>it matter.</span>
			<span class="portrait-orbit"></span>
		</div>
		<img class="hero-portrait" src="<?php echo esc_url( mrkwp_asset( 'matt-founder.webp' ) ); ?>" alt="Matt Knighton, founder of MRK WP, smiling and welcoming you" width="1800" height="1005" fetchpriority="high">
		<div class="portrait-note">
			<span class="note-spark" aria-hidden="true">✳</span>
			<div>Less overwhelm.<br><strong>More possibility.</strong></div>
		</div>
		<div class="portrait-signature">
			<strong>Matt Knighton</strong>
			<span>Founder, MRK WP</span>
			<span aria-hidden="true">↗</span>
		</div>
	</div>
</section>
<!-- /wp:group -->
