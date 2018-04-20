<?php
/**
 * @package Codearchitect
 */

namespace CA_Inc\modules\cpt;

use CA_Inc\setup\Settings;
use CA_Inc\modules\api\ModulesSetup;

class Setup {

    public static $module;

    public static $module_title;

    public static $module_parent_slug;

    public static $module_slug;

    public static $module_capability = 'manage_options';


    public static $cpt_table_per_page=10;   //use: CptTable->prepare_items();


    public function __construct(){

        self::$module = Settings::$plugin_modules['cpt']['key'];   //get module from modules list;

        self::$module_parent_slug = ModulesSetup::get_main_module_key(); //page parent slug

        self::$module_slug = self::$module_parent_slug .'_'. self::$module; //module page slug

        self::$module_title=Settings::$plugin_modules['cpt']['title']; //uppercase first letter


        $post_action = self::$module.'_module_form_add';    //action defined at form hidden field: cpt/template/table/table_item_add.php
        add_action( 'admin_post_'.$post_action, array($this,'add_module_items') );

        $post_action = self::$module.'_module_form_edit';   //action defined at form hidden field: cpt/template/table/table_item_edit.php
        add_action( 'admin_post_'.$post_action, array($this,'edit_module_items') );

        $post_action = self::$module.'_module_form_delete';   //action defined at form hidden field: cpt/template/table/table_item_delete.php
        add_action( 'admin_post_'.$post_action, array($this,'delete_module_items') );

    }


    public static function delete_cpt_posts(){  //usage plugin uninstall : uninstall.php - delete module posts from wp_posts table, meta fields, taxonomies ...;

        if( isset(Settings::$plugin_db['modules'][self::$module]['modules']) ):   //if cpt modules list not empty;

            foreach(Settings::$plugin_db['modules'][self::$module]['modules'] as $module):

                $module_name = $module['module_name'];

                $posts = get_posts( array( 'post_type' => $module_name )); //return wp_posts object format structure

                foreach($posts as $post):

                    wp_delete_post( $post->ID, true ); //flag: true - force delete, (do not add to trash); delete posts from wp_posts table, meta fields, taxonomies ...;

                endforeach;

            endforeach;

        endif;

    }


    public static function cpt_table_module_data(){    //use:CptTable::prepare_items();

        $module_list = array();

        if( isset(Settings::$plugin_db['modules'][self::$module]['modules']) ):   //if cpt modules list not empty;

            foreach(Settings::$plugin_db['modules'][self::$module]['modules'] as $cpt_module):

                $module=array();
                $module['module_id']=$cpt_module['module_id'];
                $module['module']=$cpt_module['module_name'];
                $module['singular_name']=$cpt_module['singular_name'];
                $module['plural_name']=$cpt_module['plural_name'];
                $module['public']= ($cpt_module['public_status'] ==1)?'yes':'no';
                $module['archive']=($cpt_module['archive_status']==1)?'yes':'no';

                array_push($module_list,$module);

            endforeach;

        endif;

        return $module_list;

    }


    public static function get_cpt_module_by_id($id){ //usage for templates: edit, delete data by id: function CptSetup::cpt_table_item_edit_template($id), CptSetup::cpt_table_item_delete_template($id);

        $module=array();

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

        return $module;


    }

    public static function render_template(){   //TEMPLATES CONTROLLER

        if( isset($_GET['page']) && $_GET['page'] != self::$module_slug )    //if accessing page isn`t module page, cancel code below;
            return;


        if( isset($_GET['action']) ){

            if($_GET['action']== 'cpt_table_add_new_item')
                self::cpt_table_item_add_template();    //add template

            if($_GET['action']=='cpt_table_row_edit' )
                self::cpt_table_item_edit_template();   //render edit template by module id param;

            if($_GET['action']=='cpt_table_row_delete' )
                self::cpt_table_item_delete_template(); //render delete template by module id param;

            if($_GET['action']=='cpt_table_all_items')
                self::cpt_table_view_template();


        }else{

            self::cpt_table_view_template();    //show table

        }


    }


    public static function cpt_table_view_template(){

        require_once(Settings::$plugin_path . '/inc/modules/'.self::$module.'/template/table/table_view.php');

    }


    public static function cpt_table_item_add_template(){

        require_once(Settings::$plugin_path . '/inc/modules/'.self::$module.'/template/table/table_item_add.php');

    }


    public static function cpt_table_item_edit_template(){ //use: render_template()

        $module_id = (isset($_GET['module_id']))?$_GET['module_id']:'';

        $id = preg_replace('#[^0-9]#','',$module_id);

        if($id == ''){ _e('module not exist',PLUGIN_DOMAIN); return;}    //check after filter if id param not empty;

        $cpt_module = self::get_cpt_module_by_id( $id );

        if(count($cpt_module) < 1){ _e('module not exist',PLUGIN_DOMAIN); return;} //if module not found by id, stop generate edit template;

        require_once(Settings::$plugin_path . '/inc/modules/'.self::$module.'/template/table/table_item_edit.php');

    }


    public static function cpt_table_item_delete_template(){    //use: render_template()

        //check module_id
        $module_id = (isset($_GET['module_id']))?$_GET['module_id']:'';

        $id = preg_replace('#[^0-9]#','',$module_id);

        if($id == ''){ _e('module not exist',PLUGIN_DOMAIN); return;}    //check after filter if id param not empty;

        $cpt_module = self::get_cpt_module_by_id( $id );

        if(count($cpt_module) < 1){ _e('module not exist',PLUGIN_DOMAIN); return;} //if module not found by id, stop generate delete template;


        //check module_name
        $module_name = (isset($_GET['module_name']))? esc_attr( $_GET['module_name'] ):'';

        $args = array(
            'post_type'   => $module_name   //post_type by module_name
        );

        $post_type = get_posts( $args ); //get posts by post_type=module_name from wp_posts;

        if(count($post_type)>0){    //if any post exists on post_type=module_name, don`t render item delete template;

            $a_link = sprintf('<a href="%s?post_type=%s">%s</a>',   //link to post_type
                admin_url('edit.php'),
                $module_name,
                $module_name
            );


            $msg = sprintf('<p>'. __('module %s have posts in post type: %s',PLUGIN_DOMAIN).'</p>',$module_name,$a_link);

            echo self::link_to_cpt_page();
            echo $msg;
            return;
        }


        require_once(Settings::$plugin_path .'/inc/modules/'.self::$module.'/template/table/table_item_delete.php');

    }


    public static function link_to_cpt_page(){ //usage: cpt_table: add,edit,delete templates back to table list

        return sprintf('<a href="%s?page=%s">&lt;&lt;&nbsp;%s</a>',
            admin_url('admin.php'),
            self::$module_slug,
            __('back to list',PLUGIN_DOMAIN)
        );

    }


    public function add_module_items(){

        if( isset($_POST[self::$module.'_module_form_add_submit']) ){  //form submit button

            $nonce_action = self::$module.'_module_form_add_action';
            $nonce_data = ( isset($_POST[self::$module.'_module_form_add_nonce']) )? $_POST[self::$module.'_module_form_add_nonce'] :'';

            if ( !wp_verify_nonce( $nonce_data, $nonce_action ) )//wp nonce created at form: cpt/template/table/table_item_add.php
                ModulesSetup::redirect_module_page(self::$module_slug);


            $module = array();
            $module['module_id'] = ModulesSetup::generate_id(); //generate unique id

            $module_name = ( isset($_POST[Settings::$plugin_option][self::$module]['module']['module_name']) )? sanitize_text_field($_POST[Settings::$plugin_option][self::$module]['module']['module_name'] ):'';
            $module_name = preg_replace('#[^a-zA-Z0-9]#','',$module_name); //module name: only letters, digits, and no empty space
            $module_name = Settings::$prefix.'_'.$module_name;  //add additionally ca prefix
            $module_name = strtolower($module_name);    //all letters make lowercase

            $module['module_name'] = $module_name;
            $module['singular_name'] = ( isset($_POST[Settings::$plugin_option][self::$module]['module']['singular_name']) )? sanitize_text_field($_POST[Settings::$plugin_option][self::$module]['module']['singular_name']):'';
            $module['plural_name'] = ( isset($_POST[Settings::$plugin_option][self::$module]['module']['plural_name']) )? sanitize_text_field($_POST[Settings::$plugin_option][self::$module]['module']['plural_name']):'';
            $module['public_status'] = ( isset($_POST[Settings::$plugin_option][self::$module]['module']['public_status']) == 1 )?1:0;
            $module['archive_status'] = ( isset($_POST[Settings::$plugin_option][self::$module]['module']['archive_status']) == 1 )?1:0;


            $modules_list=array();

            if( isset(Settings::$plugin_db['modules'][self::$module]['modules']) ) {    //if cpt modules list not empty;

                $modules_list = Settings::$plugin_db['modules'][self::$module]['modules']; //first take modules from db and push to list;
                array_push($modules_list,$module);  //push new created module

                Settings::$plugin_db['modules'][self::$module]['modules'] = $modules_list;  //add fully generated modules list into db;

            }else{  //any cpt modules are not created yet

                $modules_list[]=$module;    //add new created module into modules list
                Settings::$plugin_db['modules'][self::$module]['modules'] = $modules_list; //add modules list into db
            }


            update_option(Settings::$plugin_option,Settings::$plugin_db);

            ModulesSetup::redirect_module_page(self::$module_slug);

        }


    }


    public function edit_module_items(){

        if( isset($_POST[self::$module.'_module_form_edit_submit']) ){//form submit button

            $nonce_action = self::$module.'_module_form_edit_action';
            $nonce_data = ( isset($_POST[self::$module.'_module_form_edit_nonce']) )? $_POST[self::$module.'_module_form_edit_nonce'] :'';

            if ( !wp_verify_nonce( $nonce_data, $nonce_action ) )   //wp nonce created at form: cpt/template/table/table_item_edit.php
                ModulesSetup::redirect_module_page(self::$module_slug);


            $module_id = ( isset($_POST[Settings::$plugin_option][self::$module]['module']['module_id']) )? $_POST[Settings::$plugin_option][self::$module]['module']['module_id']:'';
            $module_id = preg_replace('#[^0-9]#','',$module_id);    //make id filter
            //check after filter if module_id param not empty;
            if($module_id=='')    //if id param empty after validation, stop code below and redirect page;
                ModulesSetup::redirect_module_page(self::$module_slug);

            //note: module_name is not editable!;
            $singular_name = ( isset($_POST[Settings::$plugin_option][self::$module]['module']['singular_name']) )? sanitize_text_field($_POST[Settings::$plugin_option][self::$module]['module']['singular_name']):'';
            $plural_name = ( isset($_POST[Settings::$plugin_option][self::$module]['module']['plural_name']) )? sanitize_text_field($_POST[Settings::$plugin_option][self::$module]['module']['plural_name']):'';
            $public_status = ( isset($_POST[Settings::$plugin_option][self::$module]['module']['public_status']) == 1 )?1:0;
            $archive_status = ( isset($_POST[Settings::$plugin_option][self::$module]['module']['archive_status']) == 1 )?1:0;


            if( isset(Settings::$plugin_db['modules'][self::$module]['modules']) ):   //if cpt modules list not empty;

                $index=0;   //module array index

                foreach(Settings::$plugin_db['modules'][self::$module]['modules'] as $cpt_module):

                    if($cpt_module['module_id'] == $module_id) {

                        Settings::$plugin_db['modules'][self::$module]['modules'][$index]['singular_name'] = $singular_name;
                        Settings::$plugin_db['modules'][self::$module]['modules'][$index]['plural_name'] = $plural_name;
                        Settings::$plugin_db['modules'][self::$module]['modules'][$index]['public_status'] = $public_status;
                        Settings::$plugin_db['modules'][self::$module]['modules'][$index]['archive_status'] = $archive_status;

                        break;
                    }

                    $index++;

                endforeach;

            endif;

            update_option(Settings::$plugin_option,Settings::$plugin_db);

            ModulesSetup::redirect_module_page(self::$module_slug);

        }

    }


    public function delete_module_items(){

        if(isset($_POST['cpt_module_form_delete_submit'])){



            $nonce_action = self::$module.'_module_form_delete_action';
            $nonce_data = ( isset($_POST[self::$module.'_module_form_delete_nonce']) )? $_POST[self::$module.'_module_form_delete_nonce'] :'';

            if ( !wp_verify_nonce( $nonce_data, $nonce_action ) )//wp nonce created at form: cpt/template/table/table_item_delete.php
                ModulesSetup::redirect_module_page(self::$module_slug);

            //module id validation
            $module_id = ( isset($_POST[Settings::$plugin_option][self::$module]['module']['module_id']) )? $_POST[Settings::$plugin_option][self::$module]['module']['module_id']:'';
            $module_id = preg_replace('#[^0-9]#','',$module_id);    //make id filter
            if($module_id == '')    //check after filter if module_id param not empty;
                ModulesSetup::redirect_module_page(self::$module_slug);



            if( isset(Settings::$plugin_db['modules'][self::$module]['modules']) ):   //if cpt modules list not empty;


                $modules = Settings::$plugin_db['modules'][self::$module]['modules'];

                $key  = array_search($module_id,array_column($modules,'module_id'));

                if($key !== false):

                    unset( Settings::$plugin_db['modules'][self::$module]['modules'][$key] ); //remove module by key;

                    //note: regenerate modules list after delete module, and push to plugin db;

                    $modules_list = array();

                    foreach(Settings::$plugin_db['modules'][self::$module]['modules'] as $module):

                        array_push($modules_list,$module);

                    endforeach;

                    Settings::$plugin_db['modules'][self::$module]['modules'] = $modules_list;


                    update_option(Settings::$plugin_option,Settings::$plugin_db);

                endif;

            endif;
            
            ModulesSetup::redirect_module_page(self::$module_slug);

        }

    }


}//end class