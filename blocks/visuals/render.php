<?php
/**
 * Visuals section — mirrors Release: video on the left, big title on the right.
 *
 * @var array  $attributes
 * @var string $content Inner blocks (embed / video).
 */

defined( 'ABSPATH' ) || exit;

$has_media = '' !== trim( $content );
?>
<section <?php echo get_block_wrapper_attributes( [ 'class' => 'rs-visuals' ] ); ?>>
	<div class="rs-visuals__media<?php echo $has_media ? '' : ' rs-frame rs-visuals__empty'; ?>">
		<?php echo $content; ?>
	</div>
	<div class="rs-visuals__info">
		<div class="rs-visuals__head">
			<?php if ( $attributes['note'] ) : ?>
				<span class="rs-visuals__note"><?php echo esc_html( $attributes['note'] ); ?></span>
			<?php endif; ?>
			<?php if ( $attributes['heading'] ) : ?>
				<h2 class="rs-visuals__title"><?php echo esc_html( $attributes['heading'] ); ?><i>.</i></h2>
			<?php endif; ?>
		</div>
		<?php if ( $attributes['linkUrl'] && $attributes['linkText'] ) : ?>
			<a class="rs-visuals__link" href="<?php echo esc_url( $attributes['linkUrl'] ); ?>" target="_blank" rel="noopener"><?php echo esc_html( $attributes['linkText'] ); ?></a>
		<?php endif; ?>
	</div>
</section>
