<?php
/**
 * @package Codearchitect
 */

namespace CA_Inc\modules\settings;

use CA_Inc\setup\Settings;
use CA_Inc\modules\api\ModulesSetup;

class SettingsSetup {

    public static $module;

    public static $module_parent_slug;

    public static $module_slug;

    public static $module_title;

    public static $module_capability = 'manage_options';


    public function __construct(){

        self::$module = Settings::$plugin_modules['settings'];

        self::$module_parent_slug= Settings::$plugin_modules['codearchitect'];

        self::$module_slug = self::$module_parent_slug .'_'. self::$module;

        self::$module_title=ucfirst( self::$module ); //uppercase first letter

        $post_action = self::$module.'_module_form_add';   //action defined at form hidden field: settings/template/settings.php
        add_action( 'admin_post_'.$post_action, array($this,'save_module_items') );

    }


    public function save_module_items(){

        if (isset($_POST[self::$module.'_module_form_add_submit'])) {   //form submit btn

            $nonce_action = self::$module.'_module_form_add_action';
            $nonce_data = ( isset($_POST[self::$module.'_module_form_add_nonce']) )? $_POST[self::$module.'_module_form_add_nonce'] :'';

            if ( !wp_verify_nonce( $nonce_data, $nonce_action ) )//wp nonce created at form: settings/template/settings.php
                ModulesSetup::redirect_module_page(self::$module_slug);

            //validation
            $site_shutdown = ( isset($_POST[Settings::$plugin_option]['modules'][self::$module]['site_shutdown']) && $_POST[Settings::$plugin_option]['modules'][self::$module]['site_shutdown'] == 1 )? 1:0;
            //add to list
            Settings::$plugin_db['modules'][self::$module]['site_shutdown'] = $site_shutdown;

            //save to db
            update_option(Settings::$plugin_option,Settings::$plugin_db);
            //redirect page
            ModulesSetup::redirect_module_page(self::$module_slug);

        }

    }

    //front-end checking function
    public static function make_check_site_shutdown_status(){  //usage: on page template header.php file; change template into content-site-shutdown.php

       if(!isset(Settings::$plugin_db['modules'][SettingsSetup::$module]))
           return false;

        $settings_module = Settings::$plugin_db['modules'][SettingsSetup::$module];

        $site_shutdown_status = ( isset($settings_module['site_shutdown']) && $settings_module['site_shutdown'] == 1 )? true:false;

        return $site_shutdown_status;

    }


} 