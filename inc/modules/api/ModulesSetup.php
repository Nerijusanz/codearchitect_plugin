<?php
/**
 * @package Codearchitect
 */

namespace CA_Inc\modules\api;

use CA_Inc\setup\Settings;
use CA_Inc\modules\codearchitect;





class ModulesSetup {

    public static function get_main_module_key(){

        return Settings::$plugin_modules['codearchitect']['key'];

    }

    public static function get_modules_page_template($module){

        require_once(Settings::$plugin_path . '/inc/modules/' . $module . '/template/template.php');

    }

    public static function generate_id(){

        return time() . rand(0000,9999); //usage: CptSetup->add_module_items();

    }

    public static function redirect_module_page($page){

        header('Location: '.admin_url('admin.php').'?page='.$page);
        exit;
    }

    public static function generate_default_modules_list(){ //usage on plugin activation: api/Activate.php activate();

        self::make_clean_modules_list(); //private function;  //remove module if not exists into Settings::$plugin_modules  list anymore;

        $temp_db = array();

        if(count(Settings::$plugin_modules) > 0 ):

            foreach(Settings::$plugin_modules as $module):

                $module_key = $module['key'];
                $module_activate = $module['activate'];

                $temp_db['modules'][$module_key]['key'] = $module_key;
                $temp_db['modules'][$module_key]['activate'] = $module_activate;

            endforeach;

        endif;

        update_option(Settings::$plugin_option, $temp_db );//add default data to plugin db

    }


    public static function refresh_modules_list(){

        //add new module into plugin db;

        self::make_clean_modules_list(); //private function;  //remove module from plugin_db if not exists into Settings::$plugin_modules  list anymore;

        $temp_db = Settings::$plugin_db;    //make plugin db copy;

        $db_update_needle = false;  //db updated status - false;

        if( count(Settings::$plugin_modules)>0 ):

            foreach(Settings::$plugin_modules as $module):

                $module_key = $module['key'];

                if(!isset( $temp_db['modules'][ $module_key ] )):    //add new created module into plugin_db list if not exists yet;

                    $temp_db['modules'][$module_key]['key'] = $module_key;
                    $temp_db['modules'][$module_key]['activate']=0;
                    $db_update_needle = true;   //make neddle true, that`s mean list was updated;

                endif;

            endforeach;

        endif;

        if($db_update_needle == true):  //if temp_db was updated;

            update_option(Settings::$plugin_option,$temp_db);//add updated plugin db to plugin db

        endif;

    }


    private static function make_clean_modules_list(){
        //remove module if not exists into Settings::$plugin_modules  list anymore;
        $temp_db = Settings::$plugin_db;

        $db_update_needle = false;  //start update needle; thats means do not need to updated plugin_db

        if( isset($temp_db['modules']) && count($temp_db['modules'])>0):

            foreach($temp_db['modules'] as $temp_db_module):

                $found_module_needle = false;   //found module start needle

                foreach(Settings::$plugin_modules as $module):  //go thru list

                    if($temp_db_module['key'] == $module['key'])    //make check if module exits, and change needle param
                        $found_module_needle = true;    //current module are in the list

                endforeach;

                if($found_module_needle == false) { //module didn`t find in the Settings::$plugin_modules;

                    unset($temp_db['modules'][ $temp_db_module['key'] ]);   //remove module from plugin_db;

                    $db_update_needle = true;   //make neddle true, that`s mean list was updated;
                }

            endforeach;

            if($db_update_needle == true){  //if temp_db got updated
                update_option(Settings::$plugin_option,$temp_db);//add updated plugin db to plugin db
            }

        endif;

    }


    public static function check_module_activation_status(string $module) //usage: {Module_name}Init.php
    {
        if($module == null) return false;

        $module_status = ( isset(Settings::$plugin_db['modules'][$module]['activate']) && Settings::$plugin_db['modules'][$module]['activate'] == 1 )? true : false;

        return $module_status;

    }



    public static function generate_modules_top_navigation(){ //usage: module/template/{file};

        $page = ( isset($_GET['page']))? filter_var($_GET['page'],FILTER_SANITIZE_URL):null; //get page name

        if($page == null)
            return;

        $output='<ul class="top-navigation">';

            foreach(Settings::$plugin_modules as $plugin_module):

                $module = $plugin_module['key'];
                $module_title = $plugin_module['title'];

                if( isset(Settings::$plugin_db['modules'][$module]['activate']) && Settings::$plugin_db['modules'][$module]['activate'] == 1 ):

                    $module_page = ($module == codearchitect\Setup::$module )? codearchitect\Setup::$module : Settings::$plugin.'_'.$module;   //structure: prefix_page;

                    if($page == $module_page)   //if current show screen page == module page, unlink
                        $module_link_url=sprintf('<li><span>%s</span></li>',$module_title);
                    else
                        $module_link_url=sprintf('<li><a href="%s?page=%s">%s</a></li>',
                            admin_url('admin.php'),
                            $module_page,
                            $module_title
                        );

                    $output.=$module_link_url;

                endif;

            endforeach;

        $output.='</ul>';

        return $output;

    }


} 