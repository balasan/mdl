<?php get_header();
	
	$paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
	
	$designer_id = $_REQUEST['designer'];
	
	function wp_filter_add_meta($meta_key, $meta_value, $options)
	{
		if( !isset( $options['meta_query'] ) )
			$options['meta_query'] = array();
			
		$options['meta_query'][] = array(
			'key' => $meta_key,
			'value' => $meta_value
		);
			
		return $options;
	}
	
	function wp_filter_url_build($meta_key, $meta_value = '')
	{
		$wp_filter_url = array();
		
		if( !empty( $meta_value ) )
			$wp_filter_url[$meta_key] = $meta_value;
		
		echo ((count($wp_filter_url)) ? '?':'') . http_build_query($wp_filter_url);
	}	
	
	$args = array(
		'post_type' => 'objects',
		'posts_per_page' => 30,
		'order' => 'DESC',
		'paged' => $paged
	);


	
	if( isset($_REQUEST['search']) && !empty($_REQUEST['search']) ){
        $searchString = urldecode($_REQUEST['search']);
		$args['relation'] =  'OR';
        $args['s'] = $searchString;

        $args2 = array(
            'post_type' => 'objects',
            'posts_per_page' => 30,
            'order' => 'DESC',
            'paged' => $paged
        ); 

        $args2['meta_query'] = array(
            'relation' => 'OR', /* <-- here */
            array(
                'key' => 'Designer',
                'value' => $searchString,
                'compare' => 'LIKE'
            ),
            array(
                'key' => 'Manufacturer',
                'value' => $searchString,
                'compare' => 'LIKE'
            ),
            array(
                'key' => 'productType',
                'value' => $searchString,
                'compare' => 'LIKE'
            ),
        );
    }
	if( isset($_REQUEST['designer_id']) && !empty($_REQUEST['designer_id']) )
		$args = wp_filter_add_meta('designer_id', $_REQUEST['designer_id'], $args);
		
	if( isset($_REQUEST['manufacturer_id']) && !empty($_REQUEST['manufacturer_id']) )
		$args = wp_filter_add_meta('manufacturer_id', $_REQUEST['manufacturer_id'], $args);
		
	if( isset($_REQUEST['category_id']) && !empty($_REQUEST['category_id']) )
		$args['tag'] = $_REQUEST['category_id'];
?>     

			<?php
           		
			query_posts( array( 'pagename' => 'objects' ) );
            	
			if( have_posts() ) while ( have_posts() ) : the_post();
			
			?>
			<div id="page" class="container">
            	<div class="page-the" style="color: rgba(175, 192, 20, 1);">Antiques of the Future</div>
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
                            <li class="quick">
                            	<a href="#" class="external" onclick="return showDrop(this, '#designers');" style="color: #d70377;">
                                	<span>Designer</span>
                                    <i class="fa fa-caret-down"></i>
                                </a>
                            </li>
                            <li class="quick">
                            	<a href="#" class="external" onclick="return showDrop(this, '#manufacturer');">
                                	<span>Manufacturer</span>
                                    <i class="fa fa-caret-down"></i>
                                </a>
                            </li>
                            <li class="quick">
                            	<a href="#" class="external" onclick="return showDrop(this, '#categories');" style="color: #00bcff;">
                                	<span>Category</span>
                                    <i class="fa fa-caret-down"></i>
                                </a>
                            </li>
                            
                            <div class="drop" id="designers">
                            	<ul>
                                	<li><a href="?">All</a></li>
                                	<?php $filter_designer = new WP_Query( array( 'post_type' => 'designer', 'posts_per_page' => -1, 'orderby' => 'title', 'order' => 'ASC' ) ); ?>
                                    <?php if( $filter_designer->have_posts() ) while ( $filter_designer->have_posts() ) : $filter_designer->the_post();  ?>
                                    	<?php $title = get_the_title(); if ( !empty( $title ) ) : ?>
                                        <li><a href="<?php wp_filter_url_build('designer_id', get_the_ID()); ?>"><?php echo $title; ?></a></li>
                                        <?php endif; ?>
                                    <?php endwhile; ?>
                                </ul>
                                <div class="close" onclick="hideDrops();"><i class="fa fa-chevron-right"></i></div>
                            </div>
                            
                            <div class="drop" id="manufacturer">
                            	<ul>
                                	<li><a href="?">All</a></li>
                                	<?php $filter_manufacturer = new WP_Query( array( 'post_type' => 'Manufacturer', 'posts_per_page' => -1, 'orderby' => 'title', 'order' => 'ASC' ) ); ?>
                                    <?php if( $filter_manufacturer->have_posts() ) while ( $filter_manufacturer->have_posts() ) : $filter_manufacturer->the_post();  ?>
                                    	<?php $title = get_the_title(); if ( !empty( $title ) ) : ?>
                                    	<li><a href="<?php wp_filter_url_build('manufacturer_id', get_the_ID()); ?>"><?php echo $title; ?></a></li>
                                        <?php endif; ?>
                                    <?php endwhile; ?>
                                </ul>
                                <div class="close" onclick="hideDrops();"><i class="fa fa-chevron-right"></i></div>
                            </div>
                            
                            <div class="drop" id="categories">
                            	<ul>
                                	<li><a href="?">All</a></li>
                            		<?php 
                                        $categories = get_categories('hide_empty=0');
								
                            		  // $categories = get_tags();
									
									if( $categories ) foreach($categories as $category) : ?>
                                    	<?php if ( !empty( $category->name ) ) : ?>
                                    	<li><a href="<?php wp_filter_url_build('category_id', $category->slug); ?>"><?php echo $category->name; ?></a></li>
                                        <?php endif; ?>
									<?php endforeach; ?>
                                </ul>
                                <div class="close" onclick="hideDrops();"><i class="fa fa-chevron-right"></i></div>
                            </div>
                        </ul>
                    </div>
                </div>
            </div>
            
            <div id="grid" class="container">
            	<a href="#" class="search-btn external" onclick="$('#search').addClass('show'); return false;">
                	<i class="fa fa-search"></i>
                </a>
            	<div class="gutter-sizer"></div>
                <?php 
                
                    if(!$args2){
                        $result = new WP_Query($args);
                        // $result->query( $args );
                    }
                    else{
                        $q1 = new WP_Query($args);
                        $q2 = new WP_Query($args2);

                        $merged = array_merge( $q1->posts, $q2->posts );
                        
                        $post_ids = array();
                        foreach( $merged as $item ) {
                            $post_ids[] = $item->ID;
                        }

                        $unique = array_unique($post_ids);

                        if(count($unique))
                            $result = new WP_Query(
                                array(
                                'post__in' => $unique,
                                'post_type' => 'objects',
                                'nopaging' => 1,
                                'order' => 'DESC',
                            ));
                        else{
                            $result = $q2;
                        }

                    }

                ?>

                <?php if( $result->have_posts() ) while ( $result->have_posts() ) : $result->the_post(); ?>
                
                <?php $thumb = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), 'med-large' );
					$designer = get_post_meta( $post->ID, 'Designer', true );
					$category = get_the_category();
				?>
            	<article class="item post hide" id="post-<?php the_ID(); ?>">
                	<a href="<?php the_permalink(); ?>">
                        <img src="<?php echo $thumb[0]; ?>" alt="<?php the_title(); ?>" width="<?php echo $thumb[1]; ?>" height="<?php echo $thumb[2]; ?>">
                        <div class="display">
                            <h2><?php the_title(); ?></h2>
                            <div class="desc">
                                <span class="date"><?php the_time('Y'); ?></span> | <span class="designer"><?php echo $designer; ?></span>
                            </div>
                            <div class="category"><?php echo $category[0]->cat_name; ?></div>
                        </div>
                    </a>
                </article>
                
                <?php endwhile; ?>

            <div class="navigation" data-url="<?php echo get_next_posts_page_link(); ?>"><a href="<?php echo get_next_posts_page_link(); ?>">More</a></div>

            </div>
            
            
            <script type="text/javascript">

            $( document ).ready(function(){		
                var $container = $('#grid');

                Infscroll.init({
                    navSelector : '.navigation',
                    loader : $('.loading'),
                    containerSelector : '#grid',
                    itemSelector: '.item',
                    after : function(newElements){
                        Infscroll.okToLoad = false;
                        $container.imagesLoaded(function() {
                            Infscroll.okToLoad = true;
                        })

                        $(newElements).each(function() {
							var self = $(this);
							
							self.find('img').one("load", function() {
								$container.isotope('appended', self.removeClass('hide'));
								$container.find('.item').each(function() {
									 $(this).find('.display').css( 'top', ( $(this).innerHeight() - $(this).find('.display').innerHeight()) / 2 );
								});
                            }).each(function() {
                                if(this.complete)
									$(this).load();
                            });
						});
                    }

                })
            })
			</script>

<?php get_footer(); ?>