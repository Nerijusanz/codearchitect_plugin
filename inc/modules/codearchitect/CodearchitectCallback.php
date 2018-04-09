<?php
/**
 * @package Codearchitect
 */

namespace CA_Inc\modules\codearchitect;

use CA_Inc\setup\Settings;


class CodearchitectCallback {


	public static function template(){


		require_once(Settings::$plugin_path . '/inc/modules/' . CodearchitectSetup::$module . '/template/' . CodearchitectSetup::$module .'.php');

	}

}