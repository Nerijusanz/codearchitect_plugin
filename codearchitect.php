<?php
/**
 * @package Codearchitect
 */
/*
Plugin Name: Codearchitect plugin
Plugin URI: https://www.codearchitect.lt
Description:  CodeArchitect plugin modules
Version: 1.0.0
Author: CodeArchitect Team
Author URI: https://codearchitect.lt
License: GPLv2 or later
Text Domain: codearchitect
*/

// If this file is called directly, abort!!!
defined( 'ABSPATH' ) or die( 'direct plugin accessibility not allow' );



//COMPOSER:
// Require COMPOSER Autoload
if ( file_exists( dirname( __FILE__ ) . '/vendor/autoload.php' ) )
    require_once dirname( __FILE__ ) . '/vendor/autoload.php';


//initialization plugin classes
if ( class_exists( 'CA_Inc\\Init' ) )
    new CA_Inc\Init();   //main class of loading plugin classes;


/**
 * The code that runs during plugin activation
 */
function plugin_activate() {

    CA_Inc\api\Activate::activate_plugin();  //directly call class
}
register_activation_hook( __FILE__, 'plugin_activate' );

/**
 * The code that runs during plugin deactivation
 */
function plugin_deactivate() {
    CA_Inc\api\Deactivate::deactivate_plugin(); //directly call class
}
register_deactivation_hook( __FILE__, 'plugin_deactivate' );