<?php
/**
 * @package Codearchitect
 */

namespace CA_Inc\modules\contact;

use CA_Inc\modules\api\ModulesSetup;
use CA_Inc\setup\Settings;

class Init {


    public function __construct(){

        if( !isset(Settings::$plugin_modules['contact']))
            return;

        new ContactSetup();

        if( ModulesSetup::check_module_activation_status( ContactSetup::$module ) == false ) //if false - stop render ContactModule;
            return;

        new ContactModule();    //init ContactModule

    }

} 