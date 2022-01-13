class WN_Amzs_Admin {

    constructor() {
        document.addEventListener( 'DOMContentLoaded', () => {
            this.init();
        } );
    }

    init() {
        this.sync_imgs_btn  = document.querySelector( '#wn_amzs_btn_sync_images' );
        this.logs_ul        = document.querySelector( '.wn_amzs_sync_images_admin_logs_ul' );
        this.ajax_spinner   = document.querySelector( '.wn_amzs_sync_spinner' );
        this.is_fresh_start = true;

        this.register_sync_images_btn();
    }

    register_sync_images_btn() {
        if( this.sync_imgs_btn.classList.contains( 'disabled' ) ) {
            

            //Get products to sync IDs
            let checked_inputs      = this.logs_ul.querySelectorAll( 'li > input[type="checkbox"][checked="checked"]' ),
                products_to_sync    = [],
                _data               = {
                    action:         'wn_amzs_ajax_sync_images',
                    is_fresh_start: this.is_fresh_start,
                    respond_to:     'self.server_response_receiver',
                };

            Array.prototype.forEach.call(checked_inputs, function(el, i){
                products_to_sync.push( el.getAttribute( 'value' ) );
            });

            _data['products_to_sync'] = products_to_sync;

            this.call_ajax_call( _data );
        }
    }

    server_response_receiver( response ) {
        console.log( response );

        if( response.data.product_id ) {
            let product_id  = response.data.product_id,
                status      = response.status,
                message     = response.message,
                li_element  = this.logs_ul.querySelector( 'li > input[value="' + product_id + '"]' ).parentElement,
                sub_list    = '';
            
            if( response.data.images_status && status != 'error') {
                sub_list += '<ul class="wn_amzs_sub_list">';

                Object.entries(response.data.images_status).forEach(el => {
                    console.log( el );
                    sub_list += '<li>' + el[1].file_name + '<strong> - ' + el[1].message + '</strong>';
                })
                  
                sub_list += '</ul>';
            }

            li_element.classList.add( status );
            li_element.innerHTML += '<span><strong> - ' + message + '</strong></span>' + sub_list;
        }

        if( !response.data.is_last ) {
            this.is_fresh_start = false;
            let _data           = {
                action:         'wn_amzs_ajax_sync_images',
                is_fresh_start: this.is_fresh_start,
                respond_to:     'self.server_response_receiver',
            };
            this.call_ajax_call( _data );
        }
        else {
            this.sync_imgs_btn.classList.remove( 'disabled' );
            this.ajax_spinner .remove( 'disabled' );
        }
    }

    call_ajax_call( data, url = null ) {
        let request     = new XMLHttpRequest(),
            respond_to  = false,
            self        = this;

        url = ( url ) ? new URL( url ) : new URL( wn_amzs_app_data.ajaxurl );

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
            } 
            else {
                console.log( 'We reached our target server, but it returned an error' );
            }
        };
            
        request.onerror = function() {
            console.log( 'There was a connection error of some sort' );
        };

        request.send();
    }
}

new WN_Amzs_Admin();

