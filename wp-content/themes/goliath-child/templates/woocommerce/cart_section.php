<?php
/**
 * @see \App\WC::add_floating_cart()
 * @see \App\WC::add_floating_cart()
 * 
 * */

$cart_items_count = count( WC()->cart->get_cart() );

if( $cart_items_count == 0 ) {
    $cart_items_count = '';
}

?>

<li class="wn_mwh_menu_add_to_cart">
    <div class="wn_mwh_menu_add_to_cart_cart wn_mwh_cart_button">
        <span class="wn_mwh_menu_add_to_cart_items_number"><?php echo esc_attr( $cart_items_count ); ?></span>
        <i class="wn_mwh_menu_add_to_cart_icon"></i>
    </div>
</li>