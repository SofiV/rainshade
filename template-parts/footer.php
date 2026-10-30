<?php
/**
 * Site footer. Menu: Appearance → Menus → "Footer" (nothing shows until one is assigned).
 */

defined( 'ABSPATH' ) || exit;
?>
<div class="rs-footer">
	<div class="rs-footer__top">
		<?php $signup = get_theme_mod( 'rainshade_signup_url' ); // Appearance → Customize → Footer ?>
		<?php if ( $signup ) : ?>
			<p class="rs-footer__signup">
				<span><?php echo esc_html( get_theme_mod( 'rainshade_signup_text', 'tell me when it rains again:' ) ); ?></span>
				<a href="<?php echo esc_url( $signup ); ?>" target="_blank" rel="noopener"><?php echo esc_html( get_theme_mod( 'rainshade_signup_link', 'sign up' ) ); ?></a>
			</p>
		<?php endif; ?>
		<?php
		wp_nav_menu( [
			'theme_location'  => 'footer',
			'container'       => 'nav',
			'container_class' => 'rs-footer__nav',
			'menu_class'      => 'rs-menu',
			'depth'           => 1,
			'fallback_cb'     => false,
		] );

		// Icons from Appearance - Customize - Footer.
		$links = '';
		foreach ( rainshade_socials() as $service => $label ) {
			$url = get_theme_mod( "rainshade_social_{$service}" );
			if ( $url ) {
				$links .= get_comment_delimited_block_content( 'core/social-link', [ 'service' => $service, 'url' => $url ], '' );
			}
		}
		if ( $links ) {
			echo do_blocks( get_comment_delimited_block_content(
				'core/social-links',
				[ 'openInNewTab' => true, 'className' => 'is-style-logos-only' ],
				'<ul class="wp-block-social-links is-style-logos-only">' . $links . '</ul>'
			) );
		}
		?>
	</div>
	<div class="rs-footer__bottom">
		<span>© <?php echo esc_html( wp_date( 'Y' ) ); ?> <?php bloginfo( 'name' ); ?></span>
		<?php if ( is_singular() && has_block( 'rainshade/window' ) ) : ?>
			<a href="#top"><?php esc_html_e( 'wipe the glass again', 'rainshade' ); ?></a>
		<?php endif; ?>
	</div>
</div>
