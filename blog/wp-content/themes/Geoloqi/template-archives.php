<?php /* Template Name: Archives Page */ ?>

<?php get_header(); ?>

<div class="container">
  <div id="main">
    <section>
      <h2>Archives by Month:</h2>
      <ul>
        <?php wp_get_archives('type=monthly'); ?>
      </ul>
    </section>
    <section>
      <h2>Archives by Subject:</h2>
      <ul>
        <?php wp_list_categories(); ?>
      </ul>
    </section>
  </div>
  <?php get_sidebar(); ?>
</div>

<?php get_footer(); ?>