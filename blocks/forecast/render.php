<?php
/**
 * Forecast tracklist.
 *
 * @var array  $attributes
 * @var string $content Rendered tracks.
 */

defined( 'ABSPATH' ) || exit;
?>
<div <?php echo get_block_wrapper_attributes( [ 'class' => 'rs-forecast' ] ); ?>>
	<?php if ( $attributes['headLeft'] || $attributes['headRight'] ) : ?>
		<div class="rs-forecast__head">
			<span><?php echo esc_html( $attributes['headLeft'] ); ?></span>
			<span><?php echo esc_html( $attributes['headRight'] ); ?></span>
		</div>
	<?php endif; ?>
	<ol class="rs-forecast__list"><?php echo $content; ?></ol>
</div>
