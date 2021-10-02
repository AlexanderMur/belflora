<?php

namespace Belfora;


use WC_Product;
use WP_Term;

class Product {

    /**
     * @var static
     */
    private static $_instance = null;
    public function __construct()
    {
        add_filter('woocommerce_currency_symbol', function($currency) {
            if ($currency === '&#8381;') {
                return 'руб.';
            }
            return $currency;
        }, 10, 1);

//        add_filter('woocommerce_product_add_to_cart_url', [$this, 'variationAddToCartUrl'], 10, 2);
    }

    public static function instance()
    {
        if (is_null(self::$_instance)) {
            self::$_instance = new self();
        }
        return self::$_instance;
    }

    public function getCategoryThumbnail(WP_Term $term) {

        $thumb_id = get_term_meta($term->term_id,'thumbnail_id')[0] ?? 0;
        if ($thumb_id) {
            return wp_get_attachment_image_src($thumb_id, 'large')[0] ?? '';
        }
    }
    public function getProductImageSrc( $product, $size = 'woocommerce_thumbnail', $attr = array(), $placeholder = true) {
        $image = '';
        if ($product->get_image_id() ) {
            $image = wp_get_attachment_image_src($product->get_image_id(), $size, false )[0] ?? '';
        } elseif ($product->get_parent_id() ) {
            $parent_product = wc_get_product($product->get_parent_id() );
            if ( $parent_product ) {
                $image = wp_get_attachment_image_src( $parent_product->get_image_id(), $size, false )[0] ?? '';
            }
        }
        if (!$image) {
            $image = wc_placeholder_img_src( $size );
        }
        return $image;
    }
    /**
     * @param WC_Product $product
     * @param $attributeName
     * @return WP_Term[]
     */
    public function getAttributes(WC_Product $product, $attributeName) {
        $attrs = $product->get_variation_attributes()[$attributeName];
        $terms = wc_get_product_terms(
            $product->get_id(),
            $attributeName,
            array(
                'fields' => 'all',
            )
        );
        $returnTerms = [];
        foreach ($terms as $term) {
            if ( in_array( $term->slug, $attrs, true ) ) {
                $returnTerms[] = $term;
            }
        }
        return $returnTerms;

    }

    /**
     * @param WC_Product|\WC_Order_Item$product
     * @return string|string[]
     */
    public function getProducAttrName($product) {
        if ($product instanceof WC_Product) {
            $parent_name = $product->get_title();
            $name = $product->get_name();
            return str_replace($parent_name . ' - ', '', $name);
        }
        if ($product instanceof \WC_Order_Item) {
            $parent_name = $product->get_product()->get_title();
            $name = $product->get_name();
            return str_replace($parent_name . ' - ', '', $name);
        }

    }
}

