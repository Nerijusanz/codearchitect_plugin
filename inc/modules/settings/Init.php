<?php
/**
 * @package Codearchitect
 */

namespace CA_Inc\modules\settings;

use CA_Inc\modules\api\ModulesSetup;
use CA_Inc\setup\Settings;

class Init {

    public function __construct(){

        if( !isset(Settings::$plugin_modules['settings']))
            return;

        new SettingsSetup();

        if( ModulesSetup::check_module_activation_status(SettingsSetup::$module) == false ) //if false stop load SettingsModule;
            return; //turn off module

        //init module
        new SettingsModule();

    }

} 