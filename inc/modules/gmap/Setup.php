<?php
/**
 * @package Codearchitect
 */

namespace CA_Inc\modules\gmap;

use CA_Inc\setup\Settings;
use CA_Inc\modules\api\ModulesSetup;

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

        add_action('init',array($this,'localize_gmap_settings'));


    }

    public static function gmap_front_template(){
        //note:: add this function on template;  echo gmap_front_template();
        if(ModulesSetup::check_module_activation_status(self::$module) == false)
            return; //stop redering map

        return '<div id="map"></div>';

    }

    public function gmap_frontend_enqueue(){

        $src = 'https://maps.googleapis.com/maps/api/js?key='.self::get_gmap_module_item('api_key');
        wp_enqueue_script( 'gmap-js', $src, array(),'', true );
    }


    public static function localize_gmap_settings(){

        $items_fields_key = array('map_zoom','map_center_lat','map_center_long','locations');   //items fields keys which make localized

        $localize_list=array();

        foreach($items_fields_key as $key):

            $localize_list['gmap'][$key] = self::get_gmap_module_item($key);

        endforeach;

        $localize_list = array_merge(Settings::$localize_front_settings,$localize_list);

        Settings::$localize_front_settings = $localize_list;

    }

    public static function get_gmap_module_item($item_name){

        return (isset(Settings::$plugin_db['modules'][self::$module][$item_name]))? Settings::$plugin_db['modules'][self::$module][$item_name]:null;

    }


    public function save_module_items(){    //gmap main submit btn

        //var_dump($_POST);exit;

        if (isset($_POST[self::$module.'_module_form_add_submit'])):  //form submit

            $nonce_action = self::$module.'_module_form_add_action';
            $nonce_data = ( isset($_POST[self::$module.'_module_form_add_nonce']) )? $_POST[self::$module.'_module_form_add_nonce'] :'';

            if ( !wp_verify_nonce( $nonce_data, $nonce_action ) )//wp nonce created at form hidden field;
                ModulesSetup::redirect_module_page(self::$module_slug);


            //make check if post module exitst;
            if(!isset($_POST[Settings::$plugin_option]['modules'][self::$module]))
                ModulesSetup::redirect_module_page(self::$module_slug);

            $post_module = $_POST[Settings::$plugin_option]['modules'][self::$module];  //post array

            if(count($post_module)>0){  //make check if post array not empty

                foreach($post_module as $key=>$value){  //get post array item key =>value;

                    Settings::$plugin_db['modules'][self::$module][$key] = sanitize_text_field($value);

                }

            }

            update_option(Settings::$plugin_option,Settings::$plugin_db);

            //redirect
            ModulesSetup::redirect_module_page(self::$module_slug);

        endif;

    }



    /*****************TABLE PROCESS***********************/

    public static function module_locations_item_save($post_item){

        if(!isset($post_item['id']))
            ModulesSetup::redirect_module_page(self::$module_slug);

        $item_id = preg_replace('#[^0-9]#','',$post_item['id']);    //make id filter
        //check after filter if item_id param not empty;
        if(empty($item_id))    //if id param empty after validation, stop code below and redirect page;
            ModulesSetup::redirect_module_page(self::$module_slug);

        $item = array();

        if(count($post_item)>0){

            foreach($post_item as $key=>$value){

                $item[$key] = ($key == 'id')? $item_id : sanitize_text_field($value);

            }

        }


        if( isset(Settings::$plugin_db['modules'][self::$module]['locations']) ) {    //if locations list not empty;

            $item_list = Settings::$plugin_db['modules'][self::$module]['locations']; //first take locations array from db;
            array_push($item_list,$item);  //push new created item;

            Settings::$plugin_db['modules'][self::$module]['locations'] = $item_list;  //add fully generated locations list into db;

        }else{  //any locations are not created yet
            $item_list=array(); //generate new array
            array_push($item_list,$item);   //add new item into array
            Settings::$plugin_db['modules'][self::$module]['locations'] = $item_list; //add modules list into db
        }

        update_option(Settings::$plugin_option,Settings::$plugin_db);

        ModulesSetup::redirect_module_page(self::$module_slug);

    }


    public static function module_locations_item_edit($post_item){

        if(!isset($post_item['id']))
            ModulesSetup::redirect_module_page(self::$module_slug);

        $item_id = preg_replace('#[^0-9]#','',$post_item['id']);    //make id filter
        //check after filter if item_id param not empty;
        if(empty($item_id))    //if id param empty after validation, stop code below and redirect page;
            ModulesSetup::redirect_module_page(self::$module_slug);


        $item = array();

        if(count($post_item)>0){

            foreach($post_item as $key=>$value){

                $item[$key] = ($key == 'id')?$item_id:sanitize_text_field($value);

            }

        }

        if( isset(Settings::$plugin_db['modules'][self::$module]['locations']) ):   //if locations list not empty;

            $locations = Settings::$plugin_db['modules'][self::$module]['locations'];

            $key  = array_search($item['id'],array_column($locations,'id'));

            if($key !== false):

                foreach($item as $item_key=>$item_value):

                    Settings::$plugin_db['modules'][self::$module]['locations'][$key][$item_key] = $item_value;

                endforeach;

                update_option(Settings::$plugin_option,Settings::$plugin_db);

            endif;

        endif;

        ModulesSetup::redirect_module_page(self::$module_slug);


    }


    public static function module_locations_item_delete($id){

        if(!isset($id))
            ModulesSetup::redirect_module_page(self::$module_slug);

        $item_id = preg_replace('#[^0-9]#','',$id);    //make id filter
        //check after filter if item_id param not empty;
        if(empty($item_id))    //if id param empty after validation, stop code below and redirect page;
            ModulesSetup::redirect_module_page(self::$module_slug);


        if( isset(Settings::$plugin_db['modules'][self::$module]['locations']) ):   //if modules list not empty;

            $locations = Settings::$plugin_db['modules'][self::$module]['locations'];

            $key  = array_search($item_id,array_column($locations,'id'));

            if($key !== false):

                unset(Settings::$plugin_db['modules'][self::$module]['locations'][$key]);

                //note: regenerate modules list after delete module, and push to plugin db;

                $items_list = array();

                foreach(Settings::$plugin_db['modules'][self::$module]['locations'] as $item):

                    array_push($items_list,$item);

                endforeach;

                Settings::$plugin_db['modules'][self::$module]['locations'] = $items_list;

                update_option(Settings::$plugin_option,Settings::$plugin_db);

            endif;

        endif;

        ModulesSetup::redirect_module_page(self::$module_slug);

    }




    public static function module_locations_items_data(){

        $item_list = array();

        if( isset(Settings::$plugin_db['modules'][self::$module]['locations']) ):   //if locations list not empty;

            $location_list = Settings::$plugin_db['modules'][self::$module]['locations'];

            foreach($location_list as $item):

                $items=array();

                foreach($item as $key=>$value){ //take items key and value
                    $items[$key]=$value;
                }

                array_push($item_list,$items);

            endforeach;

        endif;

        return $item_list;

    }


    public static function module_locations_item_by_id($id){


        $items=array();

        $id = preg_replace('#[^0-9]#','',$id);   //make id filter: only digits 0-9 allow

        if(empty($id)) return $items; //make check id param after filter validation, if id param empty: return empty module array;

        if( isset(Settings::$plugin_db['modules'][self::$module]['locations']) ):   //if cpt modules list not empty;

            $locations = Settings::$plugin_db['modules'][self::$module]['locations'];

            $key  = array_search($id,array_column($locations,'id'));

            if($key !== false)
                $items = $locations[$key];

        endif;

        return $items;

    }


    public static function table_items_per_page(){

        return 10;

    }




} 