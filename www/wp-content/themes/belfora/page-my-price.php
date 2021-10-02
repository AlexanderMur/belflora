<?php

/*
 * Template Name: Моя цена
 * */
?>
<?php get_header(); ?>

<div id="primary" class="content-area">
    <main id="main" class="site-main" role="main">
        <div class="content">
            <section class="main-banner --background-3">
                <div class="container">
                    <div class="crumbs --white --center crumbs--mainbanner"><a class="crumbs__link" href="#">Главная страница</a><a class="crumbs__link" href="#">Избранное</a>
                    </div>
                    <h1 class="main-banner__title --white">Избранное</h1>
                    <div class="main-banner__search">

                        <?php get_template_part('template','search') ?>
                        <div class="main-banner__items">
                            <div class="main-banner__item"><img class="main-banner__ico" src="<?php echo get_theme_file_uri('dist/assets/img/banners/i1.svg') ?>" alt="">
                                <p class="main-banner__text">Монобукеты</p>
                            </div>
                            <div class="main-banner__item"><img class="main-banner__ico" src="<?php echo get_theme_file_uri('dist/assets/img/banners/i2.svg') ?>" alt="">
                                <p class="main-banner__text">Сборные букеты</p>
                            </div>
                            <div class="main-banner__item"><img class="main-banner__ico" src="<?php echo get_theme_file_uri('dist/assets/img/banners/i3.svg') ?>" alt="">
                                <p class="main-banner__text">Композиции</p>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>
        <section>
            <div class="container" style="text-align: center; padding-bottom: 100px">
                <h4 class="carts__title">Установите свой бюджет</h4>
                <div class="my_ptice_description" style="text-align: center; padding-bottom: 32px">
                    и мы соберем Вам букет, которого нет в коллекции,<br>
                    на вкус нашего лучшего флориста!
                </div>
                <form class="form" action="<?php echo wc_get_checkout_url() ?>" method="get" style="margin: auto">

                    <div class="form__block">
                        <input class="form__input" type="text" min="1000" value="2500" placeholder="2500" name="my_price">
                    </div>
                    <div class="my_ptice_last_text">установите бюджет/не менее 1000 руб.</div>
                    <button class="button --dark --big form__buttom">В корзину</button>
                </form>
            </div>
        </section>
    </main>
</div>

<?php get_footer() ?>
