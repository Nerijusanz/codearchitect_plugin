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

        if ( !empty(Settings::$plugin_db) ) //make check if plugin db option are exists;
            return;

        // The plugin db object option hasn't been created yet.

        $default=array();

        $default = array_merge($default, ModulesSetup::generate_modules_list() );   //add default modules to db

        update_option(Settings::$plugin_option, $default );//add default data to plugin db

    }



} 