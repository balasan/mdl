
<?php get_header(); ?>

<div id="content" data-info='{"type":"archive","name":"news","menuTitle":"<?php the_title(); ?>"}'>

  <header id="post-header" class="sliding">
    <h4>NEWS</h4>
  </header>

    <header id="news-archive-nav">
      <div class="toggleFilter">
        <h4>ALL</h4>
      </div>
      <ul>
        <li><a class="filter" data-filter=".posts"       href="<?php echo esc_url( home_url('/') ); ?>news-cat/posts/"><h4>POSTS</h4></a></li>
        <li><a class="filter" data-filter=".press"       href="<?php echo esc_url( home_url('/') ); ?>news-cat/press/"><h4>PRESS</h4></a></li>
        <li><a class="filter" data-filter=".exhibitions" href="<?php echo esc_url( home_url('/') ); ?>news-cat/exhibitions/"><h4>EXHIBITIONS</h4></a></li>
        <li><a class="filter" data-filter=".events"    href="<?php echo esc_url( home_url('/') ); ?>news-cat/events/"><h4>LECTURES &amp; EVENTS</h6></a></li>
        <li><a class="filter" data-filter=".instagram"   href="<?php echo esc_url( home_url('/') ); ?>news-cat/instagram/"><h4>INSTAGRAM</h4></a></li>
        <li><a class="filter" data-filter="*"            href="<?php echo esc_url( home_url('/') ); ?>news/"><h4>VIEW ALL</h4></a></li>
      </ul>
    </header>


  <div class="post sliding">




    <div id="series">
      <div id="" class="gridContainer news" data-pages="<?php echo $wp_query->max_num_pages; ?>">

        <?php
          wp_reset_query();
          while (have_posts()) : the_post();
            $thumb = wp_get_attachment_image_src( get_post_thumbnail_id(get_the_ID()), 'large-news' );
            $url = $thumb[0];
            $post_object = get_sub_field('post_link');

            $type= trim(get_field('type'));
            if( $type=="complex")
              $link = get_permalink($post_object->ID);
            else{
              $link = "javascript:void(0)";
              $type = 'simple';
            }
            $next_page = get_next_posts_page_link();

            $post_id = get_the_ID();
            $category = wp_get_post_terms( $post_id, 'news_categories', array("fields" => "names") );
            $sub = "";
            foreach($category as $c){
              $sub = $sub. " ". $c;
            }

            if ($sub == ""){
              $obj = get_post_type_object( get_post_type( ) );
              $sub = $obj->labels->singular_name;
            }

            // $post_categories = wp_get_post_categories(get_the_ID());
            $cats = "";

            // foreach($post_categories as $c) {
            //   $cat = get_category($c);
            //   $cats = $cats. " ". strtolower($cat->slug);
            // }
            $cat = "";
            if(trim($sub)=="Instagram")
              $cat = "insta";


        ?>


        <div class="grid news <?php echo $cat ." ". $type;?>">
          <div class="back">
            <div class="sub">
              <h4><?php echo $sub; ?></h4>
            </div>

            <?php if(trim($sub)=="Instagram"){ ?>

              <!-- <div class="p1 post-content-inner"> -->
                <img src="<?php echo $url; ?>">

              <!-- </div> -->

            <?php } 

                  $title = get_the_title();
                  if($cat=="insta"){
                    $pos=strpos($title, ' ', 170);
                    if($pos)
                      $title = substr($title,0,$pos);
                  }

            ?>

              <div class="itemContainer">
                <div class="gridCaption"><p class="p3"><?php echo $title; ?></p>
              </div>
              <h4 class="news-date"><?php the_field('sub_title'); ?></h4>

                <?php if($post->post_content != "" && $cat!="insta") { ?>        
                <div class="post-content">
                  <div class="p1 post-content-inner">
                    <?php the_content(); ?>
                  </div>
                </div>
                <?php }?>


                <?php if(get_field('news_link')){?>
                  <div class="post-content download">
                  <a class="external" href="<?php echo get_field('news_link')?>"  target="_blank"><h4 class="text-center">LINK</h4></a>
                  </div>
                <?php }?>

                <?php if($cat=="insta"){
                  echo '<h5>';
                  echo get_the_date();
                  if(get_field("instagram-location"))
                    echo "-". get_field("instagram-location").'</h5>';
                  else echo '</h5>';
                }
                ?>
                  <div class="socialGrid">
                      <a class="social" href="https://www.facebook.com/pages/Kehinde-Wiley/307525552594119" class="external" target="blank">f</a>
                      <a class="social" href="https://twitter.com/kehindewileyart" class="external" target="blank">t</a>
                      <a class="social" href="http://instagram.com/kehindewiley" class="external" target="blank">i</a>
                  </div>
            </div> 
          
          </div>
          
          <div class="front">
            <div class="sub">
              <h4><?php echo $sub; ?></h4>
            </div>
            <a href="<?php echo $link; ?>">
              <div class="itemContainer">
                <div class="circle" style="background-image: url('<?php echo $url; ?>');">
                </div>
                <?php
                  $title = get_the_title();
                  if($cat=="insta"){
                    $pos=strpos($title, ' ', 30);
                    if($pos)
                      $title = substr($title,0,$pos);
                  }
                ?>
                <div class="gridCaption"><p class="p3"><?php echo $title; ?></p>
                  <h4 class="news-date"><?php the_field('sub_title'); ?></h4>
                  <?php if($cat=="insta"){
                    echo '<h5>';
                    echo get_the_date();
                    if(get_field("instagram-location"))
                      echo "-". get_field("instagram-location").'</h5>';
                    else echo '</h5>';
                  }
                  ?>
                </div>
              </div> 
            </a>
          </div>
          </div>

        <?php
          endwhile;
        ?>

      </div>
    </div>

    <div class="loading-gif">
      <div class="dot"></div>
      <h4>LOADING</h4>
    </div>

    <div id="nextPage" class="hidden" data-url="<?php echo $next_page; ?>"></div>
  </div><!-- end post -->
</div><!-- end content -->





<?php get_footer(); ?>

