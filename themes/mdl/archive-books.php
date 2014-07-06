<?php get_header();
	
    $paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
	
	query_posts( array( 'post_type' => 'books', 'posts_per_page' => 10, 'order' => 'DESC', 'paged' => $paged ) );

?>
    		<div id="about" class="container">
            	
                <?php if( have_posts() ) while ( have_posts() ) : the_post(); ?>
                
                <?php
                	$thumb = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), 'large' ); $src = $thumb['0'];
					$collaborations = get_post_meta( $post->ID, 'collaborations', true );
					$subtitle = get_post_meta( $post->ID, 'subtitle', true );
				?>
                
            	<article class="post person stickem-container" id="post-<?php the_ID(); ?>">
                	<div class="aside">
                    	<div class="image stickem">
                        	<?php if( !empty( $src ) ) : ?>
                            <img src="<?php echo $src; ?>" alt="<?php the_title(); ?>">
                            <?php endif; ?>
                        </div>
                    </div>
                    <div class="content">
                    	<div class="main">
                        	<h2><?php the_title(); ?></h2>
                            <h3><?php echo $subtitle; ?></h3>
                        	<p><?php the_content(); ?></p>
                            <?php if ( !empty($collaborations) ) : ?>
                            <div class="collaborations">
                            	<h4>Collaborations</h4>
                                <p><?php echo $collaborations; ?>.... <a href="#">Read More</a></p>
                            </div>
                            <?php endif; ?>
                        </div>
                    </div>
                </article>
                
                <?php endwhile; ?>
                
            </div>
            
            <div class="navigation"><a href="<?php echo get_next_posts_page_link(); ?>">More</a></div>
            
            <script type="text/javascript">				
				$('#about').infinitescroll("destroy").infinitescroll({
					pixelsFromNavToBottom: -Math.round( $(window).height() * 0.6 ),
      				bufferPx: Math.round( $(window).height() * 0.9 )
				}, function( appended ) {
					
					for( var elem in appended )
						$(appended[elem]).sticky({ offset: 72 });
				});
			</script>

<?php get_footer(); ?>
