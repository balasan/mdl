<?php get_header(); ?>
			
            <?php query_posts( array( "pagename" => "front-page" ) );
            
			if( have_posts() ) while ( have_posts() ) : the_post();
			
			$index = 0;
           
            if( have_rows('slideshow_images') ) : ?>
            
        	<div id="slider">
                <div class="swiper-container">
                    <div class="swiper-wrapper">
                    	<?php while ( have_rows('slideshow_images') ) : the_row(); $index++; if( $index > 1 ) break; ?>
                        <?php $image = get_sub_field('image'); ?>
                        <div class="swiper-slide" style="background-image: url('<?php echo $image['url']; ?>') ">
                            <!-- <h2><?php echo $image['title']; ?></h2> -->
                            <div class="into">
                            	<b>Lisa Roberts's</b> collection is only one among many of her involvements in raising awareness about design. [...]
                                <p><a href="<?php echo esc_url( home_url( '/' ) )?>about/"><b>More About Lisa Roberts &gt;</b></a></p>
                                <ul class="socs">
                                    <li><a target="_blank" href="https://www.facebook.com/MyDesignLife" class="fb fa fa-facebook-square"></a></li>
                                    <li><a target="_blank" href="https://twitter.com/MyDesignLife" class="tw fa fa-twitter"></a></li>
                                    <li><a target="_blank" href="http://instagram.com/thelisaroberts" class="in fa fa-instagram"></a></li>
                                </ul>
                            </div>
                        </div>
                        <?php endwhile; ?>
                    </div>
                </div>
                <!--<a href="#" class="arrow-left fa fa-caret-left external"></a> 
                <a href="#" class="arrow-right fa fa-caret-right external"></a>-->
            </div>
            
            <?php endif; ?>
            
            <div id="splash" class="container">
              
              	<?php /* ?>
                <div class="splash-content desktop-small">
                  <?php the_content(); ?>
                </div>
				<?php */ ?>

                <div class="splash-about">
                	<div class="splash-about-image">
                        <div class="image">
                          <?php $image = get_field('book_image');
                            if( !empty($image) ): ?>
                            <img src="<?php echo $image['url']; ?>" alt="<?php echo $image['alt']; ?>">
                          <?php endif; ?>
                        </div>
                    	<span>DesignPOP</span>
                    </div>
                   	<div class="splash-about-buy">
                        <a target="_blank" href="<?php the_field('video_url'); ?>" class="external fancybox-media">
                            <div class="link watch">
                                <span class="louter">
                                    Watch the video
                                </span>
                            </div>
                        </a>
                        <script type="text/javascript">
                        	$('.fancybox-media').fancybox({
								openEffect  : 'none',
								closeEffect : 'none',
								helpers : {
									media : {}
								}
							});
                        </script>
                    </div>
                    <div class="splash-about-watch">
                    	<a target="_blank" href="<?php the_field('book_link'); ?>" class="external">
                            <div class="link">
                                <span class="louter">
                                    Buy the New Book
                                </span>
                            </div>
                        </a>
                    </div>
                </div>

				<?php /* ?>
                <div class="splash-content mobile-small">
                  <?php the_content(); ?>
                </div>
                <?php */ ?>

            </div>
            <?php endwhile; ?>
            

<?php get_footer(); ?>