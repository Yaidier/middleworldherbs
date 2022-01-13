<?php
/**
 * @package WN Amz Sync
 */
/*
Plugin Name: WN Amz Sync
Plugin URI: https://wirenomads.com
Description: 
Author: Yaidier Perez
Version: 1.5
Author URI: 
License: GPLv2 or later
*/
/*
Copyright (C) 2020  Yaidier Perez
This program is free software; you can redistribute it and/or
modify it under the terms of the GNU General Public License
as published by the Free Software Foundation; either version 2
of the License, or (at your option) any later version.
This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.
You should have received a copy of the GNU General Public License
along with this program; if not, write to the Free Software
Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA  02110-1301, USA.
*/

defined( 'ABSPATH' ) || exit;

define( 'WN_AMZ_SYNC_DIR', __DIR__ );
define( 'WN_AMZ_SYNC_URL', plugin_dir_url(__FILE__) );
define( 'WN_AMZ_SYNC_VERSION', 1.0 );

require_once( WN_AMZ_SYNC_DIR . '/includes/wn-amzs-api.php' );
require_once( WN_AMZ_SYNC_DIR . '/includes/wn-amzs-products-sync.php' );
require_once( WN_AMZ_SYNC_DIR . '/includes/wn-amzs-admin.php' );
require_once( WN_AMZ_SYNC_DIR . '/includes/wn-amzs-ajax-handler.php' );

class WnAmzSync
{
    public $my_plugin_name;

    function __construct() {
        $this->my_plugin_name = plugin_basename(__FILE__);
    }

    function register() {  
        add_action( 'admin_menu', array( $this, 'add_admin_pages' ) );
        add_action( 'admin_enqueue_scripts', array( $this, 'wn_amzs_admin_enqueue_scripts' ) );
        add_action( 'init', array( $this, 'add_amazon_asin_to_products_meta' ) );
        add_action( 'init', array( 'WN_Amzs_Ajax_Handler', 'init' ) );
        add_action( 'admin_init', array( 'WN_Amzs_Admin', 'settings_page' ) );
    }

    function add_amazon_asin_to_products_meta() {
        add_action( 'woocommerce_product_options_sku', function() {
            global $post;
            $meta_value = get_post_meta( $post->ID, 'product_amazon_asin', true );

            woocommerce_wp_text_input(
                array(
                    'id'          => 'product_amazon_asin',
                    'value'       => ( $meta_value ) ? $meta_value : '',
                    'label'       => '<abbr title="' . esc_attr__( 'Amazon ASIN Number', 'woocommerce' ) . '">' . esc_html__( 'ASIN', 'woocommerce' ) . '</abbr>',
                    'desc_tip'    => true,
                    'description' => __( 'ASIN refers to Amazon\'s unique identifier for each distinct product.', 'woocommerce' ),
                )
            );
        } );

        add_action( 'woocommerce_process_product_meta', function( $post_id ) {
            $amazon_asin = isset( $_POST['product_amazon_asin'] ) ? $_POST['product_amazon_asin'] : '';
            update_post_meta( $post_id, 'product_amazon_asin', $amazon_asin );
        } );
    }


    function wn_amzs_admin_enqueue_scripts( $hook ) {
        if ( 'toplevel_page_wn_amz_sync_main' != $hook ) {
            return;
        }

        wp_enqueue_style ( 'wn_amzs_style', WN_AMZ_SYNC_URL . '/assets/css/wn-amz-styles.css', array(), time() ); 
        wp_enqueue_script ( 'wn_amzs_app', WN_AMZ_SYNC_URL . '/assets/js/wn-amzs-app.js', array( 'jquery' ), time(), true ); 
        wp_localize_script( 'wn_amzs_app', 'wn_amzs_app_data', array( 'ajaxurl' => admin_url( 'admin-ajax.php' ) ) );
    }

    public function add_admin_pages() {
        add_menu_page(
            'WN Amz Sync',
            'WN Amz Sync',
            'manage_options',
            'wn_amz_sync_main',
            array( $this, 'admin_index' ),
            'dashicons-clock',
            110
        );
    }

    public function admin_index() {
        WN_Amzs_Admin::init();
    }

    function activate() {
    }
    function deactivate() {
    }
    function uninstall() {        
    }
}
if ( class_exists( 'WnAmzSync' ) ) {
    $wn_amz_sync = new WnAmzSync();
    $wn_amz_sync->register();
}

register_activation_hook( __FILE__, array( $wn_amz_sync, 'activate' ) );
register_deactivation_hook( __FILE__, array( $wn_amz_sync, 'deactivate' ) );
