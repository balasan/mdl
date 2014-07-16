<?php get_header(); ?>  

			<?php 
				$designer = get_post_meta( $post->ID, 'Designer', true );
				$designer_id = get_post_meta( $post->ID, 'designer_id', true ); ?>
			
			<div id="object" class="container">
				<article class="post object" id="post-<?php the_ID(); ?>" data-sticky_parent>
                	<div class="all-objects">
                    	<div class="row" data-sticky_column>
                    	<h2><?php echo $designer; ?></h2>
                        <?php $the_query = new WP_Query( array( 'post_type' => 'objects', 'meta_key' => 'designer_id', 'meta_value' => $designer_id ) ); ?>
                    	<?php if( $the_query->have_posts() ) while ( $the_query->have_posts() ) : $the_query->the_post();  ?>
                    	<?php $thumb = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), 'large' ); $src = $thumb['0']; ?>
                        <?php if( !empty( $src ) ) : ?>
                        <div class="image">
                        	<a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>">
                            	<img src="<?php echo $src; ?>" alt="<?php the_title(); ?>">
                            </a>
                        </div>
                        <?php endif; ?>
                        <?php endwhile; ?>
                        </div>
                    </div>
                    <div class="content">
                    	<div class="row" data-sticky_column>
                    	<?php if( have_posts() ) while ( have_posts() ) : the_post(); ?>
                        <?php $thumb = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), 'large' ); $src = $thumb['0']; ?>
                        <?php if( !empty( $src ) ) : ?>
                        <div class="image">
                        	<img src="<?php echo $src; ?>" alt="<?php the_title(); ?>">
                        </div>
                        <?php endif; ?>
                        <h2><?php the_title(); ?></h2>
                        <p><?php the_content(); ?></p>
                        <div class="enlarge">
                        	<a href="<?php echo $src; ?>" target="_blank" class="enlarge-btn">Enlarge +</a>
                            <script type="text/javascript">
								$('.enlarge-btn').fancybox({
									openEffect  : 'elastic',
									closeEffect : 'elastic',
									prevEffect	: 'elastic',
									nextEffect	: 'elastic',
									helpers :
									{
										title	:
										{
											type: 'outside'
										},
										overlay :
										{
											locked: false
										}
									}
								});
                            </script>
                        </div>
                        <?php endwhile; ?>
                        </div>
                    </div>
                    <div class="auther">
                    	<div class="row" data-sticky_column>
                    	<?php query_posts( array( 'p' => $designer_id, 'post_type' => 'designer' ) ); ?>
                    	<?php if( have_posts() ) while ( have_posts() ) : the_post(); ?>
                        <h2><?php the_title(); ?></h2>
                    	<?php $thumb = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), 'large' ); $src = $thumb['0']; ?>
                        <?php if( !empty( $src ) ) : ?>
                        <div class="image">
                        	<img src="<?php echo $src; ?>" alt="<?php the_title(); ?>">
                        </div>
                        <?php endif; ?>
                        <p><?php the_content(); ?></p>
                        <?php endwhile; ?>
                        </div>
                    </div>
                </article>
			</div>
            <script type="text/javascript">
			
			</script>

<?php get_footer(); ?>