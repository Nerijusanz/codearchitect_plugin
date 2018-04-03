<?php
/**
 * @package codearchitect
 */

namespace CA_Inc\modules\contactform;

use CA_Inc\modules\api\ModulesApi;

class ContactformModule {

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
                'parent_slug' => ContactformSetup::$module_parent_slug,
                'page_title' => __(ContactformSetup::$module_title,PLUGIN_DOMAIN),
                'menu_title' => __(ContactformSetup::$module_title,PLUGIN_DOMAIN),
                'capability' => ContactformSetup::$module_capability,
                'menu_slug' => ContactformSetup::$module_slug,  //note: menu_slug on first admin subpage have to be same parent menu_slug;
                'callback' => function(){ContactformCallback::contactform();}
            )
        );

        ModulesApi::add_admin_subpages($admin_subpages);

    }


    public function sections()
    {

        $sections = array(
            array(
                'id' => ContactformSetup::$module_slug . '_index', //structure: plugin_page.'_index';
                'title' => '',
                'page' => ContactformSetup::$module_slug
            )
        );

        ModulesApi::add_sections($sections);

    }


    public function fields()
    {

        $fields = array(
            /*array(
                'id' => 'supports',  //plugin_name+page+field_name;
                'title' => __('supports',PLUGIN_DOMAIN),
                'page' => ContactformSetup::$module_slug,
                'section' => ContactformSetup::$module_slug . '_index',
                'callback' => function(){ContactformCallback::contactform();}
            )*/
        );

        ModulesApi::add_fields($fields);

    }

} 