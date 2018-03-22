<?php
/**
 * @package Codearchitect
 */

namespace CA_Inc\site_core\shortcodes;


class ShortcodeInit {

    public function __construct(){

        add_action('init',array($this,'init'));
        //add_filter( 'comment_text', 'do_shortcode' );   //enable do shortcode on comments
        add_filter( 'the_excerpt', 'do_shortcode');   //enable do shortcodes on WP post excerpt
    }

    public function init(){
        //load shortcodes:
        new GooglemapShortcode();
        new TooltipShortcode();
        new PopoverShortcode();
    }

} 