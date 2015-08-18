<?php
/**
 * Plugin Name: Fiat Sidebar Nav
 * Plugin URI: http://fiatinsight.com
 * Description: A plugin that adds a sidebar nav
 * Version: 2.0
 * Author: Ben Zumdahl
 * Author URI: http://fiatinsight.com
 */

	if(!function_exists('get_post_top_ancestor_id')){
		function get_post_top_ancestor_id(){
    	global $post;

    if($post->post_parent){
        $ancestors = array_reverse(get_post_ancestors($post->ID));
        return $ancestors[0];
    }

    return $post->ID;
	}}


 class Fiat_Sidebar_Nav extends WP_Widget {
    function __construct() {
        $widget_ops = array( 'classname' => 'widget_fiat_sidebar_nav', 'description' => __( "Sidebar Nav" ) );
        parent::__construct('my_avatar', __('Sidebar Nav'), $widget_ops);
    }

   function widget( $args, $instance ) {
        extract($args);
        $title = apply_filters( 'widget_title', empty($instance['title']) ? '' : $instance['title'], $instance, $this->id_base);
        echo $before_widget;
        if ( !empty( $title ) ) { echo $before_title . $title . $after_title; } ?>
           	<ul class="page-list">
				<?php wp_list_pages( array('title_li'=>'','depth'=>1,'child_of'=>get_post_top_ancestor_id()) ); ?>
			</ul>
        <?php
        echo $after_widget;
    }

    function update( $new_instance, $old_instance ) {
        $instance = $old_instance;
        $instance['title'] = strip_tags($new_instance['title']);
        return $instance;
    }

    function form( $instance ) {
        $instance = wp_parse_args( (array) $instance, array( 'title' => '') );
        $title = strip_tags($instance['title']);

?>



<p><label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:'); ?></label>
<input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo esc_attr($title); ?>" /></p>

<?php

}

}

function lbi_widgets_init() {
    register_widget( 'Fiat_Sidebar_Nav' );
}

add_action( 'widgets_init', 'lbi_widgets_init' );
