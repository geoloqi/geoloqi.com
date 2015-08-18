<?php get_header(); ?>

<div class="container">
  <div id="main">
    <?php if (have_posts()) : while (have_posts()) : the_post(); ?>
      <article <?php post_class() ?> id="post-<?php the_ID(); ?>">
        <header>
          <h1 class="leading"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h1>
        </header>
        <div class="well">
          <?php the_content(); ?>
        </div>
      </article>
    <?php endwhile; endif; ?>
  </div>
  <?php get_sidebar(); ?>
</div>

<?php get_footer(); ?>