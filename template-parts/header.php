<?php
/**
 * Site header. 
 */

defined( 'ABSPATH' ) || exit;
?>
<div class="rs-header">
	<a class="rs-header__name" href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php bloginfo( 'name' ); ?></a>
	<?php
	wp_nav_menu( [
		'theme_location'  => 'primary',
		'container'       => 'nav',
		'container_class' => 'rs-header__nav',
		'menu_class'      => 'rs-menu',
		'depth'           => 1,
		'fallback_cb'     => false,
	] );
	?>
</div>
