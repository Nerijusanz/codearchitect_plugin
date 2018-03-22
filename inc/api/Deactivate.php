<?php
/**
 * @package Codearchitect
 */

namespace CA_Inc\api;


use CA_Inc\setup\Settings;

class Deactivate {

    public function __construct(){

        register_activation_hook( Settings::$plugin, array($this,'deactivate_plugin') );

    }


    public static function deactivate_plugin(){

        flush_rewrite_rules();

    }

} 