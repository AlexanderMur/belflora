<?php

use Belfora\Options;

get_header();


$filter_events = options(Options::filter_events);
$filter_categories = options(Options::filter_cats);
$flowers = options(Options::filter_flowers);
$flowers = wp_list_pluck($flowers, 'flower');

$filter_events = wp_list_pluck($filter_events, 'id');
/** @var WP_Term[] $events */
$events = get_categories([
    'taxonomy' => 'events',
    'include' => implode(',', $filter_events),
]);

$filter_categories = wp_list_pluck($filter_categories, 'id');
/** @var WP_Term[] $categories */
$categories = get_categories([
    'taxonomy' => 'product_cat',
    'include' => $filter_categories,
]);

$current_category = get_queried_object();
$is_index_archive = $current_category instanceof WP_Post_Type;

?>
    <div class="content">
        <section class="main-banner --background-1">
            <div class="container">
                <?php
                woocommerce_breadcrumb([
                    'wrap_before' => '<div class="crumbs --white --center crumbs--mainbanner">',
                    'wrap_after' => '</div>',
                    'delimiter' => '',
                ]);
                ?>
                <?php
                if (!$is_index_archive) {
                    ?>
                    <h1 class="main-banner__title --white">Каталог <?php echo $current_category->name ?></h1>
                    <?php
                } else {
                    ?>
                    <h1 class="main-banner__title --white">Все букеты</h1>
                    <?php
                }
                ?>
                <form class="main__banner-filter main__banner-filter--desktop">
                    <div class="main__banner-items">
                        <div class="main-banner__item">
                            <div class="main-banner__tooltip">
                                <div class="main-banner__main -js-fadeintooltip">
                                    Цветы&nbsp;<span class="main-banner__main-number"></span>
                                    <div class="tooltip">
                                        <div class="main-banner__main-title">Цветы</div>
                                        <?php
                                        $queryFlowers = (array)($_GET['flower'] ?? []);
                                        foreach ($flowers as $flower) {
                                            ?>
                                            <label class="checkbox">
                                                <input class="hidden"
                                                       type="checkbox"
                                                       name="flower[]"
                                                       value="<?php echo $flower ?>" <?php echo in_array($flower, $queryFlowers) ? 'checked' : '' ?>
                                                       autocomplete="off"><span class="checkbox__ico"></span>
                                                <p class="checkbox__text"><?php echo $flower ?></p>
                                            </label>
                                            <?php
                                        }
                                        ?>
                                        <div class="main-banner__main-buttons">
                                            <button class="button --white --small filter__buttom-close">Закрыть</button>
                                            <button class="button --dark --small filter__buttom-apply">Применить
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="main-banner__item">
                            <div class="main-banner__tooltip">
                                <div class="main-banner__main -js-fadeintooltip">
                                    Событие&nbsp;<span class="main-banner__main-number"></span>
                                    <div class="tooltip">
                                        <div class="main-banner__main-title">Событие (0)</div>
                                        <?php
                                        $getEvent = (array)($_GET['event'] ?? []);
                                        foreach ($events as $event) {
                                            ?>
                                            <label class="checkbox">
                                                <input class="hidden"
                                                       name="event[]"
                                                       value="<?php echo $event->term_id ?>"
                                                       type="checkbox"
                                                       autocomplete="off"
                                                       <?php echo in_array($event->term_id, $getEvent) ? 'checked' : '' ?>
                                                ><span class="checkbox__ico"></span>
                                                <p class="checkbox__text"><?php echo $event->name ?></p>
                                            </label>
                                            <?php
                                        }
                                        ?>
                                        <div class="main-banner__main-buttons">
                                            <button class="button --white --small filter__buttom-close">Закрыть</button>
                                            <button class="button --dark --small filter__buttom-apply">Применить
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="main-banner__item">
                            <div class="main-banner__tooltip">
                                <div class="main-banner__main -js-fadeintooltip">Стоимость
                                    <div class="tooltip">
                                        <div class="main-banner__main-title">Стоимость</div>
                                        <div class="range">
                                            <?php
                                            $min = esc_attr($_GET['price_min'] ?? '');
                                            $max = esc_attr($_GET['price_max'] ?? '');
                                            ?>
                                            <div class="range__inputs">
                                                <div class="range__input range__from">
                                                    <input id="range__from"
                                                           type="number"
                                                           name="price_min"
                                                           autocomplete="off"
                                                           value="<?php echo $min ?>">
                                                </div>
                                                <div class="range__input range__to">
                                                    <input id="range__to"
                                                           type="number"
                                                           name="price_max"
                                                           autocomplete="off"
                                                           value="<?php echo $max ?>">
                                                </div>
                                            </div>
                                            <div id="range-bar"></div>
                                        </div>
                                        <div class="main-banner__main-buttons">
                                            <button class="button --white --small filter__buttom-close">Закрыть</button>
                                            <button class="button --dark --small filter__buttom-apply">Применить
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="filter__reset">Сбросить всё</div>
                </form>
            </div>
        </section>
        <div class="main__banner-filter--mobile">
            <div class="container"><a class="back" href="catalog.html">Online витрина</a>
                <div class="main__banner-scroll">
                    <form class="main__banner-filter">
                        <div class="main__banner-items">
                            <div class="main-banner__item">
                                <div class="main-banner__tooltip">
                                    <div class="main-banner__main -js-fadeintooltip">
                                        Цветы&nbsp;<span class="main-banner__main-number"></span>
                                        <div class="tooltip">
                                            <div class="main-banner__main-title">Цветы</div>
                                            <?php
                                            foreach ($flowers as $flower) {
                                                ?>
                                                <label class="checkbox">
                                                    <input class="hidden"
                                                           type="checkbox"
                                                           name="flower[]"
                                                           value="<?php echo $flower ?>"><span class="checkbox__ico"></span>
                                                    <p class="checkbox__text"><?php echo $flower ?></p>
                                                </label>
                                                <?php
                                            }
                                            ?>
                                            <div class="main-banner__main-buttons">
                                                <button class="button --white --small filter__buttom-close">Закрыть
                                                </button>
                                                <button class="button --dark --small filter__buttom-apply">Применить
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="main-banner__item">
                                <div class="main-banner__tooltip">
                                    <div class="main-banner__main -js-fadeintooltip">
                                        Событие&nbsp; <span class="main-banner__main-number"></span>
                                        <div class="tooltip">
                                            <div class="main-banner__main-title">Событие</div>
                                            <?php
                                            foreach ($events as $event) {
                                                ?>
                                                <label class="checkbox">
                                                    <input class="hidden"
                                                           type="checkbox"
                                                           name="event[]"
                                                           value="<?php echo $event->term_id ?>"><span class="checkbox__ico"></span>
                                                    <p class="checkbox__text"><?php echo $event->name ?></p>
                                                </label>
                                                <?php
                                            }
                                            ?>

                                            <div class="main-banner__main-buttons">
                                                <button class="button --white --small filter__buttom-close">Закрыть
                                                </button>
                                                <button class="button --dark --small filter__buttom-apply">Применить
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="main-banner__item">
                                <div class="main-banner__tooltip">
                                    <div class="main-banner__main -js-fadeintooltip">Стоимость
                                        <div class="tooltip">
                                            <div class="main-banner__main-title">Стоимость</div>
                                            <div class="range">
                                                <div class="range__inputs">
                                                    <div class="range__input range__from">
                                                        <input id="range__from" type="text" disabled>
                                                    </div>
                                                    <div class="range__input range__to">
                                                        <input id="range__to" type="text" disabled>
                                                    </div>
                                                </div>
                                                <div id="range-bar"></div>
                                            </div>
                                            <div class="main-banner__main-buttons">
                                                <button class="button --white --small filter__buttom-close">Закрыть
                                                </button>
                                                <button class="button --dark --small filter__buttom-apply">Применить
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="filter__reset">Сбросить всё</div>
                    </form>
                </div>
            </div>
        </div>
        <section class="catalog-filter">
            <div class="container">
                <div class="catalog-filter__wrap">
                    <div class="catalog-filter__nav">
                        <div class="catalog-filter__sticky">
                            <p class="catalog-filter__title">Сортировать по: </p>
                            <ul class="catalog-filter__list">
                                <li class="catalog-filter__link <?php echo $is_index_archive ? 'active' : '' ?>">
                                    <a href="<?php echo get_post_type_archive_link('product') ?>">Все букеты</a></li>
                                <?php
                                foreach ($categories as $category) {
                                    $is_current = !$is_index_archive && $category->term_id === $current_category->term_id;
                                    ?>
                                    <li class="catalog-filter__link <?php echo $is_current ? 'active' : '' ?>">
                                        <a href="<?php echo get_category_link($category) ?>"><?php echo $category->name ?></a>
                                    </li>
                                    <?php
                                }
                                ?>
                            </ul>
                        </div>
                    </div>
                    <div class="catalog-filter__carts">
                        <div class="carts__wrap carts-list carts-list-3">
                            <?php
                            $i = 0;
                            while (have_posts()) {
                                $i++;
                                the_post();

                                if ($i === 13) {
                                    $image_url = wp_get_attachment_image_src(options()->get('index_banner_image'), array(2000, 1000))[0] ?? '';
                                    ?>
                                    <div class="page-banner lazy" data-src="<?php echo $image_url ?>">
                                        <h2 class="page-banner__title"><?php echo options()->get('index_banner_title') ?></h2>
                                        <div class="page-banner__btn"><a class="button --dark"
                                                                         href="<?php echo options(Options::index_banner_link) ?>"><?php echo options()->get('index_banner_button') ?></a>
                                        </div>
                                    </div>
                                    <?php
                                } else {

                                    do_action('woocommerce_shop_loop');
                                    wc_get_template_part('content', 'product');
                                }

                            }
                            ?>
                        </div>
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
do_action('woocommerce_after_main_content');

get_footer();
