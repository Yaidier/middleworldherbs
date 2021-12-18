<?php

/**
 * Prints the box content.
 *
 * @param WP_Post $post The object for the current post/page.
 */

class WcCustomMetaboxes {

    public function __construct() {
        
    }

    public static function product_properties_metabox_callback( $post ) {

        // Add a nonce field so we can check for it later.
        wp_nonce_field( 'member_save_meta_box_data', 'member_meta_box_nonce' );
        
        $value = get_post_meta( $post->ID, 'product_properties', true );
    
        wp_editor( stripslashes($value), 'product_porperies' . $post->ID, $settings = array('textarea_name'=>'MyInputNAME') );
      
    }
    
    public static function key_benefits_metabox_callback( $post ) {
    
        // Add a nonce field so we can check for it later.
        wp_nonce_field( 'key_benefits_metabox_save_daata', 'key_benefits_metabox_nonce' );
        
        $value = get_post_meta( $post->ID, 'key_benefits', true );
    
        wp_editor( stripslashes( $value ), 'key_benefits' . $post->ID, $settings = array('textarea_name'=>'key_benefits_input') );
      
    }
    
    public static function is_it_for_me_metabox_callback( $post ) {
    
        // Add a nonce field so we can check for it later.
        wp_nonce_field( 'is_it_for_me_metabox_save_daata', 'is_it_for_me_metabox_nonce' );
        
        $value = get_post_meta( $post->ID, 'is_it_for_me', true );
    
        wp_editor( stripslashes( $value ), 'is_it_for_me' . $post->ID, $settings = array('textarea_name'=>'is_it_for_me_input') );
      
    }
    
    public static function what_is_inside_metabox_callback( $post ) {
    
        // Add a nonce field so we can check for it later.
        wp_nonce_field( 'what_is_inside_metabox_save_daata', 'what_is_inside_metabox_nonce' );
        
        $value = get_post_meta( $post->ID, 'what_is_inside', true );
    
        wp_editor( stripslashes( $value ), 'what_is_inside' . $post->ID, $settings = array('textarea_name'=>'what_is_inside_input') );
      
    }
    
    public static function medical_use_metabox_callback( $post ) {
    
        // Add a nonce field so we can check for it later.
        wp_nonce_field( 'medical_use_metabox_save_daata', 'medical_use_metabox_nonce' );
        
        $value = get_post_meta( $post->ID, 'medical_use', true );
    
        wp_editor( stripslashes( $value ), 'medical_use' . $post->ID, $settings = array('textarea_name'=>'medical_use_input') );
      
    }
    
    public static function clinical_evidence_metabox_callback( $post ) {
    
        // Add a nonce field so we can check for it later.
        wp_nonce_field( 'clinical_evidence_metabox_save_daata', 'clinical_evidence_metabox_nonce' );
        
        $value = get_post_meta( $post->ID, 'clinical_evidence', true );
    
        wp_editor( stripslashes( $value ), 'clinical_evidence' . $post->ID, $settings = array('textarea_name'=>'clinical_evidence_input') );
      
    }
    
    public static function how_to_use_metabox_callback( $post ) {
    
        // Add a nonce field so we can check for it later.
        wp_nonce_field( 'how_to_use_metabox_save_daata', 'how_to_use_metabox_nonce' );
        
        $value = get_post_meta( $post->ID, 'how_to_use', true );
    
        wp_editor( stripslashes( $value ), 'how_to_use' . $post->ID, $settings = array('textarea_name'=>'how_to_use_input') );
      
    }
    
    public static function is_it_safe_metabox_callback( $post ) {
    
        // Add a nonce field so we can check for it later.
        wp_nonce_field( 'is_it_safe_metabox_save_daata', 'is_it_safe_metabox_nonce' );
        
        $value = get_post_meta( $post->ID, 'is_it_safe', true );
    
        wp_editor( stripslashes( $value ), 'is_it_safe' . $post->ID, $settings = array('textarea_name'=>'is_it_safe_input') );
      
    }
    
    public static function is_it_safe_metabox_save_daata( $post_id ) {
    
        if ( ! isset( $_POST['is_it_safe_metabox_nonce'] ) ) {
        return;
        }
    
        if ( ! wp_verify_nonce( $_POST['is_it_safe_metabox_nonce'], 'is_it_safe_metabox_save_daata' ) ) {
        return;
        }
    
        if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
        return;
        }
    
        // Check the user's permissions.
        if ( isset( $_POST['post_type'] ) && 'page' == $_POST['post_type'] ) {
    
        if ( ! current_user_can( 'edit_page', $post_id ) ) {
            return;
        }
    
        } else {
    
        if ( ! current_user_can( 'edit_post', $post_id ) ) {
            return;
        }
        }
    
        if ( ! isset( $_POST['is_it_safe_input'] ) ) {
        return;
        }
    
        $my_data = (($_POST['is_it_safe_input']));
    
        update_post_meta($post_id, 'is_it_safe', $my_data );
    
      
    }
    public static function how_to_use_metabox_save_daata( $post_id ) {
    
        if ( ! isset( $_POST['how_to_use_metabox_nonce'] ) ) {
        return;
        }
    
        if ( ! wp_verify_nonce( $_POST['how_to_use_metabox_nonce'], 'how_to_use_metabox_save_daata' ) ) {
        return;
        }
    
        if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
        return;
        }
    
        // Check the user's permissions.
        if ( isset( $_POST['post_type'] ) && 'page' == $_POST['post_type'] ) {
    
        if ( ! current_user_can( 'edit_page', $post_id ) ) {
            return;
        }
    
        } else {
    
        if ( ! current_user_can( 'edit_post', $post_id ) ) {
            return;
        }
        }
    
        if ( ! isset( $_POST['how_to_use_input'] ) ) {
        return;
        }
    
        $my_data = (($_POST['how_to_use_input']));
    
        update_post_meta($post_id, 'how_to_use', $my_data );
    
      
    }
    public static function clinical_evidence_metabox_save_daata( $post_id ) {
    
        if ( ! isset( $_POST['clinical_evidence_metabox_nonce'] ) ) {
        return;
        }
    
        if ( ! wp_verify_nonce( $_POST['clinical_evidence_metabox_nonce'], 'clinical_evidence_metabox_save_daata' ) ) {
        return;
        }
    
        if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
        return;
        }
    
        // Check the user's permissions.
        if ( isset( $_POST['post_type'] ) && 'page' == $_POST['post_type'] ) {
    
        if ( ! current_user_can( 'edit_page', $post_id ) ) {
            return;
        }
    
        } else {
    
        if ( ! current_user_can( 'edit_post', $post_id ) ) {
            return;
        }
        }
    
        if ( ! isset( $_POST['clinical_evidence_input'] ) ) {
        return;
        }
    
        $my_data = (($_POST['clinical_evidence_input']));
    
        update_post_meta($post_id, 'clinical_evidence', $my_data );
    
      
    }
    
    public static function medical_use_metabox_save_daata( $post_id ) {
    
        if ( ! isset( $_POST['medical_use_metabox_nonce'] ) ) {
        return;
        }
    
        if ( ! wp_verify_nonce( $_POST['medical_use_metabox_nonce'], 'medical_use_metabox_save_daata' ) ) {
        return;
        }
    
        if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
        return;
        }
    
        // Check the user's permissions.
        if ( isset( $_POST['post_type'] ) && 'page' == $_POST['post_type'] ) {
    
        if ( ! current_user_can( 'edit_page', $post_id ) ) {
            return;
        }
    
        } else {
    
        if ( ! current_user_can( 'edit_post', $post_id ) ) {
            return;
        }
        }
    
        if ( ! isset( $_POST['medical_use_input'] ) ) {
        return;
        }
    
        $my_data = (($_POST['medical_use_input']));
    
        update_post_meta($post_id, 'medical_use', $my_data );
    
      
    }
    
    
    public static function what_is_inside_metabox_save_daata( $post_id ) {
    
        if ( ! isset( $_POST['what_is_inside_metabox_nonce'] ) ) {
        return;
        }
    
        if ( ! wp_verify_nonce( $_POST['what_is_inside_metabox_nonce'], 'what_is_inside_metabox_save_daata' ) ) {
        return;
        }
    
        if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
        return;
        }
    
        // Check the user's permissions.
        if ( isset( $_POST['post_type'] ) && 'page' == $_POST['post_type'] ) {
    
        if ( ! current_user_can( 'edit_page', $post_id ) ) {
            return;
        }
    
        } else {
    
        if ( ! current_user_can( 'edit_post', $post_id ) ) {
            return;
        }
        }
    
        if ( ! isset( $_POST['what_is_inside_input'] ) ) {
        return;
        }
    
        $my_data = (($_POST['what_is_inside_input']));
    
        update_post_meta($post_id, 'what_is_inside', $my_data );
    
      
    }
    
    public static function key_benefits_metabox_save_daata( $post_id ) {

        echo 'heyhey';
    
        if ( ! isset( $_POST['key_benefits_metabox_nonce'] ) ) {
        return;
        }
    
        if ( ! wp_verify_nonce( $_POST['key_benefits_metabox_nonce'], 'key_benefits_metabox_save_daata' ) ) {
        return;
        }
    
        if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
        return;
        }
    
        // Check the user's permissions.
        if ( isset( $_POST['post_type'] ) && 'page' == $_POST['post_type'] ) {
    
        if ( ! current_user_can( 'edit_page', $post_id ) ) {
            return;
        }
    
        } else {
    
        if ( ! current_user_can( 'edit_post', $post_id ) ) {
            return;
        }
        }
    
        if ( ! isset( $_POST['key_benefits_input'] ) ) {
        return;
        }
    
        $my_data = (($_POST['key_benefits_input']));
    
        update_post_meta($post_id, 'key_benefits', $my_data );
    
      
    }
    
    public static function is_it_for_me_metabox_save_daata( $post_id ) {
    
        if ( ! isset( $_POST['is_it_for_me_metabox_nonce'] ) ) {
        return;
        }
    
        if ( ! wp_verify_nonce( $_POST['is_it_for_me_metabox_nonce'], 'is_it_for_me_metabox_save_daata' ) ) {
        return;
        }
    
        if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
        return;
        }
    
        // Check the user's permissions.
        if ( isset( $_POST['post_type'] ) && 'page' == $_POST['post_type'] ) {
    
        if ( ! current_user_can( 'edit_page', $post_id ) ) {
            return;
        }
    
        } else {
    
        if ( ! current_user_can( 'edit_post', $post_id ) ) {
            return;
        }
        }
    
        if ( ! isset( $_POST['is_it_for_me_input'] ) ) {
        return;
        }
    
        $my_data = (($_POST['is_it_for_me_input']));
    
        update_post_meta($post_id, 'is_it_for_me', $my_data );
    
      
    }
    
    /**
     * When the post is saved, saves our custom data.
     *
     * @param int $post_id The ID of the post being saved.
     */
    public static function member_save_meta_box_data( $post_id ) {
    
        if ( ! isset( $_POST['member_meta_box_nonce'] ) ) {
        return;
        }
    
        if ( ! wp_verify_nonce( $_POST['member_meta_box_nonce'], 'member_save_meta_box_data' ) ) {
        return;
        }
    
        if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
        return;
        }
    
        // Check the user's permissions.
        if ( isset( $_POST['post_type'] ) && 'page' == $_POST['post_type'] ) {
    
        if ( ! current_user_can( 'edit_page', $post_id ) ) {
            return;
        }
    
        } else {
    
        if ( ! current_user_can( 'edit_post', $post_id ) ) {
            return;
        }
        }
    
        if ( ! isset( $_POST['MyInputNAME'] ) ) {
        return;
        }
    
        $my_data = (($_POST['MyInputNAME']));
    
        update_post_meta($post_id, 'product_properties', $my_data );
    
      
    }

}




