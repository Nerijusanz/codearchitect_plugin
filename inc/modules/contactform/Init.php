<?php
/**
 * @package codearchitect
 */

namespace CA_Inc\modules\contactform;

use CA_Inc\modules\api\ModulesSetup;
use CA_Inc\setup\Settings;

class Init {

    public static $module;

    public function __construct(){

        self::$module = 'contactform';    //setup/Settings::init_modules();

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
        new ContactformMessageCpt(); //custom post type
        new ContactformMessageProcess(); //process contact form data

    }

}


