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

        //var_dump($_POST);exit;

        if (isset($_POST[self::$module.'_module_form_add_submit'])):  //form submit

            $nonce_action = self::$module.'_module_form_add_action';
            $nonce_data = ( isset($_POST[self::$module.'_module_form_add_nonce']) )? $_POST[self::$module.'_module_form_add_nonce'] :'';

            if ( !wp_verify_nonce( $nonce_data, $nonce_action ) )//wp nonce created at form hidden field;
                ModulesSetup::redirect_module_page(self::$module_slug);

            //validation
            $company_name = (isset($_POST[Settings::$plugin_option]['modules'][self::$module]['company_name']) )? sanitize_text_field($_POST[Settings::$plugin_option]['modules'][self::$module]['company_name']) :'';
            $company_address = (isset($_POST[Settings::$plugin_option]['modules'][self::$module]['company_address']))? sanitize_text_field($_POST[Settings::$plugin_option]['modules'][self::$module]['company_address']):'';
            $company_code = (isset($_POST[Settings::$plugin_option]['modules'][self::$module]['company_code']))? sanitize_text_field($_POST[Settings::$plugin_option]['modules'][self::$module]['company_code']):'';
            $company_pvm_code = (isset($_POST[Settings::$plugin_option]['modules'][self::$module]['company_pvm_code']))? sanitize_text_field($_POST[Settings::$plugin_option]['modules'][self::$module]['company_pvm_code']):'';
            $company_phone_fax = (isset($_POST[Settings::$plugin_option]['modules'][self::$module]['company_phone_fax']))? sanitize_text_field($_POST[Settings::$plugin_option]['modules'][self::$module]['company_phone_fax']):'';
            $company_mobile = (isset($_POST[Settings::$plugin_option]['modules'][self::$module]['company_mobile']))? sanitize_text_field($_POST[Settings::$plugin_option]['modules'][self::$module]['company_mobile']):'';
            $company_email = (isset($_POST[Settings::$plugin_option]['modules'][self::$module]['company_email']))? sanitize_text_field($_POST[Settings::$plugin_option]['modules'][self::$module]['company_email']):'';
            $company_working_hours = (isset($_POST[Settings::$plugin_option]['modules'][self::$module]['company_working_hours']))? sanitize_text_field($_POST[Settings::$plugin_option]['modules'][self::$module]['company_working_hours']):'';

            $bank_name = (isset($_POST[Settings::$plugin_option]['modules'][self::$module]['bank_name']))? sanitize_text_field($_POST[Settings::$plugin_option]['modules'][self::$module]['bank_name']):'';
            $bank_address = (isset($_POST[Settings::$plugin_option]['modules'][self::$module]['bank_address']))? sanitize_text_field($_POST[Settings::$plugin_option]['modules'][self::$module]['bank_address']):'';
            $bank_code = (isset($_POST[Settings::$plugin_option]['modules'][self::$module]['bank_code']))? sanitize_text_field($_POST[Settings::$plugin_option]['modules'][self::$module]['bank_code']):'';
            $bank_swift_bic_code = (isset($_POST[Settings::$plugin_option]['modules'][self::$module]['bank_swift_bic_code']))? sanitize_text_field($_POST[Settings::$plugin_option]['modules'][self::$module]['bank_swift_bic_code']):'';
            $bank_account_number = (isset($_POST[Settings::$plugin_option]['modules'][self::$module]['bank_account_number']))? sanitize_text_field($_POST[Settings::$plugin_option]['modules'][self::$module]['bank_account_number']):'';

            //add to db list
            Settings::$plugin_db['modules'][self::$module]['company_name'] = $company_name;
            Settings::$plugin_db['modules'][self::$module]['company_address'] = $company_address;
            Settings::$plugin_db['modules'][self::$module]['company_code'] = $company_code;
            Settings::$plugin_db['modules'][self::$module]['company_pvm_code'] = $company_pvm_code;
            Settings::$plugin_db['modules'][self::$module]['company_phone_fax'] = $company_phone_fax;
            Settings::$plugin_db['modules'][self::$module]['company_mobile'] = $company_mobile;
            Settings::$plugin_db['modules'][self::$module]['company_email'] = $company_email;
            Settings::$plugin_db['modules'][self::$module]['company_working_hours'] = $company_working_hours;

            Settings::$plugin_db['modules'][self::$module]['bank_name'] = $bank_name;
            Settings::$plugin_db['modules'][self::$module]['bank_address'] = $bank_address;
            Settings::$plugin_db['modules'][self::$module]['bank_code'] = $bank_code;
            Settings::$plugin_db['modules'][self::$module]['bank_swift_bic_code'] = $bank_swift_bic_code;
            Settings::$plugin_db['modules'][self::$module]['bank_account_number'] = $bank_account_number;
            //save to db
            update_option(Settings::$plugin_option,Settings::$plugin_db);

            //redirect
            ModulesSetup::redirect_module_page(self::$module_slug);

        endif;

    }


    public static function get_contact_module_item($item_name){

        return Settings::$plugin_db['modules'][self::$module][$item_name];

    }


} 