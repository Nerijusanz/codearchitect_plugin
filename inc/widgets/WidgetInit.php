<?php
/**
 * @package Codearchitect
 */

namespace CA_Inc\widgets;


class WidgetInit {

    public function __construct()
    {
        $this->init();

    }

    public function init(){

        add_action('widgets_init', array($this, 'widgets_sidebar_init'));

        //load all widgets
        new TextWidget();
        new PostPopularWidget();
    }
    /*
        Define the sidebar
    */
    public function widgets_sidebar_init()
    {
        register_sidebar(array(
            'name' => __('Sidebar', PLUGIN_DOMAIN),
            'id' => 'codearchitect-sidebar',//usage: dynamic_sidebar( 'codearchitect-sidebar' );
            'description' => __('Default sidebar to add all your widgets', PLUGIN_DOMAIN),
            'before_widget' => '<section id="%1$s" class="widget %2$s">',
            'after_widget' => '</section>',
            'before_title' => '<h2 class="widget-title">',
            'after_title' => '</h2>',
        ));
    }
} 