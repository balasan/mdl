<?php get_header();
	
    $paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
	
	$lastYear = 0;
	
	$args = array(
		'post_type' => 'press',
		'posts_per_page' => -1,
		'order' => 'DESC',
		'paged' => $paged,
		'meta_key' => 'date',
		'orderby' => 'meta_value_num'
	);
	
	query_posts($args); ?>
    
    		<div id="press" class="container">
            	
                <div class="wrapper">
                
                <h1>Press</h1>
                
                <?php if( have_posts() ) while ( have_posts() ) : the_post();
                	$time = strtotime(get_field('date'));
                	$Y = date('Y', $time);
					
					if( $lastYear == 0 )
						$lastYear = $Y; 
					
					if( $lastYear > $Y ) :
					?>
                    <div class="press-year">
						<div class="cron">
							<div class="year"><?php echo $Y; ?></div>
                        </div>
                    </div>
                    <?php endif; ?>
                
            	<article class="post press" id="post-<?php the_ID(); ?>">
                    <div class="content">
                    	<div class="main">
                        	<h2><?php the_title(); ?></h2>
                            <?php if( get_field('link') ) : ?>
                            <?php $url = parse_url(get_field('link')); ?>
                            <div class="link">
                            	<a target="_blank" href="<?php the_field('link'); ?>"><?php echo $url['host']; ?></a>
                            </div>
                            <?php endif; ?>
                        	<div class="date"><?php echo date('F jS, Y', $time); ?></div>
                        </div>
                    </div>
                </article>
                
                <?php endwhile; ?>
                
                </div>
                
            </div>
            
            <div class="navigation"><a href="<?php echo get_next_posts_page_link(); ?>">More</a></div>

<?php get_footer(); ?>
