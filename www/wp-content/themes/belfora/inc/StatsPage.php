<?php

namespace Belfora;

use Carbon_Fields\Carbon_Fields;
use Carbon_Fields\Container;
use Carbon_Fields\Field;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;


class StatsPage
{

    public function __construct()
    {


        add_action('admin_menu', [$this, 'create_menu']);


    }


    /**
     * @param $from
     * @param $to
     * @return \WC_Order[]
     * @throws \Exception
     */
    public function getOrdersByDate($from, $to)
    {
        $query = new \WC_Order_Query([
            'posts_per_page' => -1,
            'date_query' => [
                'after' => $from,
                'before' => $to,
            ]
        ]);

        $orders = $query->get_orders();
        return $orders;

    }

    function create_menu()
    {

        //create new top-level menu
        add_menu_page(
            'Belflora',
            'Отчеты',
            'edit_pages',
            'reports',
            [$this, 'settings_page']
        );
    }

    function download($filename, $pathToFile)
    {

        header("Expires: 0");
        header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
        header("Content-Type: application/octet-stream");
        header("Content-Disposition: attachment; filename=$filename");
        header("Content-Transfer-Encoding: binary");
        header("Content-Length: " . filesize($pathToFile));

        while (ob_get_level()) {
            ob_end_clean();
            @readfile($pathToFile);
        }
    }

    function downloadSheet($filename, Spreadsheet $spreadsheet)
    {

        $path_to_file = get_template_directory() . '/' . $filename;
        $writer = new Xlsx($spreadsheet);
        $writer->save($path_to_file);

        $this->download($filename, $path_to_file);
        unlink($path_to_file);
    }

    function getOrderStats()
    {
        $from = $_REQUEST['from'] ?? '';
        $to = $_REQUEST['to'] ?? '';
        if (isset($_REQUEST['from'])) {
            $orders = $this->getOrdersByDate($from, $to);
        } else {
            $query = new \WC_Order_Query([
                    'posts_per_page' => -1,
                'limit' => -1,
                'per_page' => -1,
            ]);
            $orders = $query->get_orders();
        }
        $ordersArr = [];
        if ($from) {
            $ordersArr['date'] = 'с ' . $from . ' по ' . $to ;
        } else {
            $ordersArr['date'] = date('Y-m-d');
        }
        $ordersArr['count'] = count($orders);
        $ordersArr['paid_count'] = 0;
        $ordersArr['unpaid_count'] = 0;
        $ordersArr['total'] = 0;
        $ordersArr['totalWithDelivery'] = 0;

        foreach ($orders as $order) {
            if ($order->is_paid()) {
                $ordersArr['paid_count']++;
            } else {
                $ordersArr['unpaid_count']++;
            }

            $ordersArr['total'] += $order->get_subtotal();
            $ordersArr['totalWithDelivery'] += $ordersArr['total'] + +$order->get_shipping_total();
        }
        return $ordersArr;
    }

    function settings_page()
    {

        if (!current_user_can('manage_options')) {
            return;
        }

        $tab = $_GET['tab'] ?? null;


        if (isset($_REQUEST['action'])) {
            if ($_REQUEST['action'] === 'stats') {
                if (isset($_POST['show']) && $_POST['show'] === 'xlsx') {

                    $spreadsheet = new Spreadsheet();
                    $sheet = $spreadsheet->getActiveSheet();

                    $ordersArr = $this->getOrderStats();

                    $sheet->setCellValue('A1', 'Дата');
                    $sheet->setCellValue('B1', $ordersArr['date']);
                    $sheet->setCellValue('A2', 'кол-во заказов');
                    $sheet->setCellValue('B2', $ordersArr['count']);
                    $sheet->setCellValue('A3', 'кол-во оплаченных заказов');
                    $sheet->setCellValue('B3', $ordersArr['paid_count']);
                    $sheet->setCellValue('A4', 'кол-во неоплаченных заказов');
                    $sheet->setCellValue('B4', $ordersArr['unpaid_count']);
                    $sheet->setCellValue('A5', 'сумма заказов без доставки');
                    $sheet->setCellValue('B5', $ordersArr['total']);
                    $sheet->setCellValue('A6', 'сумма заказов с доставкой');
                    $sheet->setCellValue('B6', $ordersArr['totalWithDelivery']);


                    foreach(range('A','B') as $columnID) {
                        $spreadsheet->getActiveSheet()->getColumnDimension($columnID)
                            ->setAutoSize(true);
                    }
                    $this->downloadSheet('статистика ' . $ordersArr['date'] . '.xlsx', $spreadsheet);

                }


            }
        }
        ?>
        <script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
        <script type="text/javascript"
                src="https://longbill.github.io/jquery-date-range-picker/src/jquery.daterangepicker.js"></script>

        <link rel="stylesheet"
              type="text/css"
              href="https://longbill.github.io/jquery-date-range-picker/dist/daterangepicker.min.css"/>


        <script type="text/javascript">
            jQuery(function ($) {

                $('.two-inputs').each(function () {
                    let $that = $(this);
                    $(this).dateRangePicker(
                        {
                            separator: ' to ',
                            getValue: function () {
                                if ($that.find('#date-range200').val() && $that.find('#date-range201').val())
                                    return $that.find('#date-range200').val() + ' to ' + $that.find('#date-range201').val();
                                else
                                    return '';
                            },
                            setValue: function (s, s1, s2) {
                                $that.find('#date-range200').val(s1);
                                $that.find('#date-range201').val(s2);
                            },
                        });

                });
            });
        </script>
        <div class="wrap">
            <h1><?php echo esc_html(get_admin_page_title()); ?></h1>
            <!-- Here are our tabs -->
            <nav class="nav-tab-wrapper">
                <a href="?page=reports"
                   class="nav-tab <?php if ($tab === null): ?>nav-tab-active<?php endif; ?>">Заказы</a>
                <a href="?page=reports&tab=stats"
                   class="nav-tab <?php if ($tab === 'stats'): ?>nav-tab-active<?php endif; ?>">Статистика</a>
            </nav>

            <?php
            if ($tab === 'stats') {
                ?>
                <h2>Статистика</h2>
                <form method="post">

                    <span class="two-inputs"><input id="date-range200"
                                                    size="20"
                                                    value=""
                                                    name="from"
                                                    autocomplete="off"
                        > по <input id="date-range201"
                                    size="20"
                                    value=""
                                    name="to"
                                    autocomplete="off"></span>
                    <button type="submit" name="show" value="show" class="button button-primary">Показать статистику
                    </button>
                    <button type="submit" name="show" value="xlsx" class="button button-primary">Скачать xlsx</button>
                    <input type="hidden" name="action" value="stats">
                </form>

                <?php

                $ordersArr = $this->getOrderStats();
                if ($ordersArr) {

                    ?>
                    дата: <?php echo $ordersArr['date'] ?> <br>
                    кол - во заказов: <?php echo $ordersArr['count'] ?><br>
                    кол-во оплаченных заказов: <?php echo $ordersArr['paid_count'] ?><br>
                    кол-во неоплаченных заказов: <?php echo $ordersArr['unpaid_count'] ?><br>
                    сумма заказов без доставки: <?php echo $ordersArr['total'] ?><br>
                    сумма заказов с доставкой: <?php echo $ordersArr['totalWithDelivery'] ?><br>
                    <?php
                }
                ?>
                <?php
            }
            ?>
            <?php
            if ($tab === null) {
                ?>
                <h2>Заказы</h2>
                <form method="post">
                <span class="two-inputs"><input id="date-range200"
                                                size="20"
                                                value=""
                                                name="from" autocomplete="off"> по <input id="date-range201"
                                                                                          size="20"
                                                                                          value=""
                                                                                          name="to" autocomplete="off"></span>
                    <input type="hidden" value="report" name="action">
                    <button type="submit" name="show" value="browser" class="button button-primary">Показать заказы
                    </button>
                    <button type="submit" name="show" value="xlsx" class="button button-primary">Скачать xlsx</button>
                </form>
                <?php
                $orders = [];

                if (isset($_REQUEST['action']) && $_REQUEST['action'] === 'report') {
                    $orders = $this->getOrdersByDate($_REQUEST['from'] ?? '', $_REQUEST['to'] ?? '');
                } else {
                    $query = new \WC_Order_Query();
                    $orders = $query->get_orders();
                }

                if ($orders) {
                    $exportArr = [];
                    foreach ($orders as $order) {
                        $total = strip_tags($order->get_formatted_order_total());
                        $total = str_replace('&nbsp;', ' ', $total);
                        $exportArr[] = [
                            'id' => $order->get_id(),
                            'date_created' => $order->get_date_created()->date_i18n(get_option('date_format') . ' ' . get_option('time_format')),
                            'billing_date' => $order->get_meta('_billing_date'),
                            'address' => $order->get_billing_address_1(),
                            'order_total' => $total,
                            'payment_method' => $order->get_payment_method_title(),
                            'paid' => $order->is_paid() ? 'Оплачено' : 'Не оплачено',
                        ];
                    }
                    if (isset($_REQUEST['show']) && $_REQUEST['show'] === 'xlsx') {

                        $spreadsheet = new Spreadsheet();

                        $from = $_REQUEST['from'] ?? '';
                        $to = $_REQUEST['to'] ?? '';
                        if ($from) {
                            $date = 'с ' . $from . ' по ' . $to ;
                        } else {
                            $date = date('Y-m-d');
                        }
                        $sheet = $spreadsheet->getActiveSheet();
                        $sheet->setCellValue('A1', '№заказа');
                        $sheet->setCellValue('B1', 'Дата и время создания заказа');
                        $sheet->setCellValue('C1', 'Дата и время доставки');
                        $sheet->setCellValue('D1', 'Адрес');
                        $sheet->setCellValue('E1', 'Сумма заказа');
                        $sheet->setCellValue('F1', 'Тип оплаты');
                        $sheet->setCellValue('G1', 'Статус оплаты');

                        $i = 2;
                        foreach ($exportArr as $item) {
                            $sheet->setCellValue("A$i", $item['id']);
                            $sheet->setCellValue("B$i", $item['date_created']);
                            $sheet->setCellValue("C$i", $item['billing_date']);
                            $sheet->setCellValue("D$i", $item['address']);
                            $sheet->setCellValue("E$i", $item['order_total']);
                            $sheet->setCellValue("F$i", $item['payment_method']);
                            $sheet->setCellValue("G$i", $item['paid']);
                            $i++;
                        }
                        foreach(range('A','G') as $columnID) {
                            $spreadsheet->getActiveSheet()->getColumnDimension($columnID)
                                ->setAutoSize(true);
                        }
                        $this->downloadSheet("заказы " . $date . ".xlsx", $spreadsheet);
                    } else {

                        ?>
                        <table class="widefat">
                            <thead>
                            <tr>
                                <th>№заказа</th>
                                <th>Дата и время создания заказа</th>
                                <th>Дата и время доставки</th>
                                <th>Адрес</th>
                                <th>Сумма заказа</th>
                                <th>Тип оплаты</th>
                                <th>Статус оплаты</th>
                            </tr>
                            </thead>
                            <tbody>

                            <?php
                            foreach ($exportArr as $item) {
                                ?>
                                <tr>
                                    <td>
                                        <a href="<?php echo add_query_arg('order', $item['id']) ?>"><?php echo $item['id'] ?></a>
                                    </td>
                                    <td><?php echo $item['date_created'] ?></td>
                                    <td><?php echo $item['billing_date'] ?></td>
                                    <td><?php echo $item['address']; ?></td>
                                    <td><?php echo $item['order_total']; ?></td>
                                    <td><?php echo $item['payment_method']; ?></td>
                                    <td><?php echo $item['paid'] ?></td>
                                </tr>
                                <?php
                            }
                            ?>
                            </tbody>
                        </table>
                        <?php
                    }
                }
                ?>
                <?php
            }
            ?>
        </div>
        <?php
    }


}
