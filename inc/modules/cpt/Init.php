<?php
/**
 * @package Codearchitect
 */

namespace CA_Inc\modules\cpt;

use CA_Inc\modules\api\ModulesSetup;


class Init {

    public function __construct(){

        $this->init();
    }

    public function init(){

        new CptSetup(); //initialize private cpt module params;

        if( ModulesSetup::check_module_activation_status(CptSetup::$module) == false ) //if false - stop render CptModule;
            return; //turn off module

        //init module
        new CptModule();
        new CptSlider();

    }

} 