<?php get_header(); ?>

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

      <h2>Not Found</h2>
      <p>Sorry, but you are looking for something that isn't here.</p>
      <?php get_search_form(); ?>

    <?php endif; ?>
  </div>
  <?php get_sidebar(); ?>
</div>

<?php get_footer(); ?>


