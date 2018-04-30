<?php
/**
 * @package codearchitect
 */

namespace CA_Inc\modules\api;


class ModulesList {

    private $plugin_modules = array();

    public function __construct(){


    }

    protected function setModule($key,$title,$activate){

        $module = array();
        $module['key'] = $key;
        $module['title'] = $title;
        $module['activate'] = $activate;

        array_push($this->plugin_modules,$module);

    }

    protected function getModule($key){

        $key  = array_search($key,array_column($this->plugin_modules,'key'));

        if($key !== false)
            return $this->plugin_modules[$key];

    }

    protected function getModulesList(){

        return $this->plugin_modules;

    }


} 