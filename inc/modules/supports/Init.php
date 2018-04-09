<?php
/**
 * @package Codearchitect
 */

namespace CA_Inc\modules\supports;

use CA_Inc\modules\api\ModulesSetup;
use CA_Inc\setup\Settings;

class Init {

    public function __construct(){

        if( !isset(Settings::$plugin_modules['supports']))
            return;

        new Setup();

        if( ModulesSetup::check_module_activation_status(Setup::$module) == false ) //if false stop load SupportModule;
            return; //turn off module

        //init module
        new Module();
    }

} 