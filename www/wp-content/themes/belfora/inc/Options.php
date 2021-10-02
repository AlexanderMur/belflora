<?php

namespace Belfora;

use Carbon_Fields\Carbon_Fields;
use Carbon_Fields\Container;
use Carbon_Fields\Field;

const index_title = 'index_title';

class Options
{
    const is_new = 'is_new';
    const is_super_price = 'is_super_price';
    const crb_association = 'crb_association';
    const address = 'address';
    const work_time = 'work_time';
    const phone = 'phone';
    const phone_text = 'phone_text';
    const instagram_link = 'instagram_link';
    const logo_footer = 'logo_footer';
    const copyright = 'copyright';
    const confidentiality_link = 'confidentiality_link';
    const order_time = 'order_time';
    const index_title = 'index_title';
    const index_catalog_title = 'index_catalog_title';
    const index_category_title = 'index_category_title';
    const index_category_text = 'index_category_text';
    const index_category_ids = 'index_category_ids';
    const index_banner_title = 'index_banner_title';
    const index_banner_button = 'index_banner_button';
    const index_banner_image = 'index_banner_image';
    const index_banner_link = 'index_banner_link';
    const index_text_title1 = 'index_text_title1';
    const index_text_left1 = 'index_text_left1';
    const index_text_right1 = 'index_text_right1';
    const index_text_title2 = 'index_text_title2';
    const index_text_left2 = 'index_text_left2';
    const index_text_right2 = 'index_text_right2';
    const specials_slider_items = 'specials_slider_items';
    const image = 'image';
    const text = 'text';
    const delivery_title = 'delivery_title';
    const delivery_subtitle = 'delivery_subtitle';
    const delivery_types = 'delivery_types';
    const price = 'price';
    const delivery_rajons = 'delivery_rajons';
    const delivery_payment_method1_title = 'delivery_payment_method1_title';
    const delivery_payment_method1_image = 'delivery_payment_method1_image';
    const delivery_payment_method1_link = 'delivery_payment_method1_link';
    const delivery_payment_method2_title = 'delivery_payment_method2_title';
    const delivery_payment_method2_image = 'delivery_payment_method2_image';
    const delivery_payment_method2_link = 'delivery_payment_method2_link';
    const delivery_payment_method3_title = 'delivery_payment_method3_title';
    const delivery_payment_method3_image = 'delivery_payment_method3_image';
    const delivery_payment_method3_link = 'delivery_payment_method3_link';
    const delivery_payment_method4_title = 'delivery_payment_method4_title';
    const delivery_payment_method4_image = 'delivery_payment_method4_image';
    const delivery_payment_method4_link = 'delivery_payment_method4_link';
    const delivery_steps_title = 'delivery_steps_title';
    const delivery_steps_step1 = 'delivery_steps_step1';
    const delivery_steps_step2 = 'delivery_steps_step2';
    const delivery_steps_step3 = 'delivery_steps_step3';
    const delivery_delivery_title = 'delivery_delivery_title';
    const delivery_delivery_left = 'delivery_delivery_left';
    const delivery_delivery_right = 'delivery_delivery_right';
    const filter_cats = 'filter_cats';
    const filter_flowers = 'filter_flowers';
    const flower = 'flower';
    const filter_events = 'filter_events';
    const min_price = 'min_price';
    const max_price = 'max_price';
    const basket_my_price = 'basket_my_price';
    const basket_nabor = 'basket_nabor';

    /**
     * @var static
     */
    private static $_instance = null;
    /**
     * @var array[]
     */
    public $footer_columns;
    /**
     * @var string
     */
    public $popap_form;
    /**
     * @var string
     */
    public $header_nav;
    /**
     * @var string
     */
    public $header_contacts;
    /**
     * @var string
     */
    public $header_link;

    public function __construct()
    {
        add_action('after_setup_theme', [$this, 'crb_load']);
        add_action('carbon_fields_register_fields', [$this, 'crb_attach_fields']);
        add_action('carbon_fields_fields_registered', [$this, 'after_load']);
    }
    public static function instance()
    {
        if (is_null(self::$_instance)) {
            self::$_instance = new self();
        }
        return self::$_instance;
    }

    public function crb_load()
    {
        Carbon_Fields::boot();
    }

    public function crb_attach_fields()
    {
        global $post;

        Comments::metaFields();

        add_filter('carbon_fields_association_field_options_crb_association_post_product_variation', function($args) {
            $args['post_parent'] = $_GET['post'];
            return $args;
        });
        Container::make( 'post_meta', __( 'Дополнительные настройки', 'crb' ) )
            ->where( 'post_type', '=', 'product' )
            ->add_fields(array(
                Field::make( 'textarea', 'keywords', 'Meta keywords'),
                Field::make( 'checkbox', 'has_bouquet', 'Наличие букета' ),
                Field::make( 'checkbox', 'is_new', 'Новинка' ),
                Field::make( 'checkbox', 'is_super_price', 'Супер цена' ),
                Field::make( 'select', 'rating_override', 'Перезаписать Рейтинг' )->add_options([
                    '0' => 'Не перезаписывать',
                    '1' => '1',
                    '2' => '2',
                    '3' => '3',
                    '4' => '4',
                    '5' => '5',
                ])->set_default_value( '0' ),
                Field::make( 'association', 'recommended_products', 'Дополнение' )
                    ->set_types( array(
                        array(
                            'type'      => 'post',
                            'post_type' => 'product',
                        )
                    ) ),
            ));

        $menuParent = Container::make( 'theme_options', __( 'Настройки темы', 'crb' ) )
            ->add_tab( __('Футер'), array(
                Field::make( 'text', 'address', 'Адрес' ),
                Field::make( 'text', 'work_time', 'Режим работы' ),
                Field::make( 'text', 'phone', 'Телефон' ),
                Field::make( 'text', 'phone_text', 'Заказать звонок' ),
                Field::make( 'text', 'instagram_link', 'Instagram' ),
                Field::make( 'image', 'logo_footer', 'Лого в футере' ),
                Field::make( 'text', 'copyright', 'Права' ),
                Field::make( 'text', 'confidentiality_link', 'Ссылка Политика конфиденциальности' ),
            ) )
            ->add_tab( __('Хедер'), array(
                Field::make( 'text', 'order_time', 'Принимаем заказы 24/7' ),
            ) );

        add_filter('carbon_fields_association_field_options_index_category_ids_term_product_cat', function($args) { //fix warning
            $args['orderby'] = 'id';
            return $args;
        });

        Container::make( 'theme_options', __( 'Главная страница', 'crb' ) )
            ->set_page_parent($menuParent)
            ->add_tab( __('Главная страница'), array(
                Field::make( 'text', 'index_title', 'Заголовок главной страницы' ),
                Field::make( 'complex', 'banner_items', 'Иконки поиска' )
                    ->add_fields( array(
                        Field::make( 'image', 'thumb', 'Иконка' )->set_width(1 ),
                        Field::make('select', 'cat', 'Категория')->set_width(80)->add_options(function () {
                            /** @var \WP_Term[] $categories */
                            $categories = get_categories([
                                'taxonomy' => 'product_cat',
                                'per_page' => 0,
                                'hide_empty' => false,
                            ]);
                            $dict = [];
                            foreach ($categories as $category) {
                                $dict[$category->term_id] = $category->name;
                            }
                            return $dict;
                        })
                    ) ),
                Field::make( 'text', 'index_catalog_title', 'Заголовок к товарам' ),
                Field::make( 'text', 'index_category_title', 'Заголовок к коллекциям' ),
                Field::make( 'text', 'index_category_text', 'Подзаголовок к коллекциям' ),
                Field::make( 'association', 'index_category_ids', 'Коллекции букетов категории' )
                    ->set_types([
                        [
                            'type' => 'term',
                            'taxonomy' => 'product_cat',
                            'orderby' => 'id',
                        ]
                    ]),
                Field::make( 'text', 'index_banner_title', 'Заголовок баннера' ),
                Field::make( 'text', 'index_banner_button', 'Текст кнопки' ),
                Field::make( 'text', 'index_banner_link', 'Ссылка кнопки' ),
                Field::make( 'image', 'index_banner_image', 'Изображение баннера' ),
            ) )
            ->add_tab( __('Дополнительно'), array(
                Field::make( 'text', 'index_text_title1', 'Заголовок' ),
                Field::make( 'rich_text', 'index_text_left1', 'Текст слева' )->set_width(50),
                Field::make( 'rich_text', 'index_text_right1', 'Текст справа' )->set_width(50),
                Field::make( 'text', 'index_text_title2', 'Заголовок' ),
                Field::make( 'rich_text', 'index_text_left2', 'Текст слева' )->set_width(50),
                Field::make( 'rich_text', 'index_text_right2', 'Текст справа' )->set_width(50),
            ) );

        Container::make( 'theme_options', __( 'Слайдер Актуальное', 'crb' ) )
            ->set_page_parent($menuParent)
            ->add_tab( __('Слайдер Актуальное'), array(
                Field::make( 'complex', 'specials_slider_items', __( 'Слайдер' ) )
                    ->add_fields( array(
                        Field::make( 'image', 'image', 'Изображение слайда' ),
                        Field::make( 'rich_text', 'text', 'Текст' )->set_settings(['media_buttons' => false]),
                    ) )
            ) );

        Container::make( 'theme_options', __( 'Страница Доставка и оплата', 'crb' ) )
            ->set_page_parent($menuParent)
            ->add_tab( __('Страница Доставка и оплата'), array(

                Field::make( 'text', 'delivery_title', 'Заголовок' ),
                Field::make( 'text', 'delivery_subtitle', 'Текст под заголовком' ),
                Field::make( 'complex', 'delivery_types', __( 'Тип Доставки' ) )
                    ->add_fields( array(
                        Field::make( 'text', 'text', 'Текст' )->set_width(50),
                        Field::make( 'text', 'price', 'Цена' )->set_width(50),
                    ) ),
                Field::make( 'complex', 'delivery_rajons', __( 'Тип Доставки' ) )
                    ->add_fields( array(
                        Field::make( 'text', 'text', 'Текст' )->set_width(50),
                        Field::make( 'text', 'price', 'Цена' )->set_width(50),
                    ) ),

                Field::make( 'text', 'delivery_payment_method1_title', 'Банковская карта' ),
                Field::make( 'text', 'delivery_payment_method1_image', 'Картинка' ),
                Field::make( 'text', 'delivery_payment_method1_link', 'Ссылка' ),

                Field::make( 'text', 'delivery_payment_method2_title', 'Электронные деньги' ),
                Field::make( 'text', 'delivery_payment_method2_image', 'Картинка' ),
                Field::make( 'text', 'delivery_payment_method2_link', 'Ссылка' ),


                Field::make( 'text', 'delivery_payment_method3_title', 'Наличными в магазине' ),
                Field::make( 'text', 'delivery_payment_method3_image', 'Картинка' ),
                Field::make( 'text', 'delivery_payment_method3_link', 'Ссылка' ),

                Field::make( 'text', 'delivery_payment_method4_title', 'Перевод на расчетный счет юр. лица' ),
                Field::make( 'text', 'delivery_payment_method4_image', 'Картинка' ),
                Field::make( 'text', 'delivery_payment_method4_link', 'Ссылка' ),

                Field::make( 'text', 'delivery_steps_title', 'Заголовок к баннеру' ),
                Field::make( 'textarea', 'delivery_steps_step1', 'Шаг 1' ),
                Field::make( 'textarea', 'delivery_steps_step2', 'Шаг 2' ),
                Field::make( 'textarea', 'delivery_steps_step3', 'Шаг 3' ),

                Field::make( 'text', 'delivery_delivery_title', 'Заголовок к тексту' ),
                Field::make( 'rich_text', 'delivery_delivery_left', 'Текст слева' )->set_width(50),
                Field::make( 'rich_text', 'delivery_delivery_right', 'Текст справа' )->set_width(50),
            ) );

        Container::make( 'theme_options', 'Страница Каталог' )
            ->set_page_parent($menuParent)
            ->add_tab( __('Страница Каталог'), array(

                Field::make( 'association', 'filter_cats', 'Категории' )
                    ->set_types( array(
                        array(
                            'type'      => 'term',
                            'taxonomy' => 'product_cat',
                        )
                    ) ),
                Field::make( 'complex', 'filter_flowers',  'Цветы'  )
                    ->add_fields( array(
                        Field::make( 'text', 'flower', 'Цветок' ),
                    ) ),
                Field::make( 'association', 'filter_events', 'События' )
                    ->set_types( array(
                        array(
                            'type'      => 'term',
                            'taxonomy' => 'events',
                        )
                    ) ),
                Field::make( 'text', 'min_price', 'Мин цена'),
                Field::make( 'text', 'max_price', 'Макс цена'),
            ) );

        Container::make( 'theme_options', 'Страница Корзины' )
            ->set_page_parent($menuParent)
            ->add_tab( __('Корзина'), array(

                Field::make( 'association', 'basket_my_price', 'Товар Моя цена' )
                    ->set_types( array(
                        array(
                            'type'      => 'post',
                            'post_type' => 'product',
                        )
                    ) )->set_max( 5 ),
                Field::make( 'association', 'basket_nabor', 'Товар Набор' )
                    ->set_types( array(
                        array(
                            'type'      => 'post',
                            'post_type' => 'product',
                        )
                    ) )->set_max( 5 ),

                Field::make( 'complex', 'rajons',  'Районы'  )
                    ->add_fields( array(
                        Field::make( 'text', 'name', 'Район' )->set_width(50),
                        Field::make( 'text', 'cost', 'Стоимость' )->set_width(50),
                    ) ),
            ) );
    }

    public function after_load()
    {
        $this->header_link = carbon_get_theme_option('crb_header_link');
        $this->header_nav = carbon_get_theme_option('crb_header_nav');
        $this->header_contacts = carbon_get_theme_option('crb_header_contacts');
        $this->footer_columns = carbon_get_theme_option('crb_footer');
        $this->popap_form = carbon_get_theme_option('crb_footer_form');
    }

    public function get($name)
    {
//        $r = carbon_get_theme_option($name);
//        if (is_array($r)) {
//            return [];
//        } else {
//            return '';
//        }
        return carbon_get_theme_option($name);
    }






}
