var wn_mwh_sidebar_products_slider = function () {
    jQuery(document).ready(function($){
        //Products Carousel
        if (typeof $('.wn_mwh_rc_latest_posts_slider_wrapper').slick === "function") {
            $('#wn_mwh_rc_latest_posts_slider_wrapper').slick({
                arrows: true,
                dots: false,
                infinite: false,
                speed: 300,
                slidesToShow: 1,
                slidesToScroll: 1,
                appendArrows: $('.wn_mwh_rc_header'),
                prevArrow: '<span class="wn_mwh_latest_posts_slider wn_mwh_text__active">POPULAR</span>',
                nextArrow: '<span class="wn_mwh_latest_posts_slider">FEATURED</span>',
            }
            );
        }

        $('.wn_mwh_latest_posts_slider').on('click', function(){
            $('.wn_mwh_latest_posts_slider').removeClass('wn_mwh_text__active');
            $(this).addClass('wn_mwh_text__active');
        });
    });
}

var wn_mwh_products_carousel = function() {
    
    jQuery(document).ready(function($){
        //Products Carousel

        if (typeof $('.wn_mwh_wc_products_carousel').slick === "function") {

            $('.wn_mwh_wc_products_carousel').slick({
                arrows: true,
                dots: true,
                infinite: false,
                speed: 300,
                slidesToShow: 3,
                slidesToScroll: 3,
                responsive: [
                    {
                    breakpoint: 1024,
                    settings: {
                        slidesToShow: 3,
                        slidesToScroll: 3,
                        infinite: true,
                        dots: true
                    }
                    },
                    {
                    breakpoint: 600,
                    settings: {
                        slidesToShow: 2,
                        slidesToScroll: 2
                    }
                    },
                    {
                    breakpoint: 480,
                    settings: {
                        slidesToShow: 1,
                        slidesToScroll: 1
                    }
                    }
                ],
                appendDots: $('.wn_mwh_carousel_append_dots'),
                prevArrow: '<div type="button" data-role="none" class="wn_mwh_carousel_prev_button"><svg xmlns="http://www.w3.org/2000/svg" width="100%" height="100%" viewBox="0 0 24 24"><path d="M16.67 0l2.83 2.829-9.339 9.175 9.339 9.167-2.83 2.829-12.17-11.996z"/></svg></div>',
                nextArrow: '<div type="button" data-role="none" class="wn_mwh_carousel_next_button"><svg xmlns="http://www.w3.org/2000/svg" width="100%" height="100%" viewBox="0 0 24 24"><path d="M5 3l3.057-3 11.943 12-11.943 12-3.057-3 9-9z"/></svg></div>',
            }
            );

        }
        
    });
    
    
}

var wn_mwh_custom_script = function(second_call) {


    jQuery(document).ready(function($){

        if (second_call) {
            // $('.wn_posts_shower_wrapper').parent().addClass('wn_mwh_flex_class');
    
            $('.wn_posts_shower_wrapper').parent().children('ul').children('li').each(function(){
        
                $(this).mouseover(function(){
                    console.log($(this).text());
        
                    console.log($('.wn_mwh_posts_shower_elements[data="' + $(this).text() + '"]'));
                    // $('.wn_mwh_posts_shower_elements[data="' + $(this).text() + '"]').css('background-color', 'red');
        
                    hide_elements('.wn_mwh_posts_shower_elements');
                    $('.wn_mwh_posts_shower_elements[data="' + $(this).text() + '"]').removeClass('wn_mwh_hide');
        
                });
            });
        
            function hide_elements(elements) {
                $(elements).addClass('wn_mwh_hide');
            }
        
            //Filling the Stars
            var stars_active_color = '#e5a729';
            var stars_unselected_color = '#999';
            var star_v2 = '<svg class="wn_ct_icon_stars_styles" version="1.1" xmlns="http://www.w3.org/2000/svg" width="5" height="5" viewBox="0 0 24 24"> <defs> <linearGradient id="half_grad"> <stop offset="50%" stop-color="yellow"/> <stop offset="50%" stop-color="grey" stop-opacity="1" /> </linearGradient> </defs> <path d="M12 .587l3.668 7.568 8.332 1.151-6.064 5.828 1.48 8.279-7.416-3.967-7.417 3.967 1.481-8.279-6.064-5.828 8.332-1.151z"  fill="url(#half_grad)"/> </svg>';
            var id = 0;
            var id2 = 0;
            jQuery('.wn_ct_icon__stars').each(function(){
                var star_value = jQuery(this).attr('rating');
                var star_integer_value = Math.floor(star_value);
                var star_decimal_value = Math.round(((star_value % 1) + Number.EPSILON) * 100);
        
                var run_once = false;
        
                for(var i = 1; i <= 5; i++) {
                    var first = true;
                    if(i <= star_integer_value) {
                        jQuery(this).append(star_v2);
                        jQuery(this).children('svg').last().find('linearGradient').attr('id', 'half_grad_' + id + '_' + id2);
                        jQuery(this).children('svg').last().find('path').attr('fill', 'url(#half_grad_' + id + '_' + id2 + ')');
                        jQuery(this).children('svg').last().find('stop').each(function(){                            
                            jQuery(this).attr('offset', '100%');  
                            if(first) {
                                jQuery(this).attr('stop-color', stars_active_color);  
                                first = false;
                            }
                            else {
                                jQuery(this).attr('stop-color', stars_unselected_color);  
                                first = true;
                            }                                        
                        });                        
                    }
                    else {
                        if(!run_once){
                            if(star_decimal_value > 0) {
                                jQuery(this).append(star_v2);
                                jQuery(this).children('svg').last().find('linearGradient').attr('id', 'half_grad_' + id + '_' + id2);
                                jQuery(this).children('svg').last().find('path').attr('fill', 'url(#half_grad_' + id + '_' + id2 + ')');
                                jQuery(this).children('svg').last().find('stop').each(function(){                                
                                    jQuery(this).attr('offset',  star_decimal_value + '%'); 
                                    if(first) {
                                        jQuery(this).attr('stop-color', stars_active_color);  
                                        first = false;
                                    }
                                    else {
                                        jQuery(this).attr('stop-color', stars_unselected_color);  
                                        first = true;
                                    }                                    
                                });
                            }
                            else {
                                i--;
                            }
                            run_once = true;
                        }                        
                        else {
                            jQuery(this).append(star_v2);
                            jQuery(this).children('svg').last().find('linearGradient').attr('id', 'half_grad_' + id + '_' + id2);
                            jQuery(this).children('svg').last().find('path').attr('fill', 'url(#half_grad_' + id + '_' + id2 + ')');
        
                            jQuery(this).children('svg').last().find('stop').each(function(){                                                                
                                jQuery(this).attr('offset',  '0%');
                                if(first) {
                                    jQuery(this).attr('stop-color', stars_active_color);  
                                    first = false;
                                }
                                else {
                                    jQuery(this).attr('stop-color', stars_unselected_color);  
                                    first = true;
                                } 
                            });
                        }
                    }  
                    id2++;          
                } 
                id++;
            });

            

           
        }
        else {


            //Prepare Hero 
            $('.wn_mwh_rev_slider_wrapper .wn_mwh_hero_slider_bg_img:nth-child(2)').css('display', 'block');
        
            //Hero Slider

            if (typeof $('.wn_mwh_rev_slider_wrapper').slick === "function") {
                $('.wn_mwh_rev_slider_wrapper').slick({
                    arrows: false,
                    dots: false,
                    infinite: false,
                    speed: 300,
                    slidesToShow: 1,
                    slidesToScroll: 1,
                    autoplay: true,
                    autoplaySpeed: 5000,
                }
                );
            }
            

            //show the back to top button
            var offset = 220;
            var duration = 500;
            jQuery(window).scroll(function() {
                
                if(jQuery(window).outerWidth()+15 >= 970) { 
                                    
                    if (jQuery(this).scrollTop() > offset) {
                        jQuery('.back-to-top').fadeIn(duration);
                    } else {
                        jQuery('.back-to-top').fadeOut(duration);
                    }
                }
                
            });
            
            //to the scrolling
            jQuery('.back-to-top').click(function(event) {
                event.preventDefault();
                jQuery('html, body').animate({scrollTop: 0}, duration);
                return false;
            });
        

            var distance = $('.wn_mwh_menu_wrapper').offset().top,
            $window = $(window);

            $window.scroll(function() {
                if ( $window.scrollTop() > distance ) {
                    
                    if(!$('.wn_mwh_menu_pos_fixed').hasClass('wn_mwh_menu_pos_fixed__active')) {
                        $('.wn_mwh_menu_pos_fixed').addClass('wn_mwh_menu_pos_fixed__active');
                    }
                    
                    // console.log('Your div has reached the top');
                }
                else {
                    if($('.wn_mwh_menu_pos_fixed').hasClass('wn_mwh_menu_pos_fixed__active')) {
                        $('.wn_mwh_menu_pos_fixed').removeClass('wn_mwh_menu_pos_fixed__active');
                    }
                }
            });


            $('#wn_mwh_hamburger_link').on('click', function(e){
                e.preventDefault();
                $('.wn_dropdown_wrapper').toggleClass('wn_dropdown_wrapper__active');
            });
            
            
        }

    });
     
}

wn_mwh_custom_script(false);



class WnMwhFooter {

	constructor() {
		document.addEventListener( "DOMContentLoaded", () => {
            this.init();
		} );
	}

    init(){
        this.open_close_tabs_on_mobile();
    }

	open_close_tabs_on_mobile() {
        let elements = document.querySelectorAll('.wn_mwh_footer_menu h3');

        elements.forEach( function( item ){
            let footer_menu_element = item.closest('.wn_mwh_footer_menu');
            let ul_element          = footer_menu_element.querySelector('ul');
            let ul_height           = ul_element.offsetHeight;
            let h3_height           = item.offsetHeight;

            window.addEventListener('resize', function(){

                h3_height = item.offsetHeight;
                ul_height = ul_element.offsetHeight;

                if( window.innerWidth > 767 ) {
                    footer_menu_element.style.height = 'auto';
                }

            });

            if( window.innerWidth < 768 ) {
                footer_menu_element.style.height = h3_height + 'px';
            }

            item.addEventListener('click', function(){

                if(footer_menu_element.classList.contains('wn_mwh_footer_menu__active')) {

                    footer_menu_element.style.height = h3_height + 'px';
                    footer_menu_element.classList.remove('wn_mwh_footer_menu__active');

                }
                else {

                    footer_menu_element.style.height = ( ul_height + h3_height ) + 'px';
                    footer_menu_element.classList.add('wn_mwh_footer_menu__active');

                }

            }, false);

        });
	}

}

class WnFloatingCart {

    static instance(){
        if( !WnFloatingCart.instance_obj ){
            WnFloatingCart.instance_obj = this;
        }

        return WnFloatingCart.instance_obj;
    }

    static init_on_document_load_event() {
        document.addEventListener( "DOMContentLoaded", () => {
            this.init();
		} );
    }

    static check_floating_cart_element() {
        if( !this.floating_cart ) {
            return;
        }
    }

    static init(){
        this.floating_cart   = document.querySelector('.wn_mwh_floating_cart');
        this.items_counter   = null;

        this.check_floating_cart_element();
        this.register_floating_cart_events();
        this.register_cart_button();
    }

    static alert_notification( status, message ) {
        let notification_banner = this.floating_cart.querySelector( '.wn_mwh_floating_cart_not' );

        if ( !notification_banner ) {
            return;
        }

        notification_banner.querySelector( '.wn_mwh_floating_cart_not__message' ).innerHTML = message;
        notification_banner.setAttribute( 'class', 'wn_mwh_floating_cart_not ' + 'wn_mwh_not__active_' + status ); 

        setTimeout(() => {
            notification_banner.classList.remove( 'wn_mwh_not__active_success' );
            notification_banner.classList.remove( 'wn_mwh_not__active_failure' );
        }, 2500);
    }

    static register_cart_button() {
        let self            = this,
            cart_buttons    = document.querySelectorAll('.wn_mwh_cart_button');

        Array.prototype.forEach.call( cart_buttons, function( cart_button ){
            cart_button.removeEventListener( 'click', self.cart_button_click_handler);
            cart_button.addEventListener( 'click', self.cart_button_click_handler);
        });
    }

    static cart_button_click_handler(e) {
        let self = WnFloatingCart;

        //if click is insde the cart items do not close it
        if( this.classList.contains( 'wn_mwh_floating_cart' ) && ( e.target != self.floating_cart ) ) {
            return;                    
        }

        self.floating_cart.classList.toggle( 'wn_mwh_floating_cart__active' );
    }

    static update_floating_cart( floating_cart_inner_content ) {
        this.check_floating_cart_element();

        if ( !floating_cart_inner_content ) {
            console.log( 'WN Error => Inner content is missing' );
            return;
        }

        let inner_cart          = this.floating_cart.querySelector( '.wn_mwh_floating_cart_inner' );
        inner_cart.innerHTML    = floating_cart_inner_content;

        this.register_floating_cart_events();
    }

    static update_nav_menu_cart_button() {
        this.check_floating_cart_element();

        let nav_menu_cart_items_number  = document.querySelector( '.wn_mwh_menu_add_to_cart_items_number' ),
            cart_items_count            = ( this.items_counter == 0 ) ? '' : this.items_counter;
            
        nav_menu_cart_items_number.innerHTML  = cart_items_count;
    }

    static update_items_number() {
        this.items_counter = document.querySelectorAll( '.wn_mwh_floating_cart .wn_mwh_floating_cart_inner__body_item' ).length;
    }

    static show_the_floating_cart( with_spninner ) {
        this.check_floating_cart_element();
        if( !this.floating_cart.classList.contains('wn_mwh_floating_cart__active') ) {

            this.floating_cart.classList.add('wn_mwh_floating_cart__active');

            if( with_spninner ) {
                this.floating_cart.classList.add('wn_mwh_spinner__active');
            }
        }
    }

    static remove_spinner_from_floating_cart() {
        this.check_floating_cart_element();

        if( this.floating_cart.classList.contains('wn_mwh_spinner__active') ) {
            this.floating_cart.classList.remove('wn_mwh_spinner__active');
        }
    }

    static add_spinner_to_floating_cart() {
        this.check_floating_cart_element();

        if( !this.floating_cart.classList.contains('wn_mwh_spinner__active') ) {
            this.floating_cart.classList.add('wn_mwh_spinner__active');
        }
    }

    static register_floating_cart_events() {
        this.register_remove_items_events();
        this.register_uprade_to_subscription_event();
        this.register_purchase_dropdown_options();
        this.register_packs_dropdown_options();
        this.register_cart_button();
    }

    static register_packs_dropdown_options(){
        let packs_dropdown_selects = this.floating_cart.querySelectorAll( '.wn_mwh_floating_cart_inner__body_item_pack_options_select' );

        if ( !packs_dropdown_selects ) {
            return;
        }

        Array.prototype.forEach.call( packs_dropdown_selects, function( packs_dropdown_select ){
            packs_dropdown_select.addEventListener( 'change', function() {
                let _data = {
                        action:                 'wn_mwh_float_update_pack_option',
                        cart_item_id:           this.closest( '.wn_mwh_floating_cart_inner__body_item' ).getAttribute( 'cart-item-id' ),
                        option_variation_id:    this.value,
                        respond_to:             'WnFloatingCart.server_response_receiver',
                    };
        
                WnAjaxHandler.call_ajax_call_v2( _data );
                WnFloatingCart.add_spinner_to_floating_cart();
            } );
        });
    }

    static server_response_receiver( response ) {
        console.log( response );
        if ( response['content'] != null ) 
            this.update_floating_cart( response['content'] );
        this.remove_spinner_from_floating_cart();
        this.alert_notification( response['status'], response['message'] );
    }

    static register_purchase_dropdown_options(){
        let purchase_dropdown_select = this.floating_cart.querySelector( '.wn_mwh_floating_cart_inner__body_item_subscriptions_options_select' );

        if ( !purchase_dropdown_select ) {
            return;
        }
        
        purchase_dropdown_select.addEventListener( 'change', function() {
            let _data = {
                    action:             'wn_mwh_float_update_purchase_option',
                    cart_item_id:       this.closest( '.wn_mwh_floating_cart_inner__body_item' ).getAttribute( 'cart-item-id' ),
                    purchase_option:    this.value,
                    respond_to:         'WnFloatingCart.server_response_receiver',
                };
        
            WnAjaxHandler.call_ajax_call_v2( _data );
            WnFloatingCart.add_spinner_to_floating_cart();
        } );
    }

    static register_uprade_to_subscription_event() {
        let self                 = this,
            upgrade_to_subs_btns = this.floating_cart.querySelectorAll( '.wn_mwh_floating_cart_inner__body_item_content_btn_subscribe' );

        Array.prototype.forEach.call( upgrade_to_subs_btns, function( upgrade_to_subs_btn ){
            upgrade_to_subs_btn.addEventListener( 'click', self.upgrade_to_subs_handler );
        });
    }

    static upgrade_to_subs_handler() {
        let _data = {
            action:             'wn_mwh_float_upgrade_to_subscription',
            cart_item_id:       this.closest( '.wn_mwh_floating_cart_inner__body_item' ).getAttribute( 'cart-item-id' ),
            respond_to:         'WnFloatingCart.server_response_receiver',
        };

        WnAjaxHandler.call_ajax_call_v2( _data );
        WnFloatingCart.add_spinner_to_floating_cart();
    }

    static register_remove_items_events() {
        let self = this;
        let remove_items_buttons = this.floating_cart.querySelectorAll( '.wn_mwh_floating_cart_inner__remove_item' );

        Array.prototype.forEach.call( remove_items_buttons, function( remove_item_btn ){
            remove_item_btn.addEventListener( 'click', self.remove_item_btn_handler );
        });
    }

    static remove_item_btn_handler() {
        let _data = {
                action:         'wn_mwh_float_remove_from_cart',
                product_id:     this.closest( '.wn_mwh_floating_cart_inner__body_item' ).getAttribute( 'product-id' ),
                cart_item_id:   this.closest( '.wn_mwh_floating_cart_inner__body_item' ).getAttribute( 'cart-item-id' ),
                respond_to:     'WnFloatingCart.remove_item_from_cart_receiver',
            };

        WnAjaxHandler.call_ajax_call_v2( _data );
        WnFloatingCart.add_spinner_to_floating_cart();
    }

    static remove_item_from_cart_receiver( response ) {
        if ( response['content'] != null ) {
            this.update_floating_cart( response['content'] );
            this.update_items_number();
            this.update_nav_menu_cart_button();
        }

        this.remove_spinner_from_floating_cart();
        this.alert_notification( response['status'], response['message'] );
    }
}

new WnMwhFooter();
WnFloatingCart.instance().init_on_document_load_event();




