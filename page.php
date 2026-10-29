<?php
/**
 * Regular page: title + content.
 */

defined( 'ABSPATH' ) || exit;

get_header();

while ( have_posts() ) :
	the_post();
	?>
	<article class="rs-page is-layout-constrained has-global-padding">
		<h1 class="rs-page__title"><?php the_title(); ?></h1>
		<div class="entry-content is-layout-constrained">
			<?php the_content(); ?>
		</div>
	</article>
	<?php
endwhile;

get_footer();
