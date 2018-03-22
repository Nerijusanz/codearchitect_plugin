<?php
/**
 * @package Codearchitect
 */

namespace CA_Inc\modules\settings;


use CA_Inc\setup\Settings;
use CA_Inc\modules\api\ModulesOptions;
use CA_Inc\modules\api\ModulesSetup;
use CA_Inc\modules\api\ModulesApi;


class SettingsModule
{


    public function __construct()
    {

        add_action('init',array($this,'init'));
    }


    public function init(){

        $this->admin_subpages();

        $this->sections();

        $this->fields();

    }


    public function admin_subpages()
    {

        $admin_subpages = array(
            array(
                'parent_slug' => SettingsSetup::$module_parent_slug,
                'page_title' =>__(SettingsSetup::$module_title,PLUGIN_DOMAIN),
                'menu_title' => __(SettingsSetup::$module_title,PLUGIN_DOMAIN),
                'capability' => SettingsSetup::$module_capability,
                'menu_slug' => SettingsSetup::$module_slug,  //note: menu_slug on first admin subpage have to be same parent menu_slug;
                'callback' => function(){SettingsCallback::settings();}
            )
        );

        ModulesApi::add_admin_subpages($admin_subpages);

    }


    public function sections()
    {

         $sections = array(
             array(
                 'id' => SettingsSetup::$module_slug . '_index', //important: plugin_page.'_index';
                 'title' => '',
                 'page' => SettingsSetup::$module_slug
             )
         );

        ModulesApi::add_sections($sections);

    }


    public function fields()
    {
        $fields=array(
            array(
                'id' => SettingsSetup::$module.'_site_shutdown',  //plugin_name+page+field_name;
                'title' => __('Shutdown site',PLUGIN_DOMAIN),
                'page' => SettingsSetup::$module_slug,
                'section' => SettingsSetup::$module_slug . '_index',
                'callback' => function(){SettingsCallback::field_site_shutdown();}

            )
        );

        ModulesApi::add_fields($fields);

    }


}