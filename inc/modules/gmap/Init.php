<?php
/**
 * @package Codearchitect
 */

namespace CA_Inc\modules\gmap;

use CA_Inc\modules\api\ModulesSetup;
use CA_Inc\setup\Settings;

class Init {

    public function __construct(){

        if( !isset(Settings::$plugin_modules['gmap']))
            return;

        new GmapSetup();

        if( ModulesSetup::check_module_activation_status(GmapSetup::$module) == false ) //if false stop load SettingsModule;
            return; //turn off module

        //init module
        new GmapModule();

    }

} 