<?php


    $cat_id = get_query_var('cat');
    if($cat_id == 0) {
        global $post;
        $current_permalink = get_permalink($post->ID);
    }
    else {
        $current_permalink = get_category_link($cat_id);
    }
    $menu_items = wp_get_nav_menu_items(51);

?>

<style>
        .wn_mwh_menu_wrapper {
            background-color: #232b19;
            margin-left: auto;
            margin-right: auto;
            max-width: 970px;
            width: 100%;
            border-bottom: 3px solid #ada29a;
            color: white;
            z-index: 100;
            position: relative;
        }

        .wn_mwh_menu_add_to_cart {
            position: absolute;
            right: 0;
            top: 50%;
            transform: translateY(-50%);
            padding-right: 20px;
        }

        .wn_mwh_menu_add_to_cart_cart {
            position: relative;
            cursor: pointer;
        }

        .wn_mwh_menu_add_to_cart_cart:hover .wn_mwh_menu_add_to_cart_icon{
            transform: scale(1.08);
            transition: 0.3s ease;
        }

        .wn_mwh_menu_add_to_cart_items_number {
            position: absolute;
            display: block;
            top: -5px;
            right: calc(100% - 5px);
            font-size: 10px;
            font-weight: 700;
            color: var(--wn_mwh_secondary_color);
            background-color: #fff;
            padding: 0px 5px;
            border-radius: 50px;
            font-size: 10px;
            line-height: 1.4em;
        }

        .wn_mwh_menu_add_to_cart_icon {
            display: block;
            width: 20px;
            height: 20px;
            background-image: url('data:image/svg+xml;utf8,<svg fill="rgb(255, 255, 255)" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><path d="M24 3l-.743 2h-1.929l-3.474 12h-13.239l-4.615-11h16.812l-.564 2h-13.24l2.937 7h10.428l3.432-12h4.195zm-15.5 15c-.828 0-1.5.672-1.5 1.5 0 .829.672 1.5 1.5 1.5s1.5-.671 1.5-1.5c0-.828-.672-1.5-1.5-1.5zm6.9-7-1.9 7c-.828 0-1.5.671-1.5 1.5s.672 1.5 1.5 1.5 1.5-.671 1.5-1.5c0-.828-.672-1.5-1.5-1.5z"/></svg>');
            background-size: contain;
            background-repeat: no-repeat;
            transition: 0.3s ease;
        }

        .wn_mwh_nav_ul > li > a {
            
            font-family: Abel;
            font-size: 15px;
            font-weight: 900;
            text-transform: uppercase;
            color: white;
            padding: 15px 17px;
            display: block;
            transition: 0.3s ease;
            
        }

        .wn_mwh_menu_wrapper .active > a{
            background-color: #ada29a;
            color: #232b19;
        }

        .wn_mwh_menu_wrapper a {
            text-decoration: none;
        }

        .wn_mwh_nav_ul {
            margin: 0px;
            list-style-type: none;
            list-style: none;
            list-style-image: none;
            text-align: left;
            padding-left: 0px;
            height: 48px;
        }

        .wn_mwh_nav_ul .dropdown-menu {
            display: none;
            position: absolute;
            top: 100% !important;
            width: 100%;
            left: 0px;
        }

        .wn_mwh_nav_ul .dropdown-menu ul {
            padding-left: 0px;
            width: 100%;
            max-width: 150px;
            margin: 20px;
        }

        .wn_mwh_nav_ul .dropdown-menu ul > li {
            list-style-type: none;
            
        }
        .wn_mwh_nav_ul .dropdown-menu ul > li > a {
            font-family: "Quicksand";
            font-size: 13px;
            font-weight: 400;
            color: #fff;

            padding: 15px 17px;
            display: block;
        }

        .wn_mwh_nav_ul .dropdown-menu ul > li:not(:first-child) {
            border-top: 1px solid #5e5e5e;
        }
        

        .wn_mwh_nav_ul > li {
            display: inline-block;
        }

        .wn_mwh_nav_ul > li:hover .dropdown-menu{
            display: flex;
        }

        .wn_mwh_menu_pos_fixed{
            background-color: transparent;
            width: 100%;
            z-index: 100;
            left: 0;
            top: 0;
            /* transition: 0.5s ease; */
        }

        .wn_mwh_menu_pos_fixed__active {
            position: fixed;
            /* transition: 0.5s ease; */
            background-color: #232b19;
          
        }

        .wn_mwh_menu_pos_fixed__active .wn_mwh_menu_wrapper::before {
            content: "";
            position: absolute;
            height: 3px;
            width: 100vw;
            background-color: #ada29a;
            left: 50%;
            bottom: -3px;
            transform: translateX(-50vw);
        }

        .wn_mwh_menu_pos_fixed__active .wn_mwh_nav_ul > li > a {
            padding: 5px 17px;
            transition: 0.3s ease;
        }

        .wn_mwh_menu_pos_fixed__active .wn_mwh_nav_ul {
            height: auto !important;
        }

        .wn_mwh_menu_fixed_height {
            height: 48px;
            margin-bottom: 20px;

        }

        .wn_mwh_menu_responsive_wrapper {
            display: none;
            margin-bottom: 20px;
            background-color: #232b19;
        }

        .wn_mwh_menu_responsive_wrapper a {
            font-family: Abel;
            font-size: 15px;
            font-weight: 900;
            text-transform: uppercase;
            color: white;
            display: block;
            transition: 0.3s ease;
            text-decoration: none;
            
        }

        .wn_mwh_menu_responsive_wrapper .wn_mwh_bar_flex a:nth-child(1) {
            background-color: #ada29a;
            padding: 15px 17px;
        }
        .wn_mwh_menu_responsive_wrapper .wn_mwh_bar_flex a:nth-child(2) {
            
            display: flex;
            align-items: center;
            justify-content: center;
            width: 50px;
            fill: white;
        }

        .wn_dropdown_wrapper {
            display: block;  
            background-color: #252b1a;
            position: absolute;
            z-index: 100;
            width: calc(100% - 20px);
            display: none;

    
        }

        .wn_mwh_bar_flex {
            display: flex;
            justify-content: space-between;
        }

        
        .wn_mwh_nav_ul_responsive {
            margin: 0px;
            padding: 0px;
        }

        .wn_dropdown_wrapper > ul {
            margin-left: 15px;
            margin-top: 10px;
            list-style-type: none;
        }

        .wn_dropdown_wrapper .wn_mwh_nav_ul_responsive > li {
            padding: 10px 0px;
            
        }

        .wn_dropdown_wrapper .wn_mwh_nav_ul_responsive > li:not(:first-child) {
            border-top: 1px solid #5e5e5e;
        }
        

        .wn_mwh_menu_level2_ul {
            margin-left: 0px;
            padding-left: 0px;
            margin-top: 15px;
            margin-bottom: 15px;
            list-style-type: none;
        }

        .wn_mwh_menu_level2_ul > li {
            padding: 2px 0px;
        }

        .wn_mwh_menu_level2_ul li a {
            font-family: "Quicksand";
            font-size: 12px;
            text-transform: capitalize;
        }

        .wn_dropdown_wrapper__active {
            display: block;
        }
    
                
    </style>
    <div class="wn_mwh_menu_responsive_wrapper">

        <div class="wn_mwh_bar_flex">
            <a href="<?php echo $menu_items[0]->url; ?>"><?php echo $menu_items[0]->title?>
            </a>
            
            <a id="wn_mwh_hamburger_link" href="">                
                <svg class="wn_mhw_burger_icon" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><path d="M24 6h-24v-4h24v4zm0 4h-24v4h24v-4zm0 8h-24v4h24v-4z"/></svg>                
            </a>
        </div>

        <div class="wn_dropdown_wrapper">
            <ul class="wn_mwh_nav_ul_responsive">
                <?php

                    $new_ul = true;

                    for( $i = 0; $i < count($menu_items); $i++ ) {

                        if( $menu_items[$i]->menu_item_parent == '0' ) {

                            $new_ul = true;
                            ?>
                                <li class="<?php if( $menu_items[$i]->url == $current_permalink ) echo 'active'; ?>">
                                    <a href="<?php echo $menu_items[$i]->url; ?>"><?php echo $menu_items[$i]->title; ?></a>
                            <?php

                        }
                        else {

                            if ($new_ul){

                                echo '<ul class="wn_mwh_menu_level2_ul">';

                            }

                            $new_ul = false;

                            echo '<li><a href="' . $menu_items[$i]->url . '">' . $menu_items[$i]->title . '</a></li>';

                            if($menu_items[$i + 1]->menu_item_parent == '0') {

                                echo '</ul>';

                            }
                        }
                    }?>
                </li>
            </ul>
        </div>
    </div>
    <div class="wn_mwh_menu_fixed_height">
        <div class="wn_mwh_menu_pos_fixed">
            <div class="wn_mwh_menu_wrapper">
                <ul class="wn_mwh_nav_ul">
                    <?php
                        foreach($menu_items as $menu_item) {
                            if($menu_item->menu_item_parent == '0') {
                                ?>
                                    <li class="<?php if($menu_item->url == $current_permalink) echo 'active'; ?>">
                                        <a href="<?php echo $menu_item->url; ?>"><?php echo $menu_item->title?></a>
                                    </li>
                                <?php
                            }
                        }
                    ?>
                    <li>
                        <!--Cart section-->
                        <?php require_once get_stylesheet_directory() . '/templates/woocommerce/cart_section.php'; ?>
                    </li>
                </ul>
            </div>
        </div>
    </div>



