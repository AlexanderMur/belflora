<?php
/**
 * Variable product add to cart
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/single-product/add-to-cart/variable.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 3.5.5
 */

defined('ABSPATH') || exit;

global $product;
$attribute_keys = array_keys($attributes);
$variations_json = wp_json_encode($available_variations);
$variations_attr = function_exists('wc_esc_json') ? wc_esc_json($variations_json) : _wp_specialchars($variations_json, ENT_QUOTES, 'UTF-8', true);

do_action('woocommerce_before_add_to_cart_form'); ?>
    <form class="variations_form cart"
          action="<?php echo esc_url(apply_filters('woocommerce_add_to_cart_form_action', $product->get_permalink())); ?>"
          method="post" enctype='multipart/form-data' data-product_id="<?php echo absint($product->get_id()); ?>"
          data-product_variations="<?php echo $variations_attr; // WPCS: XSS ok. ?>">
        <div class="product__item">
            <?php do_action('woocommerce_before_variations_form'); ?>

            <?php if (empty($available_variations) && false !== $available_variations) : ?>
                <p class="stock out-of-stock"><?php echo esc_html(apply_filters('woocommerce_out_of_stock_message', __('This product is currently out of stock and unavailable.', 'woocommerce'))); ?></p>
            <?php else : ?>
                <?php
                $attrs = products()->getAttributes($product, 'pa_razmer');
                ?>
                <p class="product__description">Выберите размер букета</p>
                <?php
                foreach ($attrs as $i => $attr) {
                    ?>
                    <label class="checkbox-button">
                        <input class="hidden"
                               type="radio"
                               name="size"
                               value="<?php echo $attr->slug ?>"
                               data-taxonomy="<?php echo $attr->taxonomy ?>"
                               <?php checked(0,$i) ?>
                        >
                        <div class="button --lightgrey"><?php echo $attr->name ?></div>
                    </label>
                    <?php
                }
                ?>
                <table class="variations" cellspacing="0" style="display: none">
                    <tbody>
                    <?php foreach ($attributes as $attribute_name => $options) : ?>

                        <tr>
                            <td class="label"><label
                                        for="<?php echo esc_attr(sanitize_title($attribute_name)); ?>"><?php echo wc_attribute_label($attribute_name); // WPCS: XSS ok. ?></label>
                            </td>
                            <td class="value">
                                <?php
                                wc_dropdown_variation_attribute_options(
                                    array(
                                        'options' => $options,
                                        'attribute' => $attribute_name,
                                        'product' => $product,
                                    )
                                );
                                echo end($attribute_keys) === $attribute_name ? wp_kses_post(apply_filters('woocommerce_reset_variations_link', '<a class="reset_variations" href="#">' . esc_html__('Clear', 'woocommerce') . '</a>')) : '';
                                ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                    </tbody>
                </table>

            <?php endif; ?>

            <?php do_action('woocommerce_after_variations_form'); ?>
        </div>


        <div class="product__item">

            <p class="product__description"><?php echo 'Количество' ?></p>
            <?php
            woocommerce_quantity_input(
                array(
                    'min_value' => apply_filters('woocommerce_quantity_input_min', $product->get_min_purchase_quantity(), $product),
                    'max_value' => apply_filters('woocommerce_quantity_input_max', $product->get_max_purchase_quantity(), $product),
                    'input_value' => isset($_POST['quantity']) ? wc_stock_amount(wp_unslash($_POST['quantity'])) : $product->get_min_purchase_quantity(), // WPCS: CSRF ok, input var ok.
                )
            );

            ?>

            <div class="count__description">Минимальное количество заказа - 1 штука</div>
        </div>

        <div class="product__item">
            <div class="product__list product__list--btns">
                <div class="product__btns">
                    <button class="button --dark" <?php disabled(!$product->is_in_stock()) ?>>В корзину</button>
                    <button class="button --grey popup-link" <?php disabled(!$product->is_in_stock()) ?> data-mfp-src="#1-click-popup">Купить в 1 клик</button>

                </div>
                <?php

                $wish = (array)WC()->session->get('likes');
                $isLike = in_array((string)$product->get_id(), $wish);
                ?>
                <div class="product__like product__like--desktop <?php echo $isLike ? "active" : '' ?>"
                     data-id="<?php echo $product->get_id() ?>">
                    <svg class="svgsprite _heart-full">
                        <use xlink:href="<?php echo get_theme_file_uri('dist/assets/img/sprites/svgsprites.svg#heart-full') ?>"></use>
                    </svg>
                </div>
            </div>
        </div>
        <input type="hidden" name="add-to-cart" value="<?php echo absint($product->get_id()); ?>"/>
        <input type="hidden" name="product_id" value="<?php echo absint($product->get_id()); ?>"/>
        <input type="hidden" name="variation_id" class="variation_id" value="0"/>
    </form>

    <div id="1-click-popup" class="mfp-hide white-popup">
        <?php echo do_shortcode('[contact-form-7 id="919" title="Купить в 1 клик"]') ?>
    </div>
<?php
do_action('woocommerce_after_add_to_cart_form');
