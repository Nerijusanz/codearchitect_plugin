<?php
/**
 * @package Codearchitect
 */

namespace CA_Inc\modules\contact;

use CA_Inc\setup\Settings;
use CA_Inc\modules\api\ModulesSetup;


class Init {


    public function __construct(){

        if( !isset(Settings::$plugin_modules['contact']))
            return;

        new Setup();

        if( ModulesSetup::check_module_activation_status( Setup::$module ) == false ) //if false - stop render ContactModule;
            return;

        new Module();    //init ContactModule

    }

} 