<?php
/**
 * @package Codearchitect
 */

namespace CA_Inc\api;

use CA_Inc\modules\api\ModulesSetup;
use CA_Inc\setup\Settings;

class Activate{

    public static function activate_plugin(){

        flush_rewrite_rules();

        if ( isset(Settings::$plugin_db) && !empty(Settings::$plugin_db) ) //make check if plugin db option are exists;
            ModulesSetup::refresh_modules_list();
        else    // The plugin db object option hasn't been created yet.
            ModulesSetup::generate_default_modules_list();




    }



} 