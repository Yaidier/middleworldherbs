<?php 

defined( 'ABSPATH' ) || exit;

class Wn_Related_Categories_List extends WP_Widget {

    // Creating the widget 
  
    function __construct() {
    parent::__construct(
      
    // Base ID of your widget
    'wn_related_categories_list', 
      
    // Widget name will appear in UI
    __('WN Related Categories List', 'wn_related_categories_list_domain'), 
      
    // Widget description
    array( 'description' => __( 'Display a list of related categories for the post published (ideal for sidebar)', 'wn_related_categories_list_domain' ), ) 
    );
    }


      
    // Creating widget front-end      
    public function widget( $args, $instance ) {

        $main_category_name = $instance['title'];
        $menu_name = $instance['menu_name'];         
        $post_categories = wp_get_post_categories(get_post()->ID, ['fields' => 'ids']);

        $parents = [];

        foreach($post_categories as $post_category_id) {
            $category = get_category($post_category_id);
            $parent = get_category($category->parent);

            if(!$parent instanceof WP_Error) {
                $parents[$parent->name] = $category->parent;
            }
            
        }

        foreach($parents as $index => $parent_category) {
            if($index != "") {
                $categories=get_categories(
                    array( 'parent' => $parent_category, 'exclude' => $post_categories)
                );
            }
        }

        if(empty($categories)) {
            return;
        }
        ?>
            <div class="wn_mwh_related_cat_list_wrapper">

                <div class="wn_mwh_header_wrapper">
                    <span>RELATED CATEGORIES</span>                
                </div>
                <ul>
                <?php
                    foreach($categories as $category) {
                        ?>
                        <li class="cat-item cat-item-65">
                            <a href="<?php echo get_category_link($category); ?>"><?php echo $category->name; ?></a>
                        </li>
                        <?php
                    }
                ?>
                </ul>
            </div>
        <?php        
    }
              
    // Widget Backend 
    public function form( $instance ) {
        if ( isset( $instance[ 'title' ] ) ) {
            $title = $instance[ 'title' ];
        }
        else {
            $title = __( 'New title', 'wn_related_categories_list_domain' );
        }

        if ( isset( $instance[ 'menu_name' ] ) ) {
            $menu_name = $instance[ 'menu_name' ];
        }
        else {
            $menu_name = __( 'Menu Name', 'wn_related_categories_list_domain' );
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