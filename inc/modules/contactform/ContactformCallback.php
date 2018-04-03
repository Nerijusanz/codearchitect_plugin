<?php
/**
 * @package codearchitect
 */

namespace CA_Inc\modules\contactform;

use CA_Inc\setup\Settings;

class ContactformCallback {

    public static function contactform(){

        require_once(Settings::$plugin_path . '/inc/modules/' . ContactformSetup::$module . '/template/' . ContactformSetup::$module .'.php');

    }

} 