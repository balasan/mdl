<?php get_header(); ?>
			
        	<div id="slider">
                <div class="swiper-container">
                    <div class="swiper-wrapper">
                        <div class="swiper-slide">
                            <img src="images/image02.jpg" alt="">
                        </div>
                        <div class="swiper-slide">
                            <img src="images/image03.jpg" alt="">
                        </div>
                    </div>
                </div>
                <a class="arrow-left" href="#">Prev</a> 
                <a class="arrow-right" href="#">Next</a>
            </div>
            
            
            <script type="text/javascript">
				$(function(){
					var mySwiper = $('.swiper-container').swiper({
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
					};
					
					$(window).resize(_resize); _resize();
				});
			</script>

<?php get_footer(); ?>