<?php

//Add a nag to install the options framework plugin
//See : http://wptheming.com/options-framework-plugin
if ( !function_exists( 'optionsframework_add_page' ) && current_user_can('edit_theme_options') ) {
    function portfolio_options_default() {
        add_submenu_page('themes.php', 'Theme Options', 'Theme Options', 'edit_theme_options', 'options-framework','optionsframework_page_notice');
    }
    add_action('admin_menu', 'portfolio_options_default');
}
 
if ( !function_exists( 'optionsframework_page_notice' ) ) {
	function optionsframework_page_notice() { ?>

		<div class="wrap">
		<?php screen_icon( 'themes' ); ?>
		<h2><?php _e('Theme Options'); ?></h2>
		<p><b>If you would like to use the Portfolio Press theme options, please install the <a href="https://github.com/devinsays/options-framework-plugin">Options Framework</a> plugin.</b></p>
		<p>Once the plugin is activated you will have option to:</p>
		<ul class="ul-disc">
		<li>Upload a logo image</li>
		<li>Change the sidebar position</li>
		<li>Change the menu position</li>
		<li>Display the portfolio on the home page</li>
		<li>Hide the portfolio image on the single post</li>
		<li>Update the footer text</li>
		</ul>

		<p>If you don't need these options, the plugin is not required and the theme will use default settings.</p>
		</div>
	<?php
	}
}

//Register Jquery and Modernizer with Wordpress
function register_scripts() {

  //Replace Wordpress jQuery with the latest jQuery  unless we are on an admin page
  if(!is_admin()){
    wp_deregister_script( 'jquery' );
    wp_register_script( 'jquery', get_bloginfo('template_directory').'/js/jquery-latest.min.js');
  }
  
  //Register Modernizr with Wordpress
  wp_register_script( 'modernizr', get_bloginfo('template_directory').'/js/modernizr-latest.min.js');
  
}
 
add_action('init', 'register_scripts');

//Custom Styles for TinyMCE Editor
//http://codex.wordpress.org/Function_Reference/add_editor_style
add_editor_style('css/editor.css');

// Add Wordpress Navigation Menu
if(function_exists('wp_nav_menu')){
	add_theme_support('nav-menus');
	register_nav_menus(array(
		'primary-menu' => 'Primary Menu'
	));
}

// Add Widgetized Sidebar
if(function_exists('register_sidebar')){
	register_sidebar(array(
		'name' => 'Primary Sidebar',
		'description' => '',
		'before_widget' => '<section class="widget">',
		'after_widget'  => '</section>',
		'before_title' => '<h4 classs="widget-title">',
		'after_title' => '</h4>'
	));
}

//Add Featured Images
if(function_exists('add_theme_support')){
  add_theme_support('post-thumbnails', array('page', 'post'));
  add_image_size('demo', 200, 200, true);
}

//Add RSS link to header automatically
if(function_exists('add_theme_support')) {
	add_theme_support('automatic-feed-links');
}

//Custom Excerpt
function new_excerpt_more(){
	return '&hellip;';
}

add_filter('excerpt_more', 'new_excerpt_more');

//Custom Excerpt Length
function new_excerpt_length(){
	return 300;
}

add_filter('excerpt_length', 'new_excerpt_length');

//Conditionals for checking next/previous posts
//Note: Why isn't this in core yet?
function is_next_post(){
  global $post;
  $next_post = get_adjacent_post(false,'',false);
  return ($next_post) ? true : false;
}

function is_previous_post(){
  global $post;
  $previous_post = get_adjacent_post(false,'',true);
  return ($previous_post) ? true : false;
}

//Function for geting the next/previous post url
//Note: Why isn't this in core yet?
function get_previous_post_url(){
  global $post;
  return get_permalink(get_adjacent_post(false,'',true));
}

function get_next_post_url(){
  global $post;
  return get_permalink(get_adjacent_post(false,'',false));
}

function next_post_url(){
  echo get_next_post_url();
}

function previous_post_url(){
  echo get_previous_post_url();
}

//Function for geting the next/previous post title
//Note: Why isn't this in core yet?
function get_previous_post_title(){
  global $post;
  $prev_post = get_adjacent_post(false,'',true);
  return get_the_title($prev_post->ID);
}

function get_next_post_title(){
  global $post;
  $next_post = get_adjacent_post(false,'',false);
  return get_permalink($prev_post->ID);
}

function next_post_title(){
  echo get_next_post_title();
}

function previous_post_title(){
  echo get_previous_post_title();
}

//Add Classes to pager buttons
//http://wpcanyon.com/tipsandtricks/adding-attributes-to-previous-and-next-post-links/
//Note: Why isn't this in core yet?
function posts_previous_link_attributes(){
	return 'class="previous light btn"';
}

function posts_next_link_attributes(){
	return 'class="next light btn"';
}

add_filter('next_post_link_attributes', 'posts_next_link_attributes');
add_filter('previous_post_link_attributes', 'posts_previous_link_attributes');

add_filter('next_posts_link_attributes', 'posts_next_link_attributes');
add_filter('previous_posts_link_attributes', 'posts_previous_link_attributes');

//Post Slug Function
//Note: Why isn't this in core yet?
function the_slug(){
  global $post;
  echo $post->post_name;
}

function get_the_slug(){
  global $post;
  return $post->post_name;
}

//Frist/Last Even/Odd for Post Class 
//Note: Why isn't this in core yet?
function first_last_even_odd_post_class($classes){
  
  global $wp_query;
  
  $current_post = $wp_query->current_post;
  $total_posts = $wp_query->post_count;
  
  if($current_post == 0){
    $classes[] = "first";
  }
  
  if($current_post == $total_posts){
    $classes[] = "last ";
  }
  
  if ($current_post % 2) {
    $classes[] = "even";
  } else {
    $classes[] = "odd" ;
  }
  
  return $classes;
  
}

add_filter('post_class', 'first_last_even_odd_post_class');

//Add Post/Page Slug To Body Classes
//From: http://36flavours.com/2011/02/wordpress-append-page-slug-to-body-class/
function add_body_class($classes){
  global $post;

  if (isset($post)){
    $classes[] = $post->post_type . '-' . $post->post_name;
  }
  return $classes;
}

add_filter('body_class', 'add_body_class');

//Remove generator from head for secutiry reasons
remove_action('wp_head', 'wp_generator');

// Custom HTML5 Pingback Markup
function custom_pings($comment, $args, $depth) {

	$GLOBALS['comment'] = $comment; ?>
	
	<li id="comment-<?php comment_ID(); ?>" <?php comment_class();?>>
		<article>
			<header class="comment-author vcard">
				<span class="author"><?php comment_author_link(); ?></span> - 
				<time datetime="<?php comment_time('c');?>"><?php comment_date(); ?></span>
			</header>
		</article>
   <!-- </li> is added by wordpress automatically -->
<?php 
}

// Custom HTML5 Comment Markup
function custom_comments($comment, $args, $depth) {
  global $wp_query;
   $GLOBALS['comment'] = $comment; ?>
   <li id="comment-<?php comment_ID(); ?>" <?php comment_class(); ?>>
     <article>
        <?php if ($comment->comment_approved == '0') : ?>
          <em><?php _e('Your comment is awaiting moderation.') ?></em>
          <br />
       <?php endif; ?>
       <?php echo get_avatar($comment,$size='48',$default='<path_to_url>' ); ?>
       <div class="comment-body">
          <header class="comment-author vcard clearfix">
            <?php printf(__('<h4>%s</h4>'), get_comment_author_link()) ?>
          </header>
          <?php comment_text() ?>
          <footer class="comment-meta">
            <time datetime="<?php comment_time('c');?>"><?php printf(__('%1$s at %2$s'), get_comment_date(),  get_comment_time()) ?></time>
             | <?php comment_reply_link(array_merge( $args, array('depth' => $depth, 'max_depth' => $args['max_depth']))) ?>
            <?php edit_comment_link(__('(Edit)'),' | ','') ?>
          </footer>
       </div>
     </article>
    <!-- </li> is added by wordpress automatically -->
<?php
}

// Custom Functions for CSS/Javascript Versioning
$GLOBALS["TEMPLATE_URL"] = get_bloginfo('template_url')."/";
$GLOBALS["TEMPLATE_RELATIVE_URL"] = wp_make_link_relative($GLOBALS["TEMPLATE_URL"]);

// Add ?v=[last modified time] to style sheets
function versioned_stylesheet($relative_url, $add_attributes=""){
  echo '<link rel="stylesheet" href="'.versioned_resource($relative_url).'" '.$add_attributes.'>'."\n";
}

// Add ?v=[last modified time] to javascripts
function versioned_javascript($relative_url, $add_attributes=""){
  echo '<script src="'.versioned_resource($relative_url).'" '.$add_attributes.'></script>'."\n";
}

// Add ?v=[last modified time] to a file url
function versioned_resource($relative_url){
  $file = $_SERVER["DOCUMENT_ROOT"].$relative_url;
  $file_version = "";

  if(file_exists($file)) {
    $file_version = "?v=".filemtime($file);
  }

  return $relative_url.$file_version;
}

/*
Plugin Name: Dead Simple Social
Plugin URI: 
Description: Adds helpers for theme authors for Twitter and Facebook
Author: Patrick Arlt
Version: 0.01
Author URI: http://patrickarlt.com
*/

/* Helper to get the first image from a post */
function ss_first_image() {
  global $post, $posts;
  $first_img = '';
  $output = preg_match_all('/<img.+src=[\'"]([^\'"]+)[\'"].*>/i', $post->post_content, $matches);
  $first_img = $matches[1][0];
  return $first_img;
};

function meta_image(){
  if(is_single()){
    global $post;
    if(function_exists('has_post_thumbnail')){
      if(has_post_thumbnail($post->ID)){
        $img_data = wp_get_attachment_image_src(get_post_thumbnail_id($post->ID), 'medium');
        $fb_img_url = $img_data[0];
      }
    }
    if(empty($fb_img_url)){
      $fb_img_url = ss_first_image();
    }
    if(empty($fb_img_url)){
      $fb_img_url = get_bloginfo('stylesheet-directory')."/images/social-default.png";
    }
  }
  return $fb_img_url;
}

/* Add Facebook metadata to wp_head() */
function add_google_meta() {
  if(is_single()): global $post;
    $site_url = parse_url(get_bloginfo('url')); ?>  
    <!-- Google +1 metadata -->
    <meta itemprop="name" content="<?php echo $post->post_title; ?>">
    <meta itemprop="description" content="<?php echo $post->excerpt; ?>">
    <meta itemprop="image" content="<?php echo meta_image(); ?>">
  <?php endif; 

  if(is_front_page()): ?>
    <!-- Google +1 metadata -->
    <meta itemprop="name" content="<?php get_bloginfo('name'); ?>">
    <meta itemprop="description" content="<?php get_bloginfo('description'); ?>">
    <meta itemprop="image" content="<?php echo meta_image(); ?>">
  <?php endif;
};

function add_facebook_meta(){
  if(is_single()): global $post;
    $site_url = parse_url(get_bloginfo('url')); ?>  
    <!-- Facebook metadata -->
    <meta property="og:title" content="<?php echo $post->post_title; ?>" />
    <meta property="og:type" content="article" />
    <meta property="og:url" content="<?php echo(get_permalink($post->ID)); ?>" />
    <meta property="og:site_name" content="<?php echo $site_url['host']; ?>" />
    <meta property="og:image" content="<?php echo meta_image(); ?>" />
  <?php endif; ?>

  <?php if(is_front_page()): ?>
    <!-- Facebook metadata -->
    <meta property="og:title" content="<?php get_bloginfo('name'); ?>" />
    <meta property="og:type" content="company" />
    <meta property="og:url" content="<?php echo(get_bloginfo('url')); ?>" />
    <meta property="og:image" content="<?php echo $fb_img_url = get_bloginfo('stylesheet-directory'); ?>/images/logo.png" />
    <meta property="og:site_name" content="<?php get_bloginfo('name'); ?>" />
  <?php endif;?>
<?php };

add_action('wp_head', 'add_facebook_meta');
add_action('wp_head', 'add_google_meta');

/* Add social scripts to wp_footer() so they dont block */
function add_social_scripts(){ ?>
  <script src="//connect.facebook.net/en_US/all.js#xfbml=1"></script>
  <script type="text/javascript" src="//platform.twitter.com/widgets.js"></script>
  <script type="text/javascript">
    (function() {
      var po = document.createElement('script'); po.type = 'text/javascript'; po.async = true;
      po.src = 'https://apis.google.com/js/plusone.js';
      var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(po, s);
    })();
  </script>
<?php };

add_action('wp_footer', 'add_social_scripts');

//Simple"Like" button
function the_like_button($layout = "button_count", $width = "90", $send = "true"){
  echo("<div class='simple-social-facebook'><fb:like href='".get_permalink($post->ID)."' data-send='".$send."'' layout='".$layout."' style='overflow:visible;' show_faces='false' width='".$width."' font='lucida grande'></fb:like></div>");
};

//Simple "Tweet" button
function the_tweet_button($count = "horizontal"){
  echo("<div class='simple-social-twitter'><a href='//twitter.com/share' class='twitter-share-button' data-url='". get_permalink($post->ID)."' data-text='". get_the_title($post->ID)."' data-count='".$count."'>Tweet</a></div>");
};

//Simple "+1" button
function the_plus_one_button($size = "medium"){
  echo("<div class='simple-social-plus-one'><g:plusone size='".$size."' href='".get_permalink($post->ID)."'></g:plusone></div>");
};

?>