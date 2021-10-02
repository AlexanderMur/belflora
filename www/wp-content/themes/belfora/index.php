<?php

use Belfora\Options;

get_header();

?>
    <div class="content">
        <?php get_template_part('template', 'banner-search', ['title' => options()->get('index_title')]) ?>
        <section class="section-carts">
            <div class="container">
                <h2 class="carts__title"><?php echo options()->get('index_catalog_title') ?></h2>
                <div class="carts__wrap carts-list carts-list-4">
                    <?php
                        $query = new WP_Query(array(
                            'post_type' => 'product',
                            'posts_per_page' => 12,
                        ));

                        while ($query->have_posts()) {
                            $query->the_post();
                            wc_get_template_part('content', 'product');
                        }
                    ?>
                </div>
            </div>
        </section>
        <section class="section-catalogs">
            <div class="container">
                <div class="title-text">
                    <h2 class="--text"><?php echo options()->get('index_category_title') ?></h2>
                    <p class="text"><?php echo options()->get('index_category_text') ?></p>
                </div>
                <div class="catalog">
                    <?php
                    $cats = wc_list_pluck((array) options()->get('index_category_ids'), 'id');
                    /** @var WP_Term[] $categories */
                    $categories = get_categories([
                            'taxonomy' => 'product_cat',
                        'include' => $cats,
                        'hide_empty' => false
                    ]);


                    ?>
                    <div class="catalogs__list">

                        <a class="catalog__item lazycontainer" href="<?php echo get_post_type_archive_link('product') ?>">

                            <div class="catalog__bg lazy" data-src="<?php echo get_theme_file_uri('dist/assets/img/catalog/1.png') ?>"></div>
                            <h3 class="catalog__title">Все букеты</h3>
                        </a>
                        <?php
                        foreach ($categories as $category) {
                            ?>
                            <a class="catalog__item lazycontainer" href="<?php echo get_term_link($category) ?>">

                                <div class="catalog__bg lazy" data-src="<?php echo products()->getCategoryThumbnail($category) ?>"></div>
                                <h3 class="catalog__title"><?php echo $category->name ?></h3>
                            </a>
                            <?php
                        }
                        ?>

                    </div>
                </div>
            </div>
        </section>
        <section class="page-banner-section">
            <div class="container">
                <?php
                $image_url = wp_get_attachment_image_src(options()->get('index_banner_image'), array(2000,1000))[0] ?? '';
                ?>
                <div class="page-banner lazy" data-src="<?php echo $image_url ?>">
                    <h2 class="page-banner__title"><?php echo options()->get('index_banner_title') ?></h2>
                    <div class="page-banner__btn"><a class="button --dark" href="<?php echo options(Options::index_banner_link) ?>"><?php echo options()->get('index_banner_button') ?></a></div>
                </div>
            </div>
        </section>
        <section class="section-slider">
            <div class="container">
                <h2 class="section-slider__title"><?php echo options()->get('index_special_title') ?></h2>
                <div class="main-slider swiper-container">
                    <div class="swiper-wrapper">
                        <?php
                        $specials = options()->get('specials_slider_items');
                        foreach ($specials as $special) {
                            $image_url = wp_get_attachment_image_src($special['image'], 'large')[0] ?? '';
                            ?>
                            <div class="swiper-slide main-slide" style="background-image: url(<?php echo $image_url?>)">
                                <?php echo apply_filters('the_content', $special['text'])?>
                            </div>
                            <?php
                        }
                        ?>
                    </div>
                    <div class="slider-prev slider-button">
                        <svg class="svgsprite _arrow-left">
                            <use xlink:href="<?php echo get_theme_file_uri('dist/assets/img/sprites/svgsprites.svg#arrow-left') ?>"></use>
                        </svg>
                    </div>
                    <div class="slider-next slider-button">
                        <svg class="svgsprite _arrow-right">
                            <use xlink:href="<?php echo get_theme_file_uri('dist/assets/img/sprites/svgsprites.svg#arrow-right') ?>"></use>
                        </svg>
                    </div>
                </div>
            </div>
        </section>
        <section class="text-section">
            <div class="container">
                <div class="text-block">
                    <h2 class="text-block__title"><?php echo options()->get('index_text_title1') ?></h2>
                    <div class="text-block__list">
                        <div class="text__item">
                            <p class="text"><?php echo apply_filters('the_content', options()->get('index_text_left1')) ?></p>
                        </div>
                        <div class="text__item">
                            <p class="text"><?php echo apply_filters('the_content', options()->get('index_text_right1')) ?></p>
                        </div>
                    </div>
                </div>
                <div class="text-block">
                    <h2 class="text-block__title"><?php echo options()->get('index_text_title2') ?></h2>
                    <div class="text-block__list">
                        <div class="text__item">
                            <p class="text"><?php echo apply_filters('the_content', options()->get('index_text_left2')) ?></p>
                        </div>
                        <div class="text__item">
                            <p class="text"><?php echo apply_filters('the_content', options()->get('index_text_right2')) ?></p>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>

<?php

get_footer();
