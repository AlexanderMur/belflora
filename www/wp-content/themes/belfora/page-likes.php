<?php

/*
 * Template Name: Избранное
 * */
?>
<?php get_header(); ?>

<div id="primary" class="content-area">
    <main id="main" class="site-main" role="main">
        <div class="content">
            <?php get_template_part('template', 'banner-search') ?>
        </div>
        <section class="section-carts">
            <div class="container">
                <h2 class="carts__title">Избранное</h2>
                <?php
                $likes = WC()->session->get('likes');
                if (!empty($likes)) {

                    $query = new WP_Query([
                        'post__in' => $likes,
                        'post_type' => 'product'
                    ]);
                    ?>
                    <div class="carts__wrap carts-list carts-list-4">
                        <?php
                        while ($query->have_posts()) {
                            $query->the_post();
                            wc_get_template_part('content', 'product');
                        }
                        ?>
                    </div>
                    <?php
                } else {
                    ?>
                    Здесь будут показаны избранные товары
                    <?php
                }
                ?>
            </div>
        </section>
    </main>
</div>

<?php get_footer() ?>
