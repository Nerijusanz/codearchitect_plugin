<?php
/**
 * @package Codearchitect
 */

namespace CA_Inc\modules\supports;

use CA_Inc\modules\api\ModulesSetup;

class SupportsInit {

    public function __construct(){

        new SupportsSetup();

        if( ModulesSetup::check_module_activation_status(SupportsSetup::$module) == false ) //if false stop load SupportModule;
            return; //turn off module

        //init module
        new SupportsModule();
    }

} 