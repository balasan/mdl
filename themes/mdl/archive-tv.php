<?php get_header(); ?>

			<?php
           		
			query_posts( array( 'pagename' => 'tv' ) );
            	
			if( have_posts() ) while ( have_posts() ) : the_post();
			
			?>
			<div id="page" class="container">
            	<div class="page-the">My Design Life</div>
                <div class="page-title"><h1><?php the_field('sub-title'); ?></h1></div>
                <div class="page-excerpt"><?php the_excerpt(); ?></div>
                <div class="page-excerpt-full"><?php the_content(); ?></div>
                <div class="page-read-more">
                	<a href="#" class="external" onclick="return showPage(this);">Read More</a>
                </div>
            </div>
            <?php endwhile; ?>
            
            <div class="container nav-panel">
            	<div class="selector">
                	<div class="panel">
                        <ul class="menu">
                            <li class="quick blue">
                            	<a href="#" class="external" onclick="$(this).parent().toggleClass('active'); $('.drop').toggleClass('show'); return false;">
                                	<span>Episodes</span>
                                    <i class="fa fa-caret-down"></i>
                                </a>
                            </li>
                            
                            <div class="drop">
                                <ul>
                                <?php query_posts( array( 'post_type' => 'tv', 'posts_per_page' => -1, 'order' => 'DESC' ) ); ?>
                                <?php if( have_posts() ) while ( have_posts() ) : the_post(); ?>
                                    <li><a href="#" class="external" onclick="return showEpisode('<?php the_ID(); ?>');"><?php the_title(); ?></a></li>
                                <?php endwhile; ?>
                                </ul>
                                <div class="close" style="display: none;" onclick="hideDrops();"><i class="fa fa-chevron-right"></i></div>
                            </div>
                        </ul>
                    </div>
                </div>
            </div>
            
            <?php query_posts( array( 'post_type' => 'tv', 'posts_per_page' => -1, 'order' => 'DESC' ) ); ?>
    		<div id="videos" class="container">
            	
                <?php if( have_posts() ) while ( have_posts() ) : the_post(); ?>
                
                <?php
					$subtitle = get_post_meta( $post->ID, 'subtitle', true );
					$video_url = get_post_meta( $post->ID, 'video_url', true );
				?>
                
                <article class="post video stickem-container" data-sticky_parent id="post-<?php the_ID(); ?>">
                    <div class="content desktop-small">
                    	<div class="main">
                        	<h2><?php the_title(); ?></h2>
                            <h3><?php echo $subtitle; ?></h3>
                        	<p><?php the_content(); ?></p>
                        </div>
                    </div>
                    <div class="aside">
                    	<div class="image stickem" data-sticky_column>
                        	<div class="player">
                            	<?php if ( !empty($video_url) ) : ?>
                                
                                

                                <a href="<?php echo $video_url; ?>" class="video-link"></a>
                            	
                                <!-- <div style="height: 282px; overflow: hidden;" class="ytPlayer" data-property="{videoURL:'<?php echo $video_url; ?>',containment:'self',autoPlay:false, mute:false, startAt:0, opacity:1, loop:false}"> -->
                                <!-- </div> -->
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                    <div class="content mobile-small">
                        <div class="main">
                            <h2><?php the_title(); ?></h2>
                            <h3><?php echo $subtitle; ?></h3>
                            <p><?php the_content(); ?></p>
                        </div>
                    </div>
                </article>
                
                <?php endwhile; ?>
                
            </div>
            
            <div class="navigation"><a href="<?php echo get_next_posts_page_link(); ?>">More</a></div>

<?php get_footer(); ?>
