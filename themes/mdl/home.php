<?php
/**
 * The home template file.
 *
 */
get_header();

    // <div id="content" data-info='{"type":"home","name":"home"}'> 

	
	$args = array(
		'post_type' => 'slider',
		'posts_per_page' => -1,
		'order' => 'DESC'
	);
	
	$the_query = new WP_Query( $args );
?>
			
            <?php if( $the_query->have_posts() ) : ?>
        	<div id="slider">
                <div class="swiper-container">
                    <div class="swiper-wrapper">
                    	<?php while ( $the_query->have_posts() ) : $the_query->the_post(); ?>
                        <?php $thumb = wp_get_attachment_image_src( get_post_thumbnail_id($the_query->ID), 'large' ); $src = $thumb['0']; ?>
                        <div class="swiper-slide">
                            <img src="<?php echo $src; ?>" alt="<?php the_title(); ?>">
                        </div>
                        <?php endwhile; ?>
                    </div>
                </div>
                <a class="arrow-left" href="#">Prev</a> 
                <a class="arrow-right" href="#">Next</a>
            </div>
            
            
            <script type="text/javascript">
				$(function(){
					$swiperContainer = $('.swiper-container');
					
					var mySwiper = $swiperContainer.swiper({
						mode: 'horizontal',
						loop: true
					});
					$('.arrow-left').on('click', function(e){
						e.preventDefault();
						mySwiper.swipePrev();
					});
					$('.arrow-right').on('click', function(e){
						e.preventDefault();
						mySwiper.swipeNext();
					});
					
					var _resize = function() {
						var slider = $('#slider');
						var height = slider.width() / 2 + 50;
						slider.height( height );
						
						$swiperContainer.find('.swiper-slide img').one('load', function() {
							$(this).crop(slider.width(), height);
						}).each(function() {
							if(this.complete) $(this).load();
						});
						
						/*$swiperContainer.imagesLoaded(function() {
                        	$swiperContainer.find('.swiper-slide img').crop(slider.width(), height);
                		});*/
					};
					
					$(window).resize(_resize); _resize();
				});
			</script>
            <?php endif; ?>

<?php get_footer(); ?>
