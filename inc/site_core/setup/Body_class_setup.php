<?php
/**
 * @package Codearchitect
 */

namespace CA_Inc\site_core\setup;


class Body_class_setup {

    public function __construct()
    {
        add_filter('body_class', array($this, 'body_class'));
    }

    public function body_class($classes)
    {

        // Adds a class of group-blog to blogs with more than 1 published author.
        if (is_multi_author()) {
            $classes[] = 'ca-multi-author';
        }
        // Adds a class of hfeed to non-singular pages.
        if (is_singular()) {
            $classes[] = 'ca-singular-page';
        }

        if(is_front_page()){
            $classes[] = 'ca-front-page';
        }

        if(is_home()){
            $classes[] = 'ca-home-page';
        }

        global $is_lynx,$is_gecko,$is_IE,$is_edge,$is_opera,$is_NS4,$is_safari,$is_chrome,$is_iphone;

        if($is_lynx) $classes[]='lynx';
        elseif($is_gecko) $classes[]='gecko';//Firefox
        elseif($is_IE) $classes[]='ie';
        elseif($is_edge) $classes[]='ms_edge';  //miicrosoft edge
        elseif($is_opera) $classes[]='opera';
        elseif($is_NS4) $classes[]='ns4';   //Netscape4
        elseif($is_safari) $classes[]='safari';
        elseif($is_chrome) $classes[]='chrome';
        else $classes[] = '';

        if($is_iphone) $classes[]='iphone';

        return $classes;
    }


} 