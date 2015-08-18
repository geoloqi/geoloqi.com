<h6>Posted</h6>
<p><?php the_time("D M j Y, g:Ha") ?></p>
<p>By <a href="<?php echo get_author_posts_url(get_the_author_meta( 'ID' )); ?>"><?php the_author_meta('display_name'); ?></a></p>

<?php if(has_category()) : ?>
  <h6>Categories</h6>
  <p><?php the_category('<br>') ?></p>
<?php  endif;?>

<?php if(has_tag()) : ?>
  <h6>Tagged</h6>
  <p><?php the_tags('<ul class="tag-list"><li>','</li><li>','</li></ul>'); ?></p>
<?php  endif;?>

<p><?php edit_post_link('Edit Entry', '<br><small class="right clear push-up-half">', '</small>'); ?></p>