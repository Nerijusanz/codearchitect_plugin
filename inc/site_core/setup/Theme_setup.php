<?php
/**
 * @package Codearchitect
 */

namespace CA_Inc\site_core\setup;

use CA_Inc\setup\Settings;

class Theme_setup{


    public function __construct(){

        $this->init();

    }

    public function init(){

        add_action( 'after_setup_theme', array($this,'theme_load_text_domain') );   //important: load textdomain for localization and translating
        add_action('afetr_setup_theme',array($this,'clean_theme_settings')); //clean theme head params


        add_filter('login_headerurl',array($this,'site_login_header_url')); //Replace login logo default url into site url
        add_filter('login_headertitle',array($this,'site_login_header_title')); //add title label on logo
        add_action('login_head',array($this,'site_login_logo'));    //change login link logo;


        add_action( 'after_setup_theme', array($this, 'set_custom_content_width' ), 0); //Define a max content width to allow WordPress to properly resize your images
        add_filter('the_content_more_link',array($this,'set_custom_content_read_more_link'));   //add custom CONTENT read more link

        add_filter('excerpt_more',array($this,'remove_default_excerpt_more_link')); //remove default wp excerpt more link
        add_filter('the_excerpt',array($this,'set_custom_excerpt_more_link'),21);   //add custom EXCERPT read more link
        add_filter('excerpt_length',array($this,'set_content_split_length')); //content words split if no excerpt

        add_filter('widget_tag_cloud_args',array($this,'set_custom_tags_font_size'),10,1); //add custom tags widget font size

        add_filter('comment_form_defaults',array($this,'customize_comment_form_default_fields')); //customize default comment section;

    }

    function theme_load_text_domain(){

        load_theme_textdomain( Theme_settings::$plugin, get_template_directory() . '/languages' );

    }


    public function clean_theme_settings(){

        add_filter('script_loader_src',array($this,'remove_wp_version_arg')); //remove wp version from scripts
        add_filter('style_loader_src',array($this,'remove_wp_version_arg'));    //remove wp version from style

        remove_action('wp_head','wp_generator'); //remove the meta wp version generator from header
        remove_action('wp_head','adjacent_posts_rel_link_wp_head',10,0);    //remove both: link rel="prev" and link rel="next"
        remove_action('wp_head','rsd_link');    //remove rel="edituri" link. useful for security
        remove_action('wp_head','wlwmanifest_link');    //remove link rel="wlwmanifest"
        remove_action('wp_head','feed_links',2);    // remove the link rel="alternate" feed links for regular posts fee and comments feed
        remove_action('wp_head','feed_links_extra',3);  // Remove links to the extra feeds (e.g. category feeds)

    }

        /*
    public function remove_wp_version_arg($src){

        global $wp_version;

        $url = parse_url($src,PHP_URL_QUERY);   //split url blocks into array

        parse_str($url,$url_arg);   //split variables into array

        if(!empty($url_arg) && $url_arg['ver'] === $wp_version ){

            $src = remove_query_arg('ver',$src);

        }

        return $src;

    }*/


    public function site_login_header_url($url){

        $url = site_url();

        return $url;

    }


    public function site_login_header_title($title){

        $title = get_bloginfo('name');
        return $title;

    }

    public function site_login_logo() {

        $logo_style = '<style type="text/css">h1 a {background-image: url('.Theme_settings::$login_logo_url.') !important; }</style>';
        echo $logo_style;

    }


    public function set_custom_content_width()
    {
        //Define a max content width to allow WordPress to properly resize your images
        $GLOBALS[ 'content_width' ] = apply_filters( 'content_width', 1440 );

    }


    public function set_custom_content_read_more_link(){

        $post = get_post();
        $prefix = '...';

        $content_read_more_link = sprintf('<a href="%s">%s%s</a>',
            esc_url( get_permalink($post->ID) ),
            __('read more',PLUGIN_DOMAIN),
            $prefix
        );

        return $content_read_more_link;

    }


    public static function remove_default_excerpt_more_link($more){

        return '';

    }

    public static function set_custom_excerpt_more_link($excerpt){

        $post = get_post();
        $prefix = '...';

        $excerpt_read_more_link = sprintf('<a href="%s">%s%s</a>',
            esc_url( get_permalink($post->ID) ),
            __('read more',PLUGIN_DOMAIN),
            $prefix
        );

        return $excerpt_read_more_link;

    }

    public static function set_content_split_length(){
        //content words split if not added excerpt
        return 75;

    }

    public static function set_custom_tags_font_size($args){

        $args['smallest'] = 10;
        $args['largest'] = 14;

        return $args;
    }

    public static function customize_comment_form_default_fields($default){
        //comments section. remove url field from comment form
        unset($default['fields']['url']);
        unset($default['comment_notes_after']);
        return $default;

    }

}//end class