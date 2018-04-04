<?php
/**
 * @package Codearchitect
 */

namespace CA_Inc\modules\settings;

use CA_Inc\modules\api\ModulesSetup;

class Init {

    public function __construct(){

        new SettingsSetup();

        if( ModulesSetup::check_module_activation_status(SettingsSetup::$module) == false ) //if false stop load SettingsModule;
            return; //turn off module

        //init module
        new SettingsModule();

    }

} 