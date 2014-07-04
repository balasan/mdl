<?php if( !is_ajax() ) get_header(); ?>

		<?php
            
			if( !is_ajax() ) : 
			
			$the_query = new WP_Query( array( 'page_id' => 11241 ) );
            	
			if( $the_query->have_posts() ) while ( $the_query->have_posts() ) : $the_query->the_post();
			
			$subtitle = get_post_meta( get_the_ID(), 'sub-title', true );
			?>
			<div id="page" class="container">
            	<div class="page-the"><?php the_title(); ?></div>
                <div class="page-title"><h1><?php echo $subtitle; ?></h1></div>
                <div class="page-excerpt"><?php the_excerpt(); ?></div>
                <div class="page-excerpt-full"><?php the_content(); ?></div>
                <div class="page-read-more">
                	<a href="#" onclick="return showPage(this);">Read More</a>
                </div>
            </div>
            <?php endwhile; ?>
            
            <?php endif; ?>
            
			<?php if( !is_ajax() ) : ?>
            <div class="container nav-panel">
            	<div class="selector">
                	<div class="panel">
                        <ul class="menu">
                            <li class="quick">
                            	<a href="#" onclick="$(this).parent().toggleClass('active'); $('.drop').toggleClass('show'); return false;">Episodes</a>
                            </li>
                            
                            <div class="drop">
                            <ul>
                            	<li><a href="<?php echo esc_url( home_url( '/' ) )?>/tv/">All</a></li>
                            <?php $taxonomies = get_object_taxonomies( (object) array( 'post_type' => 'tv' ) );
							
							foreach( $taxonomies as $taxonomy ) :
								
								$terms = get_terms( $taxonomy );
							
								foreach( $terms as $term ) :
										
									?><li><a href="<?php echo get_term_link($term, 'tv'); ?>"><?php echo $term->name; ?></a></li><?php
							
								endforeach;
							
							endforeach; ?>
                            </ul>
                            </div>
                        </ul>
                    </div>
                </div>
            </div>
            <?php endif; ?>
            
    		<div id="videos" class="container">
            	
                <?php if( have_posts() ) while ( have_posts() ) : the_post(); ?>
                
                <?php
					$subtitle = get_post_meta( $post->ID, 'subtitle', true );
					$video_url = get_post_meta( $post->ID, 'video_url', true );
				?>
                
                <article class="post video stickem-container" id="post-<?php the_ID(); ?>">
                    <div class="content">
                    	<div class="main">
                        	<h2><?php the_title(); ?></h2>
                            <h3><?php echo $subtitle; ?></h3>
                        	<p><?php the_content(); ?></p>
                        </div>
                    </div>
                    <div class="aside">
                    	<div class="image stickem">
                        	<div class="player">
                            	<?php if ( !empty($video_url) ) : ?>
                            	<div style="height: 282px; overflow: hidden;" class="ytPlayer" data-property="{videoURL:'<?php echo $video_url; ?>',containment:'self',autoPlay:false, mute:true, startAt:0, opacity:1, loop:false}">
                                </div>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </article>
                
                <?php endwhile; ?>
                
            </div>
            
            <div class="navigation"><a href="<?php echo get_next_posts_page_link(); ?>">More</a></div>
            
            <script type="text/javascript">
				$(function() {
					$(".ytPlayer").mb_YTPlayer();
				});
				$('#videos').infinitescroll({
					navSelector  : "div.navigation",
					nextSelector : "div.navigation a:first",
					itemSelector : "#videos .post",
					loading		 : {
						msgText 	: "<em>Loading...</em>",
						finishedMsg	: "<em>No additional posts.</em>",
						img			: "<?php echo get_template_directory_uri(); ?>/images/ajax-loader.gif"
					}
				}, function( appended ) { $(appended).find('.ytPlayer').mb_YTPlayer(); });
			</script>

<?php if( !is_ajax() ) get_footer(); ?>
