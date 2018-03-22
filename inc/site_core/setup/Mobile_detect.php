<?php
/**
 * @package Codearchitect
 */

namespace CA_Inc\site_core\setup;


class Mobile_detect {

    public static $detect;

    public function __construct(){

        add_action('after_setup_theme', array($this, 'init'));

    }

    public function init(){

        self::$detect = new \CA_Inc\site_core\library\Mobile_Detect();
        //useage:
        // $deviceType = ($detect->isMobile() ? ($detect->isTablet() ? 'tablet' : 'phone') : 'computer');  echo $deviceType;

    }
} 