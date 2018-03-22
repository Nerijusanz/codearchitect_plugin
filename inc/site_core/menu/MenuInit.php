<?php
/**
 * @package Codearchitect
 */

namespace CA_Inc\site_core\menu;

use CA_Inc\site_core\library\ WP_Bootstrap_Navwalker;

class MenuInit {

    /*
    Contrusct class to activate actions and hooks as soon as the class is initialized
*/
    public function __construct()
    {
        $this->init();
    }

    public function init(){

        add_action('init', array($this, 'register_primary_menu'));

    }


    public function register_primary_menu()
    {
        /*
            Register all your menus here
        */
        register_nav_menus(array(
            'primary' => __('Primary menu', PLUGIN_DOMAIN),
        ));

        register_nav_menus(array(
            'footer' => __('Footer menu', PLUGIN_DOMAIN),
        ));
    }


    public static function wp_bootstrap_nav_walker(){

            if ( has_nav_menu( 'primary' ) ) :
                wp_nav_menu( array(
                    'theme_location' => 'primary',
                    'menu_id' => 'primary-menu',
                    'menu_class' => 'nav navbar-nav navbar-right',
                    'walker' => new WP_Bootstrap_Navwalker()
                ) );
            endif;

    }


} 