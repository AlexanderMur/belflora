<?php

use Belfora\Cart;
use Belfora\Options;

?>


<form class="basket__wrap" action="<?php echo wc_get_checkout_url() ?>">
    <div class="basket__top">
        <div class="basket__header">
            <h2>Ваша корзина</h2>
            <button class="basket__close -js-fadeoutbasket">
                <svg class="svgsprite _close">
                    <use xlink:href="<?php echo get_theme_file_uri("dist/assets/img/sprites/svgsprites.svg#close") ?>"></use>
                </svg>
            </button>
        </div>
        <div class="basket__body">
            <?php
            if (Cart::getCartCount() === 0) {
                ?>
                <p>Корзина пуста</p>
                <?php
            }
            ?>
            <?php
            $set_id = options(Options::basket_nabor)[0]['id'] ?? 0;
            foreach (WC()->cart->get_cart() as $key => $item) {
                /** @var WC_Product $_product */
                $_product = $item['data'];
                $product_id = $item['product_id'];
                $is_set = $_product->get_id() == $set_id;
                if (!$is_set && $_product && $_product->exists()) {
                    $permalink = $_product->get_permalink();
                    $thumbnail = $_product->get_image('medium');
                    ?>
                    <div class="basket-cart">
                        <div class="basket__left">
                            <div class="basket-cart__pic"><?php echo $thumbnail ?></div>
                            <div class="basket-cart__info">
                                <h5 class="basket-cart__title"><?php echo wp_kses_post($_product->get_title()) ?></h5>
                                <p class="text-grey basket-cart__text"><?php echo theme()->products->getProducAttrName($_product) ?></p>

                                <div class="basket-cart__amount">
                                    <?php
                                    woocommerce_quantity_input(
                                        array(
                                            'input_name' => "cart[{$key}][qty]",
                                            'input_value' => $item['quantity'],
                                            'max_value' => $_product->get_max_purchase_quantity(),
                                            'min_value' => '0',
                                            'product_name' => $_product->get_name(),
                                            'label' => '',
                                            'key' => $key,

                                        ),
                                        $_product
                                    );
                                    ?>
                                    <div class="basket-cart__summ summ"><?php echo WC()->cart->get_product_subtotal($_product, $item['quantity']) ?></div>
                                </div>
                            </div>

                        </div>
                        <div class="basket__right">
                            <div class="basket-cart__close" data-key="<?php echo $key ?>">
                                <svg class="svgsprite _close-small">
                                    <use xlink:href="<?php echo get_theme_file_uri("dist/assets/img/sprites/svgsprites.svg#close-small") ?>"></use>
                                </svg>
                            </div>
                        </div>
                    </div>
                    <?php
                }
            }

            ?>
        </div>
    </div>
    <div class="basket__bottom">
        <?php
        if (Cart::getCartCount() > 0) {
            $removeNabor = WC()->session->get('remove_nabor') ?? 1
            ?>
            <div class="basket__set">
                <p>Добавить набор для продления жизни сразенных цветов?</p>
                <div class="basket__radios">
                    <label class="basket__radio">
                        <input class="hidden" type="radio" name="add_nabor" value="1" <?php checked(0, $removeNabor) ?>>
                        <div class="basket__radio-button">Да</div>
                    </label>
                    <label class="basket__radio">
                        <input class="hidden" type="radio" name="add_nabor" value="0" <?php checked(1, $removeNabor) ?>>
                        <div class="basket__radio-button">Нет</div>
                    </label>
                </div>
            </div>
            <?php
        }
        ?>
        <div class="basket__bottom-wrap">

            <?php
            if (Cart::getCartCount() > 0) {
                ?>
                <div class="basket__price price">
                    <div class="price-wrap">
                        <div class="prce__item">
                            <h5>Стоимость </h5>
                            <div class="price__number summ"> <?php echo WC()->cart->get_total() ?></div>
                        </div>
                    </div>
                    <div class="price-wrap">
                        <div class="prce__item">
                            <h5>Cкидка </h5>
                            <div class="price__number summ"> 0 руб.</div>
                        </div>
                    </div>
                </div>
                <?php
            }
            ?>
            <div class="basket__buttons">
                <?php
                if (Cart::getCartCount() > 0) {
                    ?>
                    <button type="submit" class="basket__button button --dark --big">Оформить заказ</button>
                    <?php
                }
                ?>
                <button class="basket__button basket__button--close button --white --big -js-fadeoutbasket">
                    Продолжить покупки
                </button>
            </div>
        </div>
    </div>
</form>
