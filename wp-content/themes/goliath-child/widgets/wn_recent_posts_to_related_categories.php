<?php 

defined( 'ABSPATH' ) || exit;

class Wn_Related_Categories_Recent_Posts extends WP_Widget {

    // Creating the widget 
  
    function __construct() {
    parent::__construct(
      
    // Base ID of your widget
    'wn_related_categories_recent_posts', 
      
    // Widget name will appear in UI
    __('WN Related Categories Recent Posts', 'wn_related_categories_recent_posts_domain'), 
      
    // Widget description
    array( 'description' => __( 'Display a list of most recent posts related to the category(s) of the post published (ideal for sidebar)', 'wn_related_categories_recent_posts_domain' ), ) 
    );
    }


      
    // Creating widget front-end      
    public function widget( $args, $instance ) {

        $main_category_name = $instance['title'];
        $menu_name = $instance['menu_name']; 
        
        $post_categories = wp_get_post_categories(get_post()->ID, ['fields' => 'names']);

        $args = array(
            'post_type'             => 'post',
            'post_status'           => 'publish',
            'posts_per_page'        => 5, // Limit: two products
            'tax_query'             => array( array(
                'taxonomy'      => 'category',
                'field'         => 'name', // can be 'term_id', 'slug' or 'name'
                'terms'         => $post_categories,
                )
            )
        );

        

        $featured_posts = get_posts( $args );

        ?>
            <div class="wn_related_recent_posts_wrapper">
                <div class="wn_mwh_header_wrapper">
                    <span>RECENT POSTS</span>                
                </div>

                <?php wn_mwh_display_posts_list($featured_posts, false); ?>

            </div>            
        <?php

        
        
        
    }
              
    // Widget Backend 
    public function form( $instance ) {
        if ( isset( $instance[ 'title' ] ) ) {
            $title = $instance[ 'title' ];
        }
        else {
            $title = __( 'New title', 'wn_related_categories_recent_posts_domain' );
        }

        if ( isset( $instance[ 'menu_name' ] ) ) {
            $menu_name = $instance[ 'menu_name' ];
        }
        else {
            $menu_name = __( 'Menu Name', 'wn_related_categories_recent_posts_domain' );
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