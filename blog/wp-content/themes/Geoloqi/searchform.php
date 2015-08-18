<h3>Search</h3>
<form id="searchform" method="get" class="clearfix" action="<?php bloginfo('url'); ?>/"><div>
  <label for="s">
    <span class="visuallyhidden"><?php _e('Search for:'); ?></span>
    <input type="search" name="s" id="s" placeholder="Search" value="<?php the_search_query(); ?>" />
  </label>  
  <input type="submit" class="btn primary" value="<?php echo attribute_escape(__('Go')); ?>" />
  </div>
</form>