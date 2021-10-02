<?php

namespace Belfora;


use WC_Product_Variable;
use WC_Product_Variation;
use WP_Query;

class Theme
{
    private static $_instance;
    /**
     * @var array
     */
    private $saved_flowers = [];
    /**
     * @var Options|mixed|null
     */
    public $options;
    /**
     * @var Comments
     */
    public $comments;
    /**
     * @var StatsPage
     */
    public $statsPage;
    /**
     * @var Ajax
     */
    public $ajax;
    /**
     * @var Cart
     */
    public $cart;
    /**
     * @var Filters
     */
    public $filters;
    /**
     * @var Product|null
     */
    public $products;

    public function __construct()
    {
        $this->options = options();
        $this->statsPage = new StatsPage();
        $this->comments = new Comments();
        $this->ajax = new Ajax();
        $this->cart = new Cart();
        $this->filters = new Filters();
        $this->products = products();

        add_filter( 'woocommerce_payment_gateways', function ( $gateways ) {
            $gateways[] = PaypalMethod::class;
            return $gateways;
        } );



        add_theme_support('woocommerce');
        register_nav_menus([
            'top_mobile' => 'Мобильное меню',
            'header' => 'Хедер',
            'footer1' => 'Футер 1',
            'footer2' => 'Футер 2',
            'footer3' => 'Футер 3',
        ]);

        register_post_type('specials', [

        ]);

        add_action('wp_enqueue_scripts', [$this, 'enqueue_scripts']);


        $labels = array(
            'name' => 'События',
            'singular_name' => 'Событие',
            'search_items' => 'Поиск События',
            'all_items' => 'Все События',
            'parent_item' => 'Родительский Событие',
            'parent_item_colon' => 'Родительский Событие',
            'edit_item' => 'Редактирование События',
            'update_item' => 'Обновить',
            'add_new_item' => 'Добавить новое Событие',
            'new_item_name' => 'Новое Событие',
            'menu_name' => 'События',
        );

        $args = array(
            'labels' => $labels,
            'hierarchical' => true,
            'query_var' => true,
            'rewrite' => array('slug' => 'events'),
            'show_admin_column' => true,
        );

        register_taxonomy('events', 'product', $args);

        add_filter('woocommerce_loop_add_to_cart_args', function ($args) {
            $args['class'] = '--dark -js-fadebuttons ' . $args['class'];
            return $args;
        });


        add_filter('nav_menu_link_attributes', [$this, 'add_additional_class_on_a'], 1, 3);

        add_action('woocommerce_product_after_variable_attributes', [$this, 'add_custom_variable_fields'], 10, 3);
        add_action('woocommerce_admin_process_variation_object', [$this, 'save_custom_variable_fields'], 10, 2);
        add_action('woocommerce_ajax_save_product_variations', [$this, 'on_save_product'], 10);
        add_action('woocommerce_available_variation', [$this, 'add_available_variation'], 10, 3);


        add_action('template_redirect', [$this, 'onLoaded']);

        add_action('wpo_wcpdf_after_order_data', [$this, 'wpo_wcpdf_delivery_date'], 10, 2);
        add_action( 'manage_shop_order_posts_custom_column',function  ( $column_id, $post_id ) {
            global $post;
            $order = wc_get_order($post);
            if ($column_id === 'shipping_address') {
                echo $order->get_meta('_billing_date') . ' ' .$order->get_meta('_billing_time');
            }
        }, 10000, 2 );

    }
    function wpo_wcpdf_delivery_date ($template_type, $order) {
        if ($template_type == 'invoice') {
            $text_align = is_rtl() ? 'right' : 'left';
            $address    = $order->get_formatted_billing_address();
            $shipping   = $order->get_formatted_shipping_address();
            ?>

            <tr class="payment-method">
                <th>Имя Отправителя</th>
                <td><?php echo esc_html($order->get_billing_first_name()); ?></td>
            </tr>
            <tr class="payment-method">
                <th>Телефон отправителя</th>
                <td><?php echo esc_html($order->get_billing_phone()); ?></td>
            </tr>
            <tr class="payment-method">
                <th>Email</th>
                <td><?php echo esc_html($order->get_billing_email()); ?></td>
            </tr>
            <tr class="payment-method">
                <th>Адрес получателя</th>
                <td><?php echo esc_html($order->get_shipping_address_1()); ?></td>
            </tr>

            <tr class="payment-method">
                <th>Район</th>
                <td><?php echo esc_html($order->get_meta('_shipping_rajon')); ?></td>
            </tr>
            <tr class="payment-method">
                <th>Дата доставка</th>
                <td><?php echo esc_html($order->get_meta('_shipping_date')); ?></td>
            </tr>

            <tr class="payment-method">
                <th>Время доставки</th>
                <td><?php echo esc_html($order->get_meta('_shipping_time')); ?></td>
            </tr>

            <tr class="payment-method">
                <th>Имя получателя</th>
                <td><?php echo esc_html($order->get_meta('_shipping_first_name')); ?></td>
            </tr>
            <tr class="payment-method">
                <th>Телефон получателя</th>
                <td><?php echo esc_html($order->get_meta('_shipping_phone')); ?></td>
            </tr>


            <?php
        }
    }
    /**
     * @return Theme
     */
    public static function instance()
    {
        if (is_null(self::$_instance)) {
            self::$_instance = new self();
        }
        return self::$_instance;
    }

    function onLoaded() {
        $is_thank_you_page = is_checkout() && !empty( is_wc_endpoint_url('order-received') );
        if ( !$is_thank_you_page && !is_page_template('page-orders.php') && !is_account_page()) {
            add_filter('woocommerce_enqueue_styles', '__return_empty_array');
        }
        if (false && is_page_template('page-orders.php') ) {
            wp_enqueue_style('bootstrap', get_template_directory_uri() . '/assets/bootstrap/bootstrap.css');
            wp_enqueue_script('bootstrap', get_template_directory_uri() . '/assets/bootstrap/bootstrap.js');
        }
    }



    function on_save_product($product_id)
    {
        $variations = wc_get_products(
            array(
                'status' => array('private', 'publish'),
                'type' => 'variation',
                'parent' => $product_id,
                'limit' => '0',
                'orderby' => array(
                    'menu_order' => 'ASC',
                    'ID' => 'DESC',
                ),
                'return' => 'objects',
            )
        );
        $flowers = [];
        /** @var WC_Product_Variation[] $variations */
        foreach ($variations as $variation) {
            $ingredients = get_post_meta($variation->get_id(), 'sostav', true);
            foreach ($ingredients as $ingredient) {
                foreach ((array)$ingredient as $name => $num) {
                    if (!in_array($name, $flowers)) {
                        $flowers[] = $name;
                    }
                }
            }

        }

        if (isset($flowers)) {
            update_post_meta($product_id, 'flowers', $flowers);
        }
    }


    function add_available_variation($attrs, WC_Product_Variable $i1, WC_Product_Variation $i2)
    {
        $ingredients = $i2->get_meta('sostav');
        ob_start();
        foreach ($ingredients as $ingredient) {
            foreach ((array)$ingredient as $name => $num) {
                if ($name && $num) {
                    ?>
                    <div class="catalog__structure-item">
                        <div class="catalog__structure-name"><?php echo $name ?></div>
                        <div class="catalog__structure-summ"><?php echo $num ?> шт.</div>
                    </div>
                    <?php
                }
            }
        }
        $html = ob_get_clean();
        $attrs['ingredients_html'] = $html;
        return $attrs;
    }

    function add_custom_variable_fields($i, $data, $post)
    {
        $ingredients = get_post_meta($post->ID, 'sostav', true);
        $text = '';
        foreach ($ingredients as $ingredient) {
            foreach ((array)$ingredient as $name => $num) {
                if ($name && $num) {
                    $text .= $name . ' ' . $num . ' шт.' . "\r\n";
                }
            }
        }
        ?>
        <div>
            <textarea name="sostav[<?php echo $i ?>]" id="" cols="30" rows="10"><?php echo $text ?></textarea>
        </div>
        <?php
    }

    function save_custom_variable_fields(WC_Product_Variation $variation, $i)
    {

        $text = $_POST['sostav'][$i];
        $items = explode("\r\n", $text);
        $items = array_filter($items);
        $ingredients = [];
        foreach ($items as $item) {
            $match = preg_match('/(.*) (\d+) шт\.?\s?$/', $item, $matches);
            $name = trim($matches[1]);
            $ingredients[] = [
                $name => $matches[2]
            ];
            if (!in_array($name, $this->saved_flowers)) {
                $this->saved_flowers[] = $name;
            }
        }
        $variation->add_meta_data('sostav', $ingredients, true);
    }

    function add_additional_class_on_a($attrs, $item, $args)
    {
        if (isset($args->a_class)) {
            $attrs['class'] = $args->a_class;
        }
        return $attrs;
    }

    public function enqueue_scripts()
    {


        wp_enqueue_script('polyfill', 'https://polyfill.io/v3/polyfill.min.js?features=default', [], '1');

        wp_enqueue_style('fonts1', 'https://fonts.googleapis.com/css2?family=Oranienbaum&amp;display=swap', array(), '1');
        wp_enqueue_style('fonts2', 'https://fonts.googleapis.com/css2?family=Oranienbaum&amp;family=PT+Sans:wght@400;700&amp;display=swap', array(), '1');
        wp_enqueue_style('main', get_theme_file_uri('/dist/assets/css/common.css'), array(), '1');
        wp_enqueue_style('main2', get_theme_file_uri('/style.css'), array(), '1');

        wp_enqueue_script('jquery');
        wp_enqueue_script('vendor', get_theme_file_uri('/dist/assets/js/vendors~main.bundle.js'), 'jquery', '1', true);
        wp_enqueue_script('main', get_theme_file_uri('/dist/assets/js/main.bundle.js'), 'jquery', '1', true);

        if (is_archive()) {

            global $wp_query;
            wp_localize_script('main-js', 'posts_query', [
                'ajaxurl' => site_url() . '/wp-admin/admin-ajax.php',
                'posts' => json_encode($wp_query->query_vars),
                'current_page' => get_query_var('paged') ? get_query_var('paged') : 1,
                'max_page' => $wp_query->max_num_pages
            ]);
        }
    }


    public function throw_404()
    {
        global $wp_query;
        $wp_query->set_404();
        status_header(404);
        get_template_part(404);
        exit();
    }


}
