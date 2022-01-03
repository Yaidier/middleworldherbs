jQuery(document).ready(function($){
    
} );

class WnCustomAddToCart {

    constructor() {
		document.addEventListener( "DOMContentLoaded", () => {
            this.init();
		} );
	}

    init() {
        this.add_to_cart            = document.querySelector( '.wn_custom_form_wrapper' );

        if( !this.add_to_cart ) 
            return;

        this.subscriptions_wrapper  = this.add_to_cart.querySelector( '.wn-every' );
        this.subscriptions_select   = this.add_to_cart.querySelector( '.wn-every .wn-every_select' );
        this.packs_wrapper          = this.add_to_cart.querySelector( '.wn-quatity' );
        this.packs_lis              = this.add_to_cart.querySelectorAll( '.wn-quatity_select .wn-quatity_dropdown > ul > li' ),
        this.old_value_el           = this.add_to_cart.querySelector( '.wn_mwh_price_wrapper__old .wn_mwh_price_value__old' );

        this.register_purchase_option_selector();
        this.register_pack_options_selector();
        this.register_subcription_selector();
    }

    register_subcription_selector() {
        let self = this;

        this.subscriptions_select.addEventListener( 'change', function(e) {
            let base_pack_price_value       = self.add_to_cart.querySelectorAll( '.wn-quatity_dropdown > ul > li' )[0].getAttribute( 'price-per-unit' ),
                option_el                   = this.querySelector( '[value="' + this.value + '"]' ),
                percentage_discount         = parseFloat( option_el.getAttribute( 'subscription-discount' ) ),
                price_with_dicount          = base_pack_price_value - ( ( percentage_discount / 100 ) * parseFloat( base_pack_price_value ) ),
                price_with_dicount_round    = price_with_dicount.toFixed( 2 );

            self.update_price( price_with_dicount_round );
        } );

    }

    register_purchase_option_selector() {
        let self = this,
            purchase_options_btns = this.add_to_cart.querySelectorAll( '.wn_purshase_type > li' );

        Array.prototype.forEach.call(purchase_options_btns, function(li, i){           
            li.addEventListener( 'click', function( e ) {
                if ( this.classList.contains( 'subscription_purshase_option' ) ) {
                    self.subscriptions_wrapper.style.display = 'block';
                    self.packs_wrapper.style.display = 'none';
                    self.subscriptions_select.value = '1_month';
                    self.subscriptions_select.dispatchEvent( new Event( 'change' ) );
                    self.old_value_el.innerHTML = '';
                }
                else {
                    self.subscriptions_wrapper.style.display = 'none';
                    self.packs_wrapper.style.display = 'block';
                    self.packs_lis[0].dispatchEvent( new Event( 'click' ) );
                }
            } )
        });
    }

    register_pack_options_selector() {
        let self = this;

        Array.prototype.forEach.call( this.packs_lis, function( li ){
            li.addEventListener( 'click', function( e ) {
                let varaition_price = this.getAttribute( 'variation-price' ),
                    base_price      = false;

                self.update_price( varaition_price );

                if ( base_price = self.check_if_price_is_better_deal( this ) ) {
                    let items_number    = parseInt( this.getAttribute( 'items-number' ) ),
                        old_value       = parseFloat( base_price ) * items_number;
                        
                    self.old_value_el.innerHTML = old_value;
                }
                else {
                    self.old_value_el.innerHTML = '';
                }
            } );
        } ); 
    }

    update_price( new_price_value ) {
        let price_value_element = this.add_to_cart.querySelector( '.wn-addtocart_total .wn_mwh_price_wrapper .wn_mwh_price_value' );
        price_value_element.innerHTML = new_price_value;
    }

    check_if_price_is_better_deal( li ) {
        //getting the base pack price value
        let base_pack_price_value = li.parentNode.querySelectorAll( 'li' )[0].getAttribute( 'price-per-unit' ),
            this_li_price_value = li.getAttribute( 'price-per-unit' );

        if ( this_li_price_value < base_pack_price_value ) {
            return base_pack_price_value ;
        }
        else {
            false;
        }
    }
}

class WnFloatAddToCart {

    constructor() {
		document.addEventListener( "DOMContentLoaded", () => {
            this.init();
		} );
	}

    init() {
        let add_to_cart_buttons = document.querySelectorAll( '.wn-addtocart_add_to_cart_button' );

        Array.prototype.forEach.call(add_to_cart_buttons, function( button ){
            button.addEventListener( 'click', function( e ) {
                let active_purchase_option = document.querySelector( '.wn_custom_form_wrapper .wn_purshase_type > li.wn_varselector__aactive' ),
                    _data = {
                        action:         'wn_mwh_float_add_to_cart',
                        product_id:     document.querySelector( '.wn_custom_form_wrapper' ).getAttribute( 'product-id' ),
                        variation_id:   active_purchase_option.classList.contains( 'subscription_purshase_option' ) ? document.querySelectorAll( '.wn_custom_form_wrapper .wn-quatity_dropdown > ul > li' )[0].getAttribute( 'value' ) : document.querySelector( '.wn_custom_form_wrapper .wn-quatity_dropdown > ul > li.wn_varselector__aactive' ).getAttribute( 'value' ),
                        subscription:   active_purchase_option.classList.contains( 'subscription_purshase_option' ) ? document.querySelector( '.wn-every_select' ).value : false,
                        quantity:       1,
                        respond_to:     'WnFloatAddToCart.response_receiver',
                    };

                WnAjaxHandler.call_ajax_call_v2( _data );
                WnFloatingCart.show_the_floating_cart( true );
            }, false);
        });
    }

    static response_receiver( response ) {
        if ( response['status'] == 'success' ) {
            WnFloatingCart.update_floating_cart( response['content'] );
            WnFloatingCart.update_items_number();
            WnFloatingCart.update_nav_menu_cart_button();
        }

        WnFloatingCart.remove_spinner_from_floating_cart();
        WnFloatingCart.alert_notification( response['status'], response['message'] );
    }
}

class WnGalleryHover {

    constructor() {
        document.addEventListener( "DOMContentLoaded", () => {
            this.init();
        } );
    }

    init() {
        jQuery('.wn_sp_gallery_imgs').on('mouseover', function(){
            //Adding the box-shadow css property to the selected gallery
            jQuery('.wn_sp_gallery_imgs').removeClass('wn_sp_gallery_imgs__active');
            jQuery(this).addClass('wn_sp_gallery_imgs__active');
    
            //Displaying the clicked gallery
            const img_index = jQuery(this).attr('index');
            jQuery('.wn_sp_featured_img').removeClass('wn_sp_featured_img__active');    
            jQuery('.wn_sp_featured_img[index="' + img_index + '"]').addClass('wn_sp_featured_img__active');
        });
    }
}

class WnVariableSelectorPlugin {

    constructor() {
        document.addEventListener( "DOMContentLoaded", () => {
            this.setttin_up_the_jquery_plugin();
            this.int();
        } );
    }

    setttin_up_the_jquery_plugin() {
        jQuery.fn.wnVariableSelector = function(options)  {
            let breakpoints_values = [],
                active_direction,
                max_width;
     
            active_direction = options.direction;
            max_width        = options.max_width;
    
            if ( options.breakpoints ) {
                Object.entries(options.breakpoints).forEach( ( [key, value] ) => {
                    breakpoints_values.push( key );
                } );
            }
    
            breakpoints_values.sort( function( a, b ) { return b - a } );
    
            let this_ul = jQuery(this);
            let first_child_widht = jQuery(this).find('li:first-child').outerWidth(true);
            let first_child_pos = jQuery(this).find('li:first-child').position();
    
            jQuery(this).prepend('<div class="wn_var_selector_float_back" style="left:' + first_child_pos.left + 'px; width:' + first_child_widht +'px;"></div>');
    
            function resposition_the_float_back( li ) {
                let li_pos          = jQuery(li).position();
                let this_li_width   = ( jQuery(li).outerWidth(true) );
                let this_li_height  = 0;
    
                if ( !active_direction || ( active_direction == 'row' ) ) {
                    (this_ul).css('flex-direction', 'row');
                    this_li_height = jQuery(this_ul).outerHeight(true) - 10;
                    li_pos.top = 5;
                }
    
                if ( active_direction == 'column' ) {
                    (this_ul).css('flex-direction', 'column');
                    this_li_height = jQuery(li).outerHeight(true) - 10;
                    this_li_width -= 10;
                    li_pos.top += 5;
                    li_pos.left += 5;
                }
    
                jQuery(this_ul).find('.wn_var_selector_float_back').css('width', this_li_width + 'px');
                jQuery(this_ul).find('.wn_var_selector_float_back').css('height', this_li_height + 'px');
    
                jQuery(this_ul).find('.wn_var_selector_float_back').css('top', li_pos.top + 'px');
                jQuery(this_ul).find('.wn_var_selector_float_back').css('left', li_pos.left + 'px');
    
                jQuery(this_ul).find('li').removeClass('wn_varselector__aactive');
                jQuery(li).addClass('wn_varselector__aactive');
            }
    
            //Registering click event
            jQuery(this).find('li').on('click', function(){
                jQuery(this_ul).find('.wn_var_selector_float_back').css('transition', '0.4s ease');
                resposition_the_float_back( this );
            });
    
            jQuery(window).on('resize', function(){
                const window_width = jQuery(this).width();
    
                if ( window_width < breakpoints_values[0] ) {
                    breakpoints_values.forEach( function(index, item){
                        if( window_width < breakpoints_values[item] ) {
                            active_direction = options.breakpoints[breakpoints_values[item]].direction;
                            max_width        = options.breakpoints[breakpoints_values[item]].max_width;
                        }
                    });
                }
                else {
                    active_direction = options.direction;
                    max_width        = options.max_width;
                }
    
                if( jQuery(this_ul).closest('.wn-quatity').css('display') == 'none' ) {
                    return;
                }
    
                let active_li = jQuery(this_ul).find('li.wn_varselector__aactive');
    
                jQuery(this_ul).find('.wn_var_selector_float_back').css('transition', 'unset');
                resposition_the_float_back( active_li );
            });
        }
    }
    int() {
        if( jQuery('.wn-purshase_selector > ul').length ) {
            jQuery('.wn-purshase_selector > ul').wnVariableSelector(
                {
                    direction: 'row',
                    max_width: '100%',
                    breakpoints: {
                        860: {
                            direction: 'column',
                        },
                        769: {
                            direction: 'row',
                            max_width: '500px',
                        },
                        420: {
                            direction: 'column',
                            max_width: '100%',
                        }
                    }
                }
            );
        }
        if( jQuery('.wn-quatity_dropdown > ul').length ) {
            jQuery('.wn-quatity_dropdown > ul').wnVariableSelector(
                {
                    direction: 'row',
                    max_width: '426px',
                    breakpoints: {
                        769: {
                            max_width: '400px',
                        }
                    }
                }
            );
        }
    }
}



new WnCustomAddToCart();
new WnVariableSelectorPlugin();
new WnFloatAddToCart();
new WnGalleryHover();
