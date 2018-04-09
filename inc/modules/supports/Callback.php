<?php
/**
 * @package Codearchitect
 */

namespace CA_Inc\modules\supports;

use CA_Inc\modules\api\ModulesSetup;


class Callback {


    public static function template(){

        ModulesSetup::get_modules_page_template(Setup::$module);

    }

    public static function field(){

        //echo 'SupportsCallback::field();';
        echo '<input type="text" id="datepicker" value="">';
    }

} 