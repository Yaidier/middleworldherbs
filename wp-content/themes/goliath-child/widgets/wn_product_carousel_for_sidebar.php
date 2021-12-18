<?php 

defined( 'ABSPATH' ) || exit;

class Wn_Product_Carousel_For_Sidebar extends WP_Widget {

    // Creating the widget 
  
    function __construct() {
    parent::__construct(
      
    // Base ID of your widget
    'wn_single_product_carousel', 
      
    // Widget name will appear in UI
    __('WN Single Product Carousel', 'wn_single_product_carousel_domain'), 
      
    // Widget description
    array( 'description' => __( 'Display posts category related products on a carousel (ideal for sidebar)', 'wn_single_product_carousel_domain' ), ) 
    );
    }


      
    // Creating widget front-end      
    public function widget( $args, $instance ) {

        $main_category_name = $instance['title'];
        $menu_name = $instance['menu_name'];  
        
        $post_categories = wp_get_post_categories(get_post()->ID, ['fields' => 'names']);
        $product_categories = [];

        $args = array(
            'post_type'             => 'product',
            'post_status'           => 'publish',
            'posts_per_page'        => -1, // Limit: two products
            'tax_query'             => array( array(
                'taxonomy'      => 'product_cat',
                'field'         => 'name', // can be 'term_id', 'slug' or 'name'
                'terms'         => $post_categories,
                )
            )
        );

        $products = wc_get_products( $args );

        if(empty($products)){
            return;
        }

        ?>
        
        
        <div class="wn_mwh_products_carousel_wrapper">

            <div class="wn_mwh_header_wrapper">
                <span>FEATURED PRODUCTS</span>
                
            </div>

            <div class="wn_mwh_single_carousel_wrapper"><?php


            foreach($products as $product) {
                ?>
                <div class="wn_mwh_single_product">
                <?php                    
        
                    $product_id = $product->get_id();
                    $product_name = $product->get_name();
                    $before_name = substr($product_name, 0, strpos($product_name, '™') + 3);
                    $after_name = substr($product_name, strpos($product_name, '™') + 3);
        
                    $comments_count = wp_count_comments($product_id);
                    
                    ?>
                    <a class="wn_posts_shower_unset_a_styles" href="<?php echo get_permalink($product_id); ?>">
                    <?php
                        echo $product->get_image('product_header', ['class' => 'wn_mwh_woo_img wn_mwh_carousel_single_image']);
                    ?>
                    </a>
                    
                    <div class="wn_mwh_carousel_product_content">  
                        <div class="wn_mwh_single_post_excerpt wn_mwh_rating_wrapper">
                            <i class="wn_ct_icon__stars" rating="<?php echo $product->get_average_rating(); ?>"></i>
                            <span><?php echo $comments_count->total_comments; ?> ratings</span>
                            <span><?php // echo wp_trim_words( get_the_excerpt($post_id), 20); ?></span>
                        </div>                          
                        <a class="wn_posts_shower_unset_a_styles" href="<?php echo get_permalink($product_id); ?>">
                            <h2 class="wn_mwh_carousel_product_title"><?php echo $before_name . '<br>' . '<span style="font-weight:500;">' . $after_name . '</span>'; ?></h2>
                        </a>
                        
                        <div class="wn_mwh_product_carousel_product_porperties">
                            <?php
                                $value = get_post_meta( $product_id, 'product_properties', true );
                                if($value == '') {
                                    $value = get_the_excerpt($product_id);
                                }
                                echo $value;
                            ?>
                        </div>
        
                        <div class="wn_mwh_price_atc_wrapper">
                            <div class="wn_mwh_prodcut_price">
                                <?php echo wc_price($product->get_price()); ?>
                            </div>
                            <?php 
                                $product_cart_id = WC()->cart->generate_cart_id( $product_id );                                    
                                // Returns an empty string, if the cart item is not found
                                $in_cart = WC()->cart->find_product_in_cart( $product_cart_id );
                                
                                if ( $in_cart ) {
                                    // Do something if the product is in the cart
                                    ?>
                                        <div class="wn_mwh_add_to_cart">
                                            ADDED
                                        </div>
                                    <?php
                                } else {
                                    // Do something if the product is not in the cart
                                    ?>
                                        <a class="wn_mwh_add_to_cart wn_posts_shower_unset_a_styles" href="<?php echo $product->add_to_cart_url(); ?>">
                                            ADD TO CART
                                        </a>
                                    <?php
                                }
                            ?>
                            
                        </div>
                    </div>                     
                </div>
                <?php
            }
            ?>
            </div>
        </div>
        <?php
    }
              
    // Widget Backend 
    public function form( $instance ) {
        if ( isset( $instance[ 'title' ] ) ) {
            $title = $instance[ 'title' ];
        }
        else {
            $title = __( 'New title', 'wn_single_product_carousel_domain' );
        }

        if ( isset( $instance[ 'menu_name' ] ) ) {
            $menu_name = $instance[ 'menu_name' ];
        }
        else {
            $menu_name = __( 'Menu Name', 'wn_single_product_carousel_domain' );
        }

        // Widget admin form
        ?>
        <p>
            <label for="<?php echo $this->get_field_id( 'menu_name' ); ?>"><?php _e( 'Menu Name:' ); ?></label> 
            <input class="widefat" id="<?php echo $this->get_field_id( 'menu_name' ); ?>" name="<?php echo $this->get_field_name( 'menu_name' ); ?>" type="text" value="<?php echo esc_attr( $menu_name ); ?>" />
            <label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Category Name:' ); ?></label> 
            <input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" />
        </p>
        <?php 
    }
          
    // Updating widget replacing old instances with new
    public function update( $new_instance, $old_instance ) {
        $instance = array();
        $instance['title'] = ( ! empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';
        $instance['menu_name'] = ( ! empty( $new_instance['menu_name'] ) ) ? strip_tags( $new_instance['menu_name'] ) : '';
    return $instance;
    }
}