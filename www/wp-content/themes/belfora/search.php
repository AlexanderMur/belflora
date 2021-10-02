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
            <h1 class="main-banner__title --white">Результаты поиска "<?php echo esc_attr(get_query_var('s')) ?>"</h1>
            <div class="main-banner__search">

                <?php get_template_part('template','search') ?>
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

    <section class="section-carts">
        <div class="container">
            <div class="carts__wrap carts-list carts-list-4">
                <?php
                if (have_posts()) {
                    while (have_posts()) {
                        the_post();
                        wc_get_template_part('content', 'product');
                    }
                } else {
                    ?>
                    <p><?php esc_html_e( 'Sorry, but nothing matched your search terms. Please try again with some different keywords.', 'storefront' ); ?></p>
                    <?php
                }
                ?>
            </div>
            <?php
            ?>
        </div>
    </section>
</div>

<?php get_footer() ?>
