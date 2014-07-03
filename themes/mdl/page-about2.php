<?php if( !is_ajax() ) get_header();
	
    $paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
	
	query_posts( array( 'post_type' => 'designers', 'posts_per_page' => 10, 'order' => 'DESC', 'paged' => $paged ) );

?>
			
    		<div id="about" class="container">
            	
                <?php if( have_posts() ) while ( have_posts() ) : the_post(); ?>
                
                <?php
                	$thumb = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), 'large' ); $url = $thumb['0'];
					$collaborations = get_post_meta( $post->ID, 'collaborations' );
				?>
                
            	<article class="person stickem-container" id="post-<?php the_ID(); ?>">
                	<div class="aside">
                    	<div class="image stickem">
                        	<img src="<?php echo $url; ?>" alt="<?php the_title(); ?>">
                        </div>
                    </div>
                    <div class="content">
                    	<div class="main">
                        	<h2><?php the_title(); ?></h2>
                            <h3><?php echo get_post_meta( $post->ID, 'subtitle' ); ?></h3>
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

<?php if( !is_ajax() ) get_footer(); ?>