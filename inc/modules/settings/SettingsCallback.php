<?php
/**
 * @package Codearchitect
 */

namespace CA_Inc\modules\settings;

use CA_Inc\setup\Settings;


class SettingsCallback {


    public static function template(){

        require_once(Settings::$plugin_path . '/inc/modules/' . SettingsSetup::$module . '/template/' . SettingsSetup::$module .'.php');

    }

    public static function field_site_shutdown(){

        $params = array(
            'id'=>'site_shutdown',
            'class'=>''
        );

        $checked = ( isset(Settings::$plugin_db['modules'][ SettingsSetup::$module ]['site_shutdown']) && Settings::$plugin_db['modules'][ SettingsSetup::$module ]['site_shutdown'] == 1 )? 'checked':'';

        $output='<div class="form-check">';
        $output.='<label class="form-check-label" for="'.$params['id'].'">';
        $output.='<input type="checkbox" id="'.$params['id'].'" name="'.Settings::$plugin_option.'[modules]['.SettingsSetup::$module.'][site_shutdown]" class="form-check-input '.$params['class'].'" value="1" '.$checked.' >';
        $output.= '</label>';
        $output.='</div>';

        echo $output;

    }


} 