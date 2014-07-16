<?php get_header();
	
	$args = array(
		'post_type' => 'slider',
		'posts_per_page' => -1,
		'order' => 'DESC'
	);
	
	$the_query = new WP_Query( $args );
?>
			
            <?php query_posts( array( "pagename" => "front-page" ) );
            
			if( have_posts() ) while ( have_posts() ) : the_post();
           
            if( have_rows('slideshow_images') ) : ?>
            
        	<div id="slider">
                <div class="swiper-container">
                    <div class="swiper-wrapper">
                    	<?php while ( have_rows('slideshow_images') ) : the_row(); ?>
                        <?php $image = get_sub_field('image'); ?>
                        <div class="swiper-slide" style="background: url('<?php echo $image['url']; ?>') no-repeat center center; background-size: cover; text-indent: -9999px;">
                            <h2><?php echo $image['title']; ?></h2>
                        </div>
                        <?php endwhile; ?>
                    </div>
                </div>
                <a href="#" class="arrow-left fa fa-caret-left external"></a> 
                <a href="#" class="arrow-right fa fa-caret-right external"></a>
            </div>
            
            <?php endif; ?>
            
            <div id="splash" class="container">
            	<div class="splash-content">
                	<?php the_content(); ?>
                </div>
                <div class="splash-about">
                	<div class="image">
                    <?php $image = get_field('book_image');
 
					if( !empty($image) ): ?>
                        <img src="<?php echo $image['url']; ?>" alt="<?php echo $image['alt']; ?>">
                    <?php endif; ?>
                    </div>
                    <div class="main">
                    	<a target="_blank" href="<?php the_field('book_link'); ?>" class="external">
                            <div class="link">
                                <span class="outer">
                                    Buy the New Book
                                    <span>DesignPOP</span>
                                </span>
                            </div>
                        </a>
                        <a target="_blank" href="<?php the_field('video_url'); ?>" class="external">
                            <div class="link watch">
                                <span class="outer">
                                    Watch the video
                                </span>
                            </div>
                        </a>
                    </div>
                </div>
            </div>
            <?php endwhile; ?>
            

<?php get_footer(); ?>