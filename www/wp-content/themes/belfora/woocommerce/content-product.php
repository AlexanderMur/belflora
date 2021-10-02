<?php
/**
 * The template for displaying product content within loops
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/content-product.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 3.6.0
 */

defined('ABSPATH') || exit;

/** @var WC_Product_Simple $product */
global $product;
// Ensure visibility.
if (empty($product) || !$product->is_visible()) {
    return;
}
$time = microtime(true);
$wish = (array)WC()->session->get('likes');
$isLike = in_array($product->get_id(), $wish);
$thumbnail = products()->getProductImageSrc($product, 'medium');
?>
<div class="cart">
    <div class="cart__top">
        <div class="cart__pic">
            <div class="cart__pic-img lazy" data-src="<?php echo $thumbnail ?>"></div>
        </div>
        <div class="tags">
            <?php
            if ($product->get_meta('_is_new')) {
                ?>
                <div class="tag --green">новинка</div>
                <?php
            }
            ?>
            <?php
            if ($product->get_meta('_is_super_price')) {
                ?>
                <div class="tag --orange">супер цена</div>
                <?php
            }
            ?>
        </div>
        <div class="cart__buttons">
            <?php
            if ($product->is_in_stock()) {
                ?>
                <button class="button --dark -js-fadebuttons js-add-to-cart" data-id="<?php echo $product->get_id() ?>">
                    В корзину
                </button>
                <?php
            }
            ?>
            <a class="button --grey" href="<?php the_permalink(); ?>">Смотреть букет</a>
        </div>
        <button class="cart__like <?php echo $isLike ? 'active' : '' ?>" data-id="<?php echo $product->get_id() ?>">
            <svg class="svgsprite _heart-full">
                <use xlink:href="<?php echo get_theme_file_uri('dist/assets/img/sprites/svgsprites.svg#heart-full') ?>"></use>
            </svg>
        </button>
    </div>
    <div class="cart__bottom">
        <div class="cart__title"><?php echo $product->get_price_html() ?></div>
        <div class="cart__text"><?php the_title() ?></div>
    </div>
</div>
