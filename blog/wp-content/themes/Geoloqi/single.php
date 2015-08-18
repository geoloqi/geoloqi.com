<?php get_header(); ?>

<div class="container">
  <div id="main" <?php post_class() ?> id="post-<?php the_ID(); ?>">
      <?php if (have_posts()) : while (have_posts()) : the_post(); ?>
      <div class="box">
        <div class="meta">
          <?php require("core-post-meta.php"); ?>
          <div class="clear right push-up-half">
              <?php the_tweet_button($count = "vertical"); ?>
          </div>
          <div class="clear right">
              <?php the_plus_one_button($size = "tall"); ?>
          </div>
          <div class="clear right">
              <?php the_like_button($layout = "box_count", $send="true", $width="48"); ?>
          </div>
        </div>
        <header>
          <h1 class="leading"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h1>
        </header>
        <article>
          <div class="clearfix">
            <?php the_content('Read the rest of this entry &raquo;'); ?>
          </div>
          <footer class="clearfix">
            <?php comments_popup_link('Comment (0)', 'Comment (1)', 'Comments (%)', "btn small push-right left"); ?>
            <?php the_like_button(); ?>
            <?php the_tweet_button(); ?>
            <?php the_plus_one_button(); ?>
          </footer>
        </article>
      </div>
        <h2>Comments</h2>
        <?php comments_template(); ?>
      <?php endwhile; else: ?>
        <div class="well">
          <p>Sorry, no posts matched your criteria.</p>
        </div>
      <?php endif; ?>
    
  </div>
  <?php get_sidebar(); ?>
</div>

<?php get_footer(); ?>
