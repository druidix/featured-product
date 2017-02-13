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

class kacharya_featured_product extends WP_Widget {

    public function __construct() {
        $widget_options = array( 
            'classname' => 'featured_product',
            'description' => 'Featured product rotator.  Supports multiple links per product.',
        );
            parent::__construct( 'featured_product', 'Featured Product', $widget_options );
    }

    public function widget ($args, $instance) {

        // Read CSV input file and split each line into array
        // NOTE:  File location relative to plugin dir works fine in PHP,
        // but under Wordpress, the absolute path seems to be required
        $data_file = __DIR__ . "/data/featured-products.csv";
        
        $handle = fopen( $data_file, "r" ) or exit( "Unable to open data file " . $data_file );
        
        echo '<aside id="featured-product" class="widget featured_product">' . "\n";
        
        while ( !feof($handle) ) {
            $line     = fgets( $handle );
            $elements = explode( ",", $line );
            $array    = new ArrayObject( $elements );
            $iter     = $array->getIterator();
        
            // The first element is the image URL
            if ( $iter->valid() ) {

                echo '<div class="featured-product"><img src="' . $iter->current() . '"/></div>' . "\n";
                $iter->next();
            }

            while ( $iter->valid() ) {

                $current = $iter->current();

                if ( preg_match('/craftsy/', $current) ) {

                    echo '<div class="featured-product"><a href="' . $current . '" target="_blank">Craftsy</a></div>' . "\n";
                }
                elseif ( preg_match('/etsy/', $current) ) {

                    echo '<div class="featured-product"><a href="' . $current . '" target="_blank">Etsy</a></div>' . "\n";
                }
                else {

                    echo '<div class="featured-product"><h4>$' . $current . '</h4></div>' . "\n";
                }

                $iter->next();
            }
        }
        
        echo '</aside>' . "\n";
        
        fclose($handle);
        
    }

	public function form( $instance ) {

		$how_many = !empty( $instance['how_many'] ) ? $instance['how_many'] : 5; ?>
		<p>
			<label for="<?php echo $this->get_field_id( 'how_many' ); ?>">Number of items:</label>
			<input type="text" id="<?php echo $this->get_field_id( 'how_many' ); ?>" name="<?php echo $this->get_field_name( 'how_many' ); ?>" value="<?php echo esc_attr( $how_many ); ?>" />
	    </p>
        <hr><?php

        for ($i = 0; $i < $how_many; $i++) {

            $price[$i] = !empty( $instance["price_$i"] ) ? $instance["price_$i"] : ''; ?>
            <p>
                <label for="<?php echo $this->get_field_id( "price_$i" ); ?>">Price:</label>
                <input type="text" id="<?php echo $this->get_field_id( "price_$i" ); ?>" name="<?php echo $this->get_field_name( "price_$i" ); ?>" value="<?php echo esc_attr( $price[$i] ); ?>" />
            </p>
            <hr><?php
        }
	}
}

function kacharya_register_featured_product() {

    register_widget( 'kacharya_featured_product' );
}

add_action( 'widgets_init', 'kacharya_register_featured_product' );

