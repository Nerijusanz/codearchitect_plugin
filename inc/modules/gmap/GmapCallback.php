<?php
/**
 * @package Codearchitect
 */

namespace CA_Inc\modules\gmap;

use CA_Inc\setup\Settings;


class GmapCallback {


    public static function template(){

        require_once(Settings::$plugin_path . '/inc/modules/' . GmapSetup::$module . '/template/' . GmapSetup::$module .'.php');

    }


} 