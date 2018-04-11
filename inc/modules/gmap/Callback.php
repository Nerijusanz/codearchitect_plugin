<?php
/**
 * @package Codearchitect
 */

namespace CA_Inc\modules\gmap;

use CA_Inc\setup\Settings;
use CA_Inc\modules\api\ModulesSetup;

class Callback {


    public static function template(){

        ModulesSetup::get_modules_page_template(Setup::$module);

    }

    public static function field_gmap_api_key(){

        $params = array(
            'class'=>'regular-text',
            'placeholder'=>__('api key',PLUGIN_DOMAIN)
        );

        $field_value = ( isset(Settings::$plugin_db['modules'][ Setup::$module ]['api_key']) )? Settings::$plugin_db['modules'][ Setup::$module ]['api_key']:'';

        echo '<input type="text" class="'.esc_attr($params['class']).'" name="'.Settings::$plugin_option.'[modules]['.Setup::$module.'][api_key]" value="'.esc_html($field_value).'" placeholder="'.esc_html($params['placeholder']).'" />';


    }

    public static function field_gmap_zoom(){

        $params = array(
            'class'=>'regular-text',
            'placeholder'=>__('map zoom',PLUGIN_DOMAIN)
        );

        $field_value = ( isset(Settings::$plugin_db['modules'][ Setup::$module ]['map_zoom']) )? Settings::$plugin_db['modules'][ Setup::$module ]['map_zoom']:'';

        echo '<input type="text" class="'.esc_attr($params['class']).'" name="'.Settings::$plugin_option.'[modules]['.Setup::$module.'][map_zoom]" value="'.esc_html($field_value).'" placeholder="'.esc_html($params['placeholder']).'" />';

    }

    public static function field_gmap_center_lat_lang(){

        echo '<div class="map_center">
                <span>'.self::field_gmap_center_title().'</span>
                <span>'.self::field_gmap_center_lat().'</span>
                <span>'.self::field_gmap_center_long().'</span>
            </div>';

    }

    private static function field_gmap_center_title(){

        $params = array(
            'id'=>'map_center_title',
            'class'=>'regular-text',
            'placeholder'=>__('title',PLUGIN_DOMAIN)
        );

        $field_value = ( isset(Settings::$plugin_db['modules'][ Setup::$module ]['map_center']['title']) )? Settings::$plugin_db['modules'][ Setup::$module ]['map_center']['title']:'';



        return '<label for="'.esc_attr($params['id']).'">'.__('title',PLUGIN_DOMAIN).'</label>
        <input type="text" id="'.esc_attr($params['id']).'" style="width:25%;" class="'.esc_attr($params['class']).'" name="'.Settings::$plugin_option.'[modules]['.Setup::$module.'][map_center][title]" value="'.esc_html($field_value).'" placeholder="'.esc_html($params['placeholder']).'" />';

    }

    private static function field_gmap_center_lat(){

        $params = array(
            'id'=>'map_center_lat',
            'class'=>'regular-text',
            'placeholder'=>__('lattitude',PLUGIN_DOMAIN)
        );

        $field_value = ( isset(Settings::$plugin_db['modules'][ Setup::$module ]['map_center']['lat']) )? Settings::$plugin_db['modules'][ Setup::$module ]['map_center']['lat']:'';

        return '<label for="'.esc_attr($params['id']).'">'.__('lattitude',PLUGIN_DOMAIN).'</label>
        <input type="text" id="'.esc_attr($params['id']).'" style="width:15%;" class="'.esc_attr($params['class']).'" name="'.Settings::$plugin_option.'[modules]['.Setup::$module.'][map_center][lat]" value="'.esc_html($field_value).'" placeholder="'.esc_html($params['placeholder']).'" />';

    }

    private static function field_gmap_center_long(){

        $params = array(
            'id'=>'map_center_long',
            'class'=>'regular-text',
            'placeholder'=>__('longitude',PLUGIN_DOMAIN)
        );

        $field_value = ( isset(Settings::$plugin_db['modules'][ Setup::$module ]['map_center']['long']) )? Settings::$plugin_db['modules'][ Setup::$module ]['map_center']['long']:'';

        return '<label for="'.esc_attr($params['id']).'">'.__('longitude',PLUGIN_DOMAIN).'</label>
        <input type="text" id="'.esc_attr($params['id']).'" style="width:15%;" class="'.esc_attr($params['class']).'" name="'.Settings::$plugin_option.'[modules]['.Setup::$module.'][map_center][long]" value="'.esc_html($field_value).'" placeholder="'.esc_html($params['placeholder']).'" />';

    }





} 