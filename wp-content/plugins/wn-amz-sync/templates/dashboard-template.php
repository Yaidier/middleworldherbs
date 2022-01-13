<?php
/**
 * 
 * 
 */

if ( !current_user_can( 'manage_options' ) ) {
    return;
}
?>

<div class="wrap">
    <h1><?php echo esc_html( get_admin_page_title() ); ?></h1>
    <?php settings_errors(); ?>

    <!-- Here are our tabs -->
    <nav class="nav-tab-wrapper">
      <a href="?page=wn_amz_sync_main" class="nav-tab <?php if( $tab===null ) : ?> nav-tab-active <?php endif; ?>">Sync Prices</a>
      <a href="?page=wn_amz_sync_main&tab=sync_images" class="nav-tab <?php if( $tab==='sync_images' ) : ?> nav-tab-active <?php endif; ?>">Sync Images</a>
      <a href="?page=wn_amz_sync_main&tab=settings" class="nav-tab <?php if( $tab==='settings' ) : ?> nav-tab-active <?php endif; ?>">Settings</a>
    </nav>

    <div class="tab-content">
    <?php 
        switch( $tab ) :
            case 'sync_images': self::render_sync_images_options();
                break;
            case 'settings':    self::render_settings_options();
                break;
            default:            self::render_sync_prices_options();
                break;
        endswitch; 
    ?>
    </div>
</div>