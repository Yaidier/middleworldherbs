<?php
    $particle_enabled = get_theme_mod('enable_particle_background', plsh_gs('enable_particle_background'));
    if($particle_enabled === true)
    {
        echo '<div id="particles"></div>';
    }
?>

<?php $site_url = get_site_url(); ?>

<?php
    if(
        (is_single() && get_post_type() == 'post')
        &&
        plsh_gs('show_post_read_progress') == 'on')
    {
        ?> <div class="read-progress"><span style="width: 40%;"></span></div> <?php
    }    
?>
<?php get_template_part('theme/templates/trending-news'); ?>

<!-- Header -->
<header class="wn_header">
    
    <?php if(plsh_gs('use_image_logo') == 'on') {
		?>

        <a class="wn_logo_image" href="<?php echo $site_url; ?>"><img src="<?php echo $site_url; ?>/wp-content/uploads/2021/02/cropped-cropped-Middle-World-Herbs-Logo-Png-150x150.png" alt="Middle World Herbs Logo"></a>
         
        
    <?php } else { ?>
        <div class="logo-text">
            <h2><a href="<?php echo esc_url(home_url('/')); ?>"><?php bloginfo('name'); ?></a></h2>
            <p><?php bloginfo('description'); ?></p>
        </div>
    <?php } ?>
    
    <?php // echo $banner = plsh_get_banner_by_location('header_ad'); ?>
</header>

<?php get_template_part('theme/templates/menu'); ?>