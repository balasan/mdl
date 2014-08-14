<?php get_header();
	
    // $paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
	
	// query_posts( array( 'post_type' => 'designer', 'posts_per_page' => 10, 'order' => 'DESC', 'paged' => $paged ) );

?>

            <div id="press" class="container">
                


    		<div id="about" class="container">

                <?php if( have_posts() ) while ( have_posts() ) : the_post(); ?>
                
  
                <div class="wrapper">
                

                    <div class="content">
                         <h1>Contact</h1>

                    	<div class="contact">
                        	<h2><?php the_field('title'); ?></h2>
                            <h3><?php echo $subtitle; ?></h3>
                        	<p><?php the_content(); ?></p>
                            <?php if ( !empty($collaborations) ) : ?>
                            <div class="collaborations">
                            	<h4>Collaborations</h4>
                                <p><?php echo $collaborations; ?>
                                <!-- .... <a href="#">Read More</a></p> -->
                            </div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
                
                <?php endwhile; ?>
                
            </div>
            
            <!-- <div class="navigation"><a href="<?php echo get_next_posts_page_link(); ?>">More</a></div> -->
            
            <script type="text/javascript">
				// $('#about').infinitescroll("destroy").infinitescroll({
				// 	pixelsFromNavToBottom: -Math.round( $(window).height() * 0.6 ),
    //   				bufferPx: Math.round( $(window).height() * 0.9 )
				// }, function( appended ) {
					
				// 	for( var elem in appended )
				// 		$(appended[elem]).sticky({ offset: 72 });
				// });
			</script>

<?php get_footer(); ?>
