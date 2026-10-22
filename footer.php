<?php
/**
 * Footer template for MRK WP theme
 *
 * @package MRK_WP
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

block_template_part( 'footer' );
?>

	<a class="floating-top" href="#" aria-label="<?php esc_attr_e( 'Back to top', 'mrkwp' ); ?>" hidden><span aria-hidden="true">↑</span><span>Top</span></a>

	<?php wp_footer(); ?>
</body>
</html>
