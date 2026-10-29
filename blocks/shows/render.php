<?php
/**
 * Live section.
 *
 * @var array  $attributes
 * @var string $content Rendered upcoming shows (past ones render nothing).
 */

defined( 'ABSPATH' ) || exit;
?>
<section <?php echo get_block_wrapper_attributes( [ 'class' => 'rs-shows' ] ); ?>>
	<h2 class="rs-shows__heading"><?php echo esc_html( $attributes['heading'] ); ?></h2>
	<div class="rs-shows__list">
		<?php if ( '' !== trim( $content ) ) : ?>
			<?php echo $content; ?>
		<?php else : ?>
			<p class="rs-shows__empty"><?php echo esc_html( $attributes['emptyText'] ); ?></p>
		<?php endif; ?>
	</div>
</section>
