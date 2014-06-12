
<?php get_header(); ?>

<div id="content" data-info='{"type":"archive","name":"news","menuTitle":"<?php the_title(); ?>"}'>

  <div class="post">

        <?php
          while (have_posts()) : the_post();

            //url for infinite scroll
            $next_page = get_next_posts_page_link();

          

          endwhile;
        ?>

      </div>
    </div>

    <div class="infinteLoader">
    </div>

    <!-- Url for inifinite Scroll -->
    <div id="nextPage" class="hidden" data-url="<?php echo $next_page; ?>"></div>


  </div><!-- end post -->
</div><!-- end content -->
<?php get_footer(); ?>

