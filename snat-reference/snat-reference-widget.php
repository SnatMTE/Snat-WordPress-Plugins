<?php
/*
    Plugin Name: Snat's Reference Widget
    Plugin URI: https://github.com/SnatMTE/Snat-WordPress-Plugins/tree/main/snat-reference
    Description: Displays a reference via the Harvard standard.
    Version: 1.0.3
    Author: <a href="https://snat.co.uk/">Snat</a>
    Author URI: https://snat.co.uk/
*/

class snat_reference_Widget extends WP_Widget {
    // Constructor function
    public function __construct() {
        $widget_options = array(
            'classname' => 'snat_reference_widget',
            'description' => 'Displays the current article as a reference.'
        );
        parent::__construct('snat_reference_widget', 'Snat\'s Reference Widget', $widget_options);
    }

    // Widget output function
    public function widget($args, $instance) {
        if (is_home() || is_tag() || is_category()) {
            return;
        }
        $author_id = get_the_author_meta('ID');
        $first_name = get_the_author_meta('first_name', $author_id);
        $first_initial = substr($first_name, 0, 1);
        $last_name = get_the_author_meta('last_name', $author_id);
        $publish_date = get_the_date('Y');
        $article_title = get_the_title();
        $site_name = get_bloginfo('name');
        $post_link = get_permalink();
        $view_date = date('d M Y');

        echo $args['before_widget'];
        if (!empty($instance['title'])) {
            echo $args['before_title'] . apply_filters('widget_title', $instance['title']) . $args['after_title'];
        }
        
        echo wp_kses_post("<p>");
        echo wp_kses_post("$last_name, $first_initial. ($publish_date). <em>$article_title</em>. [online] $site_name. Available at: $post_link [Accessed $view_date].");
        echo wp_kses_post("</p>");
        echo $args['after_widget'];
    }

// Widget Backend
    public function form( $instance ) {
        if ( isset( $instance[ 'title' ] ) ) {
            $title = $instance[ 'title' ];
        }
        else {
            $title = __( 'New title', 'Reference Us' );
        }

// Widget admin form
    ?>
    <p>
    <label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:' ); ?></label>
    <input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" />
    </p>
    <?php
    }

// Widget update function
    public function update($new_instance, $old_instance) {
        $instance = array();
        $instance['title'] = !empty($new_instance['title']) ? strip_tags($new_instance['title']) : '';
        return $instance;
    }
}

// Register the widget
function snat_reference_register_widget() {
    register_widget('snat_reference_Widget');
}
add_action('widgets_init', 'snat_reference_register_widget');
