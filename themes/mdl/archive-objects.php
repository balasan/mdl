<?php get_header();
	
	$paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
	
	query_posts( array( 'post_type' => 'objects', 'posts_per_page' => 30, 'order' => 'DESC', 'paged' => $paged ) );
?>

			<!--<div id="page" class="container">
            	<div class="page-the">The Show</div>
                <div class="page-title"><h1>An Inside Look at Innovative Product Design.</h1></div>
                <div class="page-excerpt">Lisa S. Roberts began her "Antiques of the Future" collection in the early nineteen eighties. Intended to raise public awareness of superior product design, her collection includes upwards of 250 products that she believes will significantly increase in value....</div>
                <div class="page-excerpt-full">Lisa S. Roberts began her "Antiques of the Future" collection in the early nineteen eighties. Intended to raise public awareness of superior product design, her collection includes upwards of 250 products that she believes will significantly increase in value, once they are no longer in production. Because Lisa has to be selective in choosing products for her collection, she draws on the advice of a team of museum curators, industrial and graphic designers, store owners, and other design professionals. Lisa S. Roberts began her "Antiques of the Future" collection in the early nineteen eighties. Intended to raise public awareness of superior product design, her collection includes upwards of 250 products that she believes will significantly increase in value, once they are no longer in production. Because Lisa has to be selective in choosing products for her collection, she draws on the advice of a team of museum curators, industrial and graphic designers, store owners, and other design professionals. Lisa S. Roberts began her "Antiques of the Future" collection in the early nineteen eighties. Intended to raise public awareness of superior product design, her collection includes upwards of 250 products that she believes will significantly increase in value, once they are no longer in production. Because Lisa has to be selective in choosing products for her collection, she draws on the advice of a team of museum curators, industrial and graphic designers, store owners, and other design professionals. Lisa S. Roberts began her "Antiques of the Future" collection in the early nineteen eighties. Intended to raise public awareness of superior product design, her collection includes upwards of 250 products that she believes will significantly increase in value, once they are no longer in production. Because Lisa has to be selective in choosing products for her collection, she draws on the advice of a team of museum curators, industrial and graphic designers, store owners, and other design professionals.</div>
                <div class="page-read-more">
                	<a href="#" onclick="return showPage(this);">Read More</a>
                </div>
            </div>-->          
			
            <div class="container nav-panel">
            	<div class="selector">
                	<div class="panel">
                        <ul class="menu">
                            <li class="quick">
                            	<a href="#" class="external" onclick="return showDrop(this, '#drop1');" style="color: #d70377;">Designer</a>
                            </li>
                            <li class="quick">
                            	<a href="#" class="external" onclick="return showDrop(this, '#drop2');">Manufacturer</a>
                            </li>
                            <li class="quick">
                            	<a href="#" class="external" onclick="return showDrop(this, '#drop3');" style="color: #00bcff;">Category</a>
                            </li>
                            
                            <div class="drop" id="drop1">
                            	<ul>
                                	<li><a href="#">Harry Allen</a></li>
                                    <li><a href="#">Ron Arad</a></li>
                                    <li><a href="#">Ron Arad and Issey Miyake</a></li>
                                    <li><a href="#">Arnell Group</a></li>
                                    <li><a href="#">Maarten Baas</a></li>
                                    <li><a href="#">Yves Behar</a></li>
                                    <li><a href="#">Dror Benshetrit</a></li>
                                    <li><a href="#">Maria Berntsen</a></li>
                                    <li><a href="#">Marc Berthier</a></li>
                                </ul>
                            </div>
                            
                            <div class="drop" id="drop2">
                            	<ul>
                                	<li><a href="#">Harry Allen</a></li>
                                    <li><a href="#">Ron Arad</a></li>
                                    <li><a href="#">Ron Arad and Issey Miyake</a></li>
                                    <li><a href="#">Arnell Group</a></li>
                                    <li><a href="#">Maarten Baas</a></li>
                                    <li><a href="#">Yves Behar</a></li>
                                    <li><a href="#">Dror Benshetrit</a></li>
                                    <li><a href="#">Maria Berntsen</a></li>
                                    <li><a href="#">Marc Berthier</a></li>
                                </ul>
                            </div>
                            
                            <div class="drop" id="drop3">
                            	<ul>
                                	<li><a href="#">Harry Allen</a></li>
                                    <li><a href="#">Ron Arad</a></li>
                                    <li><a href="#">Ron Arad and Issey Miyake</a></li>
                                    <li><a href="#">Arnell Group</a></li>
                                    <li><a href="#">Maarten Baas</a></li>
                                    <li><a href="#">Yves Behar</a></li>
                                    <li><a href="#">Dror Benshetrit</a></li>
                                    <li><a href="#">Maria Berntsen</a></li>
                                    <li><a href="#">Marc Berthier</a></li>
                                </ul>
                            </div>
                        </ul>
                    </div>
                </div>
            </div>
            
            <div id="grid" class="container">
            	<div class="gutter-sizer"></div>
                <?php if( have_posts() ) while ( have_posts() ) : the_post(); ?>
                
                <?php $thumb = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), 'large' );
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
            </div>
            
            <div class="navigation"><a href="<?php echo get_next_posts_page_link(); ?>">More</a></div>
            
            <script type="text/javascript">		
				var $container = $('#grid');
				
				$container.infinitescroll("destroy").infinitescroll({
					pixelsFromNavToBottom: -Math.round( $(window).height() * 0.6 ),
      				bufferPx: Math.round( $(window).height() * 0.9 )
				}, function( newElements ) {
					$container.imagesLoaded(function() {
                         $container.isotope('appended', $(newElements).removeClass('hide'));
						 
						 $container.find('.item').each(function() {
							$(this).find('.display').css( 'top', ( $(this).innerHeight() - $(this).find('.display').innerHeight()) / 2 );
						});
                	});
				});
			</script>

<?php get_footer(); ?>