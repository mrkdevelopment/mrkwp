<?php
/**
 * The main template file
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
		<p class="eyebrow"><?php esc_html_e( 'Latest Articles', 'mrkwp' ); ?></p>
		<h1><?php single_post_title( '', true ); ?></h1>
	</section>

	<section class="wrap section">
		<div class="content-grid">
			<?php
			if ( have_posts() ) :
				while ( have_posts() ) :
					the_post();
					?>
					<a class="content-card" href="<?php the_permalink(); ?>">
						<div class="content-art art-article" aria-hidden="true">Aa</div>
						<div class="content-card-copy">
							<span><?php echo esc_html( get_the_date() ); ?></span>
							<h3><?php the_title(); ?></h3>
							<p><?php echo esc_html( wp_trim_words( get_the_excerpt(), 18 ) ); ?></p>
							<b><?php esc_html_e( 'Read article', 'mrkwp' ); ?> <span aria-hidden="true">↗</span></b>
						</div>
					</a>
					<?php
				endwhile;
			else :
				?>
				<p><?php esc_html_e( 'No posts found.', 'mrkwp' ); ?></p>
			<?php endif; ?>
		</div>
	</section>
</main>

<?php
get_footer();
