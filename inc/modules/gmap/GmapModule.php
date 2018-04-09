<?php
/**
 * @package Codearchitect
 */

namespace CA_Inc\modules\gmap;

use CA_Inc\modules\api\ModulesApi;


class GmapModule
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
                'parent_slug' => GmapSetup::$module_parent_slug,
                'page_title' =>__(GmapSetup::$module_title,PLUGIN_DOMAIN),
                'menu_title' => __(GmapSetup::$module_title,PLUGIN_DOMAIN),
                'capability' => GmapSetup::$module_capability,
                'menu_slug' => GmapSetup::$module_slug,  //note: menu_slug on first admin subpage have to be same parent menu_slug;
                'callback' => function(){GmapCallback::template();}
            )
        );

        ModulesApi::add_admin_subpages($admin_subpages);

    }


    public function sections()
    {

         $sections = array(
             array(
                 'id' => GmapSetup::$module_slug . '_index', //important: plugin_page.'_index';
                 'title' => '',
                 'page' => GmapSetup::$module_slug
             )
         );

        ModulesApi::add_sections($sections);

    }


    public function fields()
    {
        $fields=array(
            /*array(
                'id' => GmapSetup::$module.'_site_shutdown',  //plugin_name+page+field_name;
                'title' => __('Shutdown site',PLUGIN_DOMAIN),
                'page' => GmapSetup::$module_slug,
                'section' => GmapSetup::$module_slug . '_index',
                'callback' => function(){SettingsCallback::field_site_shutdown();}

            )*/
        );

        ModulesApi::add_fields($fields);

    }


}