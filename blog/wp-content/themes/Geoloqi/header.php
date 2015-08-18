<!doctype html>
<html lang="en" class="no-js" itemscope itemtype="http://schema.org/Article">
<head>
  <meta charset="utf-8">

  <!-- www.phpied.com/conditional-comments-block-downloads/ -->
  <!--[if IE]><![endif]-->

	<title><?php wp_title(''); ?></title>

	<link rel="shortcut icon" href="<?php bloginfo('stylesheet_directory')?>/images/favicon.png">
	<!--
    <?php versioned_stylesheet($GLOBALS["TEMPLATE_RELATIVE_URL"]."style.css") ?>
	-->
  <!--
  <link rel="stylesheet" href="http://web-local.geoloqi.com:9393/css/blog.css">
  -->
  <link rel="stylesheet" href="http://geoloqi.com/css/blog.css">

	<?php wp_enqueue_script( $handle = 'modernizr'); ?>
  <?php wp_enqueue_script( $handle = 'jquery'); ?>
  	
	<!-- Wordpress Head Items -->
  <link rel="pingback" href="<?php bloginfo('pingback_url'); ?>" />
  <?php wp_head(); ?>
  <style type="text/css">
    #stc_comm_send {
      margin:0;
      padding:0;
    }
  </style>
</head>

<!-- paulirish.com/2008/conditional-stylesheets-vs-css-hacks-answer-neither/ -->
<!--[if lt IE 7 ]> <body <?php body_class('ie ie6'); ?>> <![endif]-->
<!--[if IE 7 ]>    <body <?php body_class('ie ie7'); ?>> <![endif]-->
<!--[if IE 8 ]>    <body <?php body_class('ie ie8'); ?>> <![endif]-->
<!--[if IE 9 ]>    <body <?php body_class('ie ie9'); ?>> <![endif]-->
<!--[if (gt IE 9)|!(IE)]><!--> <body <?php body_class('not-ie'); ?>> <!--<![endif]-->

<div id="wrapper">
  <div id="page">
    <header id="header">
      <a href="/" id="logo">Geoloqi</a>
      <nav id="site-selector">
        <ul>
          <li class="dropdown">
            <a href="/blog">Blog</a>
            <div class="dropdown-menu">
              <ul>
                <li>
                  <a href="http://geoloqi.com">
                    <h6>Geoloqi</h6>
                    <small>Learn more about Geoloqi</small>
                  </a>
                </li>
                <li>
                  <a href="http://developers.geoloqi.com">
                    <h6>Developers</h6>
                    <small>Build location-aware applicaitons with Geoloqi</small>
                  </a>
                </li>
                <li>
                  <a href="http://geoloqi.com/apps">
                    <h6>Apps</h6>
                    <small>See what we have built with our native SDKs</small>
                  </a>
                </li>
              </ul>
            </div>
          </li>
        </ul>
      </nav>
      
      <?php wp_nav_menu(array(
        'theme_location'  => "primary-menu",
        'container'       => 'nav'
        ));
      ?>
    </header>   
     