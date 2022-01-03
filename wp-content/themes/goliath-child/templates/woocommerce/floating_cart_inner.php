<?php 

$cart_items = WC()->cart->get_cart();
$cart_items_output = ( count( $cart_items ) > 1 ) ? count( $cart_items ) . ' items' : ( ( count( $cart_items ) == 0 ) ? '' : count( $cart_items ) . ' item' ) ;
$cart_total = WC()->cart->get_cart_total();

?>

<div class="wn_mwh_floating_cart_inner__header">
    <div class="wn_mwh_floating_cart_inner__header_top">
        <span>Your Cart</span>
        <svg class="wn_mwh_cart_button" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><path d="M23.954 21.03l-9.184-9.095 9.092-9.174-2.832-2.807-9.09 9.179-9.176-9.088-2.81 2.81 9.186 9.105-9.095 9.184 2.81 2.81 9.112-9.192 9.18 9.1z"/></svg>
    </div>
    <div class="wn_mwh_floating_cart_inner__header_free_shipment_banner">
        <svg width="28" height="21" xmlns="http://www.w3.org/2000/svg">
            <g fill-rule="nonzero" fill="none">
                <path d="M1.469 14.301c0-.165.037-.327.109-.475l2.077-4.304a.571.571 0 01.516-.324h4.135v7.289h-.419a2.961 2.961 0 00-2.856-2.218 2.953 2.953 0 00-2.85 2.218h-.35a.361.361 0 01-.362-.361V14.3zm2.078 2.92c0-.823.661-1.483 1.484-1.483.822 0 1.49.66 1.49 1.483a1.486 1.486 0 11-2.974 0zm12.94 0c0-.264.073-.521.198-.734a1.46 1.46 0 011.285-.749c.558 0 1.043.301 1.293.749a1.462 1.462 0 010 1.468 1.48 1.48 0 01-1.293.756 1.467 1.467 0 01-1.285-.756 1.463 1.463 0 01-.198-.734zM0 14.067v2.702c0 .655.531 1.186 1.186 1.186h.995a2.944 2.944 0 002.85 2.225c1.38 0 2.526-.947 2.856-2.225h7.227a2.953 2.953 0 002.856 2.225c1.374 0 2.541-.947 2.864-2.225h1.3c.755 0 1.366-.61 1.366-1.365v-5.954a5.96 5.96 0 01-1.075.103c-.133 0-.263-.012-.394-.02v5.355a.414.414 0 01-.413.413h-.784a2.96 2.96 0 00-2.826-2.215h-.075a2.945 2.945 0 00-2.82 2.215h-4.925a.414.414 0 01-.414-.413V5.882c0-.228.186-.413.414-.413H16.527a5.983 5.983 0 01-.04-.667c0-.273.025-.54.06-.802H9.671c-.754 0-1.365.61-1.365 1.365V7.73h-4.74c-.415 0-.795.238-.975.612L.15 13.41c-.1.205-.151.43-.151.658z" ></path>
                <path d="M24.744 3.744L22.36 6.46a.535.535 0 01-.39.182h-.011a.532.532 0 01-.385-.165L20.272 5.12a.533.533 0 11.77-.738l.9.938 2-2.279a.534.534 0 01.802.704M22.5 0a4.75 4.75 0 100 9.5 4.75 4.75 0 000-9.5"></path>
            </g>
        </svg>
        <p>You qualify for free shipping!</p>
    </div>
</div>
<div class="wn_mwh_floating_cart_inner__body">
    <span class="wn_mwh_floating_cart_inner__body_items_counter"><?php echo esc_attr( $cart_items_output ); ?></span>

    <?php foreach( $cart_items as $key => $item ) { 

        $cart_item_id           = $key;
        $product_id             = $item['product_id'];
        $_product               = wc_get_product( $product_id );
        $attachment_img_element = get_the_post_thumbnail( $product_id );
        $product_name           = $_product->get_title();
        $price                  = get_woocommerce_currency_symbol() . $item['line_total'];
        $total_checkout_price   = get_woocommerce_currency_symbol() . $item['line_total'];
        $quantity               = $item["quantity"];
        $is_subscription        = false;
        $subscriptions_schemes  = array_values( \WCS_ATT_Product_Schemes::get_subscription_schemes( $item[ 'data' ] ) );

        if( $item["wcsatt_data"]["active_subscription_scheme"] ) {
            $is_subscription        = true;
            $scheme_key             = $item["wcsatt_data"]["active_subscription_scheme"];
            $selected_option        = 'Deliver every ' . str_replace( '_', ' ', $scheme_key );
            $price                  = $price . '<span class="wn_mwh_floating_cart_inner__body_item_content_price_suffix"> / ' . str_replace( '_', ' ', $item["wcsatt_data"]["active_subscription_scheme"] . '</span>' );
            
        }
        else {
            $current_variation_id   = $item['variation_id'];
            $selected_option        = $item['variation']['attribute_choose-quantity'];
            $product_variations     = $_product->get_available_variations();
        }
        ?>

        <div class="wn_mwh_floating_cart_inner__body_item" cart-item-id="<?php echo esc_attr( $cart_item_id ); ?>" product-id="<?php echo esc_attr( $product_id ); ?>" >
            <?php echo $attachment_img_element; ?>
            <div class="wn_mwh_floating_cart_inner__body_item_content">
                <div class="wn_mwh_floating_cart_inner__body_item_content_title_wrapper">
                    <h3><?php echo esc_attr( $product_name );?></h3>
                    <svg class="wn_mwh_floating_cart_inner__remove_item" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><path d="M9 13v6c0 .552-.448 1-1 1s-1-.448-1-1v-6c0-.552.448-1 1-1s1 .448 1 1zm7-1c-.552 0-1 .448-1 1v6c0 .552.448 1 1 1s1-.448 1-1v-6c0-.552-.448-1-1-1zm-4 0c-.552 0-1 .448-1 1v6c0 .552.448 1 1 1s1-.448 1-1v-6c0-.552-.448-1-1-1zm4.333-8.623c-.882-.184-1.373-1.409-1.189-2.291l-5.203-1.086c-.184.883-1.123 1.81-2.004 1.625l-5.528-1.099-.409 1.958 19.591 4.099.409-1.958-5.667-1.248zm4.667 4.623v16h-18v-16h18zm-2 14v-12h-14v12h14z"/></svg>
                </div>
                <p><?php // echo esc_attr( $selected_option ); ?></p>
                <div class="wn_mwh_floating_cart_inner__body_item_content_bottom">
                    <?php if ( ! $is_subscription ) : ?>
                        <div class="wn_mwh_floating_cart_inner__body_item_pack_options">
                            <select class="wn_mwh_floating_cart_inner__body_item_pack_options_select">
                                <?php foreach ( $product_variations as $variation ) :
                                    $variation_id       = $variation['variation_id'];
                                    $variation_output   = $variation['attributes']['attribute_choose-quantity'];
                                    ?>
                                    <option class="wn_mwh_floating_cart_pack_options" value="<?php echo esc_attr( $variation_id ); ?>"<?php echo ( $current_variation_id == $variation_id ) ? 'selected="selected"' : ''; ?>><?php echo esc_attr( $variation_output ); ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    <?php else : ?>
                        <!-- <div class="wn_mwh_floating_cart_inner__body_item_content_empty"> -->
                            <!-- empty div just to keep the price div aligned to the right -->
                        <!-- </div> -->
                    <?php endif; ?>

                    <div style="display: none" class="wn_mwh_floating_cart_inner__body_item_content_quantity">
                        <button class="wn_mwh_floating_cart_inner__body_item_content_quantity_btn_less"></button>
                        <span class="wn_mwh_floating_cart_inner__body_item_content_quantity_value"><?php echo esc_attr( $quantity ); ?></span>
                        <button class="wn_mwh_floating_cart_inner__body_item_content_quantity_btn_more"></button>
                    </div>

                    <span class="wn_mwh_floating_cart_inner__body_item_content_price" ><?php echo $price ; ?></span>
                </div>
            </div>
            <?php if( !$is_subscription ) : ?>
                <?php if( !empty( $subscriptions_schemes ) ) : ?>
                    <button class="wn_mwh_floating_cart_inner__body_item_content_btn_subscribe">Upgrade to subscription & save 10%</button>
                <?php endif; ?>
            <?php else : ?>
                <div class="wn_mwh_floating_cart_inner__body_item_subscriptions_options">
                    <select class="wn_mwh_floating_cart_inner__body_item_subscriptions_options_select">
                        <optgroup label="One Time">
                            <option class="wn_mwh_floating_cart_purchase_options" value="one_time">One Time</option>
                        </optgroup>
                        <optgroup label="Subscribe and Save">
                            <?php foreach ( $subscriptions_schemes as $subscriptions_scheme ) :
                                $key = $subscriptions_scheme->get_key();
                                $key_output = str_replace('_', ' ', $key);
                                ?>
                                <option class="wn_mwh_floating_cart_purchase_options" value="<?php echo esc_attr( $key ); ?>" <?php echo ( $scheme_key == $key ) ? 'selected="selected"' : '' ?> >Deliver every <?php echo esc_attr( $key_output ); ?></option>
                            <?php endforeach; ?>
                        </optgroup>
                    </select>
                </div>
            <?php endif ?>
        </div>

    <?php } ?>

</div>

<?php if ( count( $cart_items ) > 0 ) : ?>
    <div class="wn_mwh_floating_cart_inner__footer">
        <button class="wn_mwh_floating_cart_inner__footer_btn_checkout">Checkout - <?php echo $cart_total ; ?></button>
        <p>*Shipping and Taxes will be calculated at checkout.</p>
    </div>
<?php else: ?>
    <div class="wn_mwh_floating_cart_inner__empty_message">
        <span>Your cart is empty</span>
        <button class="">CONTINUE SHOPPING</button>
    </div>
<?php endif ?>

<div class="wn_mwh_floating_cart_inner_loading_spinner" style="--wn_mwh_spinner_url: url(<?php echo get_stylesheet_directory_uri() . '/theme/assets/images/spineer.svg' ?>)" ></div>