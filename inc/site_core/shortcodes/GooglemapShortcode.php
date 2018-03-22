<?php
/**
 * @package Codearchitect
 */

namespace CA_Inc\site_core\shortcodes;


class GooglemapShortcode {

    public function __construct(){

        add_shortcode('googlemap',array($this,'init'));

    }



    function init($atts,$content=null){

        //get attributes
        $atts = shortcode_atts(
            array(
                'width' => 640,   //default width
                'height' => 480,  //default height
                'src' => '' //default src
            ),
            $atts,
            'googlemap'   //[googlemap][/googlemap]
        );


        //make validation
        $width = preg_replace('#[^0-9]#','',$atts['width']);
        $height = preg_replace('#[^0-9]#','',$atts['height']);
        $src = $atts['src'];


        if($width !='' || $height !='' || $src !=''){
            return '<iframe width="'.esc_attr($width).'" height="'.esc_attr($height).'" src="'.esc_url($src).'&output=embed"></iframe>';
        }
        //[googlemap width="800" height="500" src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d17888.72360052774!2d21.827534649063242!3d55.91313201016182!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x46e50e054c96d5f3%3A0x400d18c70e9db90!2zUGx1bmfElw!5e0!3m2!1slt!2slt!4v1510931943292"][/googlemap]
        //[googlemap width="600" height="300" src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d17888.72360052774!2d21.827534649063242!3d55.91313201016182!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x46e50e054c96d5f3%3A0x400d18c70e9db90!2zUGx1bmfElw!5e0!3m2!1slt!2slt!4v1510930101528"][/googlemap]

    }



} 