<?php

// update_option('siteurl','http://192.168.1.3/wordpress');
// update_option('home','http://192.168.1.3/wordpress');

// update_option('upload_url_path', 'http://localhost:8888/mdl/wp-content/uploads');
// update_option('upload_url_path', 'http://localhost:8888/mdl/wp-content/uploads');


add_filter( 'show_admin_bar', '__return_false' );

// This theme uses post thumbnails
	add_theme_support( 'post-thumbnails' );

// Additional Image Sizes
if ( function_exists( 'add_image_size' ) ) {
	// add_image_size( 'large-news', 620, 800 );
}

//Navigation Menus
if ( function_exists( 'register_nav_menus' ) ) {
	register_nav_menus(
		array(
		  'main' => 'Main Menu'
		)
	);
}
add_action('admin_init', 'flush_rewrite_rules');



//Post Type
add_action( 'init', 'create_post_type' );




function create_post_type() {

	register_post_type( 'Books',
		array(
			'labels' => array(
				'name' => __( 'Books' ),
				'singular_name' => __( 'Book' )
			),
			'public' => true,
			'publically_queryable' => true,

			'has_archive' => true,
			'rewrite' => array('slug' => 'slideshows', 'with_front' => false),
			'supports' => array('title','editor','thumbnail', 'revisions'),
			'taxonomies' => array('category')
		)
	);

	register_post_type( 'Objects',
		array(
			'labels' => array(
				'name' => __( 'Objects' ),
				'singular_name' => __( 'Object' )
			),
			'public' => true,
			'publically_queryable' => true,
			'has_archive' => true,
			'hierarchical' => true,
			'rewrite' => array('slug' => 'works', 'with_front' => false),
			'hierarchical' => true,
			// page-attributes enables parent/child for posts
			// 'capability_type' => 'page',
			'supports' => array('page-attributes', 'title','editor','thumbnail', 'revisions','custom-fields'),
			'taxonomies' => array('category','post_tag')
		)
	);

  //  register_taxonomy(
  //     'object_categories',
  //     'objects',
  //     array(
  //         'labels' => array(
  //             'name' => 'Object Categories',
  //             'add_new_item' => 'Add New Object Category',
  //             'new_item_name' => "New Object Category"
  //         ),
  //         'rewrite'			=> array(
		// 		'slug' 			=> 'object-cat', // This controls the base slug that will display before each term
		// 		'with_front' 	=> false // Don't display the category base before
		// 		),
  //         'show_ui' => true,
  //         'show_tagcloud' => false,
  //         'hierarchical' => true,
  //         'hasArchive' => true
  //     )
  // );


	register_post_type( 'Designer',
		array(
			'labels' => array(
				'name' => __( 'Designers' ),
				'singular_name' => __( 'Designer' )
			),
			'public' => true,
			'publically_queryable' => true,
			'has_archive' => true,
			'rewrite' => array('slug' => 'projects', 'with_front' => false),
			'hierarchical' => true,
			// page-attributes enables parent/child for posts
			'supports' => array('page-attributes', 'title','editor','thumbnail', 'revisions','custom-fields'),
			'taxonomies' => array('category','post_tag')
		)
	);

	register_post_type( 'Manufacturer',
		array(
			'labels' => array(
				'name' => __( 'Manufacturers' ),
				'singular_name' => __( 'Manufacturer' )
			),
			'public' => true,
			'publically_queryable' => true,
			'has_archive' => true,
			'rewrite' => array('slug' => 'projects', 'with_front' => false),
			'hierarchical' => true,
			// page-attributes enables parent/child for posts
			'supports' => array('page-attributes', 'title','editor','thumbnail', 'revisions','custom-fields'),
			'taxonomies' => array('category','post_tag')
		)
	);

	register_post_type( 'Press',
		array(
			'labels' => array(
				'name' => __( 'Press' ),
				'singular_name' => __( 'Press' )
			),
			'public' => true,
			'publically_queryable' => true,
			'has_archive' => true,
			'rewrite' => array('slug' => 'news', 'with_front' => false),
			'hierarchical' => true,
			// page-attributes enables parent/child for posts
			'supports' => array('page-attributes', 'title','editor','thumbnail', 'revisions'),
			// 'taxonomies' => array('category')
		)
	);



	register_post_type( 'tv',
		array(
			'labels' => array(
				'name' => __( 'TV Episodes' ),
				'singular_name' => __( 'TV Episode' )
			),
			'public' => true,
			'publically_queryable' => true,
			'has_archive' => true,
			'rewrite' => array('slug' => 'products', 'with_front' => false),
			'hierarchical' => true,
			// page-attributes enables parent/child for posts
			'supports' => array('page-attributes', 'title','editor','thumbnail', 'revisions'),
			'taxonomies' => array('category')
		)
	);
}




//initiate sessions

add_action('init', 'myStartSession', 1);
add_action('wp_logout', 'myEndSession');
add_action('wp_login', 'myEndSession');

function myStartSession() {
    if(!session_id()) {
        session_start();
        header("Cache-Control: no-cache");
		header("Pragma: no-cache");
    }
}

function myEndSession() {
    session_destroy ();
}

// firefox sessions fix

remove_action('wp_head', 'adjacent_posts_rel_link_wp_head');


// add scripts

function theme_script()
{
	wp_deregister_script('jquery');
	wp_register_script ('jquery', 'http://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js');
	/*wp_register_script ('jquery', 'https://ajax.googleapis.com/ajax/libs/jquery/1.8.1/jquery.min.js');*/
 	/*wp_register_script( 'jquery', get_template_directory_uri() . '/js/jquery-1.8.1.min.js');*/
	wp_register_script( 'app', get_template_directory_uri() . '/js/app.js');
	wp_enqueue_script('jquery');
	wp_enqueue_script('app');
}

add_action('wp_enqueue_scripts','theme_script');

	add_action('wp_ajax_search', 'ajax_search_request');
	add_action('wp_ajax_nopriv_search', 'ajax_search_request');

	function ajax_search_request() {
		
		$value = mysql_real_escape_string($_REQUEST['value']);
		
		$args = array(
			's' => $value,
			'posts_per_page' => 8,
			'post_type' => array('projects', 'news', 'works')
		);
		
		$query = new WP_Query( $args );
		
		while ( $query->have_posts() ) {
			$query->the_post();
			echo '<li><a href="' . get_permalink() . '" onclick="return nav.go(this);"><span>' . get_post_type() . '</span><p>' . get_the_title() . '</p></a></li>';
		}
		
		exit;
	}



?>