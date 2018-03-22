<?php
/**
 * @package Codearchitect
 */

namespace CA_Inc\modules\contact;

use CA_Inc\setup\Settings;
use CA_Inc\modules\api\ModulesSetup;

class ContactSetup {

    public static $module;

    public static $module_parent_slug;

    public static $module_slug;

    public static $module_title;

    public static $module_capability = 'manage_options';

    public static $module_option;


    public function __construct(){

        self::$module = Settings::$plugin_modules['contact'];

        self::$module_parent_slug = Settings::$plugin_modules['codearchitect'];

        self::$module_slug = self::$module_parent_slug .'_'. self::$module;

        self::$module_title=ucfirst( self::$module ); //uppercase first letter

        $post_action = self::$module.'_module_form_add';   //action defined at form hidden field: contact/template/settings.php
        add_action( 'admin_post_'.$post_action, array($this,'save_module_items') );

    }


    public function save_module_items(){

        if (isset($_POST[self::$module.'_module_form_add_submit'])):  //form submit

            $nonce_action = self::$module.'_module_form_add_action';
            $nonce_data = ( isset($_POST[self::$module.'_module_form_add_nonce']) )? $_POST[self::$module.'_module_form_add_nonce'] :'';

            if ( !wp_verify_nonce( $nonce_data, $nonce_action ) )//wp nonce created at form hidden field;
                ModulesSetup::redirect_module_page(self::$module_slug);

            //validation
            $company_name = (isset($_POST[Settings::$plugin_option]['modules'][self::$module]['company_name']) )? sanitize_text_field($_POST[Settings::$plugin_option]['modules'][self::$module]['company_name']) :'';
            $company_address = (isset($_POST[Settings::$plugin_option]['modules'][self::$module]['company_address']))? sanitize_text_field($_POST[Settings::$plugin_option]['modules'][self::$module]['company_address']):'';
            //add to list
            Settings::$plugin_db['modules'][self::$module]['company_name'] = $company_name;
            Settings::$plugin_db['modules'][self::$module]['company_address'] = $company_address;
            //save to db
            update_option(Settings::$plugin_option,Settings::$plugin_db);

            //redirect
            ModulesSetup::redirect_module_page(self::$module_slug);

        endif;

    }


} 