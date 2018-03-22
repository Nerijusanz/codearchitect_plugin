<?php

/**
 *
 * @package Codearchitect
 */

use CA_Inc\setup\Settings;

// if uninstall.php is not called by WordPress, die
if ( ! defined( 'WP_UNINSTALL_PLUGIN' ) ) {
    die;
}

delete_option(Settings::$plugin_option);

//cpt custom post type
\CA_Inc\modules\cpt\CptSetup::delete_cpt_posts();   //delete "custom post type" posts from wp_posts table, meta fields, taxonomies ...;




/*
$post_type = get_posts( array( 'post_type' => 'book', 'numberposts' => -1 ) );

foreach( $books as $book ) {
    wp_delete_post( $book->ID, true );
}

// Access the database via SQL
global $wpdb;
$wpdb->query( "DELETE FROM wp_posts WHERE post_type = 'book'" );
$wpdb->query( "DELETE FROM wp_postmeta WHERE post_id NOT IN (SELECT id FROM wp_posts)" );
$wpdb->query( "DELETE FROM wp_term_relationships WHERE object_id NOT IN (SELECT id FROM wp_posts)" );

*/

