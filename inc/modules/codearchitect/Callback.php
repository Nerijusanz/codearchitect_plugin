<?php
/**
 * @package Codearchitect
 */

namespace CA_Inc\modules\codearchitect;

use CA_Inc\modules\api\ModulesSetup;

class Callback {


	public static function template(){

        ModulesSetup::get_modules_page_template(Setup::$module);

	}

}