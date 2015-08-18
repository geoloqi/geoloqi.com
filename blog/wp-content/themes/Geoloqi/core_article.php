<article <?php post_class() ?> id="post-<?php the_ID(); ?>">
  <div class="box">
    <div class="meta">
      <?php require("core-post-meta.php"); ?>
    </div>
    <header>
      <h2 class="leading"><a href="<?php the_permalink() ?>" rel="bookmark"><?php the_title(); ?></a></h2>
    </header>
    <div>
      <div class="clearfix">
        <?php the_content('Read the rest of this entry &raquo;'); ?>
      </div>

      <footer class="clearfix">
        <a href="<? the_permalink() ?>" class="btn primary">Share and Comment</a>
      </footer>
    </div>
  </div>
</article>
