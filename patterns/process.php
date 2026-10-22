<?php
/**
 * Title: Process (How We Work)
 * Slug: mrkwp/process
 * Categories: featured
 * Description: Three-step process journey: Capture, Optimize, and Equip.
 *
 * @package MRK_WP
 */

?>
<!-- wp:group {"tagName":"section","className":"process section","attrs":{"id":"how-it-works"}} -->
<section class="wp-block-group process section" id="how-it-works" aria-labelledby="process-title">
	<div class="wrap">
		<div class="section-heading process-heading">
			<div>
				<p class="eyebrow">How we work together</p>
				<h2 id="process-title">The site you have.<br><span>The engine you need.</span></h2>
			</div>
			<div class="process-summary">
				<strong>3</strong>
				<p><b>Clear steps.<br>One connected system.</b><span>From your expertise to a team in control.</span></p>
			</div>
		</div>
		<div class="process-journey">
			<div class="journey-line" aria-hidden="true"><span></span></div>
			<article class="process-step" data-process="capture">
				<div class="step-marker"><span>Step</span><strong>01</strong></div>
				<div class="process-copy">
					<span class="process-verb">Capture</span>
					<h3>Start with what<br>makes you, you.</h3>
					<p>We audit your site, get clear on your audience, and capture the knowledge and voice that make your business worth listening to.</p>
					<div class="process-deliverable"><svg class="icon"><use href="#i-check"/></svg><span>Your audience, your voice, a clear action plan.</span></div>
				</div>
				<div class="process-visual capture-visual" role="img" aria-label="<?php esc_attr_e( 'Your audience, expertise, and point of view combine into a clear brand voice.', 'mrkwp' ); ?>">
					<div class="visual-topline"><span>It starts with your expertise</span><svg class="icon"><use href="#i-spark"/></svg></div>
					<div class="voice-wave" aria-hidden="true"><svg viewBox="0 0 420 100" fill="none"><path d="M8 43v14M20 36v28M32 25v50M44 37v26M56 20v60M68 12v76M80 29v42M92 37v26M104 19v62M116 8v84M128 28v44M140 38v24M152 25v50M164 14v72M176 4v92M188 24v52M200 34v32M212 40v20M224 30v40M236 19v62M248 9v82M260 28v44M272 16v68M284 30v40M296 39v22M308 23v54M320 12v76M332 27v46M344 36v28M356 18v64M368 31v38M380 41v18M392 35v30M404 44v12"/></svg></div>
					<div class="voice-document">
						<div><span class="document-symbol" aria-hidden="true">Aa</span><span>Your voice, made clear.</span><svg class="icon"><use href="#i-check"/></svg></div>
						<div class="voice-document-grid"><span><i>01</i>Audience</span><span><i>02</i>Expertise</span><span><i>03</i>Point of view</span></div>
					</div>
				</div>
			</article>
			<article class="process-step" data-process="optimize">
				<div class="step-marker"><span>Step</span><strong>02</strong></div>
				<div class="process-copy">
					<span class="process-verb">Optimize</span>
					<h3>Less friction.<br>More intelligence.</h3>
					<p>We remove plugin bloat, improve performance, and structure your content into a knowledge repository AI engines can understand and reference.</p>
					<div class="process-deliverable"><svg class="icon"><use href="#i-check"/></svg><span>A faster site. An authoritative source of truth.</span></div>
				</div>
				<div class="process-visual optimize-visual" role="img" aria-label="<?php esc_attr_e( 'A fast foundation supports structured knowledge, with your expertise at the center.', 'mrkwp' ); ?>">
					<div class="visual-topline"><span>A stronger system, from the inside out</span><svg class="icon"><use href="#i-nodes"/></svg></div>
					<div class="architecture">
						<div class="architecture-layer layer-outer"><span>Fast foundation</span></div>
						<div class="architecture-layer layer-middle"><span>Structured knowledge</span></div>
						<div class="architecture-layer layer-inner"><img src="<?php echo esc_url( mrkwp_asset( 'mrk-wp-logo.svg' ) ); ?>" width="35" height="24" alt=""><strong>Your expertise</strong><span>The source of truth</span></div>
						<div class="architecture-axis" aria-hidden="true"></div>
					</div>
					<div class="architecture-caption"><span><svg class="icon"><use href="#i-check"/></svg>Own the platform</span><span><svg class="icon"><use href="#i-check"/></svg>Connect the knowledge</span></div>
				</div>
			</article>
			<article class="process-step" data-process="equip">
				<div class="step-marker"><span>Step</span><strong>03</strong></div>
				<div class="process-copy">
					<span class="process-verb">Equip</span>
					<h3>Built for your team.<br>Ready for your audience.</h3>
					<p>We create practical workflows and train your team to run them: from D2C video shorts to B2B LinkedIn thought leadership.</p>
					<div class="process-deliverable"><svg class="icon"><use href="#i-check"/></svg><span>The tools, the training, the confidence to move.</span></div>
				</div>
				<div class="process-visual equip-visual" role="img" aria-label="<?php esc_attr_e( 'One original insight becomes useful content for AI chat, social, and search.', 'mrkwp' ); ?>">
					<div class="visual-topline"><span>One idea. A connected workflow.</span><svg class="icon"><use href="#i-up-right"/></svg></div>
					<div class="workflow-source">
						<span class="workflow-source-icon"><svg class="icon"><use href="#i-spark"/></svg></span>
						<div><strong>Your original insight</strong><span>Start with something worth sharing.</span></div>
					</div>
					<div class="workflow-path" aria-hidden="true"><span></span><i></i></div>
					<div class="workflow-outputs">
						<div><span class="workflow-media"><svg class="icon"><use href="#i-play"/></svg><i></i><i></i><i></i></span><strong>Video shorts</strong><span>Made for your buyers</span></div>
						<div><span class="workflow-text"><i></i><i></i><i></i><i></i></span><strong>Thought leadership</strong><span>Written in your voice</span></div>
					</div>
				</div>
			</article>
		</div>
		<div class="process-close">
			<p>Your website stays yours.<br><strong>Your team knows what to do next.</strong></p>
			<a class="button button-light" href="<?php echo esc_url( home_url( '/contact/' ) ); ?>">Let’s talk about your website <svg class="icon"><use href="#i-up-right"/></svg></a>
		</div>
	</div>
</section>
<!-- /wp:group -->
