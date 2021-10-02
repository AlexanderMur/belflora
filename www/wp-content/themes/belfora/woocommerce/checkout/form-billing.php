<?php
/**
 * Checkout billing information form
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/checkout/form-billing.php.
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
 * @global WC_Checkout $checkout
 */

defined('ABSPATH') || exit;

$chosen_method = isset(WC()->session->chosen_shipping_methods[0]) ? WC()->session->chosen_shipping_methods[0] : '';
$rates = WC()->shipping()->get_packages()[0]['rates'] ?? [];
?>
<div class="woocommerce-billing-fields">


    <div class="form__step" style="display: block">
        <h4 class="form__title">1. Отправитель</h4>

        <div class="form__block">
            <input
                    class="form__input"
                    type="text"
                    placeholder="Ваше имя*"
                    name="billing_first_name"
                    id="billing_first_name"
                    value="<?php echo $checkout->get_value('billing_first_name') ?>"
                    required
            >
            <div class="form__error">Неправильный формат имени</div>
        </div>
        <div class="form__block">
            <input class="form__input mask-tel"
                   type="tel"
                   placeholder="Ваш телефон*"
                   name="billing_phone"
                   value="<?php echo $checkout->get_value('from_phone') ?>"
                   required>
            <div class="form__error">Неправильный формат телефона</div>
        </div>
        <div class="form__block">
            <input class="form__input"
                   type="email"
                   placeholder="Ваша почта"
                   name="billing_email"
                   value="<?php echo $checkout->get_value('from_email') ?>">
            <div class="form__error">Неправильный формат почты</div>
        </div>
    </div>

    <div class="form__step">
        <h4 class="form__title">2. Доставка</h4>

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
                           value="<?php echo $field->get_id() ?>" <?php checked($field->get_id(), $chosen_method) ?>><span
                            class="radio__circle"></span>
                    <p class="radio__text"><?php echo $field->get_label() ?></p>
                </label>
                <?php
            }

            ?>
        </div>

        <div class="js-delivery">
            <div class="form__block">
                <input class="form__input"
                       type="text"
                       placeholder="Адрес получателя"
                       name="shipping_address_1"
                       value="<?php echo $checkout->get_value('shipping_address_1') ?>">
                <div class="form__error">Неверный Адрес</div>
            </div>
            <div class="form__block select">
                <?php

                $options = (array) options('rajons');
                $options = wp_list_pluck($options, 'name');
                ?>
                <select name="shipping_rajon" id="shipping_rajon" style="display: none">
                    <?php
                    foreach ($options as $option) {
                        ?>
                        <option value="<?php echo $option ?>"><?php echo $option ?></option>
                        <?php
                    }
                    ?>
                </select>
                <div class="select__main">Район доставки</div>
                <div class="select__drop">
                    <?php
                    foreach ($options as $option) {
                        ?>
                        <div class="select__item"><?php echo $option ?></div>
                        <?php
                    }
                    ?>
                </div>
            </div>

            <div class="form__block">
                <div class="calendar">
                    <div class="calendar__input">
                        <input
                                class="form__input air-datepicker"
                                type="text"
                                inputmode="text"
                                name="shipping_date"
                                autocomplete="off"
                                data-position="top left"
                        >
                        <div class="calendar__input-text"><span>Введите дату доставки</span>
                            <svg class="svgsprite _calendar">
                                <use xlink:href="<?php echo get_theme_file_uri('dist/assets/img/sprites/svgsprites.svg#calendar') ?>"></use>
                            </svg>
                        </div>
                    </div>
                </div>
            </div>
            <p class="form__description">Доставка букетов осуществляется с 9:00 до 20:00</p>
            <div class="select">
                <div class="select__main">Время доставки</div>
                <select name="shipping_time" id="shipping_time" class="input-hidden">
                    <option value="6:00-12:00">6:00-12:00</option>
                    <option value="12:00-18:00">12:00-18:00</option>
                    <option value="18:00-24:00">18:00-24:00</option>
                </select>
                <div class="select__drop">
                    <div class="select__item">6:00-12:00</div>
                    <div class="select__item">12:00-18:00</div>
                    <div class="select__item">18:00-24:00</div>
                </div>
            </div>
        </div>
    </div>
    <div class="form__step">
        <h4 class="form__title">3. Получатель</h4>

        <div class="form__block">
            <input class="form__input"
                   type="text"
                   placeholder="Имя получателя*"
                   name="shipping_first_name"
                   value="<?php echo $checkout->get_value('to_email') ?>"
                   required>
            <div class="form__error">Неверное имя</div>
        </div>
        <div class="form__block">
            <input
                    class="form__input mask-tel"
                    type="tel"
                    placeholder="Телефон получателя*"
                    name="shipping_phone"
                    value="<?php echo $checkout->get_value('shipping_phone') ?>"
                    required
            >
            <div class="form__error">Неверный телефон</div>
        </div>
        <div class="form__block">
            <input class="form__input"
                   type="text"
                   placeholder="Комментарий к заказу"
                   name="order_comments"
                   value="<?php echo $checkout->get_value('order_comments') ?>">
        </div>
        <label class="checkbox form__checkbox">
            <input class="hidden" type="checkbox" name="terms" required><span class="checkbox__ico"></span>
            <p class="checkbox__text"><span>Даю согласие на обработку</span>&nbsp;<a href="#">персональных данных</a>
            </p>
        </label>
    </div>
    <div class="form__step">
        <h4 class="form__title">4. Оплата заказа</h4>
        <?php woocommerce_checkout_payment() ?>
    </div>
    <div class="form__buttons">
        <button class="button --dark --big form__buttom js-next-step" data-step="2">Далее</button>
        <button type="submit" class="button --dark --big form__buttom js-form-submit" style="display: none">Оплатить
            заказ
        </button>
        <a class="button --white --big form__buttom js-prev-step" href="#" style="display: none"> Вернуться назад</a>
    </div>
    <input name="billing_country" type="hidden" value="RU" />
    <input name="shipping_country" type="hidden" value="RU">
    <input type="hidden" id="ship-to-different-address-checkbox" name="ship_to_different_address" value="1">
</div>
