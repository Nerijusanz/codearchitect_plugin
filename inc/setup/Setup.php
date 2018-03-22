<?php
/**
 * @package Codearchitect
 */

namespace CA_Inc\setup;


class Setup {



    public function __construct(){


        add_action('init',array($this,'add_theme_supports'));  //add theme supports
        add_action('init',array($this,'setup_slider_image_size'));  //add main slider custom image size

        //add_action('admin_menu',array($this,'all_settings_link')); //add settings link at: wppanel->Settings->All Settings;

        add_filter('show_admin_bar',array($this,'top_admin_bar'));  //remove top admin bar
        add_action('wp_before_admin_bar_render',array($this,'add_google_analytics_link'));  //wppanel top navigation link; add new link;
        //add_action('publish_post',array($this,'notify_via_email')); //send notify via email then post published;

        add_filter('plugin_action_links_' . Settings::$plugin_init, array($this,'settings_link')); //add additional link: activate,deactivate,settings;
        add_filter('screen_options_show_screen', array($this,'wpb_remove_screen_options')); //only admin can see screen options
        add_action( 'in_admin_header', array( $this, 'in_admin_header' ) ); //screen options setup
    }


    public function top_admin_bar(){
        return false;
    }


    public function add_theme_supports(){

        add_theme_support( 'post-thumbnails' );
        add_theme_support( 'automatic-feed-links' );
        add_theme_support( 'title-tag' );
        add_theme_support('custom-header');
        add_theme_support('custom-background');

        add_theme_support( 'html5', array(
            'search-form',
            'comment-form',
            'comment-list',
            'gallery',
            'caption',
        ) );

        add_theme_support( 'post-formats', array(
            'aside',
            'gallery',
            'link',
            'image',
            'quote',
            'status',
            'video',
            'audio',
            'chat',
        ) );

    }

    public function setup_slider_image_size(){

        $prefix=Settings::$prefix;

        add_image_size( $prefix.'-slide-desktop',1500,430,true);
        add_image_size( $prefix.'-slide-mobile',600,290,true);

        /*
        foreach ( get_intermediate_image_sizes() as $size ) {
            if ( !in_array( $size, array( 'large', 'medium', 'small', 'slide-desktop','slide-mobile' ) ) ) {
                remove_image_size( $size );
            }
        }*/


    }


    public function settings_link($links){
        //plugin links: Activate,Deactivate,Settings

        $settings_link = sprintf('<a href="%s">%s</a>',
                            admin_url('admin.php').'?page='.Settings::$plugin,
                            __('Settings',PLUGIN_DOMAIN)
                        );

        array_push($links,$settings_link); //add custom link to plugin links list
        return $links;  // return links list

    }

    public function add_google_analytics_link(){

        global $wp_admin_bar;

        //var_dump($wp_admin_bar);

        $wp_admin_bar->add_menu(array(
            'id'=>'google_analytics',
            'title'=>__('Google Ananlytics',PLUGIN_DOMAIN),
            'href'=>'http://google.com/analytics'
        ));

    }


    /*function notify_via_email($post_id){

        //add_action('publish_post',array($this,'notify_via_email'));

        $post = get_post($post_id);

        $to = 'example@example.com';

        $subject = sprintf(__('published post on site: %s',PLUGIN_DOMAIN),
                        get_bloginfo('name')
        );

        $post_link = sprintf('<a href="%s">%s</a>',
                        get_permalink($post_id),
                        __('click here',PLUGIN_DOMAIN)
                    );

        $message = sprintf( __('%s was published at %s on date: %s by author: %s post link: %s',PLUGIN_DOMAIN),
                        $post->post_title,
                        get_bloginfo('name'),
                        $post->post_date,
                        get_the_author_meta('display_name',$post->post_author),
                        $post_link
                    );

        $message = sprintf('<p>%s</p>',$message);

        //var_dump($message);exit;

        //wp_mail($to,$subject,$message);

    }*/


    public function all_settings_link(){

        add_options_page(__('All Settings'),__('All Settings'),'administrator','options.php');

    }




    /**********CRON JOB************/
    /*function MY_CRON(){
        wp_schedule_single_event(time(),'MY_CRON_JOB_ACTION');
    }

    //add_action('save_post',array($this,'MY_CRON'));

    function CRON_JOB(){
        //do code
    }

    //add_action('MY_CRON_JOB_ACTION','CRON_JOB');
    */

    function wpb_remove_screen_options() {
        //only admin can see screen options
        if(!current_user_can('manage_options')) {
            return false;
        }
        return true;

    }


    function in_admin_header() {
        //screen options setup
        global $wp_meta_boxes;
        //echo '<pre>';var_dump($wp_meta_boxes[get_current_screen()->id]);echo '</pre>';
        unset( $wp_meta_boxes[get_current_screen()->id]['advanced'] );
        unset( $wp_meta_boxes[get_current_screen()->id]['normal']['core']['trackbacksdiv'] );
    }

}


