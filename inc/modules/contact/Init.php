<?php
/**
 * @package Codearchitect
 */

namespace CA_Inc\modules\contact;

use CA_Inc\modules\api\ModulesSetup;

class Init {


    public function __construct(){

        new ContactSetup();

        if( ModulesSetup::check_module_activation_status( ContactSetup::$module ) == false ) //if false - stop render ContactModule;
            return;

        new ContactModule();    //init ContactModule

    }

} 