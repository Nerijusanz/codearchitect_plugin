<?php
/**
 * @package codearchitect
 */

namespace CA_Inc\site_core\setup;

use CA_Inc\setup\Settings;

class Theme_settings {

    public static $plugin;
    public static $login_logo_url;  //login page logo url;

    public function __construct(){

        $this->init();

    }

    public function init(){

        self::$plugin = Settings::$plugin;  //note: plugin_core settings;
        self::$login_logo_url = Settings::$plugin_url . 'assets/images/codearchitect-logo.png'; //usage: Setup::site_login_logo();    login page logo url.

    }

} 