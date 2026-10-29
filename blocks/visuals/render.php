<?php
/**
 * Visuals section.
 *
 * @var array  $attributes
 * @var string $content Inner blocks (embeds).
 */

defined( 'ABSPATH' ) || exit;
?>
<section <?php echo get_block_wrapper_attributes( [ 'class' => 'rs-visuals' ] ); ?>>
	<div class="rs-visuals__head">
		<h2 class="rs-visuals__heading"><?php echo esc_html( $attributes['heading'] ); ?></h2>
		<span class="rs-visuals__note"><?php echo esc_html( $attributes['note'] ); ?></span>
	</div>
	<?php echo $content; ?>
	<?php if ( $attributes['linkUrl'] && $attributes['linkText'] ) : ?>
		<a class="rs-visuals__link" href="<?php echo esc_url( $attributes['linkUrl'] ); ?>" target="_blank" rel="noopener"><?php echo esc_html( $attributes['linkText'] ); ?></a>
	<?php endif; ?>
</section>
