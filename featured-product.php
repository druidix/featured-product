<?php
/*
Plugin Name: Featured Product
Plugin URI:  FIXME
Description: Featured product rotator.  Supports multiple links per product.
Version:     0.0.1
Author:      Kaushik Acharya
Author URI:  FIXME
License:     GPL2
License URI: https://www.gnu.org/licenses/gpl-2.0.html
Text Domain: featured-product
*/


/* Housekeeping functions */

function pluginprefix_setup_post_types()
{
        // register the "book" custom post type
            register_post_type( 'book', ['public' => 'true'] );
}
add_action( 'init', 'pluginprefix_setup_post_type' );
 
 function pluginprefix_install()
 {
         // trigger our function that registers the custom post type
             pluginprefix_setup_post_types();
              
                  // clear the permalinks after the post type has been registered
                      flush_rewrite_rules();
 }
 register_activation_hook( __FILE__, 'pluginprefix_install' );


function pluginprefix_deactivation()
{
        // our post type will be automatically removed, so no need to unregister it
         
             // clear the permalinks to remove our post type's rules
                 flush_rewrite_rules();
}
register_deactivation_hook( __FILE__, 'pluginprefix_deactivation' );
