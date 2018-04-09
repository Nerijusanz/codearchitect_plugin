<?php
/**
 * @package Codearchitect
 */

namespace CA_Inc\modules\supports;


use CA_Inc\modules\api\ModulesApi;


class SupportsModule {


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
                'parent_slug' => SupportsSetup::$module_parent_slug,
                'page_title' => __(SupportsSetup::$module_title,PLUGIN_DOMAIN),
                'menu_title' => __(SupportsSetup::$module_title,PLUGIN_DOMAIN),
                'capability' => SupportsSetup::$module_capability,
                'menu_slug' => SupportsSetup::$module_slug,  //note: menu_slug on first admin subpage have to be same parent menu_slug;
                'callback' => function(){SupportsCallback::template();}
            )
        );

        ModulesApi::add_admin_subpages($admin_subpages);

    }


    public function sections()
    {

        $sections = array(
            array(
                'id' => SupportsSetup::$module_slug . '_index', //structure: plugin_page.'_index';
                'title' => '',
                'page' => SupportsSetup::$module_slug
            )
        );

        ModulesApi::add_sections($sections);

    }


    public function fields()
    {

        $fields = array(
            array(
                'id' => 'supports',  //plugin_name+page+field_name;
                'title' => __('supports',PLUGIN_DOMAIN),
                'page' => SupportsSetup::$module_slug,
                'section' => SupportsSetup::$module_slug . '_index',
                'callback' => function(){SupportsCallback::field();}
            )
        );

        ModulesApi::add_fields($fields);

    }

} 