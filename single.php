<?php
/**
 * The template for displaying all single posts
 *
 * @package MRK_WP
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

get_header();
?>

<main id="main">
	<section class="page-intro wrap">
		<p class="eyebrow"><?php echo esc_html( get_the_date() ); ?></p>
		<h1><?php the_title(); ?></h1>
	</section>

	<section class="wrap section">
		<?php
		while ( have_posts() ) :
			the_post();
			?>
			<article id="post-<?php the_ID(); ?>" <?php post_class( 'simple-panel' ); ?>>
				<?php the_content(); ?>
			</article>
		<?php endwhile; ?>
	</section>
</main>

<?php
get_footer();
