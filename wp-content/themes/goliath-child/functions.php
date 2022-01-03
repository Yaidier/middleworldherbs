<?php

// Exit if accessed directly
if ( !defined( 'ABSPATH' ) ) exit;

use App\App as Starter;

require_once(get_template_directory() . '-child/widgets/goliath-dropdown-post-list_v2.php');	
require_once(get_template_directory() . '-child/widgets/wn_product_carousel_for_sidebar.php');	
require_once(get_template_directory() . '-child/widgets/wn_recent_posts_to_related_categories.php');	
require_once(get_template_directory() . '-child/widgets/wn_related_categories_list.php');


function my_theme_enqueue_styles() {

    update_option('wn_debugger', 'test' . get_stylesheet_uri());

    wp_enqueue_style( 'child-style', get_stylesheet_uri(),
        array( 'parenthandle' ), 
        wp_get_theme()->get('Version') //this only works if you have Version in the style header
    );

    wp_enqueue_style( 'header-menu-styles', get_stylesheet_directory_uri() . '/theme/assets/css/header-menu.css',
        array(), 
        time(),
    );  

    /*******loading slic master carousel plugin*/
    if (is_front_page() || (is_single() && 'post' == get_post_type())) {
        wp_enqueue_style( 'wn_mwh_slick_carousel_style', get_stylesheet_directory_uri() . '/addons/slick-master/slick/slick.css',
        array()
        );   
    
        wp_enqueue_style( 'wn_mwh_slick_carousel_theme_style', get_stylesheet_directory_uri() . '/addons/slick-master/slick/slick-theme.css',
        array()
        );   

        wp_enqueue_script( 'wn_mwh_lazysizes', get_stylesheet_directory_uri() . '/addons/lazysizes/lazysizes.min.js',
            array(), '', false
        ); 
        
        wp_enqueue_script( 'wn_mwh_slick_carousel_script', get_stylesheet_directory_uri() . '/addons/slick-master/slick/slick.min.js',
            array('jquery'), '', false
        ); 

        
    }
    /*loading slic master carousel plugin*******************/

    if(is_front_page()) {

        wp_enqueue_style( 'child-custom-styles', get_stylesheet_directory_uri() . '/theme/assets/css/custom.css',
            array(), 
            time()
        ); 

    }

    if ( is_single() && 'post' == get_post_type() ) {
        wp_enqueue_style( 'single-post-styles', get_stylesheet_directory_uri() . '/theme/assets/css/single-post.css',
            array(), 
            time(),
        ); 

        wp_enqueue_script( 'single-post-script', get_stylesheet_directory_uri() . '/theme/assets/js/single-post.js',
            array(), 
            time(), true
        ); 

    }

    wp_enqueue_style( 'all-styles', 
        get_stylesheet_directory_uri() . '/theme/assets/css/all.css',
        array(), 
        time()
    ); 


    

    wp_enqueue_style( 'child-responsiveness-styles', get_stylesheet_directory_uri() . '/theme/assets/css/responsiveness.css',
        array(), 
        time() 
    );    


    wp_enqueue_script( 'child-custom-script', get_stylesheet_directory_uri() . '/theme/assets/js/custom.js',
        array('jquery'), 
        time(), false
    ); 



    
    wp_enqueue_script ("my-ajax-handle", get_stylesheet_directory_uri() . "/theme/assets/js/ajax-request.js", array('jquery'), time(), true); 
    //the_ajax_script will use to print admin-ajaxurl in custom ajax.js
    wp_localize_script('my-ajax-handle', 'the_ajax_script', array('ajaxurl' =>admin_url('admin-ajax.php')));



}
add_action( 'wp_enqueue_scripts', 'my_theme_enqueue_styles' );



function wp_admin_load_scripts() {

    wp_enqueue_style( 'wn-admin-styles', get_stylesheet_directory_uri() . '/theme/assets/css/admin.css',
        array(), 
        time(),
    ); 

    wp_enqueue_script ("my-ajax-handle", get_stylesheet_directory_uri() . "/theme/assets/js/ajax-request.js", array('jquery'), time(), true); 
    //the_ajax_script will use to print admin-ajaxurl in custom ajax.js
    wp_localize_script('my-ajax-handle', 'the_ajax_script', array('ajaxurl' =>admin_url('admin-ajax.php')));
}

add_action( 'admin_enqueue_scripts', 'wp_admin_load_scripts' );


function wn_creates_custom_image_sizes() {
    add_image_size( 'product_header', 200 ); // 200 pixels wide (and unlimited height)   
    add_image_size( 'random_cat_three_column', 311, 230, true ); 
    add_image_size( 'latest_posts_tiny_thumbnail', 80, 80, true ); 

    // add_image_size( 'posts_three_columns', 60 ); // 200 pixels wide (and unlimited height)   

}
add_action( 'after_setup_theme', 'wn_creates_custom_image_sizes' );

function wn_add_widgets() {
    register_widget( 'GoliathDropdownPostList_v3' );
    register_widget( 'Wn_Product_Carousel_For_Sidebar' );
    register_widget( 'Wn_Related_Categories_Recent_Posts' );
    register_widget( 'Wn_Related_Categories_List' );
}

add_action( 'widgets_init', 'wn_add_widgets');


//add extra fields to category edit form hook
add_action ( 'category_edit_form_fields', 'extra_category_fields');


//add extra fields to category edit form callback function
function extra_category_fields( $tag ) {    //check for existing featured ID
    $t_id = $tag->term_id;
    $cat_meta = get_option( "category_" . $t_id);

    $args = array(
        'orderby'  => 'name',
        'limit' => -1,
    );

    $current_product = wc_get_product( $cat_meta['cat_product'] );

    if ($current_product == false) {
        $current_product_id = 0;
    }
    else {
        $current_product_id = $current_product->get_id();
    }

    $products = wc_get_products( $args );
    
    ?>
    <tr class="form-field">
        <th scope="row" valign="top"><label for="cat_Product"><?php _e('Category Product'); ?></label></th>
        <td>
            <select style="max-width: 300px; width: 100%;" name="Cat_meta[cat_product]" id="cat_Product">
                <?php foreach($products as $product) { ?>

                    <option value="<?php echo $product->get_id(); ?>" <?php if( $product->get_id() == $current_product_id ) { echo ' selected="selected"'; }; ?> ><?php echo $product->get_name(); ?></option>

                <?php }; ?>
            </select>
        </td>
    </tr>
    <tr>
        <th>
        </th>
        <td>
            <?php echo $cat_meta['cat_product'] ? $current_product->get_image() : ''; ?>
        </td>
    </tr>
    <?php
}

// save extra category extra fields hook
add_action ( 'edited_category', 'save_extra_category_fileds');

// save extra category extra fields callback function
function save_extra_category_fileds( $term_id ) {
    if ( isset( $_POST['Cat_meta'] ) ) {
        
        $t_id = $term_id;
        $cat_meta = get_option( "category_" . $t_id);
        $cat_keys = array_keys($_POST['Cat_meta']);
            foreach ($cat_keys as $key){
            if (isset($_POST['Cat_meta'][$key])){
                $cat_meta[$key] = $_POST['Cat_meta'][$key];
            }
        }
        //save the option array
        update_option( "category_" . $t_id, $cat_meta );
    }
}


function wn_mwh_register_custom_sidebar() {

    register_sidebar( array(
		'name'          => 'Home - Latest Articles',
		'id'            => 'home_right_1',
		'before_widget' => '',
		'after_widget'  => '',
		'before_title'  => '',
		'after_title'   => '',
	) );
}

add_action('widgets_init', 'wn_mwh_register_custom_sidebar');

function wn_products_carousel($args, $products_limit = -1, $offset = 0) {

    $cont = 0;
    
    $args = array(
        'status' => 'publish',
        'limit' => $products_limit,
        'offset' => $offset
    );
    
    $products = wc_get_products( $args );
    

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
                // echo $product->get_image('medium', ['class' => 'wn_mwh_woo_img wn_mwh_carousel_single_image']);

                ?>
                    <img class="wn_mwh_woo_img wn_mwh_carousel_single_image lazyload-2" replace="" src="<?php echo get_the_post_thumbnail_url($product_id, 'medium'); ?>" alt="">
                <?php
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
                        <?php // echo wc_price($product->get_price()); ?>
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
        $cont++;
    }
        
}

function wn_mwh_display_posts_list($posts, $display_excerpt = false) {

    // $display_excerpt = true;
    $words_trim_num = 20;
    $image_size = 'latest_posts_tiny_thumbnail';

    foreach($posts as $post){

        $post_title = $post->post_title;
        $post_id = $post->ID;
        $date = new DateTime($post->post_date);
        $comments_number = get_comments_number($post_id);

        $categories = get_the_category($post_id);
        $first_category = $categories[0];
        $category_id = $first_category->term_id;
        $category_name = $first_category->name;
        $category_link = get_category_link($category_id);

        $post_thumbnail_id = get_post_thumbnail_id($post_id);
        $image_alt = get_post_meta($post_thumbnail_id, '_wp_attachment_image_alt', TRUE);

        if(wp_get_attachment_image_src($post_thumbnail_id, $image_size) == false) {
            $thumbnail_url = wp_get_attachment_image_src(1304, $image_size)[0];
        }
        else {
            if(!wp_get_attachment_image_src($post_thumbnail_id, $image_size)[3]) {
                $thumbnail_url = wp_get_attachment_image_src($post_thumbnail_id, 'thumbnail')[0];
            }
            else {
                $thumbnail_url = wp_get_attachment_image_src($post_thumbnail_id, $image_size)[0];
            }
        }

        ?>

            <div class="">

                <div class="wn_mwh_single_post_container">
                    <a class="wn_posts_shower_unset_a_styles" href="<?php echo get_permalink($post_id); ?>">
                        <img class="wn_mwh_single_post_image lazyload-2" replace="" src="<?php echo $thumbnail_url; ?>" alt="<?php echo $image_alt; ?>">        
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
                        
                        <?php if ($display_excerpt) { ?>

                            <div class="wn_mwh_single_post_excerpt">
                                <span><?php echo wp_trim_words( get_the_excerpt($post_id), $words_trim_num); ?></span>
                            </div>

                        <?php }; ?>
                    </div>            
                </div>
            </div>
        <?php

    };    
}

function wn_clean_and_trim_excerpt($input, $char_numb) {

    $excerpt = strip_tags($input);
    $excerpt_2 = strip_tags($input);

    $excerpt_no_break_line = str_split(str_replace("&nbsp;", ' ', $excerpt));
    $excerpt_no_break_line_2 = str_split(str_replace("&nbsp;", ' ', $excerpt_2));

    for($i = 0; $i < count($excerpt_no_break_line); $i++) {
        if($excerpt_no_break_line[$i] != ' ') {
            break;
        } 
        unset($excerpt_no_break_line_2[$i]);                                            
    }
    
    $excerpt_no_break_line_2 = substr(implode($excerpt_no_break_line_2), 0, $char_numb);

    return $excerpt_no_break_line_2 . '...';
}

function wn_mwh_latest_posts() {

    $posts_limit = 4;
    $args = array(
        'numberposts' => $posts_limit,
        'post_type' => 'post',
    );
    
    $latest_posts = get_posts( $args );
    
    $cont = 0;
    $words_trim_num = 0;
    $image_size = '';

    ?><div class="wn_mwh_latest_posts_left_column">

        <div class="wn_mwh_header_wrapper">
            <span>LATEST ARTICLES</span>
            <a class="wn_posts_shower_unset_a_styles" href="<?php echo get_permalink( get_option( 'page_for_posts' ) ); ?>">
                <span>View all</span>
                <i class="wn_mwh_list_icon"></i>
            </a>
        </div>

        <div class="wn_mwh_latest_posts_left_wrapper">

            <?php

            foreach($latest_posts as $post){

                $post_title = $post->post_title;
                $post_id = $post->ID;
                $date = new DateTime($post->post_date);
                $comments_number = get_comments_number($post_id);

                $categories = get_the_category($post_id);
                $first_category = $categories[0];
                $category_id = $first_category->term_id;
                $category_name = $first_category->name;
                $category_link = get_category_link($category_id);

                $post_thumbnail_id = get_post_thumbnail_id($post_id);
                $image_alt = get_post_meta($post_thumbnail_id, '_wp_attachment_image_alt', TRUE);

                if($cont == 0) {
                    echo '<div class="wn_mwh_lp_inner_left">';
                    $words_trim_num = 10;
                    $image_size = 'thumbnail';

                }
                if($cont == $posts_limit - 1) {
                    echo '<div class="wn_mwh_lp_inner_right">';
                    $words_trim_num = 40;
                    $image_size = 'medium';
                }

                if($cont == $posts_limit - 1) {
                    $post_excerpt = wn_clean_and_trim_excerpt( get_the_excerpt($post_id), 230);
                }
                else {
                    $post_excerpt = wn_clean_and_trim_excerpt( get_the_excerpt($post_id), 100);
                }
                if(get_the_post_thumbnail_url($post_id, $image_size) == false) {
                    $thumbnail_url = wp_get_attachment_image_src(1304, $image_size)[0];
                }
                else {
                    $thumbnail_url = get_the_post_thumbnail_url($post_id, $image_size);
                }
                ?>
                    <div class="wn_mwh_single_post_container">
                        <a class="wn_posts_shower_unset_a_styles" href="<?php echo get_permalink($post_id); ?>">
                            <img class="wn_mwh_single_post_image lazyload-2" replace="" src="<?php echo $thumbnail_url; ?>" alt="<?php echo $image_alt; ?>">        
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
                                <span><?php echo $post_excerpt; ?></span>
                            </div>
                        </div>            
                    </div>
                <?php
                if(($cont == ($posts_limit) - 2) || ($cont == ($posts_limit) - 1) ) {
                    echo '</div>';
                }
                $cont++;
            };
            ?>
        </div>             
    </div>

    <?php
}

function wn_mwh_random_categories_three_columns($selected_categories, $show_thumbnails = true, $posts_published) {

    ?>
    <div class="wn_mwh_three_columns_cat_wrapper">
    <?php

 

    // $image_size = 'random_cat_three_column';

    $categories_count = count($selected_categories);
    $cont = 0;
    $fallback_image_size = '';

    // echo $categories_count . '<br>';

    if($categories_count == 3) {
        $image_size = 'random_cat_three_column';
        $fallback_image_size = 'medium';
    }
    else if($posts_count == 2) {
        $image_size = 'dropdown-featured-post-item-large';
        $fallback_image_size = 'medium';
    }
    else if($posts_count == 1) {
        $image_size = 'blog_thumb_single_medium';
        $fallback_image_size = 'large';
    }
    
    foreach($selected_categories as $selected_category_id) {

        $args = array(
            'numberposts' => 4,
            'post_type' => 'post',
            'category' => $selected_category_id,
            'exclude' => $posts_published,
        );

        $posts = get_posts( $args );

        if(!empty($posts)) {

            

            ?>
            <div class="wn_mwh_single_column">
                <?php

        
                ?>

                <div class="wn_mwh_header_wrapper">
                    <span><?php echo get_cat_name($selected_category_id); ?></span>
                <a class="wn_posts_shower_unset_a_styles" href="<?php echo get_category_link($selected_category_id); ?>">
                    <span>View all</span>
                    <i class="wn_mwh_list_icon"></i>
                </a>
                </div>

                <?php
                foreach($posts as $post) {
                    array_push($posts_published, $post->ID);
                }
                $first_run = true;
                $post = $posts[0];
                unset($posts[0]);

                    $post_title = $post->post_title;
                    $post_id = $post->ID;
                    $date = new DateTime($post->post_date);
                    $comments_number = get_comments_number($post_id);

                    $categories = get_the_category($post_id);
                    $first_category = $categories[0];
                    $category_id = $first_category->term_id;
                    $category_name = $first_category->name;
                    $category_link = get_category_link($category_id);

                    $post_thumbnail_id = get_post_thumbnail_id($post_id);
                    $image_alt = get_post_meta($post_thumbnail_id, '_wp_attachment_image_alt', TRUE);

                    $post_excerpt = wn_clean_and_trim_excerpt( get_the_excerpt($post_id), 230);

                    if(wp_get_attachment_image_src($post_thumbnail_id, $image_size) == false) {
                        $thumbnail_url = wp_get_attachment_image_src(1304, $image_size)[0];
                    }
                    else {
                        if(!wp_get_attachment_image_src($post_thumbnail_id, $image_size)[3]) {
                            $thumbnail_url = wp_get_attachment_image_src($post_thumbnail_id, $fallback_image_size)[0];
                        }
                        else {
                            $thumbnail_url = wp_get_attachment_image_src($post_thumbnail_id, $image_size)[0];
                        }
                    }
                    
                    
                    
                    ?>
                    <div class="wn_mwh_lp_inner_right">
                        <div class="wn_mwh_single_post_container">
                            <a class="wn_posts_shower_unset_a_styles wn_mwh_overflow_hidden" href="<?php echo get_permalink($post_id); ?>">
                                <img class="wn_mwh_single_post_image lazyload-2" replace="" src="<?php echo $thumbnail_url; ?>" alt="<?php echo $image_alt; ?>">        
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
                                    <span><?php echo $post_excerpt; ?></span>
                                </div>
                            </div>            
                        </div>
                    </div>
                    <?php
                

                if($show_thumbnails) {
                    ?>
                    <div class="wn_mwh_latest_posts_rigth_column">
                        <div class="wn_mwh_rc_latest_posts_slider_wrapper">
                            <div class="wn_mwh_rc_latest_posts_container">
                                <?php wn_mwh_display_posts_list($posts, false); ?>
                            </div>
                        </div>
                    </div>
                    <?php
                }
            ?>
                </div>
            <?php
            }        
        }
    ?>
    </div>
    <?php
    return $posts_published;
}
function wn_mwh_single_category_three_columns($selected_posts, $posts_published) {

    ?>
    <div class="wn_mwh_three_columns_cat_wrapper">
    <?php

    $posts_count = count($selected_posts);
    $fallback_image_size = '';

    if($posts_count == 3) {
        $image_size = 'random_cat_three_column';
        $fallback_image_size = 'medium';
    }
    else if($posts_count == 2) {
        $image_size = 'dropdown-featured-post-item-large';
        $fallback_image_size = 'medium';
    }
    else if($posts_count == 1) {
        $image_size = 'blog_thumb_single_medium';
        $fallback_image_size = 'large';
    }

    

    foreach($selected_posts as $post) {

        array_push($posts_published, $post->ID);

        

        ?>
        <div class="wn_mwh_single_column">
        <?php

        

        // var_dump($selected_category_id);


            $post_title = $post->post_title;
            $post_id = $post->ID;
            $date = new DateTime($post->post_date);
            $comments_number = get_comments_number($post_id);

            $categories = get_the_category($post_id);
            $first_category = $categories[0];
            $category_id = $first_category->term_id;
            $category_name = $first_category->name;
            $category_link = get_category_link($category_id);

            $post_thumbnail_id = get_post_thumbnail_id($post_id);
            $image_alt = get_post_meta($post_thumbnail_id, '_wp_attachment_image_alt', TRUE);

            $post_excerpt = wn_clean_and_trim_excerpt( get_the_excerpt($post_id), 230);

            $post_thumbnail_id = get_post_thumbnail_id($post->ID);
            $image_alt = get_post_meta($post_thumbnail_id, '_wp_attachment_image_alt', TRUE);

            
            if(wp_get_attachment_image_src($post_thumbnail_id, $image_size) == false) {
                $thumbnail_url = wp_get_attachment_image_src(1304, $image_size)[0];
            }
            else {
                if(!wp_get_attachment_image_src($post_thumbnail_id, $image_size)[3]) {
                    $thumbnail_url = wp_get_attachment_image_src($post_thumbnail_id, $fallback_image_size)[0];
                }
                else {
                    $thumbnail_url = wp_get_attachment_image_src($post_thumbnail_id, $image_size)[0];
                }
            }
            
            ?>
            <div class="wn_mwh_lp_inner_right" style="height: auto;">
                <div class="wn_mwh_single_post_container">
                    <a class="wn_posts_shower_unset_a_styles wn_mwh_overflow_hidden" href="<?php echo get_permalink($post_id); ?>">
                        <img class="wn_mwh_single_post_image lazyload-2" replace="" src="<?php echo $thumbnail_url; ?>" alt="<?php echo $image_alt; ?>">        
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
                            <span><?php echo $post_excerpt; ?></span>
                        </div>
                    </div>            
                </div>
            </div>
            <?php
        

        

        // wp_reset_postdata();

        ?>
        </div>
        <?php





    }

    ?>
    </div>
    <?php

    return $posts_published;


}

function time_to_refresh() {

    $last_api_call = new DateTime(get_option('WN_INST_FEED_LAST_API_CALL_TIME'));
    $current_date_time = new DateTime();

    if( $current_date_time > $last_api_call ) {

        return true;

    }
    else {

        return false;

    }

}

function wn_draw_instagram_feed( $local_img_data ) {

    ?>
        
        <div class="wn_mwh_instagram_feed_wrapper">
            <?php
            if(!empty($local_img_data)) {

                for($i = 0; $i < 12; $i++) {
                    ?>
                        <div class="wn_ig_single_container">                        
                            <div class="wn_ig_image_wrapper">
                                <a href="<?php echo $local_img_data[$i]['permalink']?>" target="_blank">
                                    <img class="lazyload-2" replace="" src="<?php echo $local_img_data[$i]['local_img_url']; ?>" alt="">
                                </a>
                            </div>                        
                            <div class="wn_mwh_instagram_text">
                                <?php echo wp_trim_words($local_img_data[$i]['caption'], 15, '...')?>
                            </div>
                            <i class="wn_ig_icon"></i>
                        </div>
                    <?php
                }

            }
            ?>
        </div>

    <?php

}

//[Instagram Section Feed]
function wn_get_instagram_local_data() {

    // $access_token = get_option('WN_INSTAGRAM_FEED_USER_ACCESS_TOKEN');

    

    $local_img_data = [];

    if(get_option('local_img_data', false) != false) {

        

        $local_img_data = get_option('local_img_data');
        wn_draw_instagram_feed( $local_img_data );

    }
    else {

        wn_instagram_feed();

    }

    return;

}


function wn_instagram_feed(){

    

    $access_token = get_option('WN_INSTAGRAM_FEED_USER_ACCESS_TOKEN');

    // wp_send_json($access_token);

    // die();

    $local_img_data = [];

    if(get_option('local_img_data', false) != false && time_to_refresh() == false) {

        
        $local_img_data = get_option('local_img_data');


    }

    // $local_img_data = [];

    if(empty($local_img_data)) {

        //Removing all files from directory
        $files = glob( get_stylesheet_directory() . '/instagram-feed-buffer/*' ); // get all file names

        foreach($files as $file){ 
            
            if(is_file($file)) {

                unlink($file); // delete file

            }

        }

        

        if( wp_mkdir_p(get_stylesheet_directory() . '/instagram-feed-buffer' )) {

            

            $posts_amount = 12;
    
            $ch = curl_init();   
            curl_setopt( $ch, CURLOPT_URL, 'https://graph.instagram.com/me/media?fields=id,caption,media_url,media_type,permalink&access_token=' . $access_token );
            curl_setopt( $ch, CURLOPT_RETURNTRANSFER , TRUE );
            $rgxrData = curl_exec( $ch ); 
            curl_close($ch);
            $rgxrData = json_decode( $rgxrData );
            $data = $rgxrData->data;


            $current_date_time = new DateTime();
            $date_time_string = $current_date_time->format('Y-m-d-H:i:s') . '-';
            $current_date_time->add(new DateInterval('PT1H'));
            $current_date_time = $current_date_time->format('Y-m-dTH:i:s');

            for($i = 0; $i < $posts_amount; $i++) {

                $remote_img = wp_remote_get($data[$i]->media_url);

                if (!$remote_img instanceof WP_Error) {

                    $caption = isset($data[$i]->caption) ? $data[$i]->caption : '';
                    $permalink = isset($data[$i]->permalink) ? $data[$i]->permalink : '';

                    $basename = basename($data[$i]->media_url);
                    $img_ext = substr($basename, strpos($basename, '.'), 4);
                
                    $myfile = fopen(get_stylesheet_directory() . '/instagram-feed-buffer/insta-img-' . $date_time_string . $i . $img_ext, "w") or die("Unable to open file!");
                    fwrite($myfile, $remote_img['body']);
                    fclose($myfile);
        
                    $local_img = wp_get_image_editor(get_stylesheet_directory() . '/instagram-feed-buffer/insta-img-' . $date_time_string . $i . $img_ext);

                    if (!$local_img instanceof WP_Error) {
                        
                        $local_img->resize(200, 200, true);
                        $local_img->save(get_stylesheet_directory() . '/instagram-feed-buffer/insta-img-' . $date_time_string . $i . $img_ext);

                        $image_data = [

                            'local_img_url' => get_stylesheet_directory_uri() . '/instagram-feed-buffer/insta-img-' . $date_time_string . $i . $img_ext,
                            'caption' => $caption,
                            'permalink' => $permalink

                        ];

                        array_push( $local_img_data, $image_data );

                    }
                    else {

                        //Error converting the file into an image
                        $posts_amount++;

                    }

                }
                else {

                    //Error getting the file
                    $posts_amount++;
                    
                }
                
            } 

            update_option('local_img_data', $local_img_data);
            update_option('WN_INST_FEED_LAST_API_CALL_TIME', $current_date_time);

        };

        wn_draw_instagram_feed( $local_img_data );

    }

    // die();

}

add_shortcode( 'wn-instagram-feed', 'wn_get_instagram_local_data' );

function wn_dequeue_scripts_home() {
    if (!is_front_page()) return;

    // wp_deregister_script( 'jquery-migrate' );
    // wp_register_script( 'jquery', includes_url( '/js/jquery/jquery.js' ), false, NULL, true );

    global $wp_scripts;
    $scripts_to_keep = [
                        
                        'my-ajax-handle',
                            // 'admin-bar',
                            // 'comment-reply',
                            // 'contact-form-7',
                            // 'fts_powered_by_js',
                            // 'fts-global',

                        'jquery',
                            // 'tp-tools', 
                            // 'revmin', 
                            // 'wc-add-to-cart',

                        'woocommerce',

                            // 'wc-cart-fragments',
                            // 'wpdiscuz-combo-js',
                            // 'monsterinsights-vue-vendors',
                            // 'monsterinsights-vue-common',
                            // 'monsterinsights-vue-frontend',
                            // 'vc_woocommerce-add-to-cart-js',
                            // 'wpp-js',
                            // 'mailchimp-woocommerce',

                        'child-custom-script',
                        'wn_mwh_slick_carousel_script',
                            // 'wn_mwh_lazysizes',
                            // 'jquery-ui-core',
                            // 'jquery-effects-slide',
                            // 'jquery-effects-size',
                            // 'plsh-modernizr',
                            // 'plsh-bootstrap',
                            // 'plsh-bootstrap-hover-dropdown',
                            // 'plsh-cycle2',
                            // 'plsh-scroll-vertical',
                            // 'plsh-cycle2-swipe',
                            // 'plsh-inview',
                            // 'plsh-hoverintent',
                            // 'plsh-sharrre',
                            // 'plsh-particles',
                            // 'plsh-theme'
                    ];
    foreach( $wp_scripts->queue as $handle ) :
        // echo $handle . '<br>';
        if (!in_array($handle, $scripts_to_keep)) {
            wp_dequeue_script($handle);
        }
    endforeach;
}
add_action( 'wp_print_scripts', 'wn_dequeue_scripts_home', 100 );

function wn_dequeue_styles_home() {
    if (!is_front_page()) return;
    global $wp_styles;

    $styles_to_keep = [
                            // 'revslider-material-icons',
                            // 'revslider-basics-css',
                            // 'rs-color-picker-css',
                            // 'revbuilder-select2RS',
                            // 'rs-roboto',
                            // 'tp-material-icons',

                        'admin-bar',
                        'sby_styles',

                            // 'wp-block-library',
                            // 'wc-block-style',
                            // 'bbp-default',
                            // 'cm-frontend',
                            // 'contact-form-7',
                            // 'fts-feeds',
                        // 'rs-plugin-settings',                        
                            // 'woocommerce-layout',
                            // 'woocommerce-smallscreen',
                            // 'woocommerce-general',
                            // 'woocommerce-inline',
                            // 'wpdiscuz-frontend-css',
                            // 'wpdiscuz-fa',
                            // 'wpdiscuz-combo-css',
                            // 'monsterinsights-vue-frontend-style',
                            // 'monsterinsights-popular-posts-style',
                            // 'wordpress-popular-posts-css',

                        'child-style',
                        'header-menu-styles',
                        'child-custom-styles',
                        'all-styles',
                        'child-responsiveness-styles',

                         // 'test-style',

                        'wn_mwh_slick_carousel_style',
                        'wn_mwh_slick_carousel_theme_style',


                        
                        'plsh-font-awesome',
                        // 'plsh-bootstrap',
                        // 'plsh-main',
                        // 'plsh-tablet',
                        // 'plsh-phone',
                        // 'plsh-woocommerce',
                        // 'plsh-bbpress',
                        // 'plsh-wordpress_style',
                        // 'plsh-sharrre',
                        // 'plsh-style',
                        //'plsh-google-fonts',
                        // 'yoast-seo-adminbar',
                        // 'js_composer_front',
                    ];
    // $styles_to_keep = ['cm-frontend', 'child-style', 'header-menu-styles', 'child-custom-styles', 'child-responsiveness-styles', 'wn_mwh_slick_carousel_style', 'wn_mwh_slick_carousel_theme_style', 'plsh-style', 'plsh-wordpress_style', 'plsh-google-fonts'];
    foreach( $wp_styles->queue as $handle ) :
        // echo $handle . '<br>';
        if (!in_array($handle, $styles_to_keep)) {
            wp_dequeue_style($handle);
        }
    endforeach;
}
add_action( 'wp_print_styles', 'wn_dequeue_styles_home', 100 );


function wn_dequeue_styles_single_product() {
    if (!is_product() || is_admin() ) {
        return;
    } 
    
    global $wp_styles;

    $styles_to_keep = [
                            // 'revslider-material-icons',
                            // 'revslider-basics-css',
                            // 'rs-color-picker-css',
                            // 'revbuilder-select2RS',
                            // 'rs-roboto',
                            // 'tp-material-icons',

                        'admin-bar',
                        // 'sby_styles',

                            // 'wp-block-library',
                            // 'wc-block-style',
                            // 'bbp-default',
                            // 'cm-frontend',
                            // 'contact-form-7',
                            // 'fts-feeds',
                        // 'rs-plugin-settings',                        
                            // 'woocommerce-layout',
                            // 'woocommerce-smallscreen',
                            'woocommerce-general',
                            // 'woocommerce-inline',
                            // 'wpdiscuz-frontend-css',
                            // 'wpdiscuz-fa',
                            // 'wpdiscuz-combo-css',
                            // 'monsterinsights-vue-frontend-style',
                            // 'monsterinsights-popular-posts-style',
                            // 'wordpress-popular-posts-css',

                        'child-style',
                        'header-menu-styles',
                        'child-custom-styles',
                        'all-styles',
                        'child-responsiveness-styles',

                         // 'test-style',

                        // 'wn_mwh_slick_carousel_style',
                        // 'wn_mwh_slick_carousel_theme_style',


                        
                        'plsh-font-awesome',
                        // 'plsh-bootstrap',
                        // 'plsh-main',
                        // 'plsh-tablet',
                        // 'plsh-phone',
                        // 'plsh-woocommerce',
                        // 'plsh-bbpress',
                        'plsh-wordpress_style',
                        // 'plsh-sharrre',
                        // 'plsh-style',
                        //'plsh-google-fonts',
                        // 'yoast-seo-adminbar',
                        // 'js_composer_front',

                        'single-product-styles',
                        'single-product-styles-768',
                        'single-product-styles-450',
                        'wm-zoom-styles'
                    ];
    // $styles_to_keep = ['cm-frontend', 'child-style', 'header-menu-styles', 'child-custom-styles', 'child-responsiveness-styles', 'wn_mwh_slick_carousel_style', 'wn_mwh_slick_carousel_theme_style', 'plsh-style', 'plsh-wordpress_style', 'plsh-google-fonts'];
    foreach( $wp_styles->queue as $handle ) :
        // echo $handle . '<br>';
        if (!in_array($handle, $styles_to_keep)) {
            wp_dequeue_style($handle);
        }
    endforeach;
}

add_action( 'wp_print_styles', 'wn_dequeue_styles_single_product', 100 );




function wn_remove_https_styles( $html, $handle, $href, $media ){
    
    
    $basenames = array(
        'sb-youtube.min.css?ver=1.4',
        'main.css?ver=5.7.2',
        'wordpress.css?ver=5.7.2',
        'slick-theme.css?ver=5.7.2',
        'font-awesome.min.css?ver=5.7.2'
    );

    $handlers = [
        'all-styles',
        'child-custom-styles',
        'plsh-main',
        'plsh-tablet',
        'plsh-phone',
        'child-responsiveness-styles',
        'wn_mwh_slick_carousel_style',
        'wn_mwh_slick_carousel_theme_style',
        'header-menu-styles'
    ];


    if( in_array( basename($href), $basenames ) || in_array( $handle, $handlers ) ){
          
        $html = str_replace( 'stylesheet', 'preload', $html );
        $html = str_replace( 'type=', 'as="style" onload="this.onload=null;this.rel=\'stylesheet\'" type=', $html );
        $html .= '<noscript><link rel="stylesheet" href="' . $href . '"></noscript>';

    }

    
    return $html;
}
add_filter( 'style_loader_tag',  'wn_remove_https_styles', 10, 4 );

// add async and defer attributes to enqueued scripts
function shapeSpace_script_loader_tag($tag, $handle, $src) {

    $handlers = [
        'jquery-core'
    ];
	
	if (in_array($handle, $handlers)) {
		
		// if (false === stripos($tag, 'async')) {
			
		// 	$tag = str_replace(' src', ' async="async" src', $tag);
			
		// }
		
		// if (false === stripos($tag, 'defer')) {
			
		// 	$tag = str_replace('<script ', '<script defer ', $tag);
			
		// }

        // update_option('wn_debug', $tag);
		
	}
    if(basename($src) == 'jquery-migrate.js?ver=3.3.2') {
        update_option('wn_debug', $handle);
    }
	
	return $tag;
	
}
add_filter('script_loader_tag', 'shapeSpace_script_loader_tag', 10, 3);

function wn_replace_current_nav_menu() {
    
    wp_nav_menu( array(
        'menu_id'           => 'menu-primary',
        'menu'              => 'primary-menu',
        'theme_location'    => 'primary-menu',
        'depth'             => 3,
        'container'         => 'div',
        'menu_class'        => 'wn_mwh_nav_ul',
        )
    );

    die();
}

function wn_load_more_products_slider() {

    $args = [ 'post_type' => 'product', 'post_status' => 'publish', 
    'posts_per_page' => -1 ];

    $products_total = count(get_posts( $args ));

    wn_products_carousel([], $products_total - 3, 3);
    die();


}


function wn_call_insta() {
    $url_request = "https://api.instagram.com/oauth/authorize?client_id=496718628054223&redirect_uri=https://middleworldherbs.com/auth&scope=user_media&response_type=code";
    
    $response = wp_remote_get($url_request);

    wp_send_json($response);
}

function more_post_ajax() {

    ?>

<div class="wn_mwh_latest_articles_wrapper">
            <?php
                wn_mwh_latest_posts();
            ?>
            <div class="wn_mwh_latest_posts_rigth_column">
                <?php
                //Most Commented Posts
                $posts_limit = 4;
                $args = array(
                    'numberposts' => $posts_limit,
                    'post_type' => 'post',
                    'order_by' => 'comment_count',
                    'order' => 'DESC'
                );

                //Manually Featured Posts
                $most_commented_posts = get_posts( $args );
                $args = array(
                    'numberposts' => $posts_limit,
                    'post_type' => 'post',
                    'meta_key' => 'is_featured',
                    'meta_value' => 'on'
                );

                $featured_posts = get_posts( $args );

                ?> 
                <div class="wn_mwh_rc_header">                           
                    <!-- Pre/Next Buttons generated in the custom.js file-->
                </div>
                <div id="wn_mwh_rc_latest_posts_slider_wrapper" class="wn_mwh_rc_latest_posts_slider_wrapper">
                    <div class="wn_mwh_rc_latest_posts_container">
                        <?php wn_mwh_display_posts_list($most_commented_posts, false); ?>
                    </div>
                    <div class="wn_mwh_rc_latest_posts_container">
                        <?php wn_mwh_display_posts_list($featured_posts, false); ?>
                    </div>
                </div>
            </div>
        </div>

        <div class="wn_mwh_world_stories_wrapper">
            <div class="wn_mwh_header_wrapper">
                <span>MIDDLE WORLD STORIES</span>
                <a class="wn_posts_shower_unset_a_styles" href="<?php echo get_permalink( get_option( 'page_for_posts' ) ); ?>">
                    <span>View all</span>
                    <i class="wn_mwh_list_icon"></i>
                </a>
            </div>
            <div class="wn_mwh_subscription_wrapper">
                <img class="lazyload-2" replace="" src="/wp-content/uploads/2021/05/typewriter.png" alt="">
                <div class="wn_mwh_subs_content">
                    <p>Dear Friend<br><i>💕</i> Self-care is such a buzzword, yet there is no clear definition of it. It has different meaning for each and every one of us. What is YOUR version of self-care? I am here to share inspirations, natural remedies <i>🌱</i>, facts and stories with you. Most of them really simple, because self-care should not be yet another thing to do <i>🌸</i> With many blessings for long and healthy life to you and your loved ones <i>🌞</i></p>
                    <div class="wn_mwh_subs_meta">
                        <p>Eva-<br><span>Natural Health Researcher and Founder of Middle World Herbs</span></p>
                        <a rel="noopener" href="https://www.youtube.com/channel/UC5LDmw7Y_9uYR2jkPTxRiHw?sub_confirmation=1&feature=subscribe-embed-click" target="_blank">
                            SUBSCRIBE TO MIDDLE WORLD YOUTUBE CHANNEL
                        </a>
                    </div>
                </div>
            </div>
            <div class="wn_youtube_feed_wrapper">                
                <?php
                // echo do_shortcode('[fts_youtube vid_count=4 large_vid=yes large_vid_title=no large_vid_description=no thumbs_play_in_iframe=yes vids_in_row=1 omit_first_thumbnail=no space_between_videos=1px force_columns=no maxres_thumbnail_images=yes thumbs_wrap_color=#000 channel_id=UC5LDmw7Y_9uYR2jkPTxRiHw]');
                echo do_shortcode('[youtube-feed]');
                ?>
            </div>
        </div>

        <div class="wn_mwh_rc_one_wrapper">

            <?php

                $posts_published = [];
                $wp_categories = get_categories( array(

                    'orderby' => 'name',
                    'order'   => 'ASC',
                    'number' => 8,
                    'hide_empty' => true,

                ) );

                shuffle($wp_categories);
                $selected_categories = [];

                for($i = 0; $i < 3; $i++) {

                    $selected_categories[$i] = $wp_categories[$i]->term_id;
                    unset($wp_categories[$i]);

                }
                $posts_published = wn_mwh_random_categories_three_columns($selected_categories, true, $posts_published);

            ?>

        </div>

        <div class="wn_mwh_instagram_section_wrapper">
            <div class="wn_mwh_header_wrapper">
                <span>MIDDLE WORLD INSPIRATIONS</span>
                <a class="wn_posts_shower_unset_a_styles" href="<?php echo get_permalink( get_option( 'page_for_posts' ) ); ?>">
                    <span>View all</span>
                    <i class="wn_mwh_list_icon"></i>
                </a>
            </div>
            <div class="wn_mwh_subscription_wrapper">
                <img class="lazyload-2" replace="" src="/wp-content/uploads/2021/05/typewriter.png" alt="">
                <div class="wn_mwh_subs_content">
                    <p>Dear Travelers<br>Sometimes a thoughtful message, a heartfelt wish, or a surprising idea can brighten up the day. Sometimes a quote from a wise man, a recipe, or an inspiring image can bring a ray of sunshine to your day or put a smile on your face. With best wishes for happy, joyful, and fulfilling Here And Now moments.</p>
                    <div class="wn_mwh_subs_meta">
                        <p>Eva-<br><span>Natural Health Researcher and Founder of Middle World Herbs</span></p>
                        
                        <a rel="noopener" href="https://www.instagram.com/accounts/login/?next=%2Fp%2FCOvtJh1jmH0%2F&source=follow" target="_blank">
                            FOLLOW US ON INSTAGRAM
                        </a>
                    </div>
                </div>
            </div>
            <div class="wn_mwh_instagram_feed_section">
                
                <?php echo do_shortcode('[wn-instagram-feed]'); ?>    

            </div>
        </div>


        <div class="wn_mwh_rc_one_wrapper">

            <?php
                if(count($wp_categories) != 0) {
                    shuffle($wp_categories);                    
                    $selected_category = $wp_categories[0]->term_id;
                    unset($wp_categories[0]);
                        
                    ?>
                        <div class="wn_mwh_header_wrapper">
                            <span><?php echo get_cat_name($selected_category); ?></span>
                            <a class="wn_posts_shower_unset_a_styles" href="<?php echo get_category_link($selected_category); ?>">
                                <span>View all</span>
                                <i class="wn_mwh_list_icon"></i>
                            </a>
                        </div>
                    <?php

                    $args = array(
                        'numberposts' => 3,
                        'post_type' => 'post',
                        'category' => $selected_category,
                        'exclude' => $posts_published,
                    );

                    $posts = get_posts( $args );

                    $posts_published = wn_mwh_single_category_three_columns($posts, $posts_published);
                }
            ?>

        </div>
        <div class="wn_mwh_rc_one_wrapper">
            
            <?php
                if(count($wp_categories) != 0) {
                    ?>
                        
                    <?php
                    shuffle($wp_categories);
                    $selected_categories = [];

                    for($i = 0; $i < 3; $i++) {
                        if(isset($wp_categories[$i])){
                            $selected_categories[$i] = $wp_categories[$i]->term_id;
                            unset($wp_categories[$i]);
                        }
                    }
                    $posts_published = wn_mwh_random_categories_three_columns($selected_categories, true, $posts_published);
                }
            ?>

        </div>
        <div class="wn_mwh_rc_one_wrapper">

            <?php
                if(count($wp_categories) != 0) {

                    shuffle($wp_categories);                    
                    $selected_category = $wp_categories[0]->term_id;
                    unset($wp_categories[0]);

                    $args = array(
                        'numberposts' => 3,
                        'post_type' => 'post',
                        'category' => $selected_category,
                        'exclude' => $posts_published,
                    );

                    $posts = get_posts( $args );

                    if(!empty($posts)) {
                        ?>
                        <div class="wn_mwh_header_wrapper">
                            <span><?php echo get_cat_name($selected_category); ?></span>
                            <a class="wn_posts_shower_unset_a_styles" href="<?php echo get_category_link($selected_category); ?>">
                                <span>View all</span>
                                <i class="wn_mwh_list_icon"></i>
                            </a>
                        </div>
                        <?php                    
                        $posts_published = wn_mwh_single_category_three_columns($posts, $posts_published);
                    }                   
                } 
            ?>

        </div>

        

    <?php
  
    // die(do_shortcode('[youtube-feed]'));
    // die();
}

// add_action('wp_ajax_nopriv_more_post_ajax', 'more_post_ajax');
// add_action('wp_ajax_more_post_ajax', 'more_post_ajax');

add_action('wp_ajax_nopriv_wn_replace_current_nav_menu', 'wn_replace_current_nav_menu');
add_action('wp_ajax_wn_replace_current_nav_menu', 'wn_replace_current_nav_menu');

add_action('wp_ajax_nopriv_wn_load_more_products_slider', 'wn_load_more_products_slider');
add_action('wp_ajax_wn_load_more_products_slider', 'wn_load_more_products_slider');

add_action('wp_ajax_nopriv_wn_instagram_feed', 'wn_instagram_feed');
add_action('wp_ajax_wn_instagram_feed', 'wn_instagram_feed');

add_action('wp_ajax_nopriv_wn_call_insta', 'wn_call_insta');
add_action('wp_ajax_wn_call_insta', 'wn_call_insta');





function wn_debugger() {
    
    if( !current_user_can( 'administrator' )) {
        return;
    }

    global $post;
    global $product;
    global $woocommerce;

    if ( $post ) {

    }
}

add_action('wp', 'wn_debugger');

function add_cors_http_header(){
    header("Access-Control-Allow-Origin: *");
}
add_action('init','add_cors_http_header');

function key_benefits_callback( ) {

    global $post;
    ?>
        <div class="wn_tab_content">

            <?php echo apply_filters('meta_content', (get_post_meta( $post->ID, 'key_benefits', true )));?>

        </div>
    <?php

}
function is_it_for_me_callback() {

    global $post;
    ?>
        <div class="wn_tab_content">

            <?php echo apply_filters('meta_content', (get_post_meta( $post->ID, 'is_it_for_me', true )));?>

        </div>
    <?php

}
function what_is_inside_callback() {

    global $post;
    ?>
        <div class="wn_tab_content">

            <?php echo apply_filters('meta_content', (get_post_meta( $post->ID, 'what_is_inside', true )));?>

        </div>
    <?php

}
function medical_use_callback() {

    global $post;
    ?>
        <div class="wn_tab_content">

            <?php echo apply_filters('meta_content', (get_post_meta( $post->ID, 'medical_use', true )));?>

        </div>
    <?php

}

function clinical_evidence_callback() {

    global $post;
    ?>
        <div class="wn_tab_content">

            <?php echo apply_filters('meta_content', (get_post_meta( $post->ID, 'clinical_evidence', true )));?>

        </div>
    <?php

}
function how_to_use_callback() {

    global $post;
    ?>
        <div class="wn_tab_content">

            <?php echo apply_filters('meta_content', (get_post_meta( $post->ID, 'how_to_use', true )));?>

        </div>
    <?php

}
function is_it_safe_callback() {

    global $post;
    ?>
        <div class="wn_tab_content">

            <?php echo apply_filters('meta_content', (get_post_meta( $post->ID, 'is_it_safe', true )));?>

        </div>
    <?php

}

/**
 * Remove product data tabs
 */
add_filter( 'woocommerce_product_tabs', 'woo_remove_product_tabs', 98 );
function woo_remove_product_tabs( $tabs ) {

    unset( $tabs['description'] );  // Remove the description tab
    unset( $tabs['reviews'] );  // Remove the description tab

    global $post;
    $product_tabs = [

        'key_benefits' => [
            'title' => 'Key Benefits',
            'priority' => 31,
            'callback' => 'key_benefits_callback',
        ],
        'is_it_for_me' => [
            'title' => 'Is it for Me?',
            'priority' => 32,
            'callback' => 'is_it_for_me_callback',
        ],
        'what_is_inside' => [
            'title' => 'what\'s inside?',
            'priority' => 32,
            'callback' => 'what_is_inside_callback',
        ],
        'medical_use' => [
            'title' => 'History of Medicinal Use',
            'priority' => 32,
            'callback' => 'medical_use_callback',
        ],
        'clinical_evidence' => [
            'title' => 'Evidence from Clinical Research',
            'priority' => 32,
            'callback' => 'clinical_evidence_callback',
        ],
        'how_to_use' => [
            'title' => 'How to use?',
            'priority' => 32,
            'callback' => 'how_to_use_callback',
        ],
        'is_it_safe' => [
            'title' => 'Is it Safe?',
            'priority' => 32,
            'callback' => 'is_it_safe_callback',
        ],

    ];

    foreach ( $product_tabs as $key => $product_tab_value ) {

        $value = get_post_meta( $post->ID, $key, true );
        if ( $value != '' || $value != false ) {

            $tabs[$key] = $product_tab_value;

        }

    }

    return $tabs;

}


/* @Recreate the default filters on the_content so we can pull formated content with get_post_meta
-------------------------------------------------------------- */
add_filter( 'meta_content', 'wptexturize'        );
add_filter( 'meta_content', 'convert_smilies'    );
add_filter( 'meta_content', 'convert_chars'      );
add_filter( 'meta_content', 'wpautop'            );
add_filter( 'meta_content', 'shortcode_unautop'  );
add_filter( 'meta_content', 'prepend_attachment' );


/**     
 * Display the comment template...
 *
 * @see http://stackoverflow.com/a/28644134/2078474
 */
function wn_single_product_comments_template( $atts = array(), $content = '' ) {

   if( is_singular() && post_type_supports( get_post_type(), 'comments' ) )
   {
       ob_start();
       comments_template();
       add_filter( 'comments_open',       'wpse_comments_open'   );
       add_filter( 'get_comments_number', 'wpse_comments_number' );
       return ob_get_clean();
   }
   return '';
}

function wpse_comments_open( $open )
{
   remove_filter( current_filter(), __FUNCTION__ );
   return false;
}

function wpse_comments_number( $open )
{
   remove_filter( current_filter(), __FUNCTION__ );
   return 0;
}


add_filter('wcsatt_single_product_options', function($options, $subscription_schemes, $product){

    $product_price = floatval($product->get_price());



    // foreach( $options as &$option ) {

    //     if ( $option['class'] == 'one-time-option' ) {

    //         $variantions_counter += 1;

    //         echo 'variation---> ' . $variantions_counter . '<br>';

    //         // if ( $variantions_counter >= 2 ) {
    //         //     break;
    //         // }
    //     }
    //     else {


    //         $option['description'] = $option['value'];

    //     }

    // echo '<pre>';
    // var_dump($options);
    // echo '</pre>';



    //     echo '///////////////////////////';

    // }

    // unset( $option );

    // echo '///////////////////////////';

    return $options;

}, 10, 3);

require_once( __DIR__ . '/autoloader.php' );
Starter::init();

function wn_dequeue_scripts_single_product() {

    global $wp_scripts;

    // echo '<pre>';
    // var_dump( $wp_scripts );
    // echo '</pre>';
    // die();

    

}

add_action( 'wp_print_scripts', 'wn_dequeue_scripts_single_product', 100 );

    // global $product;
    // echo '<pre>';
    // var_dump( $product );
    // echo '</pre>';
    // die();
