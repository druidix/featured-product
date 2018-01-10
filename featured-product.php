<?php
/*
Plugin Name: Featured Product
Plugin URI:  https://github.com/druidix/featured_product
Description: Featured product rotator.  Supports multiple links per product.
Version:     0.0.2
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
        echo '<h3 class="widget-title">' . $instance['title'] . "</h3>\n";

        if ( !empty($instance['shop_url']) && !empty($instance['shop_link_text']) ) {
        
            echo '<strong><a href="' . $instance['shop_url'] . '" target="_blank">' . $instance['shop_link_text'] . "</a></strong>\n";
        }

        $how_many_items = !empty( $instance['how_many_items'] ) ? $instance['how_many_items'] : 0;

        // How many random items to pick
        $how_many_to_display = !empty( $instance['how_many_to_display'] ) ? $instance['how_many_to_display'] : 1;

        // Based on how many items there are total, build an array of that many indices,
        // then pick N random ones (defined above) from that array
        $indices_to_display = array_rand( range(0, ($how_many_items - 1)), $how_many_to_display );
        settype($indices_to_display, "array");

        foreach ( $indices_to_display as &$i ) {

            // Only attempt to display an item if all required fields are present:
            // -  image URL
            // -  item name
            // -  price
            // -  store1 link OR store2 link
            if ( !empty($instance["image_url_$i"]) && !empty($instance["item_name_$i"])
                && !empty($instance["price_$i"]) && (!empty($instance["store1_link_$i"]) || (!empty($instance["store2_link_$i"]))) ) {

                // Image URL
                echo '<div class="featured-product" style="padding-top: 20px;"><img src="' . $instance["image_url_$i"] 
                    . '"/></div>' . "\n<br>\n";

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

        unset( $i );

        echo '</aside>' . "\n";
    }

	public function form( $instance ) {

		$title = !empty( $instance['title'] ) ? $instance['title'] : 'Featured Patterns'; ?>
		<p>
			<label for="<?php echo $this->get_field_id( 'title' ); ?>">Title:</label>
			<input type="text" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" value="<?php echo esc_attr( $title ); ?>" />
	    </p><?php

		$shop_url = $instance['shop_url']; ?>
		<p>
			<label for="<?php echo $this->get_field_id( 'shop_url' ); ?>">Shop Page URL:</label>
			<input type="text" id="<?php echo $this->get_field_id( 'shop_url' ); ?>" name="<?php echo $this->get_field_name( 'shop_url' ); ?>" value="<?php echo esc_attr( $shop_url ); ?>" />
	    </p><?php

		$shop_link_text = $instance['shop_link_text']; ?>
		<p>
			<label for="<?php echo $this->get_field_id( 'shop_link_text' ); ?>">Shop Page Link Text:</label>
			<input type="text" id="<?php echo $this->get_field_id( 'shop_link_text' ); ?>" name="<?php echo $this->get_field_name( 'shop_link_text' ); ?>" value="<?php echo esc_attr( $shop_link_text ); ?>" />
	    </p><?php

		$how_many_items = !empty( $instance['how_many_items'] ) ? $instance['how_many_items'] : 5; ?>
		<p>
			<label for="<?php echo $this->get_field_id( 'how_many_items' ); ?>">Number of items:</label>
			<input type="text" id="<?php echo $this->get_field_id( 'how_many_items' ); ?>" name="<?php echo $this->get_field_name( 'how_many_items' ); ?>" value="<?php echo esc_attr( $how_many_items ); ?>" />
	    </p><?php

        $how_many_to_display = !empty( $instance['how_many_to_display'] ) ? $instance['how_many_to_display'] : 1; ?>
        <p>
            <label for="<?php echo $this->get_field_id( 'how_many_to_display' ); ?>">To be displayed:</label>
			<input type="text" id="<?php echo $this->get_field_id( 'how_many_to_display' ); ?>" name="<?php echo $this->get_field_name( 'how_many_to_display' ); ?>" value="<?php echo esc_attr( $how_many_to_display ); ?>" />
        </p>
        <hr><?php

        for ($i = 0; $i < $how_many_items; $i++) {

            $image_url[$i] = $instance["image_url_$i"]; ?>
            <p>
                <label for="<?php echo $this->get_field_id( "image_url_$i" ); ?>">Image URL:</label>
                <input type="text" id="<?php echo $this->get_field_id( "image_url_$i" ); ?>" name="<?php echo $this->get_field_name( "image_url_$i" ); ?>" value="<?php echo esc_attr( $image_url[$i] ); ?>" />
            </p><?php

            $item_name[$i] = $instance["item_name_$i"]; ?>
            <p>
                <label for="<?php echo $this->get_field_id( "item_name_$i" ); ?>">Item Name:</label>
                <input type="text" id="<?php echo $this->get_field_id( "item_name_$i" ); ?>" name="<?php echo $this->get_field_name( "item_name_$i" ); ?>" value="<?php echo esc_attr( $item_name[$i] ); ?>" />
            </p><?php

            $price[$i] = $instance["price_$i"]; ?>
            <p>
                <label for="<?php echo $this->get_field_id( "price_$i" ); ?>">Price:</label>
                <input type="text" id="<?php echo $this->get_field_id( "price_$i" ); ?>" name="<?php echo $this->get_field_name( "price_$i" ); ?>" value="<?php echo esc_attr( $price[$i] ); ?>" />
            </p><?php

            $store1_link[$i] = $instance["store1_link_$i"]; ?>
            <p>
                <label for="<?php echo $this->get_field_id( "store1_link_$i" ); ?>">Store 1 Link:</label>
                <input type="text" id="<?php echo $this->get_field_id( "store1_link_$i" ); ?>" name="<?php echo $this->get_field_name( "store1_link_$i" ); ?>" value="<?php echo esc_attr( $store1_link[$i] ); ?>" />
            </p><?php

            $link1_label[$i] = $instance["link1_label_$i"]; ?>
            <p>
                <label for="<?php echo $this->get_field_id( "link1_label_$i" ); ?>">Store 1 Link Text:</label>
                <input type="text" id="<?php echo $this->get_field_id( "link1_label_$i" ); ?>" name="<?php echo $this->get_field_name( "link1_label_$i" ); ?>" value="<?php echo esc_attr( $link1_label[$i] ); ?>" />
            </p><?php

            $store2_link[$i] = $instance["store2_link_$i"]; ?>
            <p>
                <label for="<?php echo $this->get_field_id( "store2_link_$i" ); ?>">Store 2 Link:</label>
                <input type="text" id="<?php echo $this->get_field_id( "store2_link_$i" ); ?>" name="<?php echo $this->get_field_name( "store2_link_$i" ); ?>" value="<?php echo esc_attr( $store2_link[$i] ); ?>" />
            </p><?php

            $link2_label[$i] = $instance["link2_label_$i"]; ?>
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

