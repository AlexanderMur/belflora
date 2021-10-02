<?php
/**
 * Order Customer Details
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/order/order-details-customer.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 3.4.4
 */

defined('ABSPATH') || exit;

?>
<section class="woocommerce-customer-details">

    <h2 class="woocommerce-column__title">Отправитель</h2>

    <address>

        <?php if ($order->get_billing_first_name()) : ?>
            <p><?php echo esc_html($order->get_billing_first_name()); ?></p>
        <?php endif; ?>

        <?php if ($order->get_billing_phone()) : ?>
            <p><?php echo esc_html($order->get_billing_phone()); ?></p>
        <?php endif; ?>

        <?php if ($order->get_billing_email()) : ?>
            <p><?php echo esc_html($order->get_billing_email()); ?></p>
        <?php endif; ?>
    </address>
</section>
<section class="woocommerce-customer-details">
    <h2 class="woocommerce-column__title">Доставка</h2>

    <address>

        <?php if ($order->get_billing_address_1()) : ?>
            <p><?php echo esc_html($order->get_billing_address_1()); ?></p>
        <?php endif; ?>

        <?php if ($order->get_meta('_shipping_rajon')) : ?>
            <p><?php echo esc_html($order->get_meta('_shipping_rajon')); ?></p>
        <?php endif; ?>

        <?php if ($order->get_meta('_shipping_date')) : ?>
            <p><?php echo esc_html($order->get_meta('_shipping_date')); ?></p>
        <?php endif; ?>
        <?php if ($order->get_meta('_shipping_time')) : ?>
            <p><?php echo esc_html($order->get_meta('_shipping_time')); ?></p>
        <?php endif; ?>
    </address>

</section>
<section class="woocommerce-customer-details">

    <h2 class="woocommerce-column__title">Получатель</h2>

    <address>


        <?php if ($order->get_shipping_first_name()) : ?>
            <p><?php echo esc_html($order->get_shipping_first_name()); ?></p>
        <?php endif; ?>

        <?php if ($order->get_meta('_shipping_phone')) : ?>
            <p><?php echo esc_html($order->get_meta('_shipping_phone')); ?></p>
        <?php endif; ?>
    </address>
</section>
