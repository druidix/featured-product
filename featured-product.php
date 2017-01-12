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


// Housekeeping functions

function featured-product_setup_post_types()
{
        //FIXME:  Figure out what post types is / are required for this.  Doesn't
        //        look like we need any for this plugin
        // register the "book" custom post type
        //register_post_type( 'book', ['public' => 'true'] );
}
add_action( 'init', 'featured-product_setup_post_type' );
 
 function featured-product_install()
 {
         // trigger our function that registers the custom post type
             featured-product_setup_post_types();
              
                  // clear the permalinks after the post type has been registered
                      flush_rewrite_rules();
 }
 register_activation_hook( __FILE__, 'featured-product_install' );


function featured-product_deactivation()
{
        // our post type will be automatically removed, so no need to unregister it
         
        // clear the permalinks to remove our post type's rules
        flush_rewrite_rules();
}
register_deactivation_hook( __FILE__, 'featured-product_deactivation' );


// This is where we remove data files, drop DB tables, etc as needed.
// For now, just aliasing this to the deactivation function
// FIXME:  Revisit this before production launch
register_uninstall_hook(__FILE__, 'featured-product_deactivate');

// TODO:  Read CSV input file

// TODO:  Create HTML snippet containing image, store links and corresponding prices
