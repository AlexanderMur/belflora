<?php

use function Belfora\get_rating_html;
use function Belfora\groupComments;
use function Belfora\num_decline;

defined('ABSPATH') || exit;

get_header();
global $product;
$recommended = carbon_get_post_meta($product->get_id(), 'recommended_products');
$recommended = wp_list_pluck($recommended, 'id');
$recommended_posts = get_posts([
        'post_type' => 'product',
        'post__in' => $recommended,
]);

 /** @var WP_Comment[] $comments */
$comments = get_comments([
    'post_id' => get_the_id(),
    'status' => 'approve'
]);
$comments = groupComments($comments);
?>

    <div class="content">
        <section class="product-section">
            <div class="container">
                <?php
                woocommerce_breadcrumb([
                    'wrap_before' => '<div class="crumbs">',
                    'wrap_after' => '</div>',
                    'delimiter' => '',
                ]);
                ?>
                <div class="product">
                    <div class="product__slider">
                        <div class="product__slider__top">
                            <div class="swiper-container">
                                <div class="swiper-wrapper">
                                    <div class="swiper-slide product__slide"
                                         style="background: url(<?php the_post_thumbnail_url('large'); ?>) no-repeat center / cover"></div>
                                    <?php
                                    $attachment_ids = $product->get_gallery_image_ids();

                                    foreach ($attachment_ids as $attachment_id) {
                                        ?>
                                        <div class="swiper-slide product__slide"
                                             style="background: url(<?php echo wp_get_attachment_url($attachment_id) ?>) no-repeat center / cover"></div>
                                        <?php
                                    }
                                    ?>
                                </div>
                                <div class="slider-prev slider-button">
                                    <svg class="svgsprite _arrow-left">
                                        <use xlink:href="<?php echo get_theme_file_uri('/dist/assets/img/sprites/svgsprites.svg#arrow-left') ?>"></use>
                                    </svg>
                                </div>
                                <div class="slider-next slider-button">
                                    <svg class="svgsprite _arrow-right">
                                        <use xlink:href="<?php echo get_theme_file_uri('/dist/assets/img/sprites/svgsprites.svg#arrow-right') ?>"></use>
                                    </svg>
                                </div>
                            </div>
                        </div>
                        <div class="product__slider-bottom">
                            <div class="product__slider-item active"
                                 style="background: url(<?php the_post_thumbnail_url('large'); ?>) no-repeat center / cover"></div>
                            <?php
                            $attachment_ids = $product->get_gallery_image_ids();

                            foreach ($attachment_ids as $attachment_id) {
                                ?>
                                <div class="product__slider-item"
                                     style="background: url(<?php echo wp_get_attachment_url($attachment_id) ?>) no-repeat center / cover"></div>

                                <?php
                            }
                            ?>
                        </div>
                        <?php

                        $wish = (array) WC()->session->get('likes');
                        $isLike = in_array((string) $product->get_id(), $wish);
                        ?>
                        <div class="product__like product__like--mobile <?php echo $isLike ? "active" : '' ?>" data-id="<?php echo $product->get_id() ?>">
                            <svg class="svgsprite _heart-full">
                                <use xlink:href="<?php echo get_theme_file_uri('/dist/assets/img/sprites/svgsprites.svg#heart-full') ?>"></use>
                            </svg>
                        </div>
                    </div>
                    <div class="product__content">
                        <div class="product__item">
                            <h2 class="product__title"><?php the_title() ?></h2>
                            <div class="product__list">
                                <?php
                                if ($product->is_in_stock()) {
                                    ?>
                                    <div class="status">Есть в наличии</div>
                                    <?php
                                } else {
                                    ?>
                                    <div class="status" style="color: red">Нет в наличии</div>
                                    <?php
                                }
                                ?>
                                <div class="product__stars">
                                    <?php
                                    $stars = carbon_get_post_meta($product->get_id(), 'rating_override');
                                    if (!$stars){
                                        $stars = $product->get_average_rating();
                                    }
                                    get_rating_html($stars);
                                    ?>
                                </div>
                                <p class="product-reports-summ"><?php echo num_decline(count($comments), ['отзыв', 'отзыва', 'отзывов'])?></p>
                            </div>
                            <p class="product__price"><?php echo $product->get_price_html() ?></p>
                        </div>
                        <?php
                        woocommerce_template_single_add_to_cart()
                        ?>
                        <div class="accardeon">
                            <div class="accardeon__item">
                                <div class="accardeon__main">Состав букета</div>
                                <div class="accardeon__drop">
                                    <div class="catalog__structure">
                                        <div class="catalog__structure-item">
                                            <div class="catalog__structure-name">Хризантемы</div>
                                            <div class="catalog__structure-summ">7 шт.</div>
                                        </div>
                                        <div class="catalog__structure-item">
                                            <div class="catalog__structure-name">Кустовые розы</div>
                                            <div class="catalog__structure-summ">5 шт.</div>
                                        </div>
                                        <div class="catalog__structure-item">
                                            <div class="catalog__structure-name">Упаковка</div>
                                            <div class="catalog__structure-summ">1 шт.</div>
                                        </div>
                                        <div class="catalog__structure-item">
                                            <div class="catalog__structure-name">Лента</div>
                                            <div class="catalog__structure-summ">1 шт.</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="accardeon__item">

                                <div class="accardeon__main">Отзывы (<?php echo count($comments) ?>)</div>
                                <div class="accardeon__drop">
                                    <p>Хотите оставить отзыв о данном товаре?</p>
                                    <div class="accardeon__main accardeon__main-report">Оставить отзыв</div>
                                    <div class="accardeon__drop">
                                        <div class="product__form">
                                            <?php
                                            get_template_part('part', 'form', [
                                                'post_id' => $post->ID,
                                            ])
                                            ?>
                                        </div>
                                    </div>
                                    <div class="product__reports">

                                        <?php
                                        foreach ($comments as $comment) {
                                            /** @var WP_Comment $commentObj */
                                            $commentObj = $comment['comment'];
                                            ?>
                                            <div class="product__report">
                                                <p class="product__report-text"><?php echo $commentObj->comment_content ?></p>
                                                <div class="product__report-info">
                                                    <div class="product__report-name"><?php echo get_comment_meta($commentObj->comment_ID, 'name', true) ?></div>
                                                    <div class="product__report-stars">
                                                        <div class="stars">
                                                            <?php
                                                            $stars = get_comment_meta($commentObj->comment_ID, 'rating', true) ?? 0;
                                                            get_rating_html($stars);
                                                            ?>
                                                        </div>
                                                    </div>
                                                    <div class="product__report-date"><?php echo $commentObj->comment_date ?></div>
                                                </div>
                                            </div>
                                            <?php
                                            foreach ($comment['children'] as $child) {
                                                ?>
                                                <div class="product__report--company">
                                                    <div class="product__report">
                                                        <p class="product__report-text"><?php echo $child->comment_content ?></p>
                                                        <div class="product__report-info">
                                                            <div class="product__report-logo"><img src="<?php echo get_theme_file_uri('dist/assets/img/logo.svg') ?>"
                                                                                                   alt=""></div>
                                                            <div class="product__report-date"><?php $child->comment_date ?></div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <?php
                                            }
                                        }
                                        ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <?php
        if ($recommended_posts) {
            ?>
            <section class="offers-section">
                <div class="container">
                    <h2>Хорошее дополнение к цветам</h2>
                    <div class="carts__wrap carts-list carts-list-4">
                        <?php
                        foreach ($recommended_posts as $post) {
                            wc_setup_product_data($post);
                            wc_get_template_part('content', 'product');
                        }
                        ?>
                    </div>
                </div>
            </section>
            <?php
        }
        ?>
    </div>
<?php

get_footer();


/* Omit closing PHP tag at the end of PHP files to avoid "headers already sent" issues. */
