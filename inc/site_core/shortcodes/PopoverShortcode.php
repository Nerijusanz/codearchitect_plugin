<?php
/**
 * @package Codearchitect
 */

namespace CA_Inc\site_core\shortcodes;


class PopoverShortcode {

    public function __construct(){

        add_shortcode('popover',array($this,'init'));

    }


    function init($atts,$content=null){

        //make bootstrap popover component
        //add in to .src/scripts/modules/content.js: $('[data-toggle="popover"]').popover();
        //different css: span.awps-popover, btn.awps-popover

        $atts = shortcode_atts(
            array(
                'placement'=>'right',   //default placement="right"
                'content'=>'',  //default content
                'trigger'=>'click'  //make default trigger
            ),
            $atts,
            'popover'   //[popover][/popover]
        );

        //parameters into variables
        $placement = $atts['placement'];
        $attr_content = $atts['content'];
        $trigger = $atts['trigger'];

        //check isset content, if false use default content
        $attr_content = ($attr_content=='')?$content:$attr_content;

        //usage: insert into WP post content: [popover placement="right" trigger="hover" content="this is popover text"]popover content[/popover]

        //return '<span class="awps-popover" data-container="body" data-toggle="popover" data-placement="'.$placement.'" data-trigger="'.$trigger.'" data-content="'.$attr_content.'">'.$content.'</span>';
        return '<button type="button" class="btn btn-danger popover" data-container="body" data-toggle="popover" data-placement="'.esc_attr($placement).'" data-trigger="'.esc_attr($trigger).'" data-content="'.esc_attr($attr_content).'">'.esc_html($content).'</button>';


    }


} 