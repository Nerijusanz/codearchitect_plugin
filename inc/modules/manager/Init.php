<?php
/**
 * @package Codearchitect
 */


namespace CA_Inc\modules\manager;
use CA_Inc\setup\Settings;

class Init {

    public function __construct(){

        if( !isset(Settings::$plugin_modules['manager']))
            return;

        //init module
        new Setup();
        new Module();

    }

} 