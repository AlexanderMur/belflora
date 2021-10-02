<?php

use Belfora\Cart;
use function Belfora\get_sorted_menu;
global $post;
?>
<!DOCTYPE html>
<html class="no-js" lang="ru">
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0">
    <meta name="format-detection" content="telephone=no">

   <?php wp_head();?>
    <?php
    if ($post instanceof WP_Post) {
        $product = wc_get_product($post);
        if ($product instanceof WC_Product) {
            $keywords = $product->get_meta('_keywords');
            if ($keywords) {
                ?>
                <meta name="keywords" content="<?php echo esc_attr($keywords) ?>">
                <?php
            }
        }
    }
    ?>
</head>
<body <?php body_class('body')?>>
    <div class="header header-size">
        <div class="container">
            <div class="header__wrap">
                <div class="mobile-search">
                    <div class="search search-main">
                        <button class="circle__button search__btn -js-searchopen">
                            <svg class="svgsprite _search">
                                <use xlink:href="<?php echo get_template_directory_uri() ?>/dist/assets/img/sprites/svgsprites.svg#search"></use>
                            </svg>
                        </button>
                        <input class="search__input" type="text" placeholder="Поиск...">
                        <button class="search__close -js-searchclose">
                            <svg class="svgsprite _close">
                                <use xlink:href="<?php echo get_template_directory_uri() ?>/dist/assets/img/sprites/svgsprites.svg#close"></use>
                            </svg>
                        </button>
                    </div>
                </div>
                <nav class="nav header__nav">
                    <?php
                    wp_nav_menu(
                        array(
                            'theme_location'  => 'header',
                            'container' => ''
                        )
                    );
                    ?>
                </nav><a class="header__logo" href="<?php echo home_url() ?>"> <img src="<?php echo get_theme_file_uri('dist/assets/img/logo.svg') ?>" alt=""></a>

                <div class="header__info">
                    <div class="work-time"><?php echo options()->get('order_time') ?></div>
                    <div class="header__buttons">
                        <button class="circle__button circle__button--phone">
                            <svg class="svgsprite _phone">
                                <use xlink:href="<?php echo get_template_directory_uri() ?>/dist/assets/img/sprites/svgsprites.svg#phone"></use>
                            </svg>
                            <div class="tooltip --mright">
                                <div class="contact contact--margin">
                                    <a href="tel:<?php echo options()->get('phone') ?>" class="text-title"><?php echo options()->get('phone') ?></a><a class="grey-description popup-link" href="#contact-popup"><?php echo options()->get("phone_text") ?></a>
                                    <div id="contact-popup" class="white-popup mfp-hide">
                                        <?php echo do_shortcode('[contact-form-7 id="918" title="Contact form 1"]') ?>
                                    </div>
                                </div>
                                <div class="contact contact--margin">
                                    <p class="text-title"><?php echo options()->get('address') ?></p>
                                    <div class="grey-description"><?php echo options()->get('work_time') ?></div>
                                </div><a class="contact contact--social">
                                    <a href="<?php echo options()->get('instagram_link') ?>" class="circle__button circle__button--inst --black">
                                        <svg class="svgsprite _inst">
                                            <use xlink:href="<?php echo get_template_directory_uri() ?>/dist/assets/img/sprites/svgsprites.svg#inst"></use>
                                        </svg>
                                    </a>
                                    <p class="text-title">Instagram</p></a>
                            </div>
                        </button>
                        <?php
                        function getPageUrl($TEMPLATE_NAME){
                            $url = null;
                            $pages = get_pages(array(
                                'meta_key' => '_wp_page_template',
                                'meta_value' => $TEMPLATE_NAME
                            ));
                            if(isset($pages[0])) {
                                $url = get_page_link($pages[0]->ID);
                            }
                            return $url;
                        }
                        $likes = WC()->session->get('likes') ?? [];
                        $likes_url = getPageUrl('page-likes.php');
                        ?>
                        <a class="circle__button" href="<?php echo $likes_url ?>">
                            <svg class="svgsprite _heart">
                                <use xlink:href="<?php echo get_template_directory_uri() ?>/dist/assets/img/sprites/svgsprites.svg#heart"></use>
                            </svg>
                            <div class="feature__number"><?php echo count($likes) ?></div></a>
                        <button class="circle__button circle__button--basket -js-fadeinbasket" href="#">
                            <svg class="svgsprite _basket">
                                <use xlink:href="<?php echo get_template_directory_uri() ?>/dist/assets/img/sprites/svgsprites.svg#basket"></use>
                            </svg>
                            <div class="basket__number"><?php echo Cart::getCartCount() ?></div>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
        <div class="mobile-menu">
    <div class="conatiner">
        <?php
        function render_menu($items) {
            foreach ($items as $item) {

                if ($item->children) {
                    ?>
                    <div class="accardeon__item">
                        <div class="accardeon__main"><?php echo $item->title ?></div>
                        <div class="accardeon__drop">
                            <?php
                            render_menu($item->children);
                            ?>
                        </div>
                    </div>
                    <?php
                } else {
                    ?>
                    <div class="mobile-menu__link"> <a class="nav__link" href="#"><?php echo $item->title ?></a></div>
                    <?php
                }
            }
        }

        $menu_items = get_sorted_menu('top_mobile');
        ?>
        <nav class="mobile-menu__nav">
            <div class="accardeon">
                <?php render_menu($menu_items); ?>
            </div>
        </nav>
        <?php
        ?>

        <div class="mobile-menu__contacts">
            <div class="footer__contact">
                <div class="footer__circle">
                    <svg class="svgsprite _marker">
                        <use xlink:href="<?php echo get_template_directory_uri() ?>/dist/assets/img/sprites/svgsprites.svg#marker"></use>
                    </svg>
                </div>
                <div class="contact">
                    <p class="text-title"><?php echo options()->get('address') ?></p>
                    <div class="grey-description"><?php echo options()->get('work_time') ?></div>
                </div>
            </div>
            <div class="footer__contact">
                <a href="tel:<?php echo options()->get('phone') ?>" class="footer__circle">
                    <svg class="svgsprite _phone-footer">
                        <use xlink:href="<?php echo get_template_directory_uri() ?>/dist/assets/img/sprites/svgsprites.svg#phone-footer"></use>
                    </svg>
                    <div class="contact">
                        <p class="text-title"><?php echo options()->get('phone') ?></p><?php echo options()->get('phone_text') ?>
                    </div>
                </a>
            </div>
            <div class="footer__contact">
                <div class="footer__circle">
                    <svg class="svgsprite _inst">
                        <use xlink:href="<?php echo get_template_directory_uri() ?>/dist/assets/img/sprites/svgsprites.svg#inst"></use>
                    </svg>
                </div>
                <div class="contact">
                    <a href="<?php echo options()->get('instagram_link') ?>" class="text-title">Instagram</a>
                </div>
            </div>
        </div>
    </div>
</div>
