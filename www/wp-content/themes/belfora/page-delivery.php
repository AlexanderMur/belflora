<?php

/*
 * Template Name: Доставка и оплата
 * */
?>
<?php get_header(); ?>

<div class="content">
    <section class="main-banner --background-3">
        <div class="container">
            <?php
            woocommerce_breadcrumb([
                'wrap_before' => '<div class="crumbs --white --center crumbs--mainbanner">',
                'wrap_after' => '</div>',
                'delimiter' => '',
            ]);
            ?>
            <h1 class="main-banner__title --white"><?php echo get_the_title() ?></h1>
            <div class="main-banner__search">
                <div class="search search-main">
                    <button class="circle__button search__btn -js-searchopen">
                        <svg class="svgsprite _search">
                            <use xlink:href="<?php echo get_theme_file_uri('dist/assets/img/sprites/svgsprites.svg#search') ?>"></use>
                        </svg>
                    </button>
                    <input class="search__input" type="text" placeholder="Поиск...">
                    <button class="search__close -js-searchclose">
                        <svg class="svgsprite _close">
                            <use xlink:href="<?php echo get_theme_file_uri('dist/assets/img/sprites/svgsprites.svg#close') ?>"></use>
                        </svg>
                    </button>
                </div>
                <div class="main-banner__items">
                    <div class="main-banner__item"><img class="main-banner__ico" src="<?php echo get_theme_file_uri('dist/assets/img/banners/i1.svg') ?>"
                                                        alt="">
                        <p class="main-banner__text">Монобукеты</p>
                    </div>
                    <div class="main-banner__item"><img class="main-banner__ico" src="<?php echo get_theme_file_uri('dist/assets/img/banners/i2.svg') ?>"
                                                        alt="">
                        <p class="main-banner__text">Сборные букеты</p>
                    </div>
                    <div class="main-banner__item"><img class="main-banner__ico" src="<?php echo get_theme_file_uri('dist/assets/img/banners/i3.svg') ?>"
                                                        alt="">
                        <p class="main-banner__text">Композиции</p>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section class="section-delivery">
        <div class="container">
            <div class="delivery">
                <div class="title-text">
                    <h2 class="--text"><?php echo options()->get('delivery_title') ?></h2>
                    <p class="text"><?php echo options()->get('delivery_subtitle') ?></p>
                </div>
                <div class="delivery__price">
                    <div class="delivery__block">
                        <?php
                        $types = options()->get('delivery_types');
                        foreach ($types as $type) {
                            ?>
                            <div class="delivery__item">
                                <div class="delivery__name"><?php echo $type['text'] ?></div>
                                <div class="delivery__summ"><?php echo $type['price'] ?></div>
                            </div>
                            <?php
                        }
                        ?>
                    </div>
                    <div class="delivery__block">
                        <?php
                        $rajons = options()->get('delivery_rajons');
                        foreach ($rajons as $rajon) {
                            ?>
                            <div class="delivery__item">
                                <div class="delivery__name"><?php echo $rajon['text'] ?></div>
                                <div class="delivery__summ"><?php echo $rajon['price'] ?></div>
                            </div>
                            <?php
                        }
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section class="pay-section">
        <div class="container">
            <div class="pay">
                <h2 class="pay__title">Способы оплаты заказа</h2>
                <div class="pay__list"><a class="pay__item" href="<?php echo options()->get('delivery_payment_method1_link') ?>">
                        <div class="pay_ico">
                            <svg class="svgsprite _<?php echo options()->get('delivery_payment_method1_image') ?>">
                                <use xlink:href="<?php echo get_theme_file_uri('dist/assets/img/sprites/svgsprites.svg#' . options()->get('delivery_payment_method1_image')) ?>"></use>
                            </svg>
                        </div>
                        <p class="pay__text"><?php echo options()->get('delivery_payment_method1_title') ?></p></a><a class="pay__item" href="<?php echo options()->get('delivery_payment_method2_link') ?>">
                        <div class="pay_ico">
                            <svg class="svgsprite _<?php echo options()->get('delivery_payment_method2_image') ?>">
                                <use xlink:href="<?php echo get_theme_file_uri('dist/assets/img/sprites/svgsprites.svg#' . options()->get('delivery_payment_method2_image')) ?>"></use>
                            </svg>
                        </div>
                        <p class="pay__text"><?php echo options()->get('delivery_payment_method2_title') ?></p></a><a class="pay__item" href="<?php echo options()->get('delivery_payment_method3_link') ?>">
                        <div class="pay_ico">
                            <svg class="svgsprite _<?php echo options()->get('delivery_payment_method3_image') ?>">
                                <use xlink:href="<?php echo get_theme_file_uri('dist/assets/img/sprites/svgsprites.svg#' . options()->get('delivery_payment_method3_image')) ?>"></use>
                            </svg>
                        </div>
                        <p class="pay__text"><?php echo options()->get('delivery_payment_method3_title') ?></p></a><a class="pay__item" href="<?php echo options()->get('delivery_payment_method4_link') ?>">
                        <div class="pay_ico">
                            <svg class="svgsprite _<?php echo options()->get('delivery_payment_method4_image') ?> ">
                                <use xlink:href="<?php echo get_theme_file_uri('dist/assets/img/sprites/svgsprites.svg#' . options()->get('delivery_payment_method4_image')) ?>"></use>
                            </svg>
                        </div>
                        <p class="pay__text"><?php echo options()->get('delivery_payment_method4_title') ?></p></a></div>
            </div>
        </div>
    </section>
    <section class="how-section">
        <div class="container">
            <div class="how">
                <h2 class="how-section__title">Как происходит оплата?</h2>
                <div class="how-section__list">
                    <div class="how-section__item">
                        <p><?php echo options()->get('delivery_steps_step1') ?></p>
                    </div>
                    <div class="how-section__item">
                        <p><?php echo options()->get('delivery_steps_step2') ?></p>
                    </div>
                    <div class="how-section__item">
                        <p><?php echo options()->get('delivery_steps_step3') ?></p>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section class="text-section">
        <div class="container">
            <div class="text-block">
                <h2 class="text-block__title"><?php echo options()->get('delivery_delivery_title') ?></h2>
                <div class="text-block__list">
                    <div class="text__item">
                        <p class="text"><?php echo options()->get('delivery_delivery_left') ?></p>
                    </div>
                    <div class="text__item">
                        <p class="text"><?php echo options()->get('delivery_delivery_right') ?></p>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

<?php get_footer() ?>
