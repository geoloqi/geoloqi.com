<?php get_header(); ?>

<div class="light-background">
  <div class="container">
    <?php $post = $posts[0]; // Hack. Set $post so that the_date() works. ?>
    <?php /* If this is a category archive */ if (is_category()) { ?>
    <h2 class="compress"><?php single_cat_title(); ?></h2>
    <?php /* If this is a tag archive */ } elseif( is_tag() ) { ?>
    <h2 class="compress">Posts Tagged &#8216;<?php single_tag_title(); ?>&#8217;</h2>
    <?php /* If this is a daily archive */ } elseif (is_day()) { ?>
    <h2 class="compress">Archive for <?php the_time('F jS, Y'); ?></h2>
    <?php /* If this is a monthly archive */ } elseif (is_month()) { ?>
    <h2 class="compress">Archive for <?php the_time('F, Y'); ?></h2>
    <?php /* If this is a yearly archive */ } elseif (is_year()) { ?>
    <h2 class="compress">Archive for <?php the_time('Y'); ?></h2>
    <?php /* If this is an author archive */ } elseif (is_author()) { ?>
    <h2 class="compress"><?php the_author_meta('display_name', $post->post_author); ?></h2>
    
    <?php /* If this is a paged archive */ } elseif (isset($_GET['paged']) && !empty($_GET['paged'])) { ?>
    <h2>Blog Archives</h2>
    <?php } ?>
  </div>
</div>

<div class="container">
  <div id="main">
      <?php if (have_posts()) : ?>
        <?php while (have_posts()) : the_post(); ?>
          <?php require("core_article.php"); ?>
        <?php endwhile; ?>
        <nav>
          <div><?php next_posts_link('&laquo; Older Entries') ?></div>
          <div><?php previous_posts_link('Newer Entries &raquo;') ?></div>
        </nav>
      <?php else : ?>
        <h2>No Posts Found.</h2>
      <?php endif;?>      
    </div>
    <?php get_sidebar(); ?>
</div>

<?php get_footer(); ?>
