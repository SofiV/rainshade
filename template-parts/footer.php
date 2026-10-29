<?php
/**
 * Site footer. Menu: Appearance → Menus → "Footer" (nothing shows until one is assigned).
 */

defined( 'ABSPATH' ) || exit;
?>
<div class="rs-footer">
	<div class="rs-footer__top">
		<p class="rs-footer__signup">
			<span><?php esc_html_e( 'tell me when it rains again:', 'rainshade' ); ?></span>
			<a href="#"><?php esc_html_e( 'sign up →', 'rainshade' ); ?></a>
		</p>
		<?php
		wp_nav_menu( [
			'theme_location'  => 'footer',
			'container'       => 'nav',
			'container_class' => 'rs-footer__nav',
			'menu_class'      => 'rs-menu',
			'depth'           => 1,
			'fallback_cb'     => false,
		] );
		?>
	</div>
	<div class="rs-footer__bottom">
		<span>© <?php echo esc_html( wp_date( 'Y' ) ); ?> <?php bloginfo( 'name' ); ?></span>
		<a href="#top"><?php esc_html_e( 'wipe the glass again ↑', 'rainshade' ); ?></a>
	</div>
</div>
