<?php
/**
 * 404.
 */

defined( 'ABSPATH' ) || exit;

get_header();
?>
<div class="rs-page rs-404 is-layout-constrained has-global-padding">
	<h1 class="rs-404__code">404</h1>
	<p class="rs-404__text">
		<?php esc_html_e( 'this page was washed away by the rain.', 'rainshade' ); ?>
		<a href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php esc_html_e( 'back to the window ↑', 'rainshade' ); ?></a>
	</p>
</div>
<?php
get_footer();
