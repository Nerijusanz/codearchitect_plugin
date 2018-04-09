<?php
/**
 * @package Codearchitect
 */

namespace CA_Inc\modules\manager;

use CA_Inc\setup\Settings;
use CA_Inc\modules\codearchitect\CodearchitectSetup;

class ManagerCallback {


    public static function template(){

        require_once(Settings::$plugin_path . '/inc/modules/' . ManagerSetup::$module . '/template/' . ManagerSetup::$module .'.php');

    }


    public static function field_modules_name(){

        //make check if any module are in the manager list

        if( isset(Settings::$plugin_db['modules']) && count(Settings::$plugin_db['modules']) > 0 ):

            $output='';

                foreach(Settings::$plugin_modules as $plugin_module):

                    $module = $plugin_module['key'];
                    $module_title = $plugin_module['title'];

                    if($module == ManagerSetup::$module  || $module == CodearchitectSetup::$module ) continue; //skip modules loop on currents keys;
                    //var_dump($plugin_option['modules'][$module]['activate']);
                    $check_status = ( isset(Settings::$plugin_db['modules'][ $module ]['activate']) && Settings::$plugin_db['modules'][ $module ]['activate'] == 1 )?'checked':'';

                    $output.='<div class="form-check">';
                    $output.='<label class="form-check-label" for="'.$module.'">';
                    $output.='<input type="checkbox" id="'.$module.'" name="'. Settings::$plugin_option.'[modules]['.$module.'][activate]" class="form-check-input '.$module.'" value="1" '.$check_status.' >';

                    $text = sprintf(__('Activate %s module',PLUGIN_DOMAIN),$module_title);
                    $output.= $text;
                    $output.='</div>';

                endforeach;

            echo $output;

        endif;

    }

} 