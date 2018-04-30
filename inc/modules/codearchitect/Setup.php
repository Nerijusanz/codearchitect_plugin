<?php
/**
 * @package Codearchitect
 */

namespace CA_Inc\modules\codearchitect;

use CA_Inc\setup\Settings;
use CA_Inc\modules\api\ModulesSetup;

use CA_Inc\modules\api\ModulesList;

use CA_Inc\modules\api\MainModuleSetup;

class Setup extends MainModuleSetup {

    private $module_setup;

    protected $module_list;


    public static $module;

    //public static $module_slug;

    public static $module_title;

    public static $module_activation=1;

    public static $module_capability = 'manage_options';

    public static $module_icon='dashicons-admin-generic';

    public static $module_menu_position = 110;





    public function __construct(){

        $this->module_setup = new MainModuleSetup();

        $this->module_list = new ModulesList();

        $this->registerModule();

        $this->setPluginModule();    //params: $key,$title,$activation;



        self::$module = 'codearchitect';//ModulesSetup::get_main_module_key();


        //self::$module_slug = self::$module;

        self::$module_title = 'Codearchitect'; //Settings::$plugin_modules['codearchitect']['title'];







    }

    private function registerModule(){

        $this->module_setup->setModule('codearchitect');

        $this->module_setup->setModuleTitle('Codearchitect');

        $this->module_setup->setModuleActivation(1);

        $this->module_setup->setModuleCapability('manage_options');

        $this->module_setup->setModuleIcon('dashicons-admin-generic');

        $this->module_setup->setModuleMenuPosition(110);


    }


    private function setPluginModule(){

        $key = $this->module_setup->getModule();
        $title = $this->module_setup->getModuleTitle();
        $activation = $this->module_setup->getModuleActivation();

        //$this->plugin_modules->setModule($key,$title,$activation);

    }




}