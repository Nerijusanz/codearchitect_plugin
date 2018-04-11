<?php
/**
 * @package codearchitect
 */

namespace CA_Inc\modules\gmap\table;

use CA_Inc\setup\Settings;
use CA_Inc\modules\gmap\Setup;


class TableSetup {

    public static $module;
    public static $page;

    public static $table_name;  //unique table name
    public static $data;    //module data
    public static $items_per_page;  //for pagination
    public static $order_by_item;//order by column name
    public static $order_type;  //default asc
    public static $primary_column;  //column name

    public function __construct(){

        self::$table_name = 'locations';
        self::$table_name = Setup::$module.'_table_'.self::$table_name; //module+table+name

        self::$module = Setup::$module;
        self::$page = Setup::$module_slug;

        self::$data = Setup::table_module_data();
        self::$items_per_page = Setup::table_items_per_page();

        self::$order_by_item = 'title'; //order by column name
        self::$order_type = 'asc';
        self::$primary_column = 'title';    //primary column name;


    }

    public static function page_link(){ //usage: cpt_table: add,edit,delete templates back to table list

        return sprintf('<a href="%s?page=%s">&lt;&lt;&nbsp;%s</a>',
            admin_url('admin.php'),
            $_GET['page'],// make validation
            __('back to list',PLUGIN_DOMAIN)
        );

    }

    public static function get_item_by_id($id){ //usage for templates: edit, delete data by id: function CptSetup::cpt_table_item_edit_template($id), CptSetup::cpt_table_item_delete_template($id);

        $module=array();

        /*$id = preg_replace('#[^0-9]#','',$id);   //make id filter: only digits 0-9 allow

        if($id == '') return $module; //make check id param after filter validation, if id param empty: return empty module array;

        if( isset(Settings::$plugin_db['modules'][self::$module]['modules']) ):   //if cpt modules list not empty;

            foreach(Settings::$plugin_db['modules'][self::$module]['modules'] as $cpt_module):

                if($cpt_module['module_id'] == $id) {
                    $module=$cpt_module;
                    break;
                }
            endforeach;

        endif;
        */
        return $module;


    }

    //hidden field
    public static function field_item_id($value=''){

        return '<input type="hidden" name="'.Settings::$plugin_option.'[modules]['.Setup::$module.'][locations][id]" value="'.esc_html($value).'" />';

    }


    public static function field_item_title($value=''){

        $params = array(
            'class'=>'regular-text',
            'placeholder'=>__('title',PLUGIN_DOMAIN)
        );

        return '<input type="text" class="'.esc_attr($params['class']).'" name="'.Settings::$plugin_option.'[modules]['.Setup::$module.'][locations][title]" value="'.esc_html($value).'" placeholder="'.esc_html($params['placeholder']).'" />';

    }

    public static function field_item_lat($value=''){

        $params = array(
            'class'=>'regular-text',
            'placeholder'=>__('latitude',PLUGIN_DOMAIN)
        );

        return '<input type="text" class="'.esc_attr($params['class']).'" name="'.Settings::$plugin_option.'[modules]['.Setup::$module.'][locations][lat]" value="'.esc_html($value).'" placeholder="'.esc_html($params['placeholder']).'" />';

    }

    public static function field_item_long($value=''){

        $params = array(
            'class'=>'regular-text',
            'placeholder'=>__('longitude',PLUGIN_DOMAIN)
        );

        return '<input type="text" class="'.esc_attr($params['class']).'" name="'.Settings::$plugin_option.'[modules]['.Setup::$module.'][locations][long]" value="'.esc_html($value).'" placeholder="'.esc_html($params['placeholder']).'" />';

    }


} 