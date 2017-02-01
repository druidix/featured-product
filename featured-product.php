<?php
/*
Plugin Name: Featured Product
Plugin URI:  https://github.com/druidix/featured_product
Description: Featured product rotator.  Supports multiple links per product.
Version:     0.0.1
Author:      Kaushik Acharya
Author URI:  https://github.com/druidix/
License:     GPL2
License URI: https://www.gnu.org/licenses/gpl-2.0.html
Text Domain: featured_product
*/


// Housekeeping functions

function featured_product_setup_post_types()
{
        //FIXME:  Figure out what post types is / are required for this.  Doesn't
        //        look like we need any for this plugin
        // register the "book" custom post type
        //register_post_type( 'book', ['public' => 'true'] );
}
add_action( 'init', 'featured_product_setup_post_type' );
 
 function featured_product_install()
 {
         // trigger our function that registers the custom post type
             featured_product_setup_post_types();
              
                  // clear the permalinks after the post type has been registered
                      flush_rewrite_rules();
 }
 register_activation_hook( __FILE__, 'featured_product_install' );


function featured_product_deactivation()
{
        // our post type will be automatically removed, so no need to unregister it
         
        // clear the permalinks to remove our post type's rules
        flush_rewrite_rules();
}
register_deactivation_hook( __FILE__, 'featured_product_deactivation' );


// This is where we remove data files, drop DB tables, etc as needed.
// For now, just aliasing this to the deactivation function
// FIXME:  Revisit this before production launch
register_uninstall_hook(__FILE__, 'featured_product_deactivate');

// Read CSV input file and split each line into array
// NOTE:  File location relative to plugin dir works fine in PHP,
// but under Wordpress, the absolute path seems to be required
$data_file = __DIR__ . "/data/featured-products.csv";

$handle = fopen( $data_file, "r" ) or exit( "Unable to open data file " . $data_file );

while ( !feof($handle) ) {
    $line     = fgets( $handle );
    $elements = explode( ",", $line );
    $array    = new ArrayObject( $elements );
    $iter     = $array->getIterator();

    while ( $iter->valid() ) {
        echo $iter->current() . "<br>\n";
        $iter->next();
    }
}

fclose($handle);

// TODO:  Create HTML snippet containing image, store links and corresponding prices
