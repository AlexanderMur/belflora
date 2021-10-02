<?php
/**
 *
 * Template Name: Отзывы
 */

get_header();
?>

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
                <h1 class="main-banner__title --white">О нас говорят</h1>
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
        <section class="orders-section">
            <div class="container">
                <div class="orders__list">

                    <?php /** @var WP_Comment[] $comments */
                    $comments = get_comments([
                        'post_id' => get_the_id(),
                        'status' => 'approve',
                    ]) ?>
                    <?php get_template_part('template', 'list', [
                            'comments' => $comments
                    ]) ?>

                    <div>

                        <?php
                        if (wp_get_current_user()->ID ?? 0) {
                            ?>
                            Здравствуйте, <?php echo wp_get_current_user()->display_name ?>
                            <?php
                        }
                        ?>
                        <?php
                        get_template_part('part', 'form', [
                            'post_id' => $post->ID,
                        ])
                        ?>
                    </div>
                </div>
            </div>
        </section>
        <section class="offers-section">
            <div class="container">
                <h2>Интересные предложения</h2>
                <?php get_template_part('template', 'recommends') ?>
            </div>
        </section>
    </div>


<?php
get_footer();
