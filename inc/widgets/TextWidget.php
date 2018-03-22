<?php
/**
 * @package Codearchitect
 */

namespace CA_Inc\widgets;


use WP_Widget;
/**
 * Custom Widget.
 */
class TextWidget extends WP_Widget
{
    /*
        Contrusct class to activate actions and hooks as soon as the class is initialized
    */
    public function __construct()
    {
        $widget_ops = array(
            'classname' => 'widget_codearchitect',
            'description' => 'Codearchitect Custom Text Widget',
            'customize_selective_refresh' => true,
        );
        $control_ops = array(
            'width' => 400,
            'height' => 350,
        );

        parent::__construct( 'widget_codearchitect', 'Codearchitect Custom Text', $widget_ops, $control_ops);

        add_action('widgets_init', array(&$this, 'widgetsInit'));
    }

    /**
     * Register this widget
     */
    public function widgetsInit()
    {
        register_widget( $this );
    }

    /**
     * Outputs the content of the widget
     *
     * @param array $args
     * @param array $instance
     */
    public function widget( $args, $instance ) {
        echo $args['before_widget'];
        if ( ! empty( $instance['title'] ) ) {
            echo $args['before_title'] . apply_filters( 'widget_title', $instance['title'] ) . $args['after_title'];
        }
        echo $args['after_widget'];
    }

    /**
     * Outputs the options form on admin
     *
     * @param array $instance The widget options
     */
    public function form( $instance ) {
        $title = ! empty( $instance['title'] ) ? $instance['title'] : __( 'Custom Text',PLUGIN_DOMAIN );
        ?>
        <p>
            <label for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>"><?php esc_attr_e( 'Title:', 'awps' ); ?></label>
            <input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>" type="text" value="<?php echo esc_html( $title ); ?>">
        </p>
    <?php
    }

    /**
     * Processing widget options on save
     *
     * @param array $new_instance The new options
     * @param array $old_instance The previous options
     */
    public function update( $new_instance, $old_instance ) {
        $instance = $old_instance;
        $instance['title'] = sanitize_text_field( $new_instance['title'] ); //wp sanitize_text_field();

        return $instance;
    }
}