<?php
/**
 * @package Codearchitect
 */

namespace CA_Inc\api;


use CA_Inc\setup\Settings;

class Deactivate {

    public static function deactivate_plugin(){

        flush_rewrite_rules();

    }

} 