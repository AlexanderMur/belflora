<?php

use Belfora\Options;

?>

    <div class="template-cart">
        <?php
        $set_id = options(Options::basket_nabor)[0]['id'] ?? 0;
        $cart = WC()->cart->get_cart();
        foreach ($cart as $key => $item) {
            $product_id = $item['product_id'];

            if ($product_id == $set_id) {
                $set = $item;
                unset($cart[$key]);
                $cart[$key] = $set;
                break;
            }
        }
        foreach ($cart as $key => $item) {
            /** @var WC_Product $_product */
            $_product = $item['data'];
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
                                        href="<?php echo $permalink ?>"><?php echo wp_kses_post($_product->get_title()) ?></a>
                            </h5>
                            <p class="text-grey basket-cart__text"><?php echo theme()->products->getProducAttrName($_product) ?></p>
                            <div class="basket-cart__amount">
                                <?php
                                if (!$is_set) {
                                    ?>
                                    <?php
                                    woocommerce_quantity_input(
                                        array(
                                            'input_name' => "cart[{$key}][qty]",
                                            'input_value' => $item['quantity'],
                                            'max_value' => $_product->get_max_purchase_quantity(),
                                            'min_value' => '0',
                                            'product_name' => $_product->get_name(),
                                            'label' => false,
                                            'key' => $key,
                                        ),
                                        $_product
                                    );
                                    ?>
                                    <?php
                                }
                                ?>
                                <div class="basket-cart__summ summ"><?php echo WC()->cart->get_product_subtotal($_product, $item['quantity']) ?></div>
                            </div>

                        </div>

                    </div>
                    <div class="basket__right">
                        <div class="basket-cart__close" data-key="<?php echo $key ?>">
                            <svg class="svgsprite _close-small">
                                <use xlink:href="<?php echo get_theme_file_uri('dist/assets/img/sprites/svgsprites.svg#close-small') ?>"></use>
                            </svg>
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
                WC()->cart->calculate_shipping();
                WC()->cart->calculate_totals();
                if (WC()->cart->get_shipping_total() > 0) {
                    ?>
                    <div class="price-wrap">
                        <div class="prce__item">
                            <h5>Доставка </h5>
                            <div class="price__number summ"><?php echo WC()->cart->get_cart_shipping_total() ?></div>
                        </div>
                    </div>
                    <?php
                }

                ?>
                <div class="price-wrap">
                    <div class="prce__item">
                        <h5>Стоимость </h5>
                        <div class="price__number summ"><?php echo WC()->cart->get_total() ?></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php
