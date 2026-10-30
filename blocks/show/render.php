<?php
/**
 * One show. Renders nothing once the date has passed.
 *
 * @var array $attributes
 */

defined( 'ABSPATH' ) || exit;

$date = $attributes['date'];
if ( ! $date || $date < wp_date( 'Y-m-d' ) ) {
	return;
}

$tag   = $attributes['url'] ? 'a' : 'div';
$extra = $attributes['url'] ? [ 'href' => esc_url( $attributes['url'] ), 'target' => '_blank', 'rel' => 'noopener' ] : [];
$attrs = get_block_wrapper_attributes( [ 'class' => 'rs-show' ] );
foreach ( $extra as $k => $v ) {
	$attrs .= sprintf( ' %s="%s"', $k, esc_attr( $v ) );
}
$place = implode( ' — ', array_filter( [ $attributes['city'], $attributes['venue'] ] ) );
?>
<<?php echo $tag; ?> <?php echo $attrs; ?>>
	<time class="rs-show__date" datetime="<?php echo esc_attr( $date ); ?>"><?php echo esc_html( wp_date( 'd.m', strtotime( $date ) ) ); ?></time>
	<span class="rs-show__place"><?php echo esc_html( $place ); ?></span>
	<?php if ( $attributes['url'] ) : ?>
		<span class="rs-show__cta">tickets</span>
	<?php endif; ?>
</<?php echo $tag; ?>>
