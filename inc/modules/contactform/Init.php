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

        new ContactformSetup();

        if( ModulesSetup::check_module_activation_status( ContactformSetup::$module ) == false ) //if false - stop render ContactModule;
            return;

        new ContactformModule();    //init ContactModule
        new ContactformMessageCpt(); //custom post type
        new ContactformMessageProcess(); //process contact form data
    }

} 