<?php
/**
 * @package Codearchitect
 */

namespace CA_Inc\setup;


class Settings {


    public static $plugin;  //name of plugin: codearchitect
    public static $prefix='ca'; //short prefix: usage: site_core/setup/Body_class

    public static $plugin_option;   //db name: codearchitect_plugin
    public static $plugin_db;   //get db option object: wp-options table; calling  self::init_plugin_db();

    public static $plugin_init; // plugin main init file path; usage: setup/Setup.php __construct()
    public static $plugin_path; // path for php files
    public static $plugin_url; //url for: enqueue links, js, css files

    public static $plugin_modules;  //plugin custom modules list;

    public static $localize_front_settings_name;    //wp_localize script activated on Enqueue class;
    public static $localize_front_settings; //wp_localize script activated on Enqueue class;


    public function __construct(){

       $this->init();

    }


    public function init(){

        self::$plugin = plugin_basename( dirname(__FILE__,3) );   //get dir 3 path below of main plugin basename

        define( 'PLUGIN_DOMAIN',self::$plugin);
        define( 'WP_HOME', 'http://'.self::$plugin );
        define( 'WP_SITEURL', 'http://'.self::$plugin );

        self::$plugin_option = self::$plugin . '_plugin';    //generate plugin database option name: codearchitect_plugin

        self::$plugin_init = self::$plugin . '/' . self::$plugin . '.php'; // usage: setup/Setup.php __construct()
        self::$plugin_url = plugin_dir_url( dirname(__FILE__,2) );  //get dirname 2 path below of main plugin directory
        self::$plugin_path = plugin_dir_path( dirname(__FILE__,2) );    //get dirname 2 path below of main plugin directory

        $this->init_modules();
        $this->init_plugin_db();    //wp_options table: codearchitect_plugin

        add_action( 'init', array($this,'plugin_load_textdomain') );    //important: load textdomain for localization and translating
        add_action('init',array(__CLASS__,'localize_front_settings'));  //localization defined on Enqueue class



    }


    //created custom modules
    public static function init_modules(){

        self::$plugin_modules = array(
            'codearchitect'=>'codearchitect',   //main module
            'settings' => 'settings',
            'contact' => 'contact',
            'contactform' => 'contactform',
            'cpt' => 'cpt',
            'supports' => 'supports',
            'manager' => 'manager'  //manager module: turn on/off other modules
        );

    }

    public static function init_plugin_db(){
        self::$plugin_db = get_option(self::$plugin_option); //get db object
    }

    function plugin_load_textdomain() { //important: load textdomain for localization and translating
        load_plugin_textdomain( PLUGIN_DOMAIN, false, self::$plugin . '/languages' );  //get dir 3 path below of main plugin directory
    }



    public static function localize_front_settings(){

        self::$localize_front_settings_name = strtoupper(self::$plugin.'_settings');    //call settings: CODEARCHITECT_SETTINGS
        //localization defined on: setup\Enqueue class
        self::$localize_front_settings = array(
            //'front_nonce_action'=>wp_create_nonce('front_nonce_field'),
            'site_url'=>get_bloginfo('url'),
            'ajaxurl'=>admin_url('admin-ajax.php')
        );

    }



}