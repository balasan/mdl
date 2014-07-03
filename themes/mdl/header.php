<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>" />
<meta name="viewport" content="width=device-width, height=device-height, initial-scale=1, maximum-scale=1, user-scalable=0" />

<title><?php
  /*
   * Print the <title> tag based on what is being viewed.
   */
  global $page, $paged;

  wp_title( '|', true, 'right' );

  // Add the blog name.
  bloginfo( 'name' );

  // Add the blog description for the home/front page.
  $site_description = get_bloginfo( 'description', 'display' );
  if ( $site_description && ( is_home() || is_front_page() ) )
    echo " | $site_description";
?>
</title>
<link rel="shortcut icon" href="<?php echo esc_url( home_url( '/' ) ); ?>favicon.ico">
<link rel="profile" href="http://gmpg.org/xfn/11" />
<link rel="stylesheet" type="text/css" media="all" href="<?php bloginfo( 'stylesheet_url' ); ?>" />
<link rel="stylesheet" type="text/css" media="all" href="<?php echo get_template_directory_uri() . '/js/ytplayer/css/YTPlayer.css' ?>" />
<link rel="stylesheet" type="text/css" media="all" href="<?php echo get_template_directory_uri() . '/css/idangerous.swiper.css' ?>" />
<link rel="stylesheet" type="text/css" media="all" href="<?php echo get_template_directory_uri() . '/css/style.css' ?>" />

<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>" />
<?php wp_head(); ?>
<script type="text/javascript" src="<?php echo get_template_directory_uri() . '/js/ytplayer/jquery.mb.YTPlayer.js' ?>"></script>
<script type="text/javascript" src="<?php echo get_template_directory_uri() . '/js/jquery.easing-1.3.min.js' ?>"></script>
<script type="text/javascript" src="<?php echo get_template_directory_uri() . '/js/jquery.mousewheel.min.js' ?>"></script>
<script type="text/javascript" src="<?php echo get_template_directory_uri() . '/js/history.js' ?>"></script>
<script type="text/javascript" src="<?php echo get_template_directory_uri() . '/js/history.adapter.jquery.js' ?>"></script>
<script type="text/javascript" src="<?php echo get_template_directory_uri() . '/js/router.js' ?>"></script>

<script type="text/javascript" src="http://imagesloaded.desandro.com/imagesloaded.pkgd.min.js"></script>

<script type="text/javascript" src="<?php echo get_template_directory_uri() . '/js/ytplayer/inc/jquery.mb.YTPlayer.js' ?>"></script>
<script type="text/javascript" src="<?php echo get_template_directory_uri() . '/js/jquery.infinitescroll.js?ver=2.6.1' ?>"></script>
<script type="text/javascript" src="<?php echo get_template_directory_uri() . '/js/jquery.isotope.min.js' ?>"></script>
<script type="text/javascript" src="<?php echo get_template_directory_uri() . '/js/jquery.scripts.js' ?>"></script>

</head>

<?php
	$menu_args = array(
	  'theme_location'  => '',
	  'menu'            => '', 
	  'container'       => false, 
	  'container_class' => '', 
	  'container_id'    => '',
	  'menu_class'      => 'menu', 
	  'menu_id'         => '',
	  'echo'            => true,
	  'fallback_cb'     => 'wp_page_menu',
	  'before'          => '',
	  'after'           => '',
	  'link_before'     => '',
	  'link_after'      => '',
	  'items_wrap'      => '<ul id=\"%1$s\" class=\"%2$s\">%3$s</ul>',
	  'depth'           => 0
	);
?>

<body <?php body_class(); ?> data-base="<?php echo esc_url( home_url( '/' ) )?>">
	
    <div id="wrapper">
    	<header id="header">
            <nav id="navigation">
            	<div class="logo">My Design Life</div>
                <ul class="menu">
                	<?php //wp_nav_menu( $menu_args ); ?>
                    <li><a href="<?php echo esc_url( home_url( '/' ) )?>">HOME</a></li>
                	<li><a href="<?php echo esc_url( home_url( '/' ) )?>books/" class="books">BOOKS</a></li>
                    <li><a href="<?php echo esc_url( home_url( '/' ) )?>works/" class="aotf">ANTIQUES OF THE FUTURE</a></li>
                    <li><a href="<?php echo esc_url( home_url( '/' ) )?>about/" class="about">ABOUT</a></li>
                    <li><a href="<?php echo esc_url( home_url( '/' ) )?>tv/" class="tv">TV</a></li>
                </ul>
                <ul class="nav-btn"><li></li><li></li><li></li></ul>
            </nav>
        </header>
        
        <div id="container">
	