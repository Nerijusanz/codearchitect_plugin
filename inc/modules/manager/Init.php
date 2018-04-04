<?php
/**
 * @package Codearchitect
 */


namespace CA_Inc\modules\manager;


class Init {

    public function __construct(){
        //init module
        new ManagerSetup();
        new ManagerModule();

    }

} 