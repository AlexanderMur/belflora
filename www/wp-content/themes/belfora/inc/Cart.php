<?php

namespace Belfora;

class Cart
{
    public function __construct()
    {

        add_action('template_redirect', [$this, 'load']);
        add_filter( 'woocommerce_add_cart_item', [$this, 'set_my_price_data'], 15 );
        add_filter( 'woocommerce_get_cart_item_from_session', [$this, 'set_my_price_data_from_session'], 15, 2 );
        add_filter('woocommerce_checkout_fields', [$this, 'addCheckoutFields']);

        add_filter('woocommerce_cart_shipping_packages', [$this, 'get_shipping_packages']);

        add_action('wp_ajax_update_rajon', [$this, 'update_rajon']);
        add_action('wp_ajax_nopriv_update_rajon', [$this, 'update_rajon']);

//        add_action('woocommerce_cod_process_payment_order_status', [$this, 'updateStatusCod'], 10, 2);

    }

    function updateStatusCod($status, $order) {
        if ($status === 'processing') {
            return 'status-pending';
        }
        return $status;
    }
    public function update_rajon() {
        WC()->session->set('shipping_rajon',  $_POST['rajon']);
        wp_send_json(theme()->ajax->getRefreshedFragments());
    }
    public function get_shipping_packages($packages) {
        foreach ($packages as $key => $package) {
            $packages[$key]['destination']['rajon'] = WC()->session->get('shipping_rajon');
        }
        return $packages;
    }

    /**
     * @throws \Exception
     */
    public function load()
    {
        if (isset($_GET['my_price'])) {
            $my_price = $_GET['my_price'];
            $id = options(Options::basket_my_price)[0]['id'] ?? 0;
            if ($id && $my_price > 1000) {
                WC()->cart->add_to_cart($id, 1, 0, [], ['my_price' => $my_price]);
            }
        }
        if (is_checkout()) {
            if (theme()->cart->removedNabor()) {
                $this->addNabor(0);
            } else {
                $this->addNabor(1);
            }
        }
    }
    public function removedNabor() {
        return WC()->session->get('remove_nabor') ?? 1;
    }
    /**
     * @param int $state
     * @throws \Exception
     */
    public function addNabor($state = 1) {

        $nabor_id = options(Options::basket_nabor)[0]['id'] ?? 0;
        if ($state == 0) {
            $key = $this->findProductInCart($nabor_id);
            if ($key) {
                WC()->cart->remove_cart_item($key);
            }
        } else {
            $found = $this->findProductInCart($nabor_id);
            if (!$found)
                WC()->cart->add_to_cart($nabor_id);

            WC()->session->set('remove_nabor', 0);
        }
    }
    public function removeNabor() {
        $this->addNabor(0);
        WC()->session->set('remove_nabor', 1);
    }
    static function getCartCount()
    {
        $count = 0;
        $setId = options(Options::basket_nabor)[0]['id'] ?? 0;
        foreach (WC()->cart->get_cart() as $item) {
            $product = $item['data'];
            if ($product->get_id() == $setId) {
                $count += 0;
            } else {
                $count += $item['quantity'];
            }
        }
        return $count;
    }

    /**
     * @param $productId
     * @return int|string Cart item key
     *
     */
    function findProductInCart($productId)
    {
        if (sizeof(WC()->cart->get_cart()) > 0) {
            foreach (WC()->cart->get_cart() as $cart_item_key => $values) {
                $_product = $values['data'];
                if ($_product->get_id() == $productId)
                    return $cart_item_key;
            }
        }
    }

    function set_my_price_data($cart_item) {

        if ( ! empty ( $cart_item['my_price'] ) ){
            $cart_item['data']->set_price( $cart_item['my_price']  );
            $cart_item['data']->set_regular_price( $cart_item['my_price']  );
            $cart_item['data']->set_sale_price( $cart_item['my_price']  );
        }

        return $cart_item;
    }

    function set_my_price_data_from_session( $cart_item, $values) {
        if ( ! empty( $values['my_price'] ) ) {
            $cart_item['my_price'] = $values['my_price'];
            $cart_item = $this->set_my_price_data( $cart_item );
        }

        return $cart_item;
    }

    public function addCheckoutFields($fields)
    {

            unset($fields['shipping']['shipping_last_name']);
            unset($fields['shipping']['shipping_country']);
            unset($fields['shipping']['shipping_state']);
            unset($fields['shipping']['shipping_postcode']);
            unset($fields['shipping']['shipping_city']);

            $fields['shipping'] = array_merge($fields['shipping'], [

                'shipping_rajon' => [
                    'placeholder' => 'Ваше Имя*',
                    'type' => 'select',
                ],
                'shipping_phone' => [
                    'placeholder' => 'Дата',
                    'type' => 'text',
                ],
                'shipping_time' => [
                    'placeholder' => 'Время*',
                    'type' => 'select',
                ],
                'shipping_date' => [
                    'placeholder' => 'Дата',
                    'type' => 'text',
                ],
            ]);

            unset($fields['billing']['billing_last_name']);
            unset($fields['billing']['billing_company']);
            unset($fields['billing']['billing_address_2']);
            unset($fields['billing']['billing_city']);
            unset($fields['billing']['billing_state']);
            unset($fields['billing']['billing_postcode']);

            $fields['billing']['billing_email']['required'] = false;
            $fields['billing']['billing_address_1']['required'] = false;
            $fields['billing'] = array_merge($fields['billing'], [
                'billing_delivery' => [
                    'type' => 'radio',
                    'options' => [
                        '0' => 'Забрать в магазине',
                        '1' => 'Доставка курьером',
                    ]
                ],
                'order_comments' => [
                    'placeholder' => 'Комментарий к заказу',
                ],
                'terms' => [
                    'type' => 'checkbox',
                    'required' => true,
                ],
            ]);


            return $fields;

    }
}
