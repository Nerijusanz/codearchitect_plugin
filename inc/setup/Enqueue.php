<?php
/**
 * @package Codearchitect
 */

namespace CA_Inc\setup;

use CA_Inc\modules\codearchitect\CodearchitectSetup;

class Enqueue {


	public function __construct() {

		add_action( 'admin_enqueue_scripts', array( $this, 'admin_enqueue' ) );     //for back-end
		add_action( 'wp_enqueue_scripts', array( $this, 'frontend_enqueue' ) );   //for front-end
	}

    public static function check_allow_enqueue_page(){  //usage: admin_enqueue();

        global $pagenow;

        $page = (isset($_GET['page']))? esc_attr($_GET['page']):'';
        $post_type = (isset($_GET['post_type']))? esc_attr($_GET['post_type']):'';

        $page = explode('_',$page); //parent: codearchitect; child_pages: codearchitect_manager,codearchitect_settings,codearchitect_cpt...

        $page_prefix = $page[0]; //use first exploded param;

        if( $pagenow == 'admin.php' && $page_prefix == CodearchitectSetup::$module )   //make check if: admin.php?page=codearchitect
            return true;


        return false;

    }


	public function admin_enqueue() {
        // Activate browser-sync on development environment
        //note: constant APP_ENV defined on wp-config.php; WP_SITEURL - Settings.php;

        if ( APP_ENV === 'development' ) :  //setup:wp-config.php
            wp_enqueue_script('__bs_script__', WP_SITEURL . ':3000/browser-sync/browser-sync-client.js', array(), null, true);  //WP_SITEURL - setup/Settings class;
        endif;

        if(self::check_allow_enqueue_page() == false)   //make check if is allowed enqueue into this page
            return;

        wp_deregister_script( 'jquery' ); // Deregister the built-in version of jQuery from WordPress

        wp_enqueue_style( 'admin-style', Settings::$plugin_url . 'assets/css/codearchitect_plugin_admin.min.css', array(), '', 'all' );
        wp_enqueue_script( 'admin-js', Settings::$plugin_url . 'assets/js/codearchitect_plugin_admin.min.js', array(),'',true );    //true: add js link at page bottom

	}


	public function frontend_enqueue() {

        wp_enqueue_style( 'front-style', Settings::$plugin_url . 'assets/css/codearchitect_plugin_front.min.css', array(), '', 'all' );
        //plugin back-end settings to js file
		wp_enqueue_script( 'front-settings', Settings::$plugin_url . 'assets/js/codearchitect_plugin_settings.min.js', array(), true );    //for localization params
        wp_localize_script('front-settings',Settings::$localize_front_settings_name,Settings::$localize_front_settings); //Settings->localize_front_settings();

        wp_enqueue_script( 'front-js', Settings::$plugin_url . 'assets/js/codearchitect_plugin_front.min.js', array(), true );

	}

}