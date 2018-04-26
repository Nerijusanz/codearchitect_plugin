<?php
/**
 * @package codearchitect
 */

namespace CA_Inc\modules\gmap\table;


class Table
{
    public static $module;
    public static $page;

    public function __construct(){

        new TableSetup();

        self::$module = TableSetup::$module;
        self::$page = TableSetup::$page;

    }


    public static function generate_table(){

        $table = new ListTable();
        $table->render_table();

    }


    public static function render_table_template(){   //TEMPLATES CONTROLLER


        if( isset($_GET['page']) && (filter_var($_GET['page'],FILTER_SANITIZE_URL) != self::$page) )    //if accessing page isn`t module page, cancel code below;
            return;

        if( isset($_GET['action']) ){

            $action = filter_var($_GET['action'],FILTER_SANITIZE_URL);

            if($action == 'table_add_new_item')
                self::table_item_add_template();    //add template

            if($action == 'table_row_edit' )
                self::table_item_edit_template();   //render edit template by module id param;

            if($action == 'table_row_delete' )
                self::table_item_delete_template(); //render delete template by module id param;

            if($action == 'table_all_items')
                self::table_view_template();

        }else{
            self::table_view_template();    //show table

        }

    }


    public static function table_view_template(){

        require_once('template/table_view.php');
    }


    public static function table_item_add_template(){

        require_once('template/table_item_add.php');

    }


    public static function table_item_edit_template(){ //use: render_template()


        $id = (isset($_GET['item_id']))?filter_var($_GET['item_id'],FILTER_SANITIZE_URL):null;

        $item = TableSetup::get_table_item_by_id($id);

        if(count($item) < 1){ _e('item not exist',PLUGIN_DOMAIN); return;} //if module not found by id, stop generate edit template;

        require_once('template/table_item_edit.php');

    }


    public static function table_item_delete_template(){    //use: render_template()
        
        //check module_id
        $id = (isset($_GET['item_id']))?filter_var($_GET['item_id'],FILTER_SANITIZE_URL):null;

        $item = TableSetup::get_table_item_by_id($id);

        if(count($item) < 1){ _e('item not exist',PLUGIN_DOMAIN); return;} //if module not found by id, stop generate edit template;

        require_once('template/table_item_delete.php');

    }






}