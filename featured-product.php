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

        echo '<aside id="featured-product" class="widget featured_product">' . "\n";

        $how_many = !empty( $instance['how_many'] ) ? $instance['how_many'] : 0;

        for ($i = 0; $i < $how_many; $i++) {

            // Only attempt to display an item if all required fields are present:
            // -  image URL
            // -  item name
            // -  price
            // -  store1 link OR store2 link
            if ( !empty($instance["image_url_$i"]) && !empty($instance["item_name_$i"])
                && !empty($instance["price_$i"]) && (!empty($instance["store1_link_$i"]) || (!empty($instance["store2_link_$i"]))) ) {

                // Image URL
                echo '<div class="featured-product"><img src="' . $instance["image_url_$i"] . '"/></div>' . "\n";

                // Item name
                echo '<div class="featured-product">' . $instance["item_name_$i"] . '</div>' . "\n";

                // Price
                echo '<div class="featured-product">Price - $' . $instance["price_$i"] . '</div>' . "\n";

                // Store URLs
                if ( !empty($instance["store1_link_$i"]) ) {

                    // In case we have a store URL but no link label for it, set the label to be the same as the URL
                    $link1_label = !empty( $instance["link1_label_$i"] ) ? $instance["link1_label_$i"] : "store1_link_$i";

                    echo '<div class="featured-product"><a href="' . $instance["store1_link_$i"] . '" target="_blank">' . $link1_label  . '</a></div>' . "\n";
                }

                if ( !empty($instance["store2_link_$i"]) ) {

                    // In case we have a store URL but no link label for it, set the label to be the same as the URL
                    $link2_label = !empty( $instance["link2_label_$i"] ) ? $instance["link2_label_$i"] : "store2_link_$i";

                    echo '<div class="featured-product"><a href="' . $instance["store2_link_$i"] . '" target="_blank">' . $link2_label  . '</a></div>' . "\n";
                }
            }
        }

        echo '</aside>' . "\n";
    }

	public function form( $instance ) {

		$how_many = !empty( $instance['how_many'] ) ? $instance['how_many'] : 5; ?>
		<p>
			<label for="<?php echo $this->get_field_id( 'how_many' ); ?>">Number of items:</label>
			<input type="text" id="<?php echo $this->get_field_id( 'how_many' ); ?>" name="<?php echo $this->get_field_name( 'how_many' ); ?>" value="<?php echo esc_attr( $how_many ); ?>" />
	    </p>
        <hr><?php

        for ($i = 0; $i < $how_many; $i++) {

            $image_url[$i] = !empty( $instance["image_url_$i"] ) ? $instance["image_url_$i"] : ''; ?>
            <p>
                <label for="<?php echo $this->get_field_id( "image_url_$i" ); ?>">Image URL:</label>
                <input type="text" id="<?php echo $this->get_field_id( "image_url_$i" ); ?>" name="<?php echo $this->get_field_name( "image_url_$i" ); ?>" value="<?php echo esc_attr( $image_url[$i] ); ?>" />
            </p><?php

            $item_name[$i] = !empty( $instance["item_name_$i"] ) ? $instance["item_name_$i"] : ''; ?>
            <p>
                <label for="<?php echo $this->get_field_id( "item_name_$i" ); ?>">Item Name:</label>
                <input type="text" id="<?php echo $this->get_field_id( "item_name_$i" ); ?>" name="<?php echo $this->get_field_name( "item_name_$i" ); ?>" value="<?php echo esc_attr( $item_name[$i] ); ?>" />
            </p><?php

            $price[$i] = !empty( $instance["price_$i"] ) ? $instance["price_$i"] : ''; ?>
            <p>
                <label for="<?php echo $this->get_field_id( "price_$i" ); ?>">Price:</label>
                <input type="text" id="<?php echo $this->get_field_id( "price_$i" ); ?>" name="<?php echo $this->get_field_name( "price_$i" ); ?>" value="<?php echo esc_attr( $price[$i] ); ?>" />
            </p><?php

            $store1_link[$i] = !empty( $instance["store1_link_$i"] ) ? $instance["store1_link_$i"] : ''; ?>
            <p>
                <label for="<?php echo $this->get_field_id( "store1_link_$i" ); ?>">Store 1 Link:</label>
                <input type="text" id="<?php echo $this->get_field_id( "store1_link_$i" ); ?>" name="<?php echo $this->get_field_name( "store1_link_$i" ); ?>" value="<?php echo esc_attr( $store1_link[$i] ); ?>" />
            </p><?php

            $link1_label[$i] = !empty( $instance["link1_label_$i"] ) ? $instance["link1_label_$i"] : ''; ?>
            <p>
                <label for="<?php echo $this->get_field_id( "link1_label_$i" ); ?>">Store 1 Link Text:</label>
                <input type="text" id="<?php echo $this->get_field_id( "link1_label_$i" ); ?>" name="<?php echo $this->get_field_name( "link1_label_$i" ); ?>" value="<?php echo esc_attr( $link1_label[$i] ); ?>" />
            </p><?php

            $store2_link[$i] = !empty( $instance["store2_link_$i"] ) ? $instance["store2_link_$i"] : ''; ?>
            <p>
                <label for="<?php echo $this->get_field_id( "store2_link_$i" ); ?>">Store 2 Link:</label>
                <input type="text" id="<?php echo $this->get_field_id( "store2_link_$i" ); ?>" name="<?php echo $this->get_field_name( "store2_link_$i" ); ?>" value="<?php echo esc_attr( $store2_link[$i] ); ?>" />
            </p><?php

            $link2_label[$i] = !empty( $instance["link2_label_$i"] ) ? $instance["link2_label_$i"] : ''; ?>
            <p>
                <label for="<?php echo $this->get_field_id( "link2_label_$i" ); ?>">Store 2 Link Text:</label>
                <input type="text" id="<?php echo $this->get_field_id( "link2_label_$i" ); ?>" name="<?php echo $this->get_field_name( "link2_label_$i" ); ?>" value="<?php echo esc_attr( $link2_label[$i] ); ?>" />
            </p>
            <hr><?php
        }
	}
}

function kacharya_register_featured_product() {

    register_widget( 'kacharya_featured_product' );
}

add_action( 'widgets_init', 'kacharya_register_featured_product' );

