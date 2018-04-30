<?php
/**
 * @package codearchitect
 */

namespace CA_Inc\modules\api;


class MainModuleSetup {

    private $module;

    private $module_title;

    private $module_activation;

    private $module_capability; //= 'manage_options';

    private $module_icon; //'dashicons-admin-generic';

    private $module_menu_position; // = 110;


    protected function __construct(){

    }

    protected function setModule($module){

        if(!isset($this->module))
            $this->module = $module;

    }

    protected function getModule(){

        if(isset($this->module))
            return $this->module;

    }

    protected function setModuleTitle($title){

        if(!isset($this->module_title))
            $this->module_tite = $title;

    }

    protected function getModuleTitle(){

        if(isset($this->module_title))
            return $this->module_title;

    }

    protected function setModuleActivation($activation=0){

        if(!isset($this->module_activation))
            $this->module_activation = $activation;

    }

    protected function getModuleActivation(){

        if(isset($this->module_activation))
            return $this->module_activation;

    }

    protected function setModuleCapability($capability){

        if(!isset($this->module_capability))
            $this->module_capability = $capability;

    }

    protected function getModuleCapability(){

        if(isset($this->module_capability))
            return $this->module_capability;

    }

    protected function setModuleIcon($icon){

        if(!isset($this->module_icon))
            $this->module_icon = $icon;

    }

    protected function getModuleIcon(){

        if(isset($this->module_icon))
            return $this->module_icon;

    }

    protected function setModuleMenuPosition($position){

        if(!isset($this->module_menu_position))
            $this->module_menu_position = $position;

    }

    protected function getModuleMenuPosition(){

        if(isset($this->module_menu_position))
            return $this->module_menu_position;

    }


} 