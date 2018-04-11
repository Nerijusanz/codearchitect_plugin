<?php
/**
 * @package Codearchitect
 */

namespace CA_Inc\modules\gmap;

use CA_Inc\setup\Settings;
use CA_Inc\modules\api\ModulesSetup;

use CA_Inc\modules\gmap\table\ListTableProcess;

class Setup {

    public static $module;

    public static $module_parent_slug;

    public static $module_slug;

    public static $module_title;

    public static $module_capability = 'manage_options';


    public function __construct(){

        self::$module = Settings::$plugin_modules['gmap']['key'];

        self::$module_parent_slug = ModulesSetup::get_main_module_key();

        self::$module_slug = self::$module_parent_slug .'_'. self::$module;

        self::$module_title=Settings::$plugin_modules['gmap']['title']; //uppercase first letter

        add_action( 'wp_enqueue_scripts', array( $this, 'gmap_frontend_enqueue' ) );   //for front-end

        $post_action = self::$module.'_module_form_add';   //action defined at form hidden field: contact/template/settings.php
        add_action( 'admin_post_'.$post_action, array($this,'save_module_items') );

        self::localize_gmap_settings();

    }

    public function save_module_items(){

        //var_dump($_POST);exit;

        if (isset($_POST[self::$module.'_module_form_add_submit'])):  //form submit

            $nonce_action = self::$module.'_module_form_add_action';
            $nonce_data = ( isset($_POST[self::$module.'_module_form_add_nonce']) )? $_POST[self::$module.'_module_form_add_nonce'] :'';

            if ( !wp_verify_nonce( $nonce_data, $nonce_action ) )//wp nonce created at form hidden field;
                ModulesSetup::redirect_module_page(self::$module_slug);

            //validation
            $api_key = (isset($_POST[Settings::$plugin_option]['modules'][self::$module]['api_key']) )? sanitize_text_field($_POST[Settings::$plugin_option]['modules'][self::$module]['api_key']):'';
            $map_zoom = (isset($_POST[Settings::$plugin_option]['modules'][self::$module]['map_zoom']) )? sanitize_text_field($_POST[Settings::$plugin_option]['modules'][self::$module]['map_zoom']):'';
            $map_center_title = (isset($_POST[Settings::$plugin_option]['modules'][self::$module]['map_center']['title']) )? sanitize_text_field($_POST[Settings::$plugin_option]['modules'][self::$module]['map_center']['title']):'';
            $map_center_lat = (isset($_POST[Settings::$plugin_option]['modules'][self::$module]['map_center']['lat']) )? sanitize_text_field($_POST[Settings::$plugin_option]['modules'][self::$module]['map_center']['lat']):'';
            $map_center_long = (isset($_POST[Settings::$plugin_option]['modules'][self::$module]['map_center']['long']) )? sanitize_text_field($_POST[Settings::$plugin_option]['modules'][self::$module]['map_center']['long']):'';
            //add to db list
            Settings::$plugin_db['modules'][self::$module]['api_key'] = $api_key;
            Settings::$plugin_db['modules'][self::$module]['map_zoom'] = $map_zoom;
            Settings::$plugin_db['modules'][self::$module]['map_center']['title'] = $map_center_title;
            Settings::$plugin_db['modules'][self::$module]['map_center']['lat'] = $map_center_lat;
            Settings::$plugin_db['modules'][self::$module]['map_center']['long'] = $map_center_long;

            //save to db
            update_option(Settings::$plugin_option,Settings::$plugin_db);

            //redirect
            ModulesSetup::redirect_module_page(self::$module_slug);

        endif;

    }

    public function gmap_frontend_enqueue(){

        $src = 'https://maps.googleapis.com/maps/api/js?key='.self::get_gmap_module_item('api_key');
        wp_enqueue_script( 'gmap-js', $src, array(),'', true );
    }

    public static function localize_gmap_settings(){

        $gmap=array();
        $gmap['gmap']['map_zoom'] = self::get_gmap_module_item('map_zoom');
        $gmap['gmap']['map_center']['lat'] = self::get_gmap_module_map_center_item('lat');
        $gmap['gmap']['map_center']['long'] = self::get_gmap_module_map_center_item('long');

        $gmap = array_merge(Settings::$localize_front_settings,$gmap);

        Settings::$localize_front_settings = $gmap;

    }


    public static function get_gmap_module_item($item_name){

        return (isset(Settings::$plugin_db['modules'][self::$module][$item_name]))? sanitize_text_field(Settings::$plugin_db['modules'][self::$module][$item_name]):null;

    }

    public static function get_gmap_module_map_center_item($item_name){

        return (isset(Settings::$plugin_db['modules'][self::$module]['map_center'][$item_name]))? sanitize_text_field(Settings::$plugin_db['modules'][self::$module]['map_center'][$item_name]):null;

    }


    public static function gmap_front_template(){
        //note:: add this function on template;  echo gmap_front_template();
        if(ModulesSetup::check_module_activation_status(self::$module) == false)
            return; //stop redering map

        return '<div id="map"></div>';

    }



    /*****************TABLE PROCESS***********************/

    public static function table_module_data(){

        return array(
            array(
                'id'=>1,
                'title'=>'location1',
                'lat'=>'lat1',
                'long'=>'long1'
            ),
            array(
                'id'=>2,
                'title'=>'location2',
                'lat'=>'lat2',
                'long'=>'long2'
            )
        );

    }

    public static function table_items_per_page(){

        return 10;

    }


    public static function get_module_by_id($id){ //usage for templates: edit, delete data by id: function CptSetup::cpt_table_item_edit_template($id), CptSetup::cpt_table_item_delete_template($id);

       /*$module=array();

        $id = preg_replace('#[^0-9]#','',$id);   //make id filter: only digits 0-9 allow

        if($id == '') return $module; //make check id param after filter validation, if id param empty: return empty module array;

        if( isset(Settings::$plugin_db['modules'][self::$module]['modules']) ):   //if cpt modules list not empty;

            foreach(Settings::$plugin_db['modules'][self::$module]['modules'] as $cpt_module):

                if($cpt_module['module_id'] == $id) {
                    $module=$cpt_module;
                    break;
                }
            endforeach;

        endif;

        return $module;*/


    }


} 