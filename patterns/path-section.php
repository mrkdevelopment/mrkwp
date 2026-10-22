<?php
/**
 * Title: Path Section
 * Slug: mrkwp/path-section
 * Categories: featured, call-to-action
 * Description: Three pathways: Community, Advisory, and Resources.
 *
 * @package MRK_WP
 */

?>
<!-- wp:html -->
<section class="path-section wrap">
	<div class="section-heading">
		<div>
			<p class="eyebrow">Choose your next step</p>
			<h2>Learn together.<br>Build with purpose.</h2>
		</div>
		<p>Some days you need a useful tutorial.<br>Other days, a fresh pair of eyes.<br>There’s a place for both here.</p>
	</div>
	<div class="path-grid">
		<a class="path-card path-community" href="<?php echo esc_url( home_url( '/community/' ) ); ?>">
			<div class="path-symbol" aria-hidden="true"><span>you</span><span>+</span><span>us</span></div>
			<h3>Find your people.</h3>
			<p>A free community for curious people making WordPress and AI work in the real world.</p>
			<b>Explore the community <span>↗</span></b>
		</a>
		<a class="path-card path-advisory" href="<?php echo esc_url( home_url( '/advisory/' ) ); ?>">
			<div class="advisory-art" aria-hidden="true"><span>One conversation.</span><strong>A clearer<br>way forward.</strong></div>
			<h3>Let’s think it through.</h3>
			<p>Bring your questions. We’ll spend one focused hour finding your next move.</p>
			<b>Explore 1:1 advisory <span>↗</span></b>
		</a>
		<a class="path-card path-resources" href="<?php echo esc_url( home_url( '/resources/' ) ); ?>">
			<div class="resource-art" aria-hidden="true"><span>↗</span><span>▶</span><span>{ }</span></div>
			<h3>Borrow what I’ve learned.</h3>
			<p>Videos, articles, client stories, and practical skills you can put to work today.</p>
			<b>Open the resource library <span>↗</span></b>
		</a>
	</div>
</section>
<!-- /wp:html -->
