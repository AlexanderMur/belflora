<?php

/*
 * Template Name: Заказы
 * */
?>


<?php get_header(); ?>

<div id="primary" class="content-area">
    <main id="main" class="site-main" role="main">
        <div class="content">
            <?php get_template_part('template', 'banner-search') ?>

        </div>
        <section id="printOrders">

            <div class="container woocommerce">
                <?php
                if (isset($_GET['order'])) {
                    $id = $_GET['order'];
                    $order = wc_get_order($id);
                    woocommerce_order_details_table($id);
                    ?>
                    <a href="<?php echo get_the_permalink(get_the_ID()) ?>">Back</a>
                    <button class="printOrdersBtn">Print</button>
                    <?php
                } else {
                    $orders = wc_get_orders([]);
                    ?>
                    <table>
                        <thead>
                        <tr>
                            <th>№заказа</th>
                            <th>Дата создания заказа</th>
                            <th>Дата доставки</th>
                            <th>Адрес</th>
                            <th>Сумма заказа</th>
                            <th>Тип оплаты</th>
                            <th>Статус оплаты</th>
                            <th>Выполнение заказа</th>
                            <th>Действие</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php
                        foreach ($orders as $order) {
                            ?>
                            <tr>
                                <td>
                                    <a href="<?php echo add_query_arg('order', $order->get_id()) ?>"><?php echo $order->get_id() ?></a>
                                </td>
                                <?php
                                ?>
                                <td><?php echo $order->get_date_created()->date_i18n( get_option( 'date_format' ) . ' ' . get_option( 'time_format' ) ) ?></td>
                                <?php
                                ?>
                                <td>
                                    <?php echo $order->get_meta('_billing_date') ?>
                                </td>
                                <?php
                                ?>
                                <td><?php echo $order->get_billing_address_1(); ?></td>
                                <?php
                                ?>
                                <td><?php echo $order->get_formatted_order_total(); ?></td>
                                <?php
                                ?>
                                <td><?php echo $order->get_payment_method_title(); ?></td>
                                <?php
                                ?>
                                <td><?php echo $order->is_paid() ? 'Оплачено' : 'Не оплачено'; ?></td>
                                <?php
                                ?>
                                <td><?php echo wc_get_order_status_name($order->get_status()); ?></td>
                                <td>
                                    <button class="btn js-print-order" data-order="<?php echo $order->get_id() ?>">Печать</button>
                                </td>
                            </tr>
                            <?php
                        }
                        ?>
                        </tbody>
                    </table>
                    <?php
                }

                ?>

            </div>
        </section>
    </main>
</div>

<?php get_footer() ?>
