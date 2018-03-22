<?php
/**
 * @package Codearchitect
 */

namespace CA_Inc\modules\api;


class ModulesApi
{
    /**
     * Settings array
     * @var private array
     */
    private static $settings = array();

    /**
     * Sections array
     * @var private array
     */
    private static $sections = array();

    /**
     * Fields array
     * @var private array
     */
    private static $fields = array();


    /**
     * Admin pages array
     * @var private array
     */
    private static $admin_pages = array();

    /**
     * Admin subpages array
     * @var private array
     */
    private static $admin_subpages = array();



    public function __construct(){

        add_action( 'admin_menu', array(__CLASS__, 'add_admin_menu' ) );

        add_action( 'admin_init', array(__CLASS__, 'add_custom_settings' ) );

    }
    /**
     * Injects user's defined pages array into $admin_pages array
     *
     * @param  var $pages      array of user's defined pages
     */
    public static function add_admin_pages( $pages )
    {
        $pages = array_merge(self::$admin_pages,$pages);
        self::$admin_pages = $pages;
    }

    /**
     * Injects user's defined pages array into $admin_subpages array
     *
     * @param  var $pages      array of user's defined pages
     */
    public static function add_admin_subpages( $pages )
    {
        $pages = array_merge(self::$admin_subpages,$pages);
        self::$admin_subpages = $pages;
    }

    /**
     * Injects user's defined settings array into $settings array
     *
     * @param  var $args      array of user's defined settings
     */
    public static function add_settings( $args )
    {
        $args = array_merge(self::$settings,$args);
        self::$settings = $args;
    }

    /**
     * Injects user's defined sections array into $sections array
     *
     * @param  var $args      array of user's defined sections
     */
    public static function add_sections( $args )
    {
        $args = array_merge(self::$sections,$args);
        self::$sections = $args;
    }

    /**
     * Injects user's defined fields array into $fields array
     *
     * @param  var $args      array of user's defined fields
     */
    public static function add_fields( $args )
    {
        $args = array_merge(self::$fields,$args);
        self::$fields = $args;
    }

    /**
     * Call WordPress methods to generate Admin pages and subpages
     */
    public static function add_admin_menu()
    {
        if( !empty( self::$admin_pages ) ):

            foreach( self::$admin_pages as $page ):
                add_menu_page( $page['page_title'], $page['menu_title'], $page['capability'], $page['menu_slug'], $page['callback'], $page['icon_url'], $page['position'] );
            endforeach;

        endif;


        if(!empty( self::$admin_subpages ) ):

            foreach( self::$admin_subpages as $page ):
                add_submenu_page( $page['parent_slug'], $page['page_title'], $page['menu_title'], $page['capability'], $page['menu_slug'], $page['callback'] );
            endforeach;

        endif;
    }

    /**
     * Call WordPress methods to register settings, sections, and fields
     */
    public static function add_custom_settings()
    {

        if( !empty( self::$settings ) ):
            foreach( self::$settings as $setting ):
                register_setting( $setting["option_group"], $setting["option_name"], ( isset( $setting["callback"] ) ? $setting["callback"] : '' ) );
            endforeach;
        endif;


        if( !empty( self::$sections ) ):
            foreach( self::$sections as $section ):
                add_settings_section( $section["id"], $section["title"], ( isset( $section["callback"] ) ? $section["callback"] : '' ), $section["page"] );
            endforeach;
        endif;

        if( !empty( self::$fields ) ):
            foreach( self::$fields as $field ):
                add_settings_field( $field["id"], $field["title"], ( isset( $field["callback"] ) ? $field["callback"] : '' ), $field["page"], $field["section"], ( isset( $field["args"] ) ? $field["args"] : '' ) );
            endforeach;
        endif;
    }
}