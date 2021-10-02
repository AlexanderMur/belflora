<?php
/**
 * Pay for order form
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/checkout/form-pay.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 5.2.0
 */

use Belfora\Options;

defined( 'ABSPATH' ) || exit;

/** @var WC_Order $order */
$totals = $order->get_order_item_totals(); // phpcs:ignore WordPress.WP.GlobalVariablesOverride.Prohibited

$rates = WC()->shipping()->get_packages()[0]['rates'] ?? [];
?>

<div class="container">
    <h2 class="step__title">Детали заказа</h2>
    <div class="steps__list">

        <form id="order_review" method="post" class="form">

            <div class="form__radios-flex">
                <?php


                foreach ($rates as $key => $field) {
                    /**
                     * @var $field WC_Shipping_Rate
                     */
                    ?>

                    <label class="radio">
                        <input class="hidden"
                               type="radio"
                               name="shipping_method[0]"
                               data-index="0"
                               value="<?php echo $field->get_id() ?>" <?php checked($field->get_id(), $chosen_method ?? 0) ?>><span
                                class="radio__circle"></span>
                        <p class="radio__text"><?php echo $field->get_label() ?></p>
                    </label>
                    <?php
                }

                ?>
            </div>
            <h4 class="form__title">Оплата заказа</h4>




            <?php if ( $order->needs_payment() ) : ?>
                <ul class="wc_payment_methods payment_methods methods">
                    <?php
                    if ( ! empty( $available_gateways ) ) {
                        foreach ( $available_gateways as $gateway ) {
                            wc_get_template( 'checkout/payment-method.php', array( 'gateway' => $gateway ) );
                        }
                    } else {
                        echo '<li class="woocommerce-notice woocommerce-notice--info woocommerce-info">' . apply_filters( 'woocommerce_no_available_payment_methods_message', esc_html__( 'Sorry, it seems that there are no available payment methods for your location. Please contact us if you require assistance or wish to make alternate arrangements.', 'woocommerce' ) ) . '</li>'; // @codingStandardsIgnoreLine
                    }
                    ?>
                </ul>
            <?php endif; ?>
            <div class="form__buttons">
                <button type="submit" class="button --dark --big form__buttom js-form-submit" style="">Оплатить
                    заказ
                </button>
            </div>

            <input type="hidden" name="woocommerce_pay" value="1" />
            <?php wp_nonce_field( 'woocommerce-pay', 'woocommerce-pay-nonce' ); ?>
        </form>

        <div class="template-cart">
            <?php
            $set_id = options(Options::basket_nabor)[0]['id'] ?? 0;
            foreach ($order->get_items() as $item_id => $item) {
                /** @var WC_Product $_product */
                $_product = $item->get_product();
                $product_id = $item['product_id'];
                if ($_product && $_product->exists()) {
                    $permalink = $_product->get_permalink();
                    $thumbnail = products()->getProductImageSrc($_product, 'medium') ?? '';

                    $is_set = $_product->get_id() == $set_id;
                    ?>
                    <div class="basket-cart">
                        <div class="basket__left">
                            <div class="basket-cart__pic"><img src="<?php echo $thumbnail ?>" alt="">
                            </div>
                            <div class="basket-cart__info">
                                <h5 class="basket-cart__title"><a
                                            href="<?php echo $permalink ?>"><?php echo strip_tags($_product->get_title()) ?></a>
                                </h5>
                                <p class="text-grey basket-cart__text"><?php echo theme()->products->getProducAttrName($item) ?></p>

                            </div>

                        </div>
                    </div>
                    <?php
                }
            }
            ?>

            <div class="basket__bottom-wrap">
                <div class="basket__price price">
                    <?php

                    if ($order->get_shipping_total() > 0) {
                        ?>
                        <div class="price-wrap">
                            <div class="prce__item">
                                <h5>Доставка </h5>
                                <div class="price__number summ"><?php echo wc_price($order->get_shipping_total()) ?></div>
                            </div>
                        </div>
                        <?php
                    }
                    ?>
                    <div class="price-wrap">
                        <div class="prce__item">
                            <h5>Стоимость </h5>
                            <div class="price__number summ"><?php echo $order->get_formatted_order_total() ?></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
