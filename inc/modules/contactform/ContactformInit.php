<?php
/**
 * @package codearchitect
 */

namespace CA_Inc\modules\contactform;

use CA_Inc\modules\api\ModulesSetup;

class ContactformInit {

    public function __construct(){

        new ContactformSetup();

        if( ModulesSetup::check_module_activation_status( ContactformSetup::$module ) == false ) //if false - stop render ContactModule;
            return;

        new ContactformModule();    //init ContactModule

    }

} 