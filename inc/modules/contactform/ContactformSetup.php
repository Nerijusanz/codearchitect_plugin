<?php
/**
 * @package codearchitect
 */

namespace CA_Inc\modules\contactform;

use CA_Inc\setup\Settings;
use CA_Inc\modules\api\ModulesSetup;

class ContactformSetup {

    public static $module;

    public static $module_parent_slug;

    public static $module_slug;

    public static $module_title;

    public static $module_capability = 'manage_options';


    public function __construct(){

        self::$module = Settings::$plugin_modules['contactform']['key'];

        self::$module_parent_slug = Settings::$plugin_modules['codearchitect']['key'];

        self::$module_slug = self::$module_parent_slug .'_'. self::$module;

        self::$module_title=Settings::$plugin_modules['contactform']['title']; //uppercase first letter

        add_shortcode('contact_form',array($this,'set_contact_form_shortcode'));

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
            $contact_activate_deactivate = (isset($_POST[Settings::$plugin_option]['modules'][self::$module]['contact_activate_deactivate']) )? sanitize_text_field($_POST[Settings::$plugin_option]['modules'][self::$module]['contact_activate_deactivate']) :'';
            $contact_send_email = (isset($_POST[Settings::$plugin_option]['modules'][self::$module]['contact_send_email']) )? sanitize_text_field($_POST[Settings::$plugin_option]['modules'][self::$module]['contact_send_email']) :'';

            //add to db list
            Settings::$plugin_db['modules'][self::$module]['contact_activate_deactivate'] = $contact_activate_deactivate;
            Settings::$plugin_db['modules'][self::$module]['contact_send_email'] = $contact_send_email;

            //save to db
            update_option(Settings::$plugin_option,Settings::$plugin_db);
            //redirect page
            ModulesSetup::redirect_module_page(self::$module_slug);

        endif;


    }


    public function set_contact_form_shortcode($atts,$content=null){
        //note://[contact_form][/contact_form] this shortcode add to contact page content block;
        $atts = shortcode_atts(
            array(),
            $atts,
            'contact_form'  //[contact_form][/contact_form] this shortcode add to contact page content block;
        );

        if( isset(Settings::$plugin_db['modules'][ self::$module ]['contact_activate_deactivate']) && Settings::$plugin_db['modules'][ self::$module ]['contact_activate_deactivate'] == 1 ) {

            ob_start(); //turn on output buffering;
                require_once 'template/contact_form_template.php';//save template into output buffer, and do not let return or echo instantly template!!!
            return ob_get_clean(); //first lets render site content, and after rendered site content, insert buffer content
        }

    }


} 