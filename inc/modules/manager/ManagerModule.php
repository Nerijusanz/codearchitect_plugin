<?php
/**
 * @package Codearchitect
 */

namespace CA_Inc\modules\manager;

use CA_Inc\setup\Settings;
use CA_Inc\modules\api\ModulesOptions;
use CA_Inc\modules\api\ModulesApi;


class ManagerModule {


    public function __construct()
    {
        add_action('init',array($this,'init'));
    }

    public function init(){

        $this->admin_subpages();

        $this->sections();

        $this->fields();

    }


    public function admin_subpages(){

        $admin_subpages = array(
            array(
                'parent_slug' => ManagerSetup::$module_parent_slug,
                'page_title' => __(ManagerSetup::$module_title,PLUGIN_DOMAIN),
                'menu_title' => __(ManagerSetup::$module_title,PLUGIN_DOMAIN),
                'capability' => ManagerSetup::$module_capability,
                'menu_slug' => ManagerSetup::$module_slug,
                'callback' => function(){ManagerCallback::template();}
            )
        );

        ModulesApi::add_admin_subpages($admin_subpages);

    }


    public function sections(){

        $sections=array(
            array(
                'id' => ManagerSetup::$module_slug . '_index',    //important structure: plugin_page.'_index';
                'title' => '',//add localization
                //'callback'=>''
                'page' => ManagerSetup::$module_slug
            )
        );

        ModulesApi::add_sections($sections);

    }


    public function fields(){

        $fields = array(
            array(
                'id' => 'manager_list',
                'title' => __('Manager',PLUGIN_DOMAIN),
                'page' => ManagerSetup::$module_slug,
                'section' => ManagerSetup::$module_slug . '_index',
                'callback' => function(){ManagerCallback::field_modules_name();}
            )
        );

        ModulesApi::add_fields($fields);

    }



} 