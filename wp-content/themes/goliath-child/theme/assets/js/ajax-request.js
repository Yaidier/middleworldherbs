jQuery(document).ready(function($){

    var ajax_called = false;
    var nav_menu_ajax_called = false;
    var products_slider_called = false;

    var active_nav_menu_url; 

    jQuery('#button_id').click(function(){
        callAjaxReplaceNavMenu();
        console.log('hey');
    });

    // if(!nav_menu_ajax_called) {
    //     callAjaxReplaceNavMenu();
    // }

    // if(!ajax_called) {
    //     callAjax();
    // }
    

    function callAjax() {

        console.log( 'Calling AJAX' );

        if (!ajax_called) {
            ajax_called = true;
            jQuery.ajax({
                type: "POST",
                dataType: "html",
                url: the_ajax_script.ajaxurl,
                data: "action=more_post_ajax",
                success: function (data) {
                    var $data = jQuery(data);
                    if ($data.length) {
                        jQuery(".wn_homepage-content").append($data);
                        wn_mwh_sidebar_products_slider();
                        callAjaxInstaFeed();
                        
                    }             
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    // $loader.html(jqXHR + " :: " + textStatus + " :: " + errorThrown);
                }
            });
        }
    }

    function callAjaxReplaceNavMenu() {
        if (!nav_menu_ajax_called) {
            nav_menu_ajax_called = true;
            jQuery.ajax({
                type: "POST",
                dataType: "html",
                url: the_ajax_script.ajaxurl,
                data: "action=wn_replace_current_nav_menu",
                success: function (data) {
                    if (data.length) {
                        wn_mwh_check_active();
                        jQuery('.wn_mwh_menu_wrapper').empty();
                        jQuery('.wn_mwh_menu_wrapper').append(data);
                        wn_mwh_replace_active();
                        wn_mwh_custom_script(true);
                        console.log('reloading the floating cart again');
                        WnFloatingCart.instance().register_cart_button();
                    } 
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    $loader.html(jqXHR + " :: " + textStatus + " :: " + errorThrown);
                }
        
            });
        }
    }

    function callAjaxProducts() {
        if (!products_slider_called) {
            products_slider_called = true;
            jQuery.ajax({
                type: "POST",
                dataType: "html",
                url: the_ajax_script.ajaxurl,
                data: "action=wn_load_more_products_slider",
                success: function (data) {
                    if (data.length) {

                        $('.wn_mwh_wc_products_carousel').append(data);

                        wn_mwh_products_carousel();

                    } 
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    $loader.html(jqXHR + " :: " + textStatus + " :: " + errorThrown);
                }
        
            });
            
        }
    }

    function callAjaxInstaFeed() {

        products_slider_called = true;
        jQuery.ajax({

            type: "POST",
            dataType: "html",
            url: the_ajax_script.ajaxurl,
            data: "action=wn_instagram_feed",
            success: function (data) {

                if (data.length) {

                    $('.wn_mwh_instagram_feed_section').empty();
                    $('.wn_mwh_instagram_feed_section').append(data);

                } 
            },
            error: function (jqXHR, textStatus, errorThrown) {

                console.log('>>>>>>>ERROR CALLING AJAX<<<<<<<<<');

                console.log(the_ajax_script);

            }
    
        });
            
        
    }

    function wn_mwh_check_active() {
        active_nav_menu_url = jQuery('.wn_mwh_menu_wrapper .wn_mwh_nav_ul .active').children('a').attr('href');
    } 

    function wn_mwh_replace_active() {
        jQuery('.wn_mwh_menu_wrapper .wn_mwh_nav_ul li').each(function(){
            if(jQuery(this).children('a').attr('href') == active_nav_menu_url) {
                jQuery(this).addClass('active');
            }
        });
    }


    $.fn.isInViewport = function() {
        var elementTop = $(this).offset().top;
        var elementBottom = elementTop + $(this).outerHeight();
        var viewportTop = $(window).scrollTop();
        var viewportBottom = viewportTop + $(window).height();
      
        return elementBottom > viewportTop && elementTop < viewportBottom;
    };
      
    $(window).on('resize scroll', function() {
        if(!ajax_called) {
            // callAjax();
        }

        if(!nav_menu_ajax_called) {
            callAjaxReplaceNavMenu();
        }

        if(!products_slider_called) {
            // callAjaxProducts();
        }
    });

    $(document).mousemove(function(){
        if(!ajax_called) {
            // callAjax();
        }

        if(!nav_menu_ajax_called) {
            callAjaxReplaceNavMenu();
        }

        if(!products_slider_called) {
            // callAjaxProducts();
        }
    });

});


class WnAjaxHandler {

    static instance(){

        if( !WnAjaxHandler.instance_obj ){

            WnAjaxHandler.instance_obj = this;

        }

        return WnAjaxHandler.instance_obj;
    }

    static init() {

        document.addEventListener( "DOMContentLoaded", () => {
            
		} );

    }

    static check() {
        console.log( 'hello from AJAX HANDLER' );
    }

    static param(object) {
        
        var parameters = [];
        for (var property in object) {
            if (object.hasOwnProperty(property)) {
                parameters.push(encodeURI(property + '=' + object[property]));
            }
        }

        return parameters.join('&');
    }

    static ajax_call( action, data ) {

        let request = new XMLHttpRequest(),
            object  = {
                action: action,
            };

        Object.entries(data).forEach(
            ([key, value]) => { 
                object[key] = value;
            }
        );

        request.open( 'POST', the_ajax_script.ajaxurl, true );
        request.setRequestHeader( 'Content-Type', 'application/x-www-form-urlencoded; charset=UTF-8' );
        request.onreadystatechange = function() {

            if ( this.readyState == 4 && this.status == 200 ) {
                console.log( 'success on response' );
                console.log( JSON.parse( this.response ) );
            }
            else {
                console.log( 'Something went wrong' );
            }
        };

        request.send( this.param( object ) );
    }

    static call_ajax_call_v2( data, url = null ) {

        let request     = new XMLHttpRequest(),
            respond_to  = false;

        url = ( url ) ? new URL( url ) : new URL( the_ajax_script.ajaxurl );

        Object.entries(data).forEach(([key, value]) => {

            if( key != 'respond_to' ){
                url.searchParams.append( key, value );
            }
            else {
                respond_to = value;
            }

        });

        request.open( 'GET', url.href, true );
        request.onload = function() {

            if (this.status >= 200 && this.status < 400) {

                let response = this.response;

                if( respond_to ) {
                    eval( respond_to + '(' + response + ')' );
                }
                else {
                    console.log( response );
                }

            } else {
                console.log( 'We reached our target server, but it returned an error' );
            }
        };
            
        request.onerror = function() {
            console.log( 'There was a connection error of some sort' );
        };

        request.send();

    }

}





                