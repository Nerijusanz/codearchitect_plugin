<?php
/**
 * @package Codearchitect
 */
namespace CA_Inc;


final class Init    //setup final class - child classes can`t override or extend
{


    public function __construct()
    {
        $this->initClasses();

    }

    public function initClasses()
    {

        $this->plugin_core_classes();
        $this->site_core_classes();

    }


    public function plugin_core_classes(){

        //setup
        new setup\Settings();   //plugin params
        new setup\Setup();  //wordpress core setup
        new setup\Enqueue();    //include JS\CSS links
        new setup\Customizer(); //wp customizer
        //api
        new api\Activate(); //activate plugin
        new api\Deactivate();   //deactivate plugin
        //widget
        new widgets\WidgetInit();   //wp widgets

        //plugin modules api
        new modules\api\ModulesApi(); //class initialize modules admin_pages , subpages, settings,sections,fields;
        new modules\api\ModulesSetup(); //plugin all modules setup
        //plugin modules
        new modules\codearchitect\CodearchitectInit();
        new modules\manager\ManagerInit();
        new modules\settings\SettingsInit();
        new modules\cpt\CptInit();
        new modules\contact\ContactInit();
        new modules\contactform\ContactformInit();
        new modules\supports\SupportsInit();

    }


    public function site_core_classes(){
        //setup
        new site_core\setup\Theme_settings();
        new site_core\setup\Theme_setup();
        new site_core\setup\Mobile_detect();
        new site_core\setup\Body_class_setup();
        //menu
        new site_core\menu\MenuInit();
        //shortcodes
        new site_core\shortcodes\ShortcodeInit();

    }






}


