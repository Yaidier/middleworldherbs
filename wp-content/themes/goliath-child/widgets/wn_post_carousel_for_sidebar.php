<?php 

defined( 'ABSPATH' ) || exit;

class GoliathDropdownPostList_V3 extends WP_Widget {

    // Creating the widget 
  
    function __construct() {
    parent::__construct(
      
    // Base ID of your widget
    'wpb_widget', 
      
    // Widget name will appear in UI
    __('WN Dynamic Menu Contento', 'wpb_widget_domain'), 
      
    // Widget description
    array( 'description' => __( 'Display latest post and related product when users hover over the categories in Mega Menues', 'wpb_widget_domain' ), ) 
    );
    }

    public function wn_getmenu_subitems($menu, $submenu_title) {

        $menu_data = wp_get_nav_menu_items($menu);

        $selectted_item;
        foreach( $menu_data as $item ) {

            if( $item->title == $submenu_title ) {
                $selectted_item = $item;
            }
        }

        $selected_subitems = [];
        foreach( $menu_data as $item ) {
            if ( $item->menu_item_parent == $selectted_item->ID) {
                array_push($selected_subitems, $item);
            }
        }

        return $selected_subitems;

    }
      
    // Creating widget front-end
      
    public function widget( $args, $instance ) {

        $main_category_name = apply_filters( 'widget_title', $instance['title'] );
        $menu_name = $instance['menu_name'];

        $selected_subitems = $this->wn_getmenu_subitems($menu_name, $main_category_name);        

        ?>
        <div class="wn_posts_shower_wrapper">            
        <?php

            $contador = 0;
            foreach ( $selected_subitems as $subitem ) {

                ?>
                    <div class="wn_mwh_posts_shower_elements<?php if($contador != 0) echo ' wn_mwh_hide'; ?>" data="<?php echo $subitem->title; ?>">
                    <?php 

                        $category_name = $subitem->title;
                        $category_id = get_cat_ID($category_name);
                        $category_link = get_category_link($category_id);

                        $args = array(
                            'numberposts' => 2,
                            'post_type' => 'post',
                            'category' => $category_id
                        );
                        
                        $latest_posts = get_posts( $args );

                        ?>
                            <div class="wn_mhw_elements_container">
                        <?php

                        foreach($latest_posts as $post){

                            $excerpt = '';
                            $post_title = $post->post_title;
                            $post_id = $post->ID;
                            $date = new DateTime($post->post_date);
                            $comments_number = get_comments_number($post_id);

                            ?>
                                <div class="wn_mwh_single_post_container">
                                    <a class="wn_posts_shower_unset_a_styles" href="<?php echo get_permalink($post_id); ?>">
                                        <img class="wn_mwh_single_post_image" src="<?php echo get_the_post_thumbnail_url($post_id, 'thumbnail',) ?>" alt="">        
                                    </a>
                                    <div class="wn_mwh_single_post_content_container">
                                        <a class="wn_posts_shower_unset_a_styles" href="<?php echo get_permalink($post_id); ?>">
                                            <h2 class="wn_mwh_single_post_title"><?php echo $post_title; ?></h2>
                                        </a>
                                        <div class="wn_mwh_single_metadata">
                                            <a href="<?php echo $category_link; ?>" title="<?php echo $category_name; ?>" class="tag-default"><?php echo $category_name; ?></a>
                                            <i class="fa fa-clock-o"></i>
                                            <span><?php echo $date->format('M d, Y'); ?></span>
                                            <i class="fa fa-comments"></i>
                                            <span><?php echo $comments_number; ?></span>
                                        </div>
                                        <div class="wn_mwh_single_post_excerpt">
                                            <?php 
                                                echo wn_clean_and_trim_excerpt(get_the_excerpt($post_id), 80);
                                            ?>                                        
                                            <span><?php // echo wn_clean_and_trim_excerpt(get_the_excerpt($post_id), 25); ?></span>
                                        </div>
                                    </div>            
                                </div>
                        <?php
                        }
                        ?>                        
                        </div>                        
                    
                    <div class="wn_mwh_posts_shower_product_wrapper">
                        <?php 

                            $product_id = get_option( "category_" . $category_id)['cat_product'];

                            if($product_id != '') {                                

                                $product = wc_get_product($product_id);
                                $product_name = $product->get_name();
                                $comments_count = wp_count_comments($product_id);
                                
                                ?>
                                <a class="wn_posts_shower_unset_a_styles" href="<?php echo get_permalink($product_id); ?>"><?php
                                    echo $product->get_image('product_header', ['class' => 'wn_mwh_woo_img']);
                                ?>
                                </a>

                                <div class="wn_mwh_single_post_content_container wn_mwh_product_meta">

                                    <a href="<?php echo $category_link; ?>" title="<?php echo $category_name; ?>" class="tag-default"><?php echo $category_name; ?></a>
                                    <a class="wn_posts_shower_unset_a_styles" href="<?php echo get_permalink($product_id); ?>">
                                        <h2 class="wn_mwh_single_post_title"><?php echo $product_name; ?></h2>
                                    </a>

                                    <div class="wn_mwh_single_post_excerpt wn_mwh_rating_wrapper">

                                        <i class="wn_ct_icon__stars" rating="<?php echo $product->get_average_rating(); ?>"></i>
                                        <span><?php echo $comments_count->total_comments; ?> ratings</span>
                                        <span><?php // echo wp_trim_words( get_the_excerpt($post_id), 20); ?></span>

                                    </div>
                                    <div class="wn_mwh_single_post_excerpt wn_mwh_single_post_product_categories">
                                        <?php
                                            $value = get_post_meta( $product_id, 'product_properties', true );

                                            if($value == '') {
                                                $value = get_the_excerpt($product_id);
                                            }
                                            echo $value;
                                        ?>
                                    </div>
                                </div>  
                                <?php
                            }
                        ?>
                    </div>                   
                </div>
                <?php 
                $contador++;
            }
        ?>
        </div>
        <?php 

    }
              
    // Widget Backend 
    public function form( $instance ) {
        if ( isset( $instance[ 'title' ] ) ) {
            $title = $instance[ 'title' ];
        }
        else {
            $title = __( 'New title', 'wpb_widget_domain' );
        }

        if ( isset( $instance[ 'menu_name' ] ) ) {
            $menu_name = $instance[ 'menu_name' ];
        }
        else {
            $menu_name = __( 'Menu Name', 'wpb_widget_domain' );
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