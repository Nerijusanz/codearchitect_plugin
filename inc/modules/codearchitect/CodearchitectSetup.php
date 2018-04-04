<?php
/**
 * @package Codearchitect
 */

namespace CA_Inc\modules\codearchitect;

use CA_Inc\setup\Settings;

class CodearchitectSetup {

    public static $module;

    public static $module_slug;

    public static $module_title;

    public static $module_capability = 'manage_options';

    public static $module_icon='dashicons-admin-generic';

    public static $module_menu_position = 110;


    public function __construct(){

        self::$module = Settings::$plugin_modules['codearchitect']['key'];

        self::$module_slug = self::$module;

        self::$module_title = Settings::$plugin_modules['codearchitect']['title'];

    }
} 