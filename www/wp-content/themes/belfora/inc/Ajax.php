<?php

namespace Belfora;

use WC_Product_Variable;

class Ajax
{

    public function __construct()
    {
        add_action('wp_ajax_like', [$this, 'onLike']);
        add_action('wp_ajax_nopriv_like', [$this, 'onLike']);

        add_action('wp_ajax_add_to_cart', [$this, 'onAddToCart']);
        add_action('wp_ajax_nopriv_add_to_cart', [$this, 'onAddToCart']);

        add_action('wp_ajax_update_qty', [$this, 'onUpdateQty']);
        add_action('wp_ajax_nopriv_update_qty', [$this, 'onUpdateQty']);

        add_action('wp_ajax_get_cart', [$this, 'getCart']);
        add_action('wp_ajax_nopriv_get_cart', [$this, 'getCart']);

        add_action('wp_ajax_add_nabor', [$this, 'addNabor']);
        add_action('wp_ajax_nopriv_add_nabor', [$this, 'addNabor']);

        add_filter('woocommerce_add_to_cart_fragments', [$this, 'addToCartFragments']);
        add_action('woocommerce_update_order_review_fragments', [$this, 'update_order_review_fragments']);


    }

    function addNabor()
    {
        $state = $_POST['add_nabor'] ?? 1;
        if ($state == 1) {
            theme()->cart->addNabor($state);
        } else {
            theme()->cart->removeNabor();
        }

        wp_send_json($this->getRefreshedFragments());
    }

    function addToCartFragments($fragments)
    {
        return array_merge($fragments, $this->getRefreshedFragments());
    }

    function getRefreshedFragments()
    {
        ob_start();
        get_template_part('template', 'sidebar-cart');
        $sidebar = ob_get_clean();

        $cart = '';
        if ($_POST['is_checkout']) {
            ob_start();
            get_template_part('template', 'cart');
            $cart = ob_get_clean();
        }
        return [
            'sidebar' => $sidebar,
            'cart_count' => Cart::getCartCount(),
            '.template-cart' => $cart,
        ];
    }

    function onLike()
    {
        if (isset($_GET['id'])) {
            $id = $_GET['id'];
            $list = WC()->session->get('likes');
            if (!in_array($id, $list)) {
                $list[] = $id;
            } else {
                foreach ($list as $key => $item) {
                    if ($item === $id) {
                        unset($list[$key]);
                    }
                }
            }

            WC()->session->set('likes', $list);
            wp_send_json(count($list));
        }
    }

    /**
     * @throws \Exception
     */
    function onAddToCart()
    {
        if (isset($_POST['id'])) {
            $id = $_POST['id'];
            $product = wc_get_product($id);

            if ($product) {
                $add_to_cart = null;
                if ($product instanceof WC_Product_Variable) {
                    if ($variation = $product->get_available_variations()[0] ?? null) {
                        $add_to_cart = $variation['variation_id'];
                    }
                } else {
                    $add_to_cart = $product->get_id();
                }
                WC()->cart->add_to_cart($add_to_cart);
            }
            $arr = $this->getRefreshedFragments();
            wp_send_json($arr);
        }
    }

    function onUpdateQty()
    {
        if (isset($_POST['key'])) {
            WC()->cart->set_quantity($_POST['key'], $_POST['qty']);
            $arr = $this->getRefreshedFragments();
            wp_send_json($arr);
        }
    }


    function getCart()
    {
        $arr = $this->getRefreshedFragments();
        wp_send_json($arr);
    }

    function update_order_review_fragments($fragments)
    {

        ob_start();
        get_template_part('template', 'cart');
        $cart = ob_get_clean();
        $fragments['.template-cart'] = $cart;
        return $fragments;
    }
}

