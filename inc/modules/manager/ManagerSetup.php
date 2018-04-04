<?php
/**
 * @package Codearchitect
 */

namespace CA_Inc\modules\manager;

use CA_Inc\setup\Settings;
use CA_Inc\modules\api\ModulesSetup;
use CA_Inc\modules\codearchitect\CodearchitectSetup;

class ManagerSetup {

    public static $module;

    public static $module_parent_slug;

    public static $module_slug;

    public static $module_title;

    public static $module_capability = 'manage_options';


    public function __construct(){

        self::$module = Settings::$plugin_modules['manager']['key'];

        self::$module_parent_slug= Settings::$plugin_modules['codearchitect']['key'];

        self::$module_slug = self::$module_parent_slug .'_'. self::$module;

        self::$module_title=Settings::$plugin_modules['manager']['title']; //uppercase first letter
        //save items
        $post_action = self::$module.'_module_form_add';   //action defined at form hidden field: manager/template/manager.php
        add_action( 'admin_post_'.$post_action, array($this,'save_module_items') );

    }


    public function save_module_items(){

        if( isset($_POST[self::$module.'_module_form_add_submit']) ){

            $nonce_action = self::$module.'_module_form_add_action';
            $nonce_data = ( isset($_POST[self::$module.'_module_form_add_nonce']) )? $_POST[self::$module.'_module_form_add_nonce'] :'';

            if ( !wp_verify_nonce( $nonce_data, $nonce_action ) )//wp nonce created at form: manager/template/manager.php
                ModulesSetup::redirect_module_page(self::$module_slug);


            foreach(Settings::$plugin_modules as $key => $val):

                if($key == self::$module || $key == CodearchitectSetup::$module ) continue; //skip the loop; //manager module always should be turn on; It turn on/off other modules;

                $activate = ( isset($_POST[Settings::$plugin_option]['modules'][$key]['activate']) && $_POST[Settings::$plugin_option]['modules'][$key]['activate'] == 1 )?1:0;

                Settings::$plugin_db['modules'][$key]['activate'] = $activate;

            endforeach;

            update_option(Settings::$plugin_option,Settings::$plugin_db);

            ModulesSetup::redirect_module_page(self::$module_slug);

        }

    }


} 