<?php
/**
 * @package Codearchitect
 */

namespace CA_Inc\modules\supports;

use CA_Inc\setup\Settings;
use CA_Inc\modules\api\ModulesSetup;

class Setup {

    public static $module;

    public static $module_parent_slug;

    public static $module_slug;

    public static $module_title;

    public static $module_capability = 'manage_options';


    public function __construct(){

        self::$module = Settings::$plugin_modules['supports']['key'];

        self::$module_parent_slug = ModulesSetup::get_main_module_key();

        self::$module_slug = self::$module_parent_slug .'_'. self::$module;

        self::$module_title = Settings::$plugin_modules['supports']['title']; //uppercase first letter

    }


} 