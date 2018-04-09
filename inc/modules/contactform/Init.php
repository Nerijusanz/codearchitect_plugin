<?php
/**
 * @package codearchitect
 */

namespace CA_Inc\modules\contactform;

use CA_Inc\modules\api\ModulesSetup;
use CA_Inc\setup\Settings;

class Init {

    public function __construct(){

        if( !isset(Settings::$plugin_modules['contactform']))
            return;

        new Setup();

        if( ModulesSetup::check_module_activation_status( Setup::$module ) == false ) //if false - stop render ContactModule;
            return;

        new Module();    //init ContactModule
        new ContactformMessageCpt(); //custom post type
        new ContactformMessageProcess(); //process contact form data
    }

} 