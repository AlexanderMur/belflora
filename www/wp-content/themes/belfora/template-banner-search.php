<?php
/** @var array $args */

$title = $args['title'] ?? get_the_title();
$bannerItems = options('banner_items') ?? [];
$bannerCats = get_categories([
        'hide_empty' => false,
        'include'
])
?>

<section class="main-banner --background-3">
    <div class="container">
        <?php
        woocommerce_breadcrumb([
            'wrap_before' => '<div class="crumbs --white --center crumbs--mainbanner">',
            'wrap_after' => '</div>',
            'delimiter' => '',
        ]);
        ?>
        <h1 class="main-banner__title --white"><?php echo $title?></h1>
        <div class="main-banner__search">

            <?php get_template_part('template','search') ?>

            <div class="main-banner__items">
                <?php
                foreach ($bannerItems as $bannerItem) {
                    $thumb = wp_get_attachment_image_src($bannerItem['thumb'])[0] ?? '';
                    $cat = get_term($bannerItem['cat']);
                    $link = get_term_link($cat);
                    $title = $cat->name;
                    ?>

                    <a href="<?php echo $link ?>" class="main-banner__item"><img class="main-banner__ico" src="<?php echo $thumb ?>" alt="">
                        <p class="main-banner__text"><?php echo $title ?></p>
                    </a>
                    <?php
                }
                ?>
            </div>
        </div>
    </div>
</section>
