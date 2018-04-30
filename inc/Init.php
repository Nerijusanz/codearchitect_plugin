<?php
/**
 * @package Codearchitect
 */
namespace CA_Inc;

use CA_Inc\modules;
final class Init    //setup final class - child classes can`t override or extend
{


    public function __construct()
    {
        $this->initClasses();

    }

    public function initClasses()
    {

        $this->plugin_core_classes();
        $this->plugin_modules();
        
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



    }

    public function plugin_modules(){

        //plugin modules api
        new modules\api\ModulesApi(); //class initialize modules admin_pages , subpages, settings,sections,fields;
        new modules\api\ModulesSetup(); //plugin all modules setup
        //plugin modules
        new modules\codearchitect\Init();
        new modules\settings\Init();
        new modules\contact\Init();
        new modules\contactform\Init();
        new modules\cpt\Init();
        new modules\gmap\Init();
        new modules\supports\Init();
        new modules\manager\Init();

    }


}


