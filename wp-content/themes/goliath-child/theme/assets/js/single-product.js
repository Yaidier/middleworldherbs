jQuery(document).ready(function($){

    let is_subscription_locked_to_one_pack = true;
 

    $.fn.wnVariableSelector = function(options)  {

        let breakpoints_values = [],
            active_direction,
            max_width;
 
        active_direction = options.direction;
        max_width        = options.max_width;

        if ( options.breakpoints ) {

            Object.entries(options.breakpoints).forEach(([key, value]) => {
                breakpoints_values.push( key );
            });

        }

        breakpoints_values.sort( function(a, b){return b - a} );

        let this_ul = $(this);
        let first_child_widht = $(this).find('li:first-child').outerWidth(true);
        let first_child_pos = $(this).find('li:first-child').position();

        

        $(this).prepend('<div class="wn_var_selector_float_back" style="left:' + first_child_pos.left + 'px; width:' + first_child_widht +'px;"></div>');

        function resposition_the_float_back( li ) {

            let li_pos = $(li).position();
            let this_li_width = ($(li).outerWidth(true) );
            let this_li_height;

            if ( !active_direction || ( active_direction == 'row' ) ) {
                (this_ul).css('flex-direction', 'row');
                this_li_height = $(this_ul).outerHeight(true) - 10;
                li_pos.top = 5;
            }

            if ( active_direction == 'column' ) {
                (this_ul).css('flex-direction', 'column');
                this_li_height = $(li).outerHeight(true) - 10;
                this_li_width -= 10;
                li_pos.top += 5;
                li_pos.left += 5;
            }

            $(this_ul).find('.wn_var_selector_float_back').css('width', this_li_width + 'px');
            $(this_ul).find('.wn_var_selector_float_back').css('height', this_li_height + 'px');

            $(this_ul).find('.wn_var_selector_float_back').css('top', li_pos.top + 'px');
            $(this_ul).find('.wn_var_selector_float_back').css('left', li_pos.left + 'px');

            $(this_ul).find('li').removeClass('wn_varselector__aactive');
            $(li).addClass('wn_varselector__aactive');

        }

        //Registering click event
        $(this).find('li').on('click', function(){

            $(this_ul).find('.wn_var_selector_float_back').css('transition', '0.4s ease');
            resposition_the_float_back( this );

        });

        $(window).on('resize', function(){

            const window_width = $(this).width();

            if ( window_width < breakpoints_values[0] ) {

                breakpoints_values.forEach(function(index, item){

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

            if( $(this_ul).closest('.wn-quatity').css('display') == 'none' ) {
                return;
            }

            let active_li = $(this_ul).find('li.wn_varselector__aactive');
            $(this_ul).css('max-width', max_width);

            $(this_ul).find('.wn_var_selector_float_back').css('transition', 'unset');
            resposition_the_float_back( active_li );

        });
    
    }

    // On mouse hover event
    function wn_sp_gallery_onmousehover() {
        $('.wn_sp_gallery_imgs').on('mouseover', function(){

            //Adding the box-shadow css property to the selected gallery
            $('.wn_sp_gallery_imgs').removeClass('wn_sp_gallery_imgs__active');
            $(this).addClass('wn_sp_gallery_imgs__active');
    
            //Displaying the clicked gallery
            const img_index = $(this).attr('index');
            $('.wn_sp_featured_img').removeClass('wn_sp_featured_img__active');    
            $('.wn_sp_featured_img[index="' + img_index + '"]').addClass('wn_sp_featured_img__active');
    
        });
    }

    function restric_subscriptios_to_one_pack () {

        let cont = 0;

        var check_element_to_attach_event =  setInterval(() => {

            if ( $('.wcsatt-options-prompt-radios').length) {


                $('.variations_form').on('click', '.wcsatt-options-prompt-radios > li > label', function() {

                    if ( !$(this).hasClass( 'wcsatt-options-prompt-label-one-time' ) ) {

                        $('#choose-quantity').val('1-Pack');
                        $('#choose-quantity').prop('disabled', 'disabled');

                        setTimeout(() => {
                            $('#choose-quantity').trigger('change');
                            filling_deliver_every_list();
                        }, 100);

                    }
                    else {

                        $('#choose-quantity').prop('disabled', false);

                    }
        
                });

                clearInterval( check_element_to_attach_event );

            }
            
            if ( cont >= 5 ) {

                clearInterval( check_element_to_attach_event );
                
            }

            cont++;

        }, 1000);
        
    }

    function variation_hook () {


        $( ".variations_form" ).on( "woocommerce_variation_select_change", function () {
            // Fires whenever variation selects are changed
            
        } );

    }

    function choose_quantity_click_event() {

        $('.wn-quatity_dropdown > ul > li').on('click', function(){

            const li_value = $(this).attr('value');

            $('#choose-quantity').val(li_value);

            setTimeout(() => {

                $('#choose-quantity').trigger('change');
                filling_deliver_every_list();

            }, 100);

        });
    }
    function choose_every_click_event() {

        $('.wn-every_dropdown > ul').on('click', ' > li', function(){

            const li_value = $(this).attr('value');

            $( this ).closest('ul').find( 'li' ).removeClass( 'active' );
            $( this ).addClass( 'active' );

            $('.wcsatt-options-product-dropdown').val(li_value);

            setTimeout(() => {

                $('.wcsatt-options-product-dropdown').trigger('change');

            }, 100);

        });
    }

    function update_add_to_cart_button_status() {

        if ( $('.single_add_to_cart_button').hasClass( 'disabled' ) ) {

            $('.wn-addtocart_add_to_cart_button').addClass( 'wn-addtocart_add_to_cart_button--disabled' );

        }else {

            $('.wn-addtocart_add_to_cart_button').removeClass( 'wn-addtocart_add_to_cart_button--disabled' );

        }

    }

    function price_change_event() {

        $('#choose-quantity').on('change', function(){

            setTimeout(() => {

                var price_html_content = $('.woocommerce-variation-price > .price > .woocommerce-Price-amount').html();
                $('.wn-addtocart_total > span').html(price_html_content);

                update_add_to_cart_button_status();
                
            }, 100);


        });
    }

    function add_to_cart_click_event() {

        $('.wn-addtocart_add_to_cart_button').on('click', function() {

            // $('.variations_form').submit();

        });

    }

    function filling_deliver_every_list() {

        //Filling Deliver Every list with data from the real Woo elements 
        //Empty the li in Mask Template
        $('.wn-every_dropdown > ul').empty();

        $('.wcsatt-options-product-dropdown > option').each(function( index, element ){


            var text_content = $(this).text();
            var value          = $(this).attr('value');
            let class_names = '';

            if( index == 0 ) {
                class_names += 'active ';
            }

            //Removing everythin betwenn parentisis in the text content
            text_content = text_content.split('(').shift();

            //Create a new li
            const new_li_element = '<li class="' + class_names + '" value="' + value + '">' + text_content + '</li>'
            $('.wn-every_dropdown > ul').append(new_li_element);
            
        });

        //Getting first option
        let first_option_text = $('.wcsatt-options-product-dropdown > option:nth-child(1)').text();

        //Removing everything betwenn parentisis in the first option
        first_option_text = first_option_text.split('(').shift();

        $('#wn_choose_every > span').text(first_option_text);
            
    }

    function custom_cart_buttons() {

        //Filling Quantity list with data from the real Woo elements 
        //Empty the li in Mask Template
        $('.wn-quatity_dropdown > ul').empty();
        let first_run = true;
        let is_active = '';

        $('#choose-quantity > option').each(function(){

            const text_content = $(this).text();
            var value          = text_content;

            if( text_content == 'Choose an option' ) {

                return;

            }

            if(first_run) {
                is_active = 'wn_varselector__aactive ';
            }
            else {
                is_active = '';
            }
            

            //Create a new li
            const new_li_element = '<li class="' + is_active + '" value="' + value + '">' + text_content + '</li>'
            $('.wn-quatity_dropdown > ul').append(new_li_element);

            first_run = false;
            
        });

        //Setting the slect to the default option
        const default_selected_option = $("#choose-quantity > option[selected='selected']").text();
        const default_selected_option_value = $("#choose-quantity > option[selected='selected']").attr('value');
        // $('#wn_choose_quantity > span').text(default_selected_option);
        $('#choose-quantity').val(default_selected_option_value);

        setTimeout(() => {
            $('#choose-quantity').trigger('change');
        }, 100);


        //Getting the Price Value
        const prive_html_content = $('.woocommerce-variation-price > .price > .woocommerce-Price-amount').html();
        $('.wn-addtocart_total > span').html(prive_html_content);

        //Registering Choose Quatity Events
        choose_quantity_click_event();

        //Registering Choose Deliver Events
        choose_every_click_event();

        //Registering Price Change Event
        price_change_event();

        //Registering the Add to Cart Button Event
        add_to_cart_click_event();


        $('.wn_purshase_type > li').on('click', function() {

            if($(this).hasClass('subscription_purshase_option')) {

                //Trigering the click event on the real woo element
                $('.wcsatt-options-prompt-radios > li > .wcsatt-options-prompt-label-subscription').click();

                setTimeout(() => {

                    $('.wcsatt-options-product-dropdown').val('1_month');
                    $('.wcsatt-options-product-dropdown').trigger('change');
                    filling_deliver_every_list();
                    
                }, 100);
                
                if ( is_subscription_locked_to_one_pack ) {
                    $('#wn_choose_quantity > span').text('1-Pack');
                    $('#wn_choose_quantity').addClass('wn-addtocart_add_to_cart_button--disabled');
                    $('.wn-quatity').css('display', 'none');
                }
  
                // $('.wn-addtocart_total').css('display', 'none');
                $('.wn-every').css('display', 'block');

                $('.wn-addtocart > label').text('DELIVER');
                $('.wn-addtocart_add_to_cart_button').text('SIGN UP');
    
            }
            else {

                //Trigering the click event on the real woo element
                $('.wcsatt-options-prompt-radios > li > .wcsatt-options-prompt-label-one-time').click();

                $('#wn_choose_quantity').removeClass('wn-addtocart_add_to_cart_button--disabled');
                $('.wn-quatity').css('display', 'block');

                $('.wn-quatity_dropdown ul li.wn_varselector__aactive').trigger('click');

                // $('.wn-addtocart_total').css('display', 'flex');
                $('.wn-every').css('display', 'none');

                $('.wn-addtocart > label').text('TOTAL');
                $('.wn-addtocart_add_to_cart_button').text('ADD TO CART');
            }
        });
   
        //Displaying the dropdown for Deliver Every
        $('#wn_choose_every').on('click', function(){

            $(this).toggleClass('wn-every_select--open');

        });


        //Assigning the new Deliver Every select to the slected div
        $('.wn-every_dropdown > ul').on('click', '> li', function() {
    
            //Storing the value of the li
            const selected_li = $(this).text(); 

            //Asigning the value to the main selector 
            $('#wn_choose_every > span').text(selected_li);
    
        });

    }

    //Registering Events
    wn_sp_gallery_onmousehover();
    if ( is_subscription_locked_to_one_pack ) {
        restric_subscriptios_to_one_pack();
    }
    
    variation_hook();

    if ( !$('.out-of-stock').length && $('.variations_form').length && !$('#wn_product_not_purchasable').length ) {
        $('.wn_custom_form_wrapper').css('display', 'block');
        custom_cart_buttons();
    }

    // Calling Functions 
    $('.wn-purshase_selector > ul').wnVariableSelector(
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
    $('.wn-quatity_dropdown > ul').wnVariableSelector(
        {
            direction: 'row',
            max_width: '426px',

            breakpoints: {
                // 970: {
                //     // direction: 'column',
                //     max_width: '550px',
                // },
                769: {
                    max_width: '400px',
                }
            }

        }
    );
});

class WnFloatAddToCart {

    constructor() {
		document.addEventListener( "DOMContentLoaded", () => {
            this.init();
		} );
	}

    init(){

        let add_to_cart_buttons = document.querySelectorAll('.wn-addtocart_add_to_cart_button');

        Array.prototype.forEach.call(add_to_cart_buttons, function(button, i){

            button.addEventListener('click', function( e ) {

                console.log( 'the ajax url' );
                console.log( the_ajax_script.ajaxurl );

                let request             = new XMLHttpRequest(),
			        url                 = new URL( the_ajax_script.ajaxurl ),
                    product_id          = document.querySelector( 'form.variations_form.cart input[name="product_id"]' ).getAttribute( 'value' ),
                    variation_id        = document.querySelector( 'form.variations_form.cart input[name="variation_id"]' ).getAttribute( 'value' ),
                    quantity            = document.querySelector( 'form.variations_form.cart input[name="quantity"]' ).getAttribute( 'value' ),
                    active_li_element   = document.querySelector( 'div.wn_custom_form_wrapper .wn_purshase_type.wn_var_selector > li.wn_varselector__aactive' ),
                    subscription        = active_li_element.classList.contains( 'subscription_purshase_option' ) ? document.querySelector( '.wn-every_select .wn-every_dropdown li.active' ).getAttribute( 'value' ) : false;

                url.searchParams.append( 'action',          'wn_mwh_float_add_to_cart' );
                url.searchParams.append( 'product_id',      product_id );
                url.searchParams.append( 'quantity',        quantity );
                url.searchParams.append( 'variation_id',    variation_id );
                url.searchParams.append( 'subscription',    subscription );

                console.log( 'is subscription' );
                console.log( subscription );

                console.log( 'form' );
                console.log( document.querySelector( 'form.variations_form.cart' ) );

                console.log( 'product id' );
                console.log( product_id );

                console.log( 'variation id' );
                console.log( variation_id );

                console.log( 'the url' );
                console.log( url );

                request.open( 'GET', url.href, true );
                request.onload = function() {

                    if (this.status >= 200 && this.status < 400) {

                      const resp = this.response;
                      console.log( 'Success!' );
                      console.log( resp );

                      

                    } else {
                      console.log( 'We reached our target server, but it returned an error' );
                    }
                };
                  
                request.onerror = function() {
                    console.log( 'There was a connection error of some sort' );
                };

                request.send();

                return;

            }, false);

        });

    }
}

new WnFloatAddToCart();
