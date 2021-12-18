<?php get_header(); ?>
<?php
    $class = 'full-width';
    $has_sidebar = false;
    if(
        ((is_shop() || is_product_category()) && plsh_gs('show_shop_sidebar') == 'on')
        ||
        (is_product() && plsh_gs('show_product_sidebar') == 'on')
    )
    {
        $class = '';
        $has_sidebar = true;
    }
?>

<!-- Homepage content -->
<div class="wn_woo_single_p_wrapper">

    

        <!-- Post -->
        <div <?php post_class('wn_woo_single_p_container'); ?>>
            
            <?php woocommerce_content(); ?>

        </div>

    
    
    <?php
    if($has_sidebar)
    {
        // get_sidebar();
    }
    ?>   
</div>


<?php get_footer(); ?>