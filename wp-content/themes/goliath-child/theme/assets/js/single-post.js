jQuery(document).ready(function($){
    //Products Carousel
    $('.wn_mwh_single_carousel_wrapper').slick({
        arrows: true,
        dots: false,
        infinite: false,
        speed: 300,
        slidesToShow: 1,
        slidesToScroll: 1,
        // appendDots: $('.wn_mwh_products_carousel_wrapper'),
        prevArrow: '<div type="button" data-role="none" class="wn_mwh_sidebar_carousel_prev"><svg xmlns="http://www.w3.org/2000/svg" width="100%" height="100%" viewBox="0 0 24 24"><path d="M16.67 0l2.83 2.829-9.339 9.175 9.339 9.167-2.83 2.829-12.17-11.996z"/></svg></div>',
        nextArrow: '<div type="button" data-role="none" class="wn_mwh_sidebar_carousel_next"><svg xmlns="http://www.w3.org/2000/svg" width="100%" height="100%" viewBox="0 0 24 24"><path d="M5 3l3.057-3 11.943 12-11.943 12-3.057-3 9-9z"/></svg></div>',
    }
    );

    console.log('holaaaaaaa');
    var height = [];
    $('.wn_mwh_single_carousel_wrapper').find('.slick-slide').each(function() {
        

        // console.log($(this).find('.wn_mwh_carousel_product_content').height());

        height.push($(this).find('.wn_mwh_carousel_product_content').height());
        height.sort(function(a, b){return b-a});

        

    });

    $('.wn_mwh_sidebar_carousel_buttons').on('click', function(){
        var active_element_height = $('.wn_mwh_single_carousel_wrapper').find('.slick-active').find('.wn_mwh_carousel_product_content').height();
        // console.log();
        
    })
});