<?php
/**
 * @package Codearchitect
 */

namespace CA_Inc\api;

class Deactivate {

    public static function deactivate_plugin(){

        flush_rewrite_rules();

    }

} 