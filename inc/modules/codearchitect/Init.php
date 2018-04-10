<?php
/**
 * @package Codearchitect
 */

namespace CA_Inc\modules\codearchitect;
use CA_Inc\setup\Settings;
use CA_Inc\modules\api\ModulesSetup;

class Init {

    public static $module;

    public function __construct(){

        self::$module = 'codearchitect';    //setup/Settings::init_modules();

        $this->init();

    }


    public function init(){

        if( !isset(Settings::$plugin_modules[ self::$module ]))
            return;


        if( ModulesSetup::check_module_activation_status(self::$module) == false ) //if false stop load SettingsModule;
            return; //turn off module

        //init module
        new Setup();
        new Module();

    }

}



