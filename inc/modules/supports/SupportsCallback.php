<?php
/**
 * @package Codearchitect
 */

namespace CA_Inc\modules\supports;

use CA_Inc\setup\Settings;


class SupportsCallback {


    public static function template(){

        require_once(Settings::$plugin_path . '/inc/modules/' . SupportsSetup::$module . '/template/' . SupportsSetup::$module .'.php');

    }

    public static function field(){

        //echo 'SupportsCallback::field();';
        echo '<input type="text" id="datepicker" value="">';
    }

} 