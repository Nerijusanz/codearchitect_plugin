<?php
/**
 * @package Codearchitect
 */

namespace CA_Inc\site_core\shortcodes;


class TooltipShortcode {

    public function __construct(){

        add_shortcode('tooltip',array($this,'init'));

    }


    function init($atts,$content=null){

        //make bootstrap tooltip component
        //add in to .src/scripts/modules/content.js :  $('[data-toggle="tooltip"]').tooltip();
        //different css: span.awps-tooltip, btn.awps-tooltip

        //get attributes
        $atts = shortcode_atts(
            array(
                'placement' => 'top',   //default placement="top"
                'title' => '',
                'trigger'=>'hover' //make default trigger
            ),
            $atts,
            'tooltip'   //[tooltip][/tooltip]
        );


        //parameters into variables
        $title = $atts['title'];
        $placement = $atts['placement'];
        $trigger = $atts['trigger'];

        //check isset title parameter
        $title = ($title=='')?$content : $title;    //if title are not defined, that title equals content

        //return '<span class="awps-tooltip" data-toggle="tooltip" data-placement="'.$placement.'" data-trigger="'.$trigger.'" title="'.$title.'">'.$content.'</span>';
        return '<button type="button" class="btn btn-secondary tooltip" data-toggle="tooltip" data-placement="'.esc_attr($placement).'" data-trigger="'.esc_attr($trigger).'" title="'.esc_attr($title).'">'.esc_html($content).'</button>';

        //usage: insert into WP post content: [tooltip placement="top" trigger="hover" title="this is title"]this is content[/tooltip]
    }

} 