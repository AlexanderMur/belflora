<?php
require_once('vendor/autoload.php');

use Belfora\Options;
use Belfora\Product;
use Belfora\ShippingMethod;
use Belfora\Theme;

function products(){
    return Product::instance();
}
products();
function options($option = null) {

    if ($option) {
        return Options::instance()->get($option);
    } else {
        return Options::instance();
    }
}
function theme(){
    return Theme::instance();
}
theme();

// Allow SVG
add_filter( 'wp_check_filetype_and_ext', function($data, $file, $filename, $mimes) {

    global $wp_version;
    if ( $wp_version !== '4.7.1' ) {
        return $data;
    }

    $filetype = wp_check_filetype( $filename, $mimes );

    return [
        'ext'             => $filetype['ext'],
        'type'            => $filetype['type'],
        'proper_filename' => $data['proper_filename']
    ];

}, 10, 4 );

function cc_mime_types( $mimes ){
    $mimes['svg'] = 'image/svg+xml';
    return $mimes;
}
add_filter( 'upload_mimes', 'cc_mime_types' );

function fix_svg() {
    echo '<style type="text/css">
        .attachment-266x266, .thumbnail img {
             width: 100% !important;
             height: auto !important;
        }
        </style>';
}
add_action( 'admin_head', 'fix_svg' );

add_action( 'woocommerce_shipping_init', 'techiepress_dhl_shipping_init' );

function techiepress_dhl_shipping_init() {
    if ( ! class_exists( 'WC_TECHIEPRESS_DHL_SHIPPING') ) {
        class WC_TECHIEPRESS_DHL_SHIPPING extends WC_Shipping_Method {

            public function __construct($instance_id = 0) {
                parent::__construct($instance_id);
                $this->id                 = 'techipress_dhl_shipping'; // Id for your shipping method. Should be uunique.
                $this->method_title       = 'Доставить курьером';  // Title shown in admin
                $this->method_description = __( 'Description of your Techiepress DHL Shipping' ); // Description shown in admin

                $this->enabled            = "yes"; // This can be added as an setting but for this example its forced enabled
                $this->title              = "Доставить курьером"; // This can be added as an setting but for this example its forced.
                $this->supports           = array(
                    'shipping-zones',
                    'instance-settings',
                    'instance-settings-modal',
                );
                $this->init();
            }

            public function init() {
                // Load the settings API
                $this->init_form_fields(); // This is part of the settings API. Override the method to add your own settings
                $this->init_settings(); // This is part of the settings API. Loads settings you previously init.

                // Save settings in admin if you have any defined
                add_action( 'woocommerce_update_options_shipping_' . $this->id, array( $this, 'process_admin_options' ) );
            }

            public function calculate_shipping( $package = array() ) {




                $rajons = options('rajons');
                $current = WC()->session->get('shipping_rajon');
                $cost = 0;
                foreach ($rajons as $rajon) {
                    if ($rajon['name'] === $current) {
                        $cost = $rajon['cost'];
                    }
                }

                $rate = array(
                    'label' => $this->title,
                    'cost' => $cost,
                    'calc_tax' => 'per_order'
                );


                $this->add_rate( $rate );

            }

        }
    }
}

add_filter( 'woocommerce_shipping_methods', 'add_techiepress_dhl_method');

function add_techiepress_dhl_method( $methods ) {
    $methods['techipress_dhl_shipping'] = 'WC_TECHIEPRESS_DHL_SHIPPING';
    return $methods;
}
// define the wpcf7_special_mail_tags callback
function filter_wpcf7_special_mail_tags( $var, $smt, $false ) {
    // make filter magic happen here...
    if ($smt === "_variation") {
        return $_POST['_variation'] ?? '';
    }
    if ($smt === "_quantity") {
        return $_POST['_quantity'] ?? '';
    }
    return $var;
};

// add the filter
add_filter( 'wpcf7_special_mail_tags', 'filter_wpcf7_special_mail_tags', 10, 3 );
