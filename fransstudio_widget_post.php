<?php
/*
Plugin Name: fransstudio Widget Post
Plugin URI: www.fransstudio.de
Description: Widget Display One Post
Version: 1.0
Author: Fransiskus Winata
Author URI: www.fransstudio.de
License: nocopy
Text Domain: fransstudio_widget_post
*/

add_action( 'widgets_init', function() {
  register_widget( 'fransstudio_widget_post' );
});

class fransstudio_widget_post extends WP_Widget {

  function __construct() {
    parent::__construct('fransstudio_widget_post', 'Widget Post',
      array( 'description' => 'Widget Display One Post', )
    );
  }

  // Creating widget front-end
  public function widget( $args, $instance ) {
    echo $args['before_widget'];
    $posts = $this->get_all_posts();
    if (empty($instance['post_id']) && sizeof($posts) > 0) {$instance['post_id'] = $posts[0]->ID;}
    $post = get_post($instance['post_id']);
    ?><div class="tmawp_widget_post">
      <h3 class="title"><?php echo $post->post_title; ?></h3>
      <div class="content"><?php echo apply_filters('the_content', $post->post_content); ?></div>
    </div><?php
    echo $args['after_widget'];
  }

  public function form( $instance ) {
    $posts = $this->get_all_posts();
    if (empty($instance['post_id']) && sizeof($posts) > 0) {$instance['post_id'] = $posts[0]->ID;}
    ?>
      <p>
      <label for="<?php echo $this->get_field_id('post_id'); ?>">Post</label>
      <select class="widefat" id="<?php echo $this->get_field_id('post_id'); ?>" name="<?php echo $this->get_field_name('post_id'); ?>" type="text">
        <?php foreach($posts as $post) {
          ?><option value="<?php echo $post->ID; ?>" <?php if ( $instance['post_id'] == $post->ID ) {echo 'selected';}?> ><?php echo $post->post_title; ?></option> <?php
        }  ?>
      </select>
      </p>
      <p>
    <?php
  }
  public function update( $new_instance, $old_instance ) {
    $posts = $this->get_all_posts();
    if (empty($new_instance['post_id']) && sizeof($posts) > 0) {$new_instance['post_id'] = $posts[0]->ID;}
    return $new_instance;
  }

  public function get_all_posts() {
    return get_posts('numberposts=-1');
  }
}
