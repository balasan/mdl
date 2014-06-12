<?php get_header(); ?>

<!-- fill in the data-info property for AJAX -->
<div id="content" data-info='{"type":"single","name":"object","menuTitle":"<?php the_title(); ?>"}'>
  <div class="post">
    <div class="post-inner">
      
      <?php
        while (have_posts()) : the_post();
        $category = get_the_category();
        $sub = $category[0]->cat_name;
        if ($sub == ""){
          $obj = get_post_type_object( get_post_type( ) );
          $sub = $obj->labels->singular_name;
        }
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



