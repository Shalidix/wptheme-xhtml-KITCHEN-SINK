<?php
/**
 * WordPress Widget Class to show older/newer paged posts buttons in dynamic sidebar
 * 
 * @package zui WordPress widgets
 * @subpackage ZUIWidgetOlderNewerPosts Class
 * @version 0.1 
 * @since kitchenSink theme Version 0.3
 * @author zoe somebody http://beingzoe.com/zui/
 */
class ZUIWidgetOlderNewerPosts extends WP_Widget {
    /**
     * Widget constructor
     * 
     * @since 0.1
     * @uses WP_Widget()
     */
    function ZUIWidgetOlderNewerPosts() {
        $widget_ops = array('classname' => 'widget_theme_older_newer clearfix', 'description' => __( "Displays Older/Newer buttons for paged posts navigation. Will only show on blog index or archive with &gt; 1 page of results. ") );
        //$control_ops = array('width' => 300, 'height' => 300);
        parent::WP_Widget(false, $name = 'Theme: Older/Newer buttons', $widget_ops);	
    }
    
    /**
     * Filter widget content for output
     * 
     * @see WP_Widget::widget
     * @param global $wp_query
     * @uses widget()
     * @uses is_home()
     * @uses is_archive()
     * @uses apply_filters()
     * @uses next_posts_link()
     * @uses get_next_posts_link()
     * @uses previous_posts_link()
     * @uses get_previous_posts_link()
     */
    function widget($args, $instance) {	
        global $wp_query;
        
        if ( ( is_home() || is_archive() ) && $wp_query->max_num_pages > 1 ) {

        extract( $args );
        
        $title = apply_filters('widget_title', $instance['title']);
        $next = $instance['next'];
        $previous = $instance['previous'];
        ?>
              <?php echo $before_widget; ?>
                  <?php if ( $title )
                        echo $before_title . $title . $after_title; ?>
                        
                        <?php if ( get_next_posts_link() ) { ?>
                            <div class="nav_previous" title="Browse older posts">
                                <?php next_posts_link( "$next" ); /* older */ ?>
                            </div>
                        <?php } ?>
                        <?php if ( get_previous_posts_link() ) { ?>
                            <div class="nav_next" title="Browse newer posts">
                                <?php previous_posts_link( "$previous" ); /* newer */ ?>
                            </div>
                        <?php } ?>
                        
              <?php echo $after_widget; ?>
        <?php
         }
    }
    
    /**
     * Save widget sidebar settings (from form)
     * 
     * @see WP_Widget::update
     * @uses update()
     */
    function update($new_instance, $old_instance) {				
	$instance = $old_instance;
	$instance['title'] = strip_tags($new_instance['title']);
	$instance['next'] = strip_tags($new_instance['next']);
	$instance['previous'] = strip_tags($new_instance['previous']);
        return $instance;
    }
    
    /**
     * Widget edit form
     * 
     * @see WP_Widget::form
     * @uses form()
     * @uses get_field_id()
     * @uses get_field_name()
     * @uses esc_attr()
     * @uses _e()
     */
    function form($instance) {				
        $title = esc_attr($instance['title']);
        $next = esc_attr($instance['next']);
        $previous = esc_attr($instance['previous']);
        ?>
            <p><label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:'); ?> <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo $title; ?>" /></label></p>
            <p><label for="<?php echo $this->get_field_id('next'); ?>"><?php _e('Older:'); ?> <input class="widefat" id="<?php echo $this->get_field_id('next'); ?>" name="<?php echo $this->get_field_name('next'); ?>" type="text" value="<?php echo $next; ?>" /></label></p>
            <p><label for="<?php echo $this->get_field_id('previous'); ?>"><?php _e('Newer:'); ?> <input class="widefat" id="<?php echo $this->get_field_id('previous'); ?>" name="<?php echo $this->get_field_name('previous'); ?>" type="text" value="<?php echo $previous; ?>" /></label></p>
        <?php 
    }

} // class ZUIWidgetNextPrevious

// register ZUIWidgetNextPrevious widget
add_action('widgets_init', create_function('', 'return register_widget("ZUIWidgetOlderNewerPosts");'));
?>
