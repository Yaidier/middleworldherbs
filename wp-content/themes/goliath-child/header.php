<!DOCTYPE html >

    <html lang="en">

	<!-- BEGIN head -->
	<head>

        <!-- Global site tag (gtag.js) - Google Analytics -->
        <script async src="https://www.googletagmanager.com/gtag/js?id=UA-103769157-5"></script>
        <script>
        window.dataLayer = window.dataLayer || [];
        function gtag(){dataLayer.push(arguments);}
        gtag('js', new Date());

        gtag('config', 'UA-103769157-5');
        </script>

        <!-- Meta tags -->
        <meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no" />
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">

		<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>" />
        <?php if(plsh_gs('favicon')) : ?>
			<?php if(is_ssl()) {
				$favicon_img_url = str_replace("http:", "https:", plsh_gs('favicon'));
			} else {
				$favicon_img_url = plsh_gs('favicon');
			} ?>
			<link rel="shortcut icon" href="<?php echo esc_url($favicon_img_url); ?>" />
        <?php endif; ?>
		<?php
			if ( is_singular() && get_option( 'thread_comments' ) )
            {
                wp_enqueue_script( 'comment-reply' );
            }
		?>

        <?php if (have_posts()):while(have_posts()):the_post(); endwhile; endif;?>


		<?php if(plsh_gs('display_theme_og_tags') == 'on') : ?>

			<!-- if page is content page -->
			<?php if (is_single()) { ?>
			<meta property="og:url" content="<?php the_permalink() ?>"/>
			<meta property="og:title" content="<?php esc_attr(single_post_title('')); ?>" />
			<meta property="og:description" content="<?php echo esc_attr(htmlentities(strip_tags(strip_shortcodes(get_the_excerpt())))); ?>" />
			<meta property="og:type" content="article" />
			<?php
				$img = wp_get_attachment_image_src(get_post_thumbnail_id($post->ID), 'blog_thumb_single_small');
				if($img)
				{
					echo '<meta property="og:image" content="' . $img[0] . '" />';
				}
			?>
			<!-- if page is others -->
			<?php } else { ?>
			<meta property="og:site_name" content="<?php esc_attr(bloginfo('name')); ?>" />
			<meta property="og:description" content="<?php esc_attr(bloginfo('description')); ?>" />
			<meta property="og:type" content="website" />
			<meta property="og:image" content="<?php echo esc_url(plsh_gs('logo_image')); ?>" />
			<?php } ?>

		<?php endif; ?>

        <?php $site_url = get_site_url(); ?>

        <style>

            @font-face {
                font-family: 'Abel';
                src: url('<?php echo $site_url; ?>/wp-content/themes/goliath-child/theme/assets/local-fonts/google-fonts/Abel/Abel-Regular.woff2') format('woff2'),
                    url('<?php echo $site_url; ?>/wp-content/themes/goliath-child/theme/assets/local-fonts/google-fonts/Abel/Abel-Regular.woff') format('woff');
                font-weight: normal;
                font-style: normal;
                font-display: swap;
            }

            @font-face { 
                font-family: "Quicksand"; 
                src: url(<?php echo $site_url; ?>/wp-content/themes/goliath-child/theme/assets/local-fonts/google-fonts/Quicksand/Quicksand-VariableFont_wght.ttf); 
            }

            @font-face { 
                font-family: "Anton"; 
                src: url(<?php echo $site_url; ?>/wp-content/themes/goliath-child/theme/assets/local-fonts/google-fonts/Anton/Anton-Regular.ttf); 
                font-weight: 400; 
            }

            .back-to-top {
                width: 50px;
                height: 50px;
                background: #e7e7e7;
                border-bottom: 1px solid #d9d9d9;
                position: fixed;
                bottom: 25px;
                right: 25px;
                z-index: 10000;
                display: none;
                color: #ff5732;
                font-size: 32px;
                text-align: center;
                line-height: 32px;
            }

            body {
                font: 13px/18px Raleway, sans-serif;
                color: #252525;
                background-color: #efefef;
                background-size: cover;
                margin: 0px;
            }

            body:after {
                /* display: none; */
                width: 1070px;
                content: "";
                position: fixed;
                top: 0;
                right: 50%;
                margin-right: -535px;
                height: 100%;
                background: #f7f7f7;
                border-left: 1px solid #e8e8e8;
                border-right: 1px solid #e8e8e8;
                z-index: 1;
            }

            h1, h2, h3, h4, h5, h6, p {
                margin: 0;
                padding: 0;
            }

            h2 {
                font-size: 28px;
                line-height: 28px;
                font-weight: 900;
                margin: 0 0 20px 0;
            }

            a {
                color: #252525;
            }

            .legend-default {
                color: #999;
                font-size: 11px;
            }

            .legend-default i {
                margin: 0 5px 0 0;
            }

            .tag-default {
                height: 11px;
                font-size: 9px;
                line-height: 10px;
                font-weight: 900;
                color: #fff;
                background: #ff5732;
                font-style: normal;
                text-transform: uppercase;
                padding: 1px 2px 0 2px;
                display: inline-block;
                vertical-align: top;
                margin: 4px 7px 0 0;
            }

            .title-default {
                box-shadow: #e4e4e4 0 -3px 0 inset;
            }

            .title-default > a {
                font-weight: 900;
                font-size: 15px;
                line-height: 15px;
                text-transform: uppercase;
                color: #999;
                padding: 0 0 10px 0;
                margin: 0 25px 0 0;
                display: inline-block;
            }

            .title-default > a.active {
                color: #ff5732;
                box-shadow: #ff5732 0 -3px 0 inset;
            }

            

            .wn_mwh_product_carousel_product_porperties ul {
                padding-left: 13px;
                margin-top: 10px;
            }

            .wn_mwh_product_carousel_product_porperties ul li {
                font-weight: 500;
                font-family: Quicksand;
            }

            .wn_mwh_price_atc_wrapper {
                display: flex;
            }

            .wn_mwh_single_product {
                font-family: Quicksand;
                padding: 20px;
            }

            .wn_mwh_add_to_cart {
                background-color: #443c1b !important;
                padding: 0px 5px !important;
                margin-left: 10px !important;
                color: white !important;
                font-size: 11px !important;
                font-weight: 600 !important;
            }

            .wn_mwh_prodcut_price {
                font-weight: 900;
                font-size: 16px;
                color: black;
            }

            .wn_mwh_carousel_product_title {
                font-family: Quicksand;
                font-size: 16px;
                margin-bottom: 0px !important;
                line-height: 16px;
                margin-top: 10px;
                color: #443c1b;
            }

            .wn_mwh_carousel_single_image {
                margin-left: auto;
                margin-right: auto;
                width: auto;
                height: 200px;
            }

            .wn_mwh_carousel_prev_button, .wn_mwh_carousel_next_button {
                background-color: transparent;
                width: 40px;
                height: 40px;
                position: absolute;
                top: 35%;
                padding: 10px;
                fill: #b7b7b7;
                box-shadow: 2px 2px 4px gray;
                cursor: pointer;
                transition: .5s ease;
            }

            .wn_mwh_carousel_prev_button {
                right: 100%;
            }

            .wn_mwh_carousel_next_button {
                left: 100%;
            }

            .wn_mwh_wc_products_carousel {
                margin: 10px 40px;
                margin-bottom: 0px !important;
            }

            .wn_mwh_latest_articles_wrapper {
                display: flex;
            }

            .wn_mwh_latest_posts_left_column {
                width: 70%;
                /* display: flex;  */
            }

            .wn_mwh_latest_posts_rigth_column {
                width: 30%;
                margin-left: 20px;
            }

            .wn_mwh_lp_inner_left {
                width: 60%;
                margin-right: 15px;
            }

            .wn_mwh_lp_inner_left > div:not(:last-child) {
                position: relative;
                margin-bottom: 30px
            }

            .wn_mwh_lp_inner_left > div:not(:last-child)::before {
                position: absolute;
                content: "";
                width: 100%;
                height: 1px;
                background-color: #9999993d;
                left: 0;
                bottom: -15px;
            }

            .wn_mwh_lp_inner_right {
                width: 40%;
                margin-left: 15px;
            }

            .wn_mwh_lp_inner_right .wn_mwh_single_post_container {
                flex-direction: column;
            }

            .wn_mwh_lp_inner_right .wn_mwh_single_post_container .wn_mwh_single_post_content_container {
                margin-left: 0px;
                margin-top: 10px;
            }

            .wn_mwh_lp_inner_right .wn_mwh_single_post_container .wn_mwh_single_post_image {
                width: 100%;
                height: 230px;
                transition: 0.7s ease;
            }


            .wn_mwh_latest_posts_rigth_column img {
                width: 80px;
                height: 80px;
                transition: 0.7s ease;
            }

            .wn_mwh_latest_posts_rigth_column .wn_mwh_single_post_container .wn_mwh_single_post_content_container .wn_mwh_single_metadata > a {
                display: table;
            }

            .wn_mwh_rc_header {
                position: relative;
                margin-bottom: 15px;
            }

            .wn_mwh_rc_header::before {
                content: "";
                position: absolute;
                bottom: -3px;
                left: 0;
                width: 100%;
                height: 3px;
                background-color: #443c1b12;
            }

            .wn_mwh_rc_header span {
                font-family: "Abel";
                font-weight: 600;
                font-size: 14px;
                margin-right: 20px;
                color: rgba(153, 153, 153, 0.5);
                cursor: pointer;
            }

            .wn_mwh_text__active {
                color: #252525 !important;
            }

            .wn_mwh_text__active::before {
                content: "";
                position: absolute;
                background-color: #252525;
                bottom: -3px;
                width: 68px;
                height: 3px;
            }

            .wn_mwh_carousel_product_content {
                margin-top: 10px;
            }

            .wn_mwh_latest_posts_left_wrapper {
                display: flex;
            }

            .wn_mwh_header_wrapper {
                display: flex;
                justify-content: space-between;
                align-items: flex-end;
                margin-bottom: 11px;
                font-family: "Abel";
                border-bottom: 3px solid #443c1b12;
                padding-bottom: 1px;
                position: relative;
            }

            .wn_mwh_header_wrapper::before {
                content: "";
                position: absolute;
                width: 50px;
                left: 0;
                bottom: -3px;
                border-bottom: 3px solid #443c1b;
            }

            .wn_mwh_header_wrapper > span, .wn_mwh_header_wrapper > a {
                display: block;
            }

            .wn_mwh_header_wrapper > span {
                font-size: 16px;
                font-weight: 600;
            }

            .wn_mwh_header_wrapper i {
                width: 10px;
                height: 10px;
                display: inline-block;
                background-image: url('data:image/svg+xml;utf8,<svg xmlns="http://www.w3.org/2000/svg" width="100%" height="100%" viewBox="0 0 24 24"><path d="M4 22h-4v-4h4v4zm0-12h-4v4h4v-4zm0-8h-4v4h4v-4zm3 0v4h17v-4h-17zm0 12h17v-4h-17v4zm0 8h17v-4h-17v4z"/></svg>');
            }

            .wn_mwh_wc_products_carousel_wrapper > .wn_mwh_header_wrapper {
                margin-top: 40px;
            }

            .wn_mwh_carousel_append_dots {
                display: block;
                width: 120px;
                height: 20px;
            }

            .wn_mwh_carousel_append_dots ul {
                position: static;
                display: block;
                text-align: right;
            }

            .wn_mwh_carousel_append_dots .slick-dots li {
                width: 16px;
                margin: 0 0px;
            }

            .wn_mwh_carousel_append_dots .slick-dots li button::before {
                font-size: 10px;
            }



            .wn_mwh_rc_latest_posts_slider_wrapper .wn_mwh_rc_latest_posts_container .wn_mwh_single_post_container {
                position: relative;
            }

            .wn_mwh_rc_latest_posts_slider_wrapper .wn_mwh_rc_latest_posts_container > div:not(:last-child) .wn_mwh_single_post_container {
                position: relative;
                margin-bottom: 33px;
            }

            .wn_mwh_rc_latest_posts_slider_wrapper .wn_mwh_rc_latest_posts_container div:first-child .wn_mwh_single_post_container::after {
                position: absolute;
                content: "";
                width: 100%;
                height: 1px;
                background-color: #9999993d;
                left: 0;
                top: -15px;
            }

            .wn_mwh_rc_latest_posts_slider_wrapper .wn_mwh_rc_latest_posts_container div:not(:last-child) .wn_mwh_single_post_container::before {
                position: absolute;
                content: "";
                width: 100%;
                height: 1px;
                background-color: #9999993d;
                left: 0;
                bottom: -15px;
            }

            .wn_mwh_subscription_wrapper {
                display: flex;
                margin: 25px 0px;
            }

            .wn_mwh_subscription_wrapper img {
                width: 180px;
                height: auto;
                object-fit: contain;
            }

            .wn_mwh_subs_content {
                margin-left: 14px;
            }

            .wn_mwh_subs_meta {
                display: flex;
                justify-content: space-between;
                align-items: flex-end;
            }

            .wn_mwh_subs_content p, .wn_mwh_subs_meta p {
                font-size: 14px;
                color: #443c1b;
                font-weight: 500;
            }

            .wn_mwh_subs_meta p span {
                color: #999;
            }

            .wn_mwh_world_stories_wrapper {
                margin-top: 25px;
            }

            .wn_mwh_subs_content p i {
                font-size: 18px;
                font-style: normal;
            }

            .wn_mwh_three_columns_cat_wrapper {
                display: flex;
            }

            .wn_mwh_three_columns_cat_wrapper .wn_mwh_lp_inner_right {
                width: 100%;
                margin-left: 0px;
                height: 420px;
            }

            .wn_mwh_rc_one_wrapper {
                margin-top: 25px;
            }

            .wn_mwh_single_column {
                width: 100%;
            }

            .wn_mwh_three_columns_cat_wrapper .wn_mwh_single_column {
                padding: 10px;
            }

            .wn_mwh_three_columns_cat_wrapper .wn_mwh_single_column:first-child {
                padding-left: 0px;
            }

            .wn_mwh_three_columns_cat_wrapper .wn_mwh_single_column:last-child {
                padding-right: 0px;
            }

            .wn_mwh_single_column .wn_mwh_latest_posts_rigth_column {
                width: 100%;
                margin-left: 0px;
            }

            .wn_mwh_rc_one_wrapper .wn_mwh_header_wrapper {
                margin-bottom: 13px;
            }

            .wn_mwh_rc_one_wrapper .wn_mwh_header_wrapper > span {
                text-transform: uppercase;
            }

            .wn_animated_herb {
                width: 340px;
                height: 32px;
                background-color: #443C1B;
                position: relative;
                cursor: pointer;
                text-align: center;
                border-radius: 0px;
                transition: 1s ease;
            }

            .wn_animated_herb span {
                color: white;
                font-family: Verdana, Geneva, Tahoma, sans-serif;
                font-size: 11px;
                font-weight: 500;
                line-height: 32px;
            }

            .wn_mwh_instagram_feed_wrapper {
                display: grid;
                grid-template-columns: repeat(6, minmax(0px, 1fr));
                grid-gap: 1rem;
            }

            .wn_ig_single_container {
                display: grid;
                background-color: black;
                position: relative;
                /* overflow: hidden; */
                cursor: pointer;
            }

            .wn_ig_single_container:before {
                content: "";
                padding-bottom: 100%;
                display: block;
            }

            .wn_ig_single_container::after {
                content: "";
                background-image: linear-gradient(to bottom, #000000c9, #0000009e, #000000c9);
                width: 100%;
                height: 100%;
                position: absolute;
                left: 0;
                top: 0;
                opacity: 0;
                transition: 0.7s ease;
                pointer-events: none;
            }

            .wn_ig_single_container img {
                width: 100%;
                display: block;
                position: absolute;
                height: 100%;
                object-fit: cover;
                transition: 0.5s ease;
            }

            .wn_ig_single_container a {
                display: block;
                width: 100%;
                height: 100%;
                transition: 0.7s ease;
            }

            .wn_ig_image_wrapper {
                position: absolute;
                overflow: hidden;
                width: 100%;
                height: 100%;
            }

            .wn_ig_icon::before {
                content: "\f16d";
                font-family: FontAwesomeSlick;
                position: absolute;
                left: 50%;
                top: 50%;
                transform: translate(-50%, -50%);
                font-size: 50px;
                color: #fff;
                display: block;
                opacity: 0;
                transition: 0.5s ease;
                font-style: normal;
                z-index: 20;
                pointer-events: none;
            }

            .wn_mwh_instagram_text {
                position: absolute;
                background-color: #f7f1ec;
                width: calc(100% + 100px);
                height: auto;
                left: 10px;
                bottom: 50px;
                color: #313130;
                display: block;
                font-size: 12px;
                text-align: left;
                padding: 10px;
                margin: 5px;
                box-shadow: 2px 2px 5px #3131306e;
                z-index: 1000;
                opacity: 0;
                pointer-events: none;
            }

            .wn_ig_single_container:nth-child(6) .wn_mwh_instagram_text, .wn_ig_single_container:last-child .wn_mwh_instagram_text {
                left: unset;
                right: 10px;
            }

            .wn_mwh_hero_slider_bg_img {
                position: relative;
                padding-top: 40.72%;
                background-size: cover;
                -moz-background-size: cover;
                /* Firefox 3.6 */
                background-position: center;
            }

            .wn_mwh_hero_text_img {
                position: absolute;
                top: 10%;
                left: 5%;
                width: 32%;
                height: auto;
            }

            .wn_mwh_hero_link_wrapper {
                width: 50%;
                position: absolute;
                bottom: 18%;
                text-align: center;
                left: 12.9%;
                cursor: pointer;
                text-align: left;
            }

            .wn_mwh_hero_links {
                background-color: transparent;
                position: relative;
                font-size: 17px;
                font-family: Anton;
                width: 100%;
                z-index: 0;
                color: rgb(173, 162, 154);
                letter-spacing: 1px;
            }

            .wn_mwh_hero_links::before {
                content: "";
                position: absolute;
                width: calc(100%);
                z-index: -1;
                top: 50%;
                background-repeat: no-repeat;
                background-size: cover;
                transform: translateY(calc(-50% - 1px)) scale(1.5);
            }

            .wn_mwh_hero_link_1::before {
                background-image: url('<?php echo $site_url; ?>/wp-content/uploads/2021/02/Artboard-61-1.png');
                padding-top: 12.17%;
            }

            .wn_mwh_hero_link_2::before {
                background-image: url('<?php echo $site_url; ?>/wp-content/uploads/2021/02/Artboard-61.png');
                padding-top: 20.06%;
            }

            .wn_homepage-content {
                width: 100%;
                max-width: 970px;
                margin-left: auto;
                margin-right: auto;
                padding-left: 0px !important;
                padding-right: 0px !important;
            }

            .wn_mwh_single_post_container {
                display: flex;
                margin-bottom: 20px;
            }

            .wn_posts_shower_wrapper .wn_mwh_single_post_image {
                width: 120px;
                height: 120px;
                object-fit: cover;
                max-width: unset;
            }

            .wn_mwh_single_post_content_container {
                margin-left: 15px;
            }

            .wn_mwh_single_post_title {
                font-size: 14px;
                font-weight: 900;
                line-height: 18px;
                margin-bottom: 10px;
                transition: 0.5s ease;
            }

            .wn_mwh_single_metadata {
                color: #999;
                font-size: 11px;
                margin-bottom: 5px;
            }

            .wn_mwh_single_post_excerpt {
                font-size: 13px;
            }

            .wn_posts_shower_unset_a_styles {
                all: unset !important;
                cursor: pointer !important;
            }

            .wn_mwh_rating_wrapper {
                display: flex;
                justify-content: flex-start;
                align-items: center;
            }

            .wn_mwh_rating_wrapper span {
                color: #999;
                margin-left: 5px;
            }

            .wn_ct_icon__stars {
                display: flex;
                height: auto;
            }

            .wn_ct_icon_stars_styles {
                width: 17px;
                height: auto;
            }


            body::after {
                opacity: 0 !important;
            }

            
            .trending {
                max-width: 970px;
                position: relative;
                padding: 15px 0 0 0;
                z-index: 100;
                height: 41px;
                width: 100%;
                margin-left: auto;
                margin-right: auto;
            }

            .trending .items-wrapper {
                width: 100%;
                top: -27px;
                position: relative;
                overflow: hidden;
                height: 29px;
            }

            .trending .items {
                width: 100%;
                padding: 0 0 0 95px;
                text-overflow: clip;
                white-space: nowrap;
                transition: 0.2s all;
            }

            .trending .items .item {
                display: inline-block;
            }

            .trending .items .item:after {
                content: "●";
                margin: 0 3px;
            }

            .trending .items .item .legend-default {
                margin: 0 0 0 3px;
            }

            .trending .controls {
                position: absolute;
                top: 14px;
                left: 95px;
                display: none;
                z-index: 10000;
            }

            .trending .social {
                position: absolute;
                top: 12px;
                right: 0;
                font-size: 17px;
                background: #f7f7f7;
                padding: 0 0 0 15px;
            }

            .trending .social a {
                color: #999;
            }

            /* .header {
                padding: 0;
                margin: 30px auto;
                position: relative;
                z-index: 100;
                display: table;
            }

            .header .logo-image {
                padding: 0;
                width: 242px;
                text-align: center;
                vertical-align: middle;
                display: table-cell;
                height: 95px;
            } */

            .trending .controls, .trending .social {
                background-color: transparent !important;
            }

            .title-default > a.active {
                background-color: transparent !important;
            }

            .title-default > a.active {
                background-color: #f7f7f7;
            }

            .trending .items {
                margin: 0 0 0 95px;
                padding: 0;
            }

            .trending .items .item {
                display: none;
            }

            .trending .items .item:first-child {
                display: block;
            }

            .trending .items .item:after {
                content: '';
                margin: 0;
            }

            .trending .controls {
                z-index: 100;
            }

            .wn_header {
                max-width: 970px;
                width: 100%;
                margin-left: auto;
                margin-right: auto;
                height: 100px;
                display: flex;
                justify-content: center;
                margin-bottom: 20px;
            }

            .wn_header a {
                text-align: center;
            }

            .wn_logo_image img {
                height: 100% !important;
            }

            .wn_mwh_product_meta {
                width: 50% !important;
                margin-left: -20px !important;
            }

        </style>
    <?php wp_head(); ?>
        
	</head>
    <?php $body_class = 'preload'; ?>
	<body <?php body_class($body_class); ?>>
        <?php wp_body_open(); ?>
            <?php get_template_part('theme/templates/header'); ?>
