<?php get_header(); ?>

<div class="light-background">
  <div class="container">
    <h2>Search Results for "<?php the_search_query(); ?>"</h2>
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
