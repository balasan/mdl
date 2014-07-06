<?php if( !is_ajax() ) get_header();
	 require_once(ABSPATH . 'wp-admin/includes/taxonomy.php'); 

    query_posts( array( 'post_type' => 'objects', 'posts_per_page' => -1, 'order' => 'DESC') );

    if( have_posts() ) while ( have_posts() ) : the_post(); 

        $cat = get_post_custom_values('productType')[0];

        $idObj = null;
        $idObj = get_category_by_slug($cat);
        if(!$idObj){
            echo  $cat. '<br>';
            wp_create_category($cat);
        } 


    endwhile;
    // endif;
    ?>