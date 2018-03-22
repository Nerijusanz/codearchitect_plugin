<?php
/**
 * @package Codearchitect
 */

namespace CA_Inc\modules\codearchitect;

use CA_Inc\setup\Settings;
use CA_Inc\modules\api\ModulesApi;


class CodearchitectModule {


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
                'page_title' => __(CodearchitectSetup::$module_title,PLUGIN_DOMAIN),
                'menu_title' => __(CodearchitectSetup::$module_title,PLUGIN_DOMAIN),
                'capability' => CodearchitectSetup::$module_capability,
                'menu_slug' => CodearchitectSetup::$module_slug,
                'callback' => function(){CodearchitectCallback::codearchitect();},
                'icon_url' => CodearchitectSetup::$module_icon,
                'position' => CodearchitectSetup::$module_menu_position
            )
        );


        ModulesApi::add_admin_pages($admin_page);


    }


    public function settings(){

        $settings=array(
            array(
                'option_group' => CodearchitectSetup::$module . '_options_group',
                'option_name' => CodearchitectSetup::$module,
                //'callback' =>''
            )
        );

        ModulesApi::add_settings($settings);

    }


} 