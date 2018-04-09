<?php
/**
 * @package Codearchitect
 */

namespace CA_Inc\modules\codearchitect;
use CA_Inc\setup\Settings;

class Init {

    public function __construct(){

        $this->init();

    }

    public function init(){

        if( !isset(Settings::$plugin_modules['codearchitect']))
            return;

        new Setup();
        new Module();

    }

} 