<?php
/**
 * @package codearchitect
 */

namespace CA_Inc\modules\contactform;

use CA_Inc\setup\Settings;

class ContactformSetup {

    public static $module;

    public static $module_parent_slug;

    public static $module_slug;

    public static $module_title;

    public static $module_capability = 'manage_options';


    public function __construct(){

        self::$module = Settings::$plugin_modules['contactform'];

        self::$module_parent_slug = Settings::$plugin_modules['codearchitect'];

        self::$module_slug = self::$module_parent_slug .'_'. self::$module;

        self::$module_title=ucfirst( self::$module ); //uppercase first letter

    }


} 