<?php
/**
 * The Header for our theme.
 *
 * Displays all of the <head> section and everything up till <div id="main">
 *
 */
?><!DOCTYPE html>

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
<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>" />
<?php wp_head(); ?>
<script type="text/javascript" src="<?php echo get_template_directory_uri() . '/js/jquery.easing-1.3.min.js' ?>"></script>
<script type="text/javascript" src="<?php echo get_template_directory_uri() . '/js/swiper/idangerous.swiper-2.4.2.js' ?>"></script>
<!-- <script src="http://cdnjs.cloudflare.com/ajax/libs/jquery.imagesloaded/3.0.4/jquery.imagesloaded.min.js"></script> -->
<!-- 
<script type="text/javascript" src="<?php echo get_template_directory_uri() . '/js/masonry.pkgd.min.js' ?>"></script>
 -->
<script type="text/javascript" src="<?php echo get_template_directory_uri() . '/js/jquery.isotope.min.js' ?>"></script>
<script type="text/javascript" src="<?php echo get_template_directory_uri() . '/js/jquery.mousewheel.min.js' ?>"></script>

<script type="text/javascript" src="<?php echo get_template_directory_uri() . '/js/history.js' ?>"></script>
<script type="text/javascript" src="<?php echo get_template_directory_uri() . '/js/history.adapter.jquery.js' ?>"></script>
<script type="text/javascript" src="<?php echo get_template_directory_uri() . '/js/router.js' ?>"></script>

<script type="text/javascript" src="<?php echo get_template_directory_uri() . '/js/ytplayer/inc/jquery.mb.YTPlayer.js' ?>"></script>

<script type="text/javascript">
//   var setting = { 
//     host: '<?php echo home_url( '/' ); ?>',
//     paged: <?php echo (get_query_var('paged')) ? get_query_var('paged') : 1; ?> 
//   };
// </script>

</head>

<body <?php body_class(); ?> data-base=<?php echo esc_url( home_url( '/' ) )?>>
<div id="wrapper" class="hfeed" >
<!-- 
  <?php get_sidebar(); ?>

 -->
  

  <header id="header">
  Site Header
  </header>

  <div class="loader">
  </div>



  <div id="main">


