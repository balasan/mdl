<?php
/**
 * The main template file.
 *
 */

get_header(); ?>

<?php get_sidebar(); ?>

<div id="content" data-info='{"type":"single","name":"<?php the_title(); ?>","menuTitle":"<?php the_title(); ?>"}'>
	<?php if ( have_posts() ) while ( have_posts() ) : the_post(); ?>
		<div class="post">
				
			<div class="post-inner">
				<?php the_content(); ?>
			</div>




		</div><!-- end post -->	
	<?php endwhile;?>
</div><!-- end content -->



<?php get_footer(); ?>