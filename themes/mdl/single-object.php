<?php get_header(); ?>

<!-- fill in the data-info property for AJAX -->
<div id="content" data-info='{"type":"single","name":"object","menuTitle":"<?php the_title(); ?>"}'>
  <div class="post">
    <div class="post-inner">
      
      <?php
        while (have_posts()) : the_post();
      ?>

        <?php the_title() ?>
        <?php the_content() ?>





     
      <?php endwhile; ?>
    </div><!-- end post-inner -->
  </div><!-- end post -->
</div><!-- end content -->

<?php 
  get_footer(); 
?>



