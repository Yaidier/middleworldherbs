<?php
/**
 * 
 * 
 */

class WN_Amzs_Admin {

    static $settings_sections;
    static $default_tab;
    static $tab;
    static $syncronizing_images;
    static $products_id_to_sync;
    static $products_prices_updated;

    public static function init() {
        self::setting_up_the_variables();
        self::checking_parameters();
        self::render_dashboard( self::$tab );
    }

    public static function setting_up_the_variables() {
        self::$default_tab                  = null;
        self::$tab                          = null;
        self::$syncronizing_images          = false;
        self::$products_id_to_sync          = [];
        self::$products_prices_updated      = [];
    }

    public static function checking_parameters() {
        if ( isset( $_POST['wn_amzs_btn_sync_prices'] ) ) {
            self::get_sync_prices_parameters();
        }

        if ( isset( $_POST['wn_amzs_btn_sync_images'] ) ) {
            self::get_sync_images_parameters();
        }

        self::$tab = isset( $_GET['tab'] ) ? $_GET['tab'] : self::$default_tab;
    }

    private static function get_sync_prices_parameters() {
        $products_count = isset( $_POST['products-count'] ) ? intval( $_POST['products-count'] ) : false;

        for( $i = 0; $i < $products_count; $i++) {
            if ( isset( $_POST['product-id'][$i] ) && $_POST['product-id'][$i] !== null ) {
                array_push( self::$products_id_to_sync, $_POST['product-id'][$i] );
            }
        }

        $response = WN_Products_Sync::sync_prices( self::$products_id_to_sync );

        if ( isset( $response['status'] ) && $response['status'] == 'error' ) {
            add_settings_error( 
                'Sync Prices', 
                'sync-prices', 
                $response['message'], 
                'error' 
            );
        } 
        else if ( empty( self::$products_id_to_sync ) ) {
            add_settings_error( 
                'Sync Prices', 
                'sync-prices', 
                'Please select at least one product to sync.', 
                'warning' 
            );
        }
        else {
            add_settings_error( 
                'Sync Prices', 
                'sync-prices', 
                $response['message'], 
                $response['status'] 
            );

            self::$products_prices_updated = $response['data'];
        }
    }

    private static function get_sync_images_parameters() {
        $response       = WN_Products_Sync::check_amazon_api_connection();
        $products_count = isset( $_POST['products-count'] ) ? intval( $_POST['products-count'] ) : false;

        for( $i = 0; $i < $products_count; $i++) {
            if ( isset( $_POST['product-id'][$i] ) && $_POST['product-id'][$i] !== null ) {
                array_push( self::$products_id_to_sync, $_POST['product-id'][$i] );
            }
        }

        if( isset( $response['status'] ) && $response['status'] == 'failure' ){
            add_settings_error( 
                'Sync Images', 
                'sync-images', 
                $response['message'], 
                'error' 
            );
        }
        else if ( empty( self::$products_id_to_sync ) ) {
            add_settings_error( 
                'Sync Images', 
                'sync-images', 
                'Please select at least one product to sync.', 
                'warning' 
            );
        }
        else if ( isset( $response['status'] ) && $response['status'] == 'success' ) {
            add_settings_error( 
                'Sync Images', 
                'sync-images', 
                'Syncronizing products images...', 
                'info' 
            );
            add_settings_error( 
                'Sync Images', 
                'sync-images', 
                'Do not close this tab during the processs.', 
                'warning' 
            );
            
            self::$syncronizing_images = true;
        }
    }

    public static function render_dashboard( $tab ) {
        include_once WN_AMZ_SYNC_DIR . '/templates/dashboard-template.php';  
    }

    public static function render_sync_prices_options() { 
        $asins_and_products = ( WN_Products_Sync::get_products_with_assin_number() )['asins_and_products'];

        ?>
        <h2>Sync Prices</h2>
        <form method="post" action="">
            <ul class="wn_amzs_sync_images_admin_logs_ul">
                <?php foreach( $asins_and_products as $variant_product ) :
                    $product        = wc_get_product( $variant_product );
                    $product_id     = $product->get_id();
                    $product_name   = $product->get_name();
                    $checked        = '';
                    $message        = '';
                    $status         = '';

                    if ( in_array( $product_id, self::$products_id_to_sync ) ) {
                        $checked = ' checked="checked"';
                    }

                    if ( !empty( self::$products_prices_updated ) && $checked != '' ) {
                        if ( array_key_exists( $product_id, self::$products_prices_updated ) ) {
                            $message    .= '<ul class="wn_amzs_sub_list">';
                            $status     = 'success';

                            foreach ( self::$products_prices_updated[$product_id] as $variation_name => $variation_price_data ) {
                                $status     = ( $variation_price_data['price'] !== 'error' ) ? 'success' : 'error';
                                $message    .= '<li>' . $variation_name . ' - (' . $variation_price_data['price'] . ') -> <strong>' . $variation_price_data['message'] . '</strong>';
                            }

                            $message .= '</ul>';
                        }
                        else {
                            $message = ' - error';
                            $status  = 'error';
                        }
                    }
                    echo '<li class="' . $status . '" ><input type="checkbox" name="product-id[]"  value="' . $product_id . '" ' . $checked . ' > ' . $product_name . $message . '</li>';
                endforeach; ?>
            </ul>
            <?php
            echo '<input type="hidden" name="products-count"  value="' . count( $asins_and_products ) . '">';
            submit_button( 'Sync Prices', 'primary', 'wn_amzs_btn_sync_prices' ); ?>
        </form>
        <?php 
    }

    public static function render_sync_images_options() {
        $asins_and_products = ( WN_Products_Sync::get_products_with_assin_number() )['asins_and_products'];
        ?>
        <div class="wn_amzs_sync_header">
            <h2>Sync Images</h2>
            <i class="wn_amzs_sync_spinner <?php echo ( !self::$syncronizing_images ) ? ' disabled' : '' ?>" style="background-image: url(<?php echo WN_AMZ_SYNC_URL . '/assets/svg/spinner.svg' ?>)"></i>
        </div>
        
        <div class="wn_amzs_sync_images_admin">
            <form method="post" action="">
                <ul class="wn_amzs_sync_images_admin_logs_ul">
                    <?php foreach( $asins_and_products as $variant_product ) :
                        $product = wc_get_product( $variant_product );
                        $checked = '';

                        if ( in_array( $product->get_id(), self::$products_id_to_sync ) ) {
                            $checked = ' checked="checked"';
                        }
                        echo '<li><input type="checkbox" name="product-id[]"  value="' . $product->get_id() . '" ' . $checked . ' > ' . $product->get_name() . '</li>';
                    endforeach; ?>
                </ul>
                <?php 
                
                if( self::$syncronizing_images ) { $extra_class = 'disabled'; } else { $extra_class = ''; }

                echo '<input type="hidden" name="products-count"  value="' . count( $asins_and_products ) . '">';
                submit_button( 'Sync Images', 'primary ' . $extra_class , 'wn_amzs_btn_sync_images' ); ?>
            </form>
        </div>
        <?php
    }

    public static function render_settings_options() {
        echo '<form method="post" action="options.php">';

        settings_fields( 'wn_amzs_settings_group' );
        do_settings_sections( 'wn_amzs_settings_section' );
        submit_button();

        echo '</form>';
    }

    public static function settings_page() {
        self::$settings_sections = [
            'wn_amzs_options' => [
                'label'     => 'Settings',
                'callback'  => 'general_options',
                'page'      => 'wn_amzs_settings_section',
                'fields'    => [
                    'lwa_client_id' => [
                        'option_group'      => 'wn_amzs_settings_group',
                        'label'             => 'LWA Client Id',
                        'type'              => 'text',
                    ],
                    'lwa_client_secret'     => [
                        'option_group'      => 'wn_amzs_settings_group',
                        'label'             => 'LWA Client Secret',
                        'type'              => 'text',
                    ],
                    'lwa_refresh_token'     => [
                        'option_group'      => 'wn_amzs_settings_group',
                        'label'             => 'LWA Refresh Token',
                        'type'              => 'text',
                    ],
                    'aws_access_key_id'     => [
                        'option_group'      => 'wn_amzs_settings_group',
                        'label'             => 'AWS Access Key ID',
                        'type'              => 'text',
                    ],
                    'aws_secret_access_key' => [
                        'option_group'      => 'wn_amzs_settings_group',
                        'label'             => 'AWS Secret Access Key',
                        'type'              => 'text',
                    ],
                    'marketplace_id' => [
                        'option_group'      => 'wn_amzs_settings_group',
                        'label'             => 'Marketplace ID',
                        'type'              => 'text',
                    ],
                ],
            ],
        ];

        foreach ( self::$settings_sections as $section_id => $section ) {
            add_settings_section( $section_id, $section['label'], array(self::class, $section['callback']), $section['page']);

            foreach ( $section['fields'] as $field_id => $field ) {
                register_setting( 
                    $field['option_group'], 
                    $field_id . '_value',
                );

                add_settings_field( 
                    'wn_amzs_field_' . $field_id, 
                    $field['label'], 
                    array(self::class, 'render_' . $field['type'] ), 
                    $section['page'], 
                    $section_id,
                    [ 'id' => $field_id ] 
                );
            }
        }
    }

    public static function general_options() {

    }

    public static function render_text( $args ) {
        $field_id   = $args['id'];
        $value      = get_option( $field_id . '_value' );
        $html       = '<input type="text" name="' . $field_id . '_value" value="' . $value . '"/>';

        echo $html;
    }

    public static function get_settings_sections() {
        return self::$settings_sections;
    }
}