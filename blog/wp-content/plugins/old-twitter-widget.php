<?php 
/*
Plugin Name: aaronpk - Twitter Widget
Plugin URI: http://aaronparecki.com
Description: Show the latest tweets from a Twitter search in the sidebar
Author: aaronpk
Version: 0.1
Author URI: http://aaronpk.com
*/

class aaronpk_Old_Twitter_Search_Widget extends WP_Widget 
{

	public function aaronpk_Old_Twitter_Search_Widget()
	{
		$widget_ops = array('classname' => 'widget_aaronpk-old-twitter-search', 'description' => 'Twitter Search Results');
		$this->WP_Widget('aaronpk-old-twitter-search', 'Twitter Search Results (aaronpk)', $widget_ops);
	}

	public function widget($args, $instance)
	{
		extract( $args );
		$title = apply_filters('widget_title', $instance['title']);
		echo $before_widget;
		if ( $title ) echo $before_title . $title . $after_title;
		
		include('/web/common-rdo/DBA.php');
		
		$db = new DBA('db.node', 'pin13', 'pin13', 'pin13');
		$tweets = $db->query('
			SELECT * 
			FROM `tweets` 
			WHERE `search_id` = 35
				AND `username` NOT IN ("loqisaur", "pkbot", "anothercasebot", "casebot") 
			ORDER BY `date` DESC LIMIT 8');
		$tweets->execute();
		echo '<ul class="tweets">';
		foreach($tweets as $t)
		{
			$t['status'] = preg_replace(
				array('|(https?://([^\s]+))|', '/(?<![a-z0-9_])@([a-z0-9_]+)/i'),
				array('<a href="$1">$2</a>', '<a href="http://twitter.com/$1">@$1</a>', ), 
				$t['status']);
			echo '<li>';
				echo '<a class="pic" style="float:left; margin-right: 4px;" href="http://twitter.com/' . $t['username'] . '" target="_blank"><img src="' . $t['image_url'] . '" width="48" /></a>';
				echo '<a class="username" href="http://twitter.com/' . $t['username'] . '" target="_blank">' . $t['username'] . '</a> ' . $t['status'];
				echo '<div style="clear: both;"></div>';
			echo '</li>';
		}
		echo '</ul>';
		
		echo $after_widget;
	}
	
	function update($new_instance, $old_instance) {
		$instance = $old_instance;
		$new_instance = wp_parse_args( (array) $new_instance, array( 'title' => '', 'user' => $defaultuser) );
		$instance['title'] = strip_tags($new_instance['title']);
		return $instance;
	}

	function form($instance) {
		$instance = wp_parse_args( (array) $instance, array( 'title' => '', 'user' => $defaultuser) );
		$title = strip_tags($instance['title']);
		$user = strip_tags($instance['user']);
		?>
<p><label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:'); ?> 
<input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo $title; ?>" />
</label></p>
		<?php
	}
}

add_action('widgets_init', create_function('', 'return register_widget("aaronpk_Old_Twitter_Search_Widget");'));

			
?>
