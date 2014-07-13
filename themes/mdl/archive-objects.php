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
	
	if( isset($_REQUEST['search']) && !empty($_REQUEST['search']) )
		$args['s'] = mysql_real_escape_string($_REQUEST['search']);
	
	if( isset($_REQUEST['designer_id']) && !empty($_REQUEST['designer_id']) )
		$args = wp_filter_add_meta('designer_id', $_REQUEST['designer_id'], $args);
		
	if( isset($_REQUEST['manufacturer_id']) && !empty($_REQUEST['manufacturer_id']) )
		$args = wp_filter_add_meta('manufacturer_id', $_REQUEST['manufacturer_id'], $args);
		
	if( isset($_REQUEST['category_id']) && !empty($_REQUEST['category_id']) )
		$args['cat'] = $_REQUEST['category_id'];
?>

<!-- 			<div id="page" class="container">
            	<div class="page-the">The Show</div>
                <div class="page-title"><h1>An Inside Look at Innovative Product Design.</h1></div>
                <div class="page-excerpt">Lisa S. Roberts began her "Antiques of the Future" collection in the early nineteen eighties. Intended to raise public awareness of superior product design, her collection includes upwards of 250 products that she believes will significantly increase in value....</div>
                <div class="page-excerpt-full">Lisa S. Roberts began her "Antiques of the Future" collection in the early nineteen eighties. Intended to raise public awareness of superior product design, her collection includes upwards of 250 products that she believes will significantly increase in value, once they are no longer in production. Because Lisa has to be selective in choosing products for her collection, she draws on the advice of a team of museum curators, industrial and graphic designers, store owners, and other design professionals. Lisa S. Roberts began her "Antiques of the Future" collection in the early nineteen eighties. Intended to raise public awareness of superior product design, her collection includes upwards of 250 products that she believes will significantly increase in value, once they are no longer in production. Because Lisa has to be selective in choosing products for her collection, she draws on the advice of a team of museum curators, industrial and graphic designers, store owners, and other design professionals. Lisa S. Roberts began her "Antiques of the Future" collection in the early nineteen eighties. Intended to raise public awareness of superior product design, her collection includes upwards of 250 products that she believes will significantly increase in value, once they are no longer in production. Because Lisa has to be selective in choosing products for her collection, she draws on the advice of a team of museum curators, industrial and graphic designers, store owners, and other design professionals. Lisa S. Roberts began her "Antiques of the Future" collection in the early nineteen eighties. Intended to raise public awareness of superior product design, her collection includes upwards of 250 products that she believes will significantly increase in value, once they are no longer in production. Because Lisa has to be selective in choosing products for her collection, she draws on the advice of a team of museum curators, industrial and graphic designers, store owners, and other design professionals.</div>
                <div class="page-read-more">
                	<a href="#" onclick="return showPage(this);">Read More</a>
                </div>
            </div>   -->        
			
            <div class="container nav-panel">
            	<div class="selector">
                	<div class="panel">
                        <ul class="menu">
                            <li class="quick">
                            	<a href="#" class="external" onclick="return showDrop(this, '#designers');" style="color: #d70377;">Designer</a>
                            </li>
                            <li class="quick">
                            	<a href="#" class="external" onclick="return showDrop(this, '#manufacturer');">Manufacturer</a>
                            </li>
                            <li class="quick">
                            	<a href="#" class="external" onclick="return showDrop(this, '#categories');" style="color: #00bcff;">Category</a>
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
                            </div>
                            
                            <div class="drop" id="categories">
                            	<ul>
                                	<li><a href="?">All</a></li>
                            		<?php $categories = get_categories();
									
									if( $categories ) foreach($categories as $category) : ?>
                                    	<li><a href="<?php wp_filter_url_build('category_id', $category->term_id); ?>"><?php echo $category->cat_name; ?></a></li>
									<?php endforeach; ?>
                                </ul>
                            </div>
                        </ul>
                    </div>
                </div>
            </div>
            
            <div id="grid" class="container">
            	<a href="#" class="search-btn external" onclick="$('#search').addClass('show'); return false;"></a>
            	<div class="gutter-sizer"></div>
                <?php query_posts( $args ); ?>
                <?php if( have_posts() ) while ( have_posts() ) : the_post(); ?>
                
                <?php $thumb = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), 'med-large' );
					$designer = get_post_meta( $post->ID, 'Designer', true );
					$category = get_the_category();
				?>
            	<article class="item post hide" id="post-<?php the_ID(); ?>">
                	<img src="<?php echo $thumb[0]; ?>" alt="<?php the_title(); ?>" width="<?php echo $thumb[1]; ?>" height="<?php echo $thumb[2]; ?>">
                    <a href="<?php the_permalink(); ?>" class="display">
                    	<h2><?php the_title(); ?></h2>
                        <div class="desc">
                        	<span class="date"><?php the_time('Y'); ?></span> | <span class="designer"><?php echo $designer; ?></span>
                        </div>
                        <div class="category"><?php echo $category[0]->cat_name; ?></div>
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
                    // totalPages = opts.totalPages
                    after : function(newElements){

                        $container.find('img').each(function(){
                            $(this).on('load',function(){
                                var $item =  $(this).parent();
                                $container.isotope('appended', $item.removeClass('hide'));
                                $item.find('.display').css( 'top', ( $item.innerHeight() - $item.find('.display').innerHeight()) / 2 );
                            })
                        })

                        // $container.imagesLoaded(function() {
                        //  $container.isotope('appended', $(newElements).removeClass('hide'));
                        //  $container.find('.item').each(function() {
                        //     $(this).find('.display').css( 'top', ( $(this).innerHeight() - $(this).find('.display').innerHeight()) / 2 );
                        // });
                    // });
                    }

                })
            })

				// var $container = $('#grid');

				
				// $container.infinitescroll("destroy").infinitescroll({
				// 	pixelsFromNavToBottom: -Math.round( $(window).height() * 0.6 ),
    //   				bufferPx: Math.round( $(window).height() * 0.9 )
				// }, function( newElements, self ) {
                    
    //                 // $container.find('.navigation a').attr('href',self.path[0] + (self.state.currPage + 1) + '/');
					// $container.imagesLoaded(function() {
     //                     $container.isotope('appended', $(newElements).removeClass('hide'));
					// 	 $container.find('.item').each(function() {
					// 		$(this).find('.display').css( 'top', ( $(this).innerHeight() - $(this).find('.display').innerHeight()) / 2 );
					// 	});
     //            	});
				// });
			</script>

<?php get_footer(); ?>