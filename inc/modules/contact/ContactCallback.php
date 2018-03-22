<?php
/**
 * @package Codearchitect
 */

namespace CA_Inc\modules\contact;

use CA_Inc\setup\Settings;


class ContactCallback {


    public static function contact(){

        return require_once(Settings::$plugin_path . '/inc/modules/' . ContactSetup::$module . '/template/' . ContactSetup::$module .'.php');

    }


    public static function field_company_name(){

        $params = array(
            'class'=>'regular-text',
            'placeholder'=>__('company name',PLUGIN_DOMAIN)
        );

        $field_value = ( isset(Settings::$plugin_db['modules'][ ContactSetup::$module ]['company_name']) )? Settings::$plugin_db['modules'][ ContactSetup::$module ]['company_name']:'';

        echo '<input type="text" class="'.esc_attr($params['class']).'" name="'.Settings::$plugin_option.'[modules]['.ContactSetup::$module.'][company_name]" value="'.esc_html($field_value).'" placeholder="'.esc_html($params['placeholder']).'" />';

    }


    public static function field_company_address(){

        $params = array(
            'class'=>'regular-text',
            'placeholder'=>__('company address',PLUGIN_DOMAIN)
        );

        $field_value = ( isset(Settings::$plugin_db['modules'][ ContactSetup::$module ]['company_address']) )? Settings::$plugin_db['modules'][ ContactSetup::$module ]['company_address']:'';

        echo '<input type="text" class="'.esc_attr($params['class']).'" name="'.Settings::$plugin_option.'[modules]['.ContactSetup::$module.'][company_address]" value="'.esc_html($field_value).'" placeholder="'.esc_html($params['placeholder']).'" />';

    }


} 