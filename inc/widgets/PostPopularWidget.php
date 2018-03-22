<?php
/**
 * @package Codearchitect
 */

namespace CA_Inc\widgets;

use WP_Widget;
use WP_Query;

class PostPopularWidget extends WP_Widget{

    public function __construct()
    {
        $widget_ops = array(
            'classname' => 'widget_codearchitect_popular_post',
            'description' => 'codearchitect Popular Posts Widget',
            'customize_selective_refresh' => true,
        );
        $control_ops = array(
            'width' => 400,
            'height' => 350,
        );

        parent::__construct( 'widget_codearchitect_post_popular', 'Codearchitect Popular posts', $widget_ops, $control_ops);

        add_action('widgets_init', array(&$this, 'widgetsInit'));
    }


    public function widgetsInit()
    {
        register_widget( $this );
    }

    public function get_post_popular_list($post_total,$post_title_length){

        //get filtered data
        $post_total = $post_total;
        $post_title_length = $post_title_length;

        $post_meta_key = 'codearchitect_post_views'; //post meta key is defined: .config/setup/setup.php  function set_post_views($postID); store post viewed number;

        $post_args = array(
            'post_type' => 'post',
            'meta_key' => $post_meta_key,
            'orderby' =>'meta_value_num',   //or meta_value
            'posts_per_page' => $post_total,
            'order' => 'DESC'
        );

        $post_query = new WP_Query($post_args);

        $output='';

        if($post_query->have_posts()):

            $output.='<ul style="list-style: none;padding:0 10px;">';

            while($post_query->have_posts()): $post_query->the_post();


                if(strlen(get_the_title()) > $post_title_length){   //if post title characters length are more than defined at variable: $instance['post_title']

                    $post_title = substr(get_the_title(),0,$post_title_length);//for example: substr($string,0,20); return firsts 20 characters of string;
                    $post_title.='...';


                }else{
                    $post_title = get_the_title();
                }


                //make validation: if have post format; return false or post format; if not defined post format, add define it standard
                //look at icon folder: assets/images/icons  post-standard.png, post-aside.png, post-gallery.png....
                //note: if post format are defined "standard" get_post_format() return false;
                $post_format = (get_post_format() !==false )? get_post_format():'standard'; //return formats: standard,aside,gallery,video,audio.....
                $img_src = get_template_directory_uri().'/assets/images/icon/post-'.$post_format.'.png';


                $output.='<li>';
                $output.='<a href="'.get_the_permalink().'" style="margin-right:10px;">';
                $output.='<img src="'.$img_src.'" style="width:18px;height:18px;margin-right:5px;" />'.$post_title.'</a>';
                //$output.='<span style="font-size: 10px;"><i class="fa fa-eye" aria-hidden="true"></i>'.get_post_meta(get_the_ID(),$post_meta_key,true).'</span>';    //get post views number
                $output.='</li>';

            endwhile;

            $output.='</ul>';

        endif;

        return $output;

    }


    public function widget( $args, $instance ) {

        //WIDGET FRONT-END

        echo $args['before_widget'];

        if ( ! empty( $instance['title'] ) ) {
            echo $args['before_title'] . apply_filters( 'widget_title', $instance['title'] ) . $args['after_title'];
        }

        //take widget storage variable data, and make filter, only positive numbers.
        $post_total = absint($instance['post_total']);
        $post_title = absint($instance['post_title']);


        $post_list = $this->get_post_popular_list($post_total,$post_title); //generate post list: get_post_popular_list();

        echo $post_list;    //show generated post list on fronted page

        echo $args['after_widget'];

    }

    /**
     * Outputs the options form on admin
     *
     * @param array $instance The widget options
     */
    public function form( $instance ) {

        //WIDGET BACK-END

        $title = (!empty( $instance['title'] )) ? $instance['title'] : __( 'Popular posts', PLUGIN_DOMAIN ); //get field title param;
        $post_total = (!empty($instance['post_total']))?absint($instance['post_total']):4;  //get field param: how many posts return;
        $post_title = (!empty($instance['post_title']))?absint($instance['post_title']):20; //get field param: how many post title characters return;
        ?>

        <p>
            <label for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>"><?php _e( 'Title', PLUGIN_DOMAIN ); ?></label>
            <input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>" type="text" value="<?php echo esc_html( $title ); ?>">
        </p>

        <p>
            <label for="<?php echo esc_attr($this->get_field_id('post_total'));?>"><?php _e('Total posts',PLUGIN_DOMAIN);?></label>
            <input class="widefat" id="<?php echo esc_attr($this->get_field_id('post_total'));?>" name="<?php echo esc_attr($this->get_field_name('post_total'));?>" type="number" value="<?php echo esc_html($post_total);?>">
        </p>

        <p>
            <label for="<?php echo esc_attr($this->get_field_id('post_title'));?>"><?php _e('Allow title characters length',PLUGIN_DOMAIN);?></label>
            <input class="widefat" id="<?php echo esc_attr($this->get_field_id('post_title'));?>" name="<?php echo esc_attr($this->get_field_name('post_title'));?>" type="number" value="<?php echo esc_html($post_title);?>">
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

        $new_instance['post_total'] = preg_replace('#[^0-9]#','',$new_instance['post_total']);  //make filter: allow only numbers;
        $instance['post_total'] = (!empty($new_instance['post_total']) && $new_instance['post_total'] > 0 )? absint($new_instance['post_total']) : 4;   //check data after filter; if empty- make default 4 posts;

        $new_instance['post_title'] = preg_replace('#[^0-9]#','',$new_instance['post_title']);//make filter: allow only numbers;
        //make validation after filter: check title characters length. if input empty, or zero, or negative number, make title default 20 characters;
        $instance['post_title'] = (!empty($new_instance['post_title']) && $new_instance['post_title'] > 0 )? absint($new_instance['post_title']) : 20;


        return $instance;   //save widget variables
    }

} 