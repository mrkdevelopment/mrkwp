<?php
/**
 * Template Name: Work With Me / Contact
 * Description: Contact Page Template
 *
 * @package MRK_WP
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

get_header();
?>

<main id="main">
<section class="page-intro wrap"><p class="eyebrow">Work with me</p><h1>Good things start<br><span>with a conversation.</span></h1><p>Book a 20-minute introductory call, or send an enquiry first. Tell me a little about your business and what you’re working toward.</p></section><section class="wrap contact-layout"><div class="booking-panel" id="booking"><div class="booking-icon" aria-hidden="true">↗</div><h2>Let’s meet.</h2><p>A 20-minute conversation about where you are, what you need, and whether I can help.</p><div class="booking-placeholder"><span class="eyebrow">20-minute introductory call</span><h3>Your next step<br>starts here.</h3><p>Online scheduling will be available when the WordPress site launches.</p><a class="button button-light" href="https://www.mrkwp.com/contact/">Contact MRK WP to arrange a call ↗</a></div><p class="preview-note">Prefer to get in touch now? Use the current contact page above.</p></div><div class="simple-panel" id="enquiry"><h2>Prefer to write first?</h2><p>Share a little context before we talk.</p><form id="enquiry-form"><label for="contact-name">Your name</label><input id="contact-name" name="name" autocomplete="name" required><label for="contact-email">Email address</label><input id="contact-email" name="email" type="email" autocomplete="email" required><label for="contact-interest">How can I help?</label><select id="contact-interest" name="interest"><option>WordPress &amp; AI project</option><option value="advisory">One-hour advisory · $299</option><option>Community question</option><option>Something else</option></select><label for="contact-message">What are you working on?</label><textarea id="contact-message" name="message" rows="5" required minlength="10" placeholder="Your website, your questions, and what you’d like to change…"></textarea><p class="preview-note">Design preview: this form prepares your enquiry locally. It does not send it. Enquiry delivery will be connected in WordPress.</p><button class="button" type="submit">Prepare my enquiry ↗</button></form><div id="enquiry-result" hidden role="status"><h3 tabindex="-1">Your enquiry is ready.</h3><p>No message has been sent. Copy your enquiry and send it through the current MRK WP contact page.</p><pre id="enquiry-summary"></pre><button class="button" id="copy-enquiry">Copy enquiry</button><p id="enquiry-copy-status" role="status"></p><a class="text-link" href="https://www.mrkwp.com/contact/">Open MRK WP contact page ↗</a><button class="back-button" id="edit-enquiry">Edit enquiry</button></div></div></section>
</main>

<?php
get_footer();
