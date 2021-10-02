<?php
/**
 * Email Addresses
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/emails/email-addresses.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates\Emails
 * @version 3.9.0
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

$text_align = is_rtl() ? 'right' : 'left';
$address    = $order->get_formatted_billing_address();
$shipping   = $order->get_formatted_shipping_address();

?><table id="addresses" cellspacing="0" cellpadding="0" style="width: 100%; vertical-align: top; margin-bottom: 40px; padding: 0;" border="0">
    <tr>
        <td style="text-align:<?php echo esc_attr( $text_align ); ?>; font-family: 'Helvetica Neue', Helvetica, Roboto, Arial, sans-serif; border:0; padding: 0 0 18px;" valign="top" width="50%">
            <h2 class="woocommerce-column__title">Отправитель</h2>

            <address class="address">

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
        </td>
    </tr>
    <tr>
        <td style="text-align:<?php echo esc_attr( $text_align ); ?>; font-family: 'Helvetica Neue', Helvetica, Roboto, Arial, sans-serif; border:0; padding: 0 0 18px;" valign="top" width="50%">
            <h2 class="woocommerce-column__title">Доставка</h2>

            <address class="address">

                <?php if ($order->get_meta('_billing_delivery') === '1') : ?>
                    <p>Доставка курьером</p>
                <?php endif; ?>
                <?php if ($order->get_meta('_billing_delivery') === '2') : ?>
                    <p>Забрать в магазине</p>
                <?php endif; ?>

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
        </td>
    </tr>
    <tr>
        <td style="text-align:<?php echo esc_attr( $text_align ); ?>; font-family: 'Helvetica Neue', Helvetica, Roboto, Arial, sans-serif; border:0; padding: 0 0 18px;" valign="top" width="50%">
            <h2 class="woocommerce-column__title">Получатель</h2>

            <address class="address">

                <?php if ($order->get_shipping_first_name()) : ?>
                    <p><?php echo esc_html($order->get_shipping_first_name()); ?></p>
                <?php endif; ?>

                <?php if ($order->get_meta('_shipping_phone')) : ?>
                    <p><?php echo esc_html($order->get_meta('_shipping_phone')); ?></p>
                <?php endif; ?>
            </address>
        </td>
    </tr>
</table>
