<?php


namespace Belfora;


use WP_Query;

class Filters
{

    public function __construct()
    {
        add_action('pre_get_posts', [$this, 'filter_category'], 10, 3);

    }

    function filter_category(WP_Query $query)
    {
        if ((is_product_category() && $query->is_main_query()) ||
            ($query->is_post_type_archive('product') && $query->is_main_query())) {

            if (get_query_var('page')) {
                $page = get_query_var('page');
                $query->set('paged', $page);
            }

            if (isset($_GET['event'])) {
                $query->set('tax_query', [[
                    'taxonomy' => 'events',
                    'field' => 'term_id',
                    'terms' => $_GET['event'],
                ]]);
            }

            if (isset($_GET['flower']) || isset($_GET['price_min']) || isset($_GET['price_max'])) {
                $meta_query = [];
                if (isset($_GET['flower'])) {
                    $meta_query[] = [
                        'key' => 'flowers',
                        'value' => implode(',', $_GET['flower']),
                        'compare' => 'LIKE',
                        'type' => 'CHAR'
                    ];
                }
                if (isset($_GET['price_min'])) {
                    $meta_query[] = [
                        'key' => '_price',
                        'value' => $_GET['price_min'],
                        'compare' => '>=',
                        'type' => 'NUMERIC'
                    ];
                }
                if (isset($_GET['price_max'])) {
                    $meta_query[] = [
                        'key' => '_price',
                        'value' => $_GET['price_max'],
                        'compare' => '<=',
                    ];
                }
                $meta_query['relation'] = 'AND';
                $query->set('meta_query', $meta_query);
            }


        }

        return $query;

    }
}
