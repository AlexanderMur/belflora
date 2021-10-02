<footer class="footer">
    <div class="container">
        <div class="footer__top">
            <div class="footer__item">
                <div class="footer__logo"><img src="<?php echo get_theme_file_uri('dist/assets/img/logo.svg') ?>" alt=""></div>
            </div>
            <div class="footer__item">
                <div class="footer__contact">
                    <div class="footer__circle">
                        <svg class="svgsprite _marker">
                            <use xlink:href="<?php echo get_theme_file_uri("dist/assets/img/sprites/svgsprites.svg#marker") ?>"></use>
                        </svg>
                    </div>
                    <div class="contact">
                        <p class="text-title"><?php echo options()->get('address') ?></p>
                        <div class="grey-description"><?php echo options()->get('work_time') ?></div>
                    </div>
                </div>
            </div>
            <div class="footer__item">
                <div class="footer__contact">
                    <a href="tel:<?php echo options()->get('phone') ?>" class="footer__circle">
                        <svg class="svgsprite _phone-footer">
                            <use xlink:href="<?php echo get_theme_file_uri("dist/assets/img/sprites/svgsprites.svg#phone-footer") ?>"></use>
                        </svg>
                    </a>
                    <div class="contact">
                        <p class="text-title"><?php echo options()->get('phone') ?></p><a class="grey-description" href="#"><?php echo options()->get('phone_text') ?></a>
                    </div>
                </div>
            </div>
            <div class="footer__item">
                <div class="footer__contact">
                    <div class="footer__circle">
                        <svg class="svgsprite _inst">
                            <use xlink:href="<?php echo get_theme_file_uri("dist/assets/img/sprites/svgsprites.svg#inst") ?>"></use>
                        </svg>
                    </div>
                    <div class="contact">
                        <p class="text-title">Instagram</p>
                    </div>
                </div>
            </div>
        </div>
        <div class="footer__center">
            <div class="footer__item">
                <p class="copyright">© Использование любого контента, размещенного на сайте, возможно только с
                    разрешения правообладателей</p><img class="pay-img" src="<?php echo get_theme_file_uri('dist/assets/img/payments.png') ?>" alt="">
            </div>
            <div class="footer__item">

                <?php
                wp_nav_menu(
                    array(
                        'theme_location'  => 'footer1',
                        'li_class' => 'footer__link',
                        'a_class' => 'link',
                    )
                );
                ?>
            </div>
            <div class="footer__item">

                <?php
                wp_nav_menu(
                    array(
                        'theme_location'  => 'footer2',
                        'li_class' => 'footer__link',
                        'a_class' => 'link',
                    )
                );
                ?>
            </div>
            <div class="footer__item">

                <?php
                wp_nav_menu(
                    array(
                        'theme_location'  => 'footer3',
                        'li_class' => 'footer__link',
                        'a_class' => 'link',
                    )
                );
                ?>
            </div>
        </div>
        <div class="footer__bottom">
            <p><a href="#"> Политика конфиденциальности</a></p>
            <p>
                Разработка сайта <a href="#">QUADRA </a></p>
        </div>
    </div>
</footer>
<footer class="mobile-footer">
    <div class="container">
        <div class="accardeon">
            <div class="accardeon__item">
                <div class="accardeon__main">Контактная информация</div>
                <div class="accardeon__drop">
                    <div class="footer__contact">
                        <div class="footer__circle">
                            <svg class="svgsprite _marker">
                                <use xlink:href="<?php echo get_theme_file_uri("dist/assets/img/sprites/svgsprites.svg#marker") ?>"></use>
                            </svg>
                        </div>
                        <div class="contact">
                            <p class="text-title">Проспект славы, 86</p>
                            <div class="grey-description">с 8 до 20:00, без выходных</div>
                        </div>
                    </div>
                    <div class="footer__contact">
                        <div class="footer__circle">
                            <svg class="svgsprite _phone-footer">
                                <use xlink:href="<?php echo get_theme_file_uri("dist/assets/img/sprites/svgsprites.svg#phone-footer") ?>"></use>
                            </svg>
                        </div>
                        <div class="contact">
                            <p class="text-title">+ 7 (924) 240-90-74</p><a class="grey-description" href="#">Заказать
                                звонок </a>
                        </div>
                    </div>
                    <div class="footer__contact">
                        <div class="footer__circle">
                            <svg class="svgsprite _inst">
                                <use xlink:href="<?php echo get_theme_file_uri("dist/assets/img/sprites/svgsprites.svg#inst") ?>"></use>
                            </svg>
                        </div>
                        <div class="contact">
                            <p class="text-title">Instagram</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="accardeon__item">
                <div class="accardeon__main">Основные разделы</div>
                <div class="accardeon__drop">
                    <div class="footer__link"><a class="link" href="#">Online витрина</a></div>
                    <div class="footer__link"><a class="link" href="#">Коллекции</a></div>
                    <div class="footer__link"><a class="link" href="#">Актуальное</a></div>
                    <div class="footer__link"><a class="link" href="#">Доставка и оплата</a></div>
                </div>
            </div>
            <div class="accardeon__item">
                <div class="accardeon__main">Информация о компании</div>
                <div class="accardeon__drop">
                    <div class="footer__link"><a class="link" href="#">О нас</a></div>
                    <div class="footer__link"><a class="link" href="#">Отзывы</a></div>
                    <div class="footer__link"><a class="link" href="#">Контакты</a></div>
                </div>
            </div>
            <div class="accardeon__item">
                <div class="accardeon__main">Способы оплаты</div>
                <div class="accardeon__drop"><img class="pay-img" src="<?php echo get_theme_file_uri('/dist/assets/img/payments.png') ?>" alt=""></div>
            </div>
        </div>
        <p class="copyright">© Использование любого контента, размещенного на сайте, возможно только с разрешения
            правообладателей</p>
        <div class="footer__bottom">
            <p><a href="#"> Политика конфиденциальности</a></p>
            <p>
                Разработка сайта <a href="#">QUADRA </a></p>
        </div>
    </div>
</footer>
<div class="basket">

    <div class="basket__bg -js-fadeoutbasket"></div>

    <?php get_template_part('template', 'sidebar-cart') ?>
</div>
<div class="mobile-bar">
    <div class="mobile-bar__item">
        <button class="mobile-bar__btn mobile-bar__btn--open -js-fadeoutbasket -js-fadeinmenu">
            <div class="mobile-bar__ico">
                <svg class="svgsprite _burger">
                    <use xlink:href="<?php echo get_theme_file_uri("dist/assets/img/sprites/svgsprites.svg#burger") ?>"></use>
                </svg>
            </div>
            <div class="mobile-bar__text">Меню</div>
        </button>
        <button class="mobile-bar__close -js-fadeoutmenu">
            <div class="mobile-bar__ico">
                <svg class="svgsprite _close">
                    <use xlink:href="<?php echo get_theme_file_uri("dist/assets/img/sprites/svgsprites.svg#close") ?>"></use>
                </svg>
            </div>
            <div class="mobile-bar__text">Закрыть</div>
        </button>
    </div>
    <div class="mobile-bar__item">
        <button class="mobile-bar__btn mobile-bar__btn--open -js-fadeinbasket -js-fadeoutmenu">
            <div class="mobile-bar__ico">
                <svg class="svgsprite _mobile-basket">
                    <use xlink:href="<?php echo get_theme_file_uri("dist/assets/img/sprites/svgsprites.svg#mobile-basket") ?>"></use>
                </svg>
            </div>
            <div class="mobile-bar__text">Корзина</div>
        </button>
        <button class="mobile-bar__close -js-fadeoutbasket">
            <div class="mobile-bar__ico">
                <svg class="svgsprite _close">
                    <use xlink:href="<?php echo get_theme_file_uri("dist/assets/img/sprites/svgsprites.svg#close") ?>"></use>
                </svg>
            </div>
            <div class="mobile-bar__text">Закрыть</div>
        </button>
    </div>
    <div class="mobile-bar__item">
        <!-- навесть .active если надо активной сделать, на странице избранное--><a
                class="mobile-bar__btn mobile-bar__btn--link" href="<?php echo '/избранное'; ?>">
            <div class="mobile-bar__ico">
                <svg class="svgsprite _feature">
                    <use xlink:href="<?php echo get_theme_file_uri("dist/assets/img/sprites/svgsprites.svg#feature") ?>"></use>
                </svg>
            </div>
            <div class="mobile-bar__text">Избранное</div>
        </a>
    </div>
</div>
<?php wp_footer() ?>
</body>
</html>
