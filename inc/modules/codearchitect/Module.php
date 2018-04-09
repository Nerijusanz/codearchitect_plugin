<?php
/**
 * @package Codearchitect
 */

namespace CA_Inc\modules\codearchitect;

use CA_Inc\modules\api\ModulesApi;


class Module {


    public function __construct()
    {
        add_action('init',array($this,'init'));

    }

    public function init(){

        $this->admin_page();

        $this->settings();
    }


    public function admin_page()
    {

        $admin_page = array(
            array(
                'page_title' => __(Setup::$module_title,PLUGIN_DOMAIN),
                'menu_title' => __(Setup::$module_title,PLUGIN_DOMAIN),
                'capability' => Setup::$module_capability,
                'menu_slug' => Setup::$module_slug,
                'callback' => function(){Callback::template();},
                'icon_url' => Setup::$module_icon,
                'position' => Setup::$module_menu_position
            )
        );


        ModulesApi::add_admin_pages($admin_page);


    }


    public function settings(){

        $settings=array(
            array(
                'option_group' => Setup::$module . '_options_group',
                'option_name' => Setup::$module,
                //'callback' =>''
            )
        );

        ModulesApi::add_settings($settings);

    }


} 