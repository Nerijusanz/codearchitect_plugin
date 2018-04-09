<?php
/**
 * @package Codearchitect
 */

namespace CA_Inc\modules\gmap;

use CA_Inc\modules\api\ModulesApi;


class Module
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
                'parent_slug' => Setup::$module_parent_slug,
                'page_title' =>__(Setup::$module_title,PLUGIN_DOMAIN),
                'menu_title' => __(Setup::$module_title,PLUGIN_DOMAIN),
                'capability' => Setup::$module_capability,
                'menu_slug' => Setup::$module_slug,  //note: menu_slug on first admin subpage have to be same parent menu_slug;
                'callback' => function(){Callback::template();}
            )
        );

        ModulesApi::add_admin_subpages($admin_subpages);

    }


    public function sections()
    {

         $sections = array(
             array(
                 'id' => Setup::$module_slug . '_index', //important: plugin_page.'_index';
                 'title' => '',
                 'page' => Setup::$module_slug
             )
         );

        ModulesApi::add_sections($sections);

    }


    public function fields()
    {
        $fields=array(
            /*array(
                'id' => Setup::$module.'_site_shutdown',  //plugin_name+page+field_name;
                'title' => __('Shutdown site',PLUGIN_DOMAIN),
                'page' => Setup::$module_slug,
                'section' => Setup::$module_slug . '_index',
                'callback' => function(){SettingsCallback::field_site_shutdown();}

            )*/
        );

        ModulesApi::add_fields($fields);

    }


}