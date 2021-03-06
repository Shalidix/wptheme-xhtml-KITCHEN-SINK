<?php
/**
 * WordPress Widget Class to show next/previous post buttons in dynamic sidebar
 * 
 * @package zui WordPress widgets
 * @subpackage ZUIWidgetNextPreviousPost Class
 * @version 0.1 
 * @since kitchenSink theme Version 0.3
 * @author zoe somebody http://beingzoe.com/zui/
 */
class ZUIWidgetNextPreviousPost extends WP_Widget {
    /**
     * Widget constructor
     * 
     * @since 0.1
     * @uses WP_Widget()
     */
    function ZUIWidgetNextPreviousPost() {
        $widget_ops = array('classname' => 'widget_theme_next_previous clearfix', 'description' => __( "Displays Next/Previous post buttons for post to post navigation. Will only show if a single post is being displayed and there is a next or previous post to go to.") );
        //$control_ops = array('width' => 300, 'height' => 300);
        parent::WP_Widget(false, $name = 'Theme: Next/Previous buttons', $widget_ops);	
    }
    
    /**
     * Filter widget content for output
     * 
     * @see WP_Widget::widget
     * @uses widget()
     * @uses is_single()
     * @uses apply_filters()
     * @uses previous_post_link()
     * @uses get_previous_post()
     * @uses next_post_link()
     * @uses get_next_post()
     */
    function widget($args, $instance) {	
        if ( is_single() ) {
        extract( $args );
        $title = apply_filters('widget_title', $instance['title']);
        $next = $instance['next'];
        $previous = $instance['previous'];
        ?>
              <?php echo $before_widget; ?>
                  <?php if ( $title )
                        echo $before_title . $title . $after_title; ?>
                        <?php if ( get_previous_post() ) { ?>
                            <div class="nav_previous">
                                <?php /*previous_post_link( '%link', "$previous" );*/ ?>
                                <?php echo "<a href='" . get_permalink( get_previous_post()->ID ) . "' title='" . get_previous_post()->post_title . "'>{$previous}" . "</a>"; ?>
                            </div>
                        <?php } ?>
                        <?php if ( get_next_post() ) { ?>
                            <div class="nav_next">
                                <?php /*next_post_link( '%link', "$next" );*/ ?>
                                <?php echo "<a href='" . get_permalink( get_next_post()->ID ) . "' title='" . get_next_post()->post_title . "'>{$next}" . "</a>"; ?>
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
            <p><label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:'); ?></label> <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo $title; ?>" /></p>
            <p><label for="<?php echo $this->get_field_id('next'); ?>"><?php _e('Next:'); ?></label> <input class="widefat" id="<?php echo $this->get_field_id('next'); ?>" name="<?php echo $this->get_field_name('next'); ?>" type="text" value="<?php echo $next; ?>" /></p>
            <p><label for="<?php echo $this->get_field_id('previous'); ?>"><?php _e('Previous:'); ?></label> <input class="widefat" id="<?php echo $this->get_field_id('previous'); ?>" name="<?php echo $this->get_field_name('previous'); ?>" type="text" value="<?php echo $previous; ?>" /></p>
        <?php 
    }

} // class ZUIWidgetNextPrevious

// register ZUIWidgetNextPrevious widget
add_action('widgets_init', create_function('', 'return register_widget("ZUIWidgetNextPreviousPost");'));
?>
