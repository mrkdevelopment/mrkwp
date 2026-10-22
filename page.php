<?php
/**
 * The template for displaying all single pages
 *
 * @package MRK_WP
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

get_header();
?>

<main id="main" class="site-main">
<?php
while ( have_posts() ) :
	the_post();

	// Check whether to show the page title.
	$show_title = get_post_meta( get_the_ID(), '_mrkwp_show_title', true );
	$has_hero   = has_block( 'mrkwp/founder-hero' ) || strpos( get_the_content(), 'founder-hero' ) !== false;

	// Default to true unless explicitly disabled, or auto-hidden if the page starts with a hero pattern.
	$display_title = true;
	if ( '0' === $show_title || 'no' === $show_title || false === $show_title ) {
		$display_title = false;
	} elseif ( '' === $show_title && $has_hero ) {
		$display_title = false;
	}
	?>

	<?php if ( $display_title ) : ?>
		<section class="page-intro wrap">
			<h1 class="page-title"><?php the_title(); ?></h1>
		</section>
	<?php endif; ?>

	<div class="entry-content">
		<?php the_content(); ?>
	</div>
<?php endwhile; ?>
</main>

<?php
get_footer();
