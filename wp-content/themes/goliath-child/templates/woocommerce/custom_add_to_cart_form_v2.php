<?php 
/**
 * 
 * 
 */

global $product;

$product_id             = $product->get_id();
$product_variations     = $product->get_available_variations();
$stock_qunatity         = $product->get_stock_quantity();
$subscriptions_schemes  = \WCS_ATT_Product_Schemes::get_subscription_schemes( $product );
$subscriptions_schemes_ = array_values( $subscriptions_schemes );
$subscription_discount  = isset( $subscriptions_schemes_[0] ) ? $subscriptions_schemes_[0]->get_discount() : '';

?>

<div product-id="<?php echo esc_attr( $product_id ); ?>" class="wn_custom_form_wrapper">
    <div class="wn-purshase_selector">
        <ul class="wn_var_selector wn_purshase_type">
            <li class="wn_one_time_purshase_option wn_varselector__aactive">One-time Purshase</li>
            <?php if ( $subscriptions_schemes ) : ?>
                <li class="subscription_purshase_option">Subscribe & Save (<?php echo esc_attr( $subscription_discount ); ?>% Off)</li>
            <?php endif; ?>
        </ul>
    </div>
 
    <div class="wn-quatity">
        <label for="wn-quatity_select">CHOOSE QUANTITY</label>
        <div id="wn_choose_quantity" class="wn-quatity_select">
            <!-- <span>text generated in single-product.js</span> -->
            <div class="wn-quatity_dropdown">
                <ul class="wn_var_selector">
                    <?php 
                    $first_li = true;
                    foreach ( $product_variations as $variation ) :
                        $variation_id       = $variation['variation_id'];
                        $variation_output   = $variation['attributes']['attribute_choose-quantity'];
                        $variation_price    = $variation['display_price'];
                        $items_number       = intval( str_replace( '-Pack', '', $variation_output ) );
                        $var_price_per_unit = round( $variation_price / $items_number , 2 );
                        ?>
                        <li class="<?php echo ( $first_li ) ? 'wn_varselector__aactive' : '' ?>" items-number="<?php echo esc_attr( $items_number ); ?>" price-per-unit="<?php echo esc_attr( $var_price_per_unit ); ?>" variation-price="<?php echo esc_attr( $variation_price ); ?>" value="<?php echo esc_attr( $variation_id ); ?>"><?php echo esc_attr( $variation_output ); ?><br>(<?php echo get_woocommerce_currency_symbol() . esc_attr( $var_price_per_unit ); ?> <?php echo ( $var_price_per_unit != $variation_price ) ? '/ UNIT' : ''; ?>)<br></li>
                        <?php 
                        $first_li = false;
                    endforeach; 
                    ?>
                </ul>
            </div>
        </div>
    </div>

    <div class="wn-every">
        <label for="wn-every_select">DELIVER EVERY</label>
        <select class="wn-every_select" name="" id="">
            <?php foreach ( $subscriptions_schemes as $subscriptions_scheme ) :
                $key        = $subscriptions_scheme->get_key();
                $key_output = str_replace('_', ' ', $key);
                $discount   = $subscriptions_scheme->get_discount();
                ?>
                <option class="" subscription-discount="<?php echo esc_attr( $discount ); ?>" value="<?php echo esc_attr( $key ); ?>" >&nbsp<?php echo esc_attr( $key_output ); ?></option>
            <?php endforeach; ?>
        </select>
    </div>
    <div class="wn-addtocart">
        <label>TOTAL</label>
        <div class="wn-addtocart_button_wrapper">
            <div class="wn-addtocart_total">
                <span class="wn_mwh_price_wrapper__old"><?php echo '<span class="wn_mwh_price_value__old"></span>'; ?></span>
                <span class="wn_mwh_price_wrapper" ><?php echo esc_attr( get_woocommerce_currency_symbol() ) . '<span class="wn_mwh_price_value">' . $product_variations[0]['display_price'] . '</span>'; ?></span>
            </div>
            <button class="wn-addtocart_add_to_cart_button <?php echo ( $stock_qunatity < 1 ) ? 'wn-addtocart_add_to_cart_button--disabled' : '' ?>"><?php echo ( $stock_qunatity < 1 ) ? 'Out of stock' : 'Add to cart'; ?></button>
        </div>
    </div>

    <div class="wn_guarantee_banner">
        <i class="wn_guarantee_icon" style="background-image: url('<?php echo get_stylesheet_directory_uri();?>/theme/assets/images/woocommerce/custom-add-to-cart-form/guarntee-icon.png');"></i>
        <span>60-DAY MONEY BACK GUARANTEE</span>
    </div>
</div>
