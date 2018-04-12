<?php
/**
 * @package codearchitect
 */

namespace CA_Inc\modules\gmap\table;

use CA_Inc\setup\Settings;
use CA_Inc\modules\gmap\Setup;
use CA_Inc\modules\api\ModulesSetup;


class TableSetup {

    public static $module;
    public static $page;

    public static $table_name;  //unique table name
    public static $table;   //table full name;
    public static $table_prefix; //module name;
    public static $data;    //module data
    public static $items_per_page;  //for pagination
    public static $order_by_item;//order by column name
    public static $order_type;  //default asc
    public static $primary_column;  //column name

    public function __construct(){

        self::$table_name = 'locations';

        self::$table_prefix = Setup::$module.'_table_';

        self::$table = self::$table_prefix . self::$table_name; //table_prefix + table_name;

        self::$module = Setup::$module;
        self::$page = Setup::$module_slug;

        self::$data = self::table_items_data();
        self::$items_per_page = self::table_items_per_page();

        self::$order_by_item = 'title'; //order by column name
        self::$order_type = 'asc';
        self::$primary_column = 'title';    //primary column name;


        $post_action = self::$table.'_form_add';
        add_action( 'admin_post_'.$post_action, array($this,'add_table_item') );

        $post_action = self::$table.'_form_edit';
        add_action( 'admin_post_'.$post_action, array($this,'edit_table_item') );

        $post_action = self::$table.'_form_delete';
        add_action( 'admin_post_'.$post_action, array($this,'delete_table_item') );

    }

    public function add_table_item(){

            //var_dump($_POST['item']);exit;


        if( isset($_POST[self::$table.'_form_add_submit']) ){  //form submit button

            $nonce_action = self::$table.'_add_action';
            $nonce_data = ( isset($_POST[self::$table.'_add_nonce']) )? $_POST[self::$table.'_add_nonce'] :null;

            if ( !wp_verify_nonce( $nonce_data, $nonce_action ) )
                ModulesSetup::redirect_module_page(self::$page);

            if(isset($_POST['item']))
                Setup::module_locations_item_save($_POST['item']);  //item data

        }

    }


    public function edit_table_item(){

        if( isset($_POST[self::$table.'_form_edit_submit']) ){  //form submit button

            $nonce_action = self::$table.'_edit_action';
            $nonce_data = ( isset($_POST[self::$table.'_edit_nonce']) )? $_POST[self::$table.'_edit_nonce'] :null;

            if ( !wp_verify_nonce( $nonce_data, $nonce_action ) )
                ModulesSetup::redirect_module_page(self::$page);

            if(isset($_POST['item']))
                Setup::module_locations_item_edit( $_POST['item'] );

        }


    }


    public function delete_table_item(){

        if( isset($_POST[self::$table.'_form_delete_submit']) ){  //form submit button

            $nonce_action = self::$table.'_delete_action';
            $nonce_data = ( isset($_POST[self::$table.'_delete_nonce']) )? $_POST[self::$table.'_delete_nonce'] :null;

            if ( !wp_verify_nonce( $nonce_data, $nonce_action ) )
                ModulesSetup::redirect_module_page(self::$page);

            if(isset($_POST['item']['id']))
                Setup::module_locations_item_delete( $_POST['item']['id'] );

        }

    }



    public static function page_link(){ //usage: cpt_table: add,edit,delete templates back to table list

        return sprintf('<a href="%s?page=%s">&lt;&lt;&nbsp;%s</a>',
            admin_url('admin.php'),
            $_GET['page'],// make validation
            __('back to list',PLUGIN_DOMAIN)
        );

    }

    public static function table_items_per_page(){

        return Setup::table_items_per_page();

    }


    public static function table_items_data(){

        return Setup::module_locations_items_data();

    }


    public static function get_table_item_by_id($id){ //usage for templates: edit, delete data by id: function CptSetup::cpt_table_item_edit_template($id), CptSetup::cpt_table_item_delete_template($id);

        return Setup::module_locations_item_by_id($id);

    }

    //hidden field
    public static function field_item_id($value=''){

        return '<input type="hidden" name="item[id]" value="'.esc_html($value).'" />';

    }


    public static function field_item_title($value=''){

        $params = array(
            'class'=>'regular-text',
            'placeholder'=>__('title',PLUGIN_DOMAIN)
        );

        return '<input type="text" class="'.esc_attr($params['class']).'" name="item[title]" value="'.esc_html($value).'" placeholder="'.esc_html($params['placeholder']).'" />';

    }

    public static function field_item_lat($value=''){

        $params = array(
            'class'=>'regular-text',
            'placeholder'=>__('latitude',PLUGIN_DOMAIN)
        );

        return '<input type="text" class="'.esc_attr($params['class']).'" name="item[lat]" value="'.esc_html($value).'" placeholder="'.esc_html($params['placeholder']).'" />';

    }

    public static function field_item_long($value=''){

        $params = array(
            'class'=>'regular-text',
            'placeholder'=>__('longitude',PLUGIN_DOMAIN)
        );

        return '<input type="text" class="'.esc_attr($params['class']).'" name="item[long]" value="'.esc_html($value).'" placeholder="'.esc_html($params['placeholder']).'" />';

    }


} 