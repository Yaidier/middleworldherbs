<?php
/**
 * Single Product Image
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/single-product/product-image.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 3.5.1
 */

defined( 'ABSPATH' ) || exit;

// Note: `wc_get_gallery_image_html` was added in WC 3.3.2 and did not exist prior. This check protects against theme overrides being used on older versions of WC.
if ( ! function_exists( 'wc_get_gallery_image_html' ) ) {
	return;
}

global $product;


?>
<div class="wn_sp_image_wrapper" data-columns="" style="opacity: 1; transition: opacity .25s ease-in-out;">

    <div class="wn_sp_gallery">

        <?php 
        
            $attachment_ids = $product->get_gallery_image_ids();

            if ( ! empty( $attachment_ids ) ) {

                $index = 0;

                ?>

                    <img class="wn_sp_gallery_imgs wn_sp_gallery_imgs__active" index="<?php echo $index++; ?>" src="<?php echo $image_link = wp_get_attachment_image_src( $product->get_image_id(), 'thumbnail' )[0]; ?>" alt=""> 

                <?php

                foreach( $attachment_ids as $attachment_id ) { ?>

                    <img class="wn_sp_gallery_imgs" index="<?php echo $index++; ?>" src="<?php echo $image_link = wp_get_attachment_image_src( $attachment_id, 'thumbnail' )[0]; ?>" alt=""> 
        
                <?php };
                
            } 

        ?>       

    </div>

    <div class="wn_sp_featured_img_wrapper">

        <?php 
        
            echo $product->is_on_sale() ? '<span class="wn_onsale">Sale!</span>' : ''; 

            if ( ! empty( $attachment_ids ) ) {

                $index = 0;

                ?>

                    <img class="wn_sp_featured_img wn_sp_featured_img__active" index="<?php echo $index++; ?>" src="<?php echo $image_link = wp_get_attachment_image_src( $product->get_image_id(), 'large' )[0]; ?>" alt=""> 

                <?php

                foreach( $attachment_ids as $attachment_id ) { ?>

                    <img class="wn_sp_featured_img wn_sp_fetured_gallary_imgs" index="<?php echo $index++; ?>" src="<?php echo $image_link = wp_get_attachment_image_src( $attachment_id, 'large' )[0]; ?>" alt=""> 
        
                <?php };
                
            }
            else { ?>

                <img class="wn_sp_featured_img" style="display:block;" src="<?php echo $image_link = wp_get_attachment_image_src( $product->get_image_id(), 'large' )[0]; ?>" alt=""> 

            <?php }
        
        ?>

        

    </div>

    

        
</div>
