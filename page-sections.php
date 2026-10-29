<?php
/**
 * Template Name: Sections (full width, no title)
 * Template Post Type: page
 *
 * Page built from the section blocks (window, release, fog-quote, visuals, photo-row, live).
 */

defined( 'ABSPATH' ) || exit;

get_header();

while ( have_posts() ) :
	the_post();
	?>
	<div class="entry-content is-layout-constrained has-global-padding">
		<?php the_content(); ?>
	</div>
	<?php
endwhile;

get_footer();
