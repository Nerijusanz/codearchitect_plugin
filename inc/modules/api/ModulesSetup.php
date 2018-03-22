<?php
/**
 * @package Codearchitect
 */

namespace CA_Inc\modules\api;

use CA_Inc\setup\Settings;
use CA_Inc\modules\codearchitect\CodearchitectSetup;
use CA_Inc\modules\manager\ManagerSetup;




class ModulesSetup {


    public static function generate_id(){

        return time() . rand(0000,9999); //usage: CptSetup->add_module_items();

    }

    public static function redirect_module_page($page){

        header('Location: '.admin_url('admin.php').'?page='.$page);
        exit;
    }


    public static function generate_modules_list(){ //usage on plugin activation: api/Activate.php activate();

        $modules = array();

        foreach(Settings::$plugin_modules as $key => $value):

            $activate_status = ($key == ManagerSetup::$module || $key == CodearchitectSetup::$module)?1:0; //manager module always should be turn on;

            $modules['modules'][$key]['activate'] = $activate_status;

        endforeach;

        return $modules;

    }


    public static function check_module_activation_status(string $module) //usage: {Module_name}Init.php
    {
        if($module == null) return false;

        $module_status = ( isset(Settings::$plugin_db['modules'][$module]['activate']) && Settings::$plugin_db['modules'][$module]['activate'] == 1 )? true : false;

        return $module_status;

    }



    public static function generate_modules_top_navigation(){ //usage: module/template/{file};

        $page = ( isset($_GET['page']))? esc_attr($_GET['page']):''; //get page name


        $output='<ul class="top-navigation">';

            foreach(Settings::$plugin_modules as $module => $module_title):

                if( isset(Settings::$plugin_db['modules'][$module]['activate']) && Settings::$plugin_db['modules'][$module]['activate'] == 1 ):

                    $module_page = ($module == CodearchitectSetup::$module)? CodearchitectSetup::$module : Settings::$plugin.'_'.$module;   //structure: prefix_page;

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