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


        if( isset($_GET['page']) && $_GET['page'] != self::$page )    //if accessing page isn`t module page, cancel code below;
            return;

        if( isset($_GET['action']) ){

            if($_GET['action']== 'table_add_new_item')
                self::table_item_add_template();    //add template

            if($_GET['action']=='table_row_edit' )
                self::table_item_edit_template();   //render edit template by module id param;

            if($_GET['action']=='table_row_delete' )
                self::table_item_delete_template(); //render delete template by module id param;

            if($_GET['action']=='table_all_items')
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

        $item_id = (isset($_GET['item_id']))?$_GET['item_id']:'';

        $item_id = preg_replace('#[^0-9]#','',$item_id);

        if($item_id == ''){ _e('item not exist',PLUGIN_DOMAIN); return;}    //check after filter if id param not empty;

        $item = TableSetup::get_item_by_id( $item_id );

        if(count($item) < 1){ _e('item not exist',PLUGIN_DOMAIN); return;} //if module not found by id, stop generate edit template;

        require_once('template/table_item_edit.php');

    }


    public static function table_item_delete_template(){    //use: render_template()
        
        //check module_id
        $item_id = (isset($_GET['module_id']))?$_GET['module_id']:'';

        $item_id = preg_replace('#[^0-9]#','',$item_id);

        if($item_id == ''){ _e('item not exist',PLUGIN_DOMAIN); return;}    //check after filter if id param not empty;

        $item = TableSetup::get_item_by_id($item_id);

        if(count($item) < 1){ _e('item not exist',PLUGIN_DOMAIN); return;} //if module not found by id, stop generate delete template;

        require_once('template/table_item_delete.php');

    }






}