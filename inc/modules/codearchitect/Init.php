<?php
/**
 * @package Codearchitect
 */

namespace CA_Inc\modules\codearchitect;


class Init {

    public function __construct(){

        $this->init();

    }

    public function init(){

        new CodearchitectSetup();
        new CodearchitectModule();

    }

} 