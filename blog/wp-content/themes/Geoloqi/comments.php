<?php
// Do not delete these lines
  if (!empty($_SERVER['SCRIPT_FILENAME']) && 'comments.php' == basename($_SERVER['SCRIPT_FILENAME']))
    die ('Please do not load this page directly. Thanks!');

  if ( post_password_required() ) { ?>
    <p class="nocomments">This post is password protected. Enter the password to view comments.</p>
  <?php
    return;
  }
?>

<!-- You can start editing here. -->

<?php if ( comments_open() ) : ?>

<section id="respond" class="well form clearfix">

  <?php if ( get_option('comment_registration') && !is_user_logged_in() ) : ?>
  
  	<p>You must be <a href="<?php echo wp_login_url( get_permalink() ); ?>">logged in</a> to post a comment.</p>
  
  <?php else : ?>

  	<form action="<?php echo get_option('siteurl'); ?>/wp-comments-post.php" method="post" id="commentform" class="stacked">
      <div class="clearfix">
        <h3><?php comment_form_title( 'Leave a Reply', 'Leave a Reply to %s' ); ?></h3>

        <div class="cancel-comment-reply">
          <small><?php cancel_comment_reply_link(); ?></small>
        </div>
      </div>

  <?php if ( is_user_logged_in() ) : ?>

  	<p>Logged in as <a href="<?php echo get_option('siteurl'); ?>/wp-admin/profile.php"><?php echo $user_identity; ?></a>. <a href="<?php echo wp_logout_url(get_permalink()); ?>" title="Log out of this account">Log out &raquo;</a></p>

  <?php else : ?>
    
    <label for="author">
      <span>Name <?php if ($req) echo "(required)"; ?></span>
      <div class="input">
  	    <input type="text" name="author" id="author" value="<?php echo esc_attr($comment_author); ?>" size="22" tabindex="1" <?php if ($req) echo "aria-required='true'"; ?> />
      </div>
    </label>

   <label for="email">
      <span>E-Mail <?php if ($req) echo "(required)"; ?></span>
      <div class="input">
  	    <input type="email" name="email" id="email" value="<?php echo esc_attr($comment_author_email); ?>" size="22" tabindex="2" <?php if ($req) echo "aria-required='true'"; ?> />
        <small class="help-block">Will not be published</small>
      </div>
    </label>

    <label for="url">
      <span>Website</span>
      <div class="input">
  	    <input type="url" name="url" id="url" value="<?php echo esc_attr($comment_author_url); ?>" size="22" tabindex="3" />
      </div>
    </label>
    
  <?php endif; ?>
    
    <label for="comment">
      <span>Comment</span>
      <div class="input">
        <textarea name="comment" id="comment" tabindex="4"></textarea>
        <small id="allowed_tags" class="help-block">Allowed Tags: <code>&lt;a&gt; &lt;abbr&gt; &lt;acronym&gt; &lt;b&gt; &lt;blockquote&gt; &lt;cite&gt; &lt;code&gt; &lt;del&gt; &lt;em&gt; &lt;i&gt; &lt;q&gt; &lt;strike&gt; &lt;strong&gt;</code></small>
      </div>
    </label>

    <div class="actions">
      <input name="submit" type="submit" id="submit" tabindex="5" value="Submit Comment" class="btn primary" />
      <small class="help-block"><?php comment_id_fields(); ?></small>
    </div>
  
    <?php do_action('comment_form', $post->ID); ?>

  </form>

</section>

<?php endif; ?>

<!-- Seperate Comments into Comments and Pingbacks -->
<?php $comments_by_type = separate_comments($comments); ?>    


<?php if ( have_comments() ) : ?>
  
  <section id="comments"> <!-- Open a Wrapper for Comments and Pingbacks -->
	
	<?php if (!empty($comments_by_type['comment'])) : ?>

	  <h3 id="comment-header"><?php comments_number('No Comments', 'One Comment', '% Comments' );?></h3>
    <div class="well">
	  <ol class="comment-list">
	  	<?php wp_list_comments('type=comment&callback=custom_comments'); ?>
	  </ol>
	  </div>
	<?php else : // this is displayed if there are no comments so far ?>
      <div class="well">
    	<?php if ( comments_open() ) : ?>
      <!-- If comments are open, but there are no comments. -->
      <p class="nocomments">Be the first to comment.</p>

     <?php else : // comments are closed ?>
      <!-- If comments are closed. -->
      <p class="nocomments">Comments are closed.</p>
  	
  		<?php endif; ?>
	  </div>
  <?php endif; ?>
  
  <?php if (!empty($comments_by_type['pings'])) : ?>

    <h3>Trackbacks/Pingbacks</h3>
    <div class="well">
      <ol class="ping-list">
          <?php wp_list_comments('type=pings&callback=custom_pings'); ?>
      </ol>
    </div>
      	
	<?php endif; ?>
  
  </section> <!-- Close Comments and Pingbacks Wrapper -->

<?php endif; ?>

<?php endif; // if you delete this the sky will fall on your head ?>