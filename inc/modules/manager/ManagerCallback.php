<?php
/**
 * @package Codearchitect
 */

namespace CA_Inc\modules\manager;

use CA_Inc\setup\Settings;
use CA_Inc\modules\codearchitect\CodearchitectSetup;

class ManagerCallback {


    public static function manager(){

        require_once(Settings::$plugin_path . '/inc/modules/' . ManagerSetup::$module . '/template/' . ManagerSetup::$module .'.php');

    }


    public static function field_modules_name(){

        //make check if any module are in the manager list

        if( isset(Settings::$plugin_db['modules']) && count(Settings::$plugin_db['modules']) > 0 ):

            $output='';

                foreach(Settings::$plugin_modules as $key => $title):

                    if($key == ManagerSetup::$module  || $key == CodearchitectSetup::$module ) continue; //skip modules loop on currents keys;
                    //var_dump($plugin_option['modules'][$key]['activate']);
                    $check_status = ( isset(Settings::$plugin_db['modules'][ $key ]['activate']) && Settings::$plugin_db['modules'][ $key ]['activate'] == 1 )?'checked':'';

                    $output.='<div class="form-check">';
                    $output.='<label class="form-check-label" for="'.$key.'">';
                    $output.='<input type="checkbox" id="'.$key.'" name="'. Settings::$plugin_option.'[modules]['.$key.'][activate]" class="form-check-input '.$key.'" value="1" '.$check_status.' >';

                    $text = sprintf(__('Activate %s module',PLUGIN_DOMAIN),$title);
                    $output.= $text;
                    $output.='</div>';

                endforeach;

            echo $output;

        endif;

    }

} 