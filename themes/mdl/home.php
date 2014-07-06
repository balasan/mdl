<?php get_header();
	
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
                        
                        <div class="swiper-slide" style="background: url('<?php echo $src; ?>') no-repeat center center; background-size: cover; text-indent: -9999px;">
                            <h2><?php the_title(); ?></h2>
                        </div>
                        <?php endwhile; ?>
                    </div>
                </div>
                <a href="#" class="arrow-left external">Prev</a> 
                <a href="#" class="arrow-right external">Next</a>
            </div>
            <?php endif; ?>

<?php get_footer(); ?>