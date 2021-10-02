<?php
/**
 * @var WC_Checkout $checkout
 */

use Belfora\Cart;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}


?>
<div class="content">
    <section class="main-banner --background-2">
        <div class="container">
            <?php woocommerce_breadcrumb([
                'wrap_before' => '<div class="crumbs --white --center crumbs--mainbanner">',
                'wrap_after' => '</div>',
                'delimiter' => '',
            ]); ?>
            <h1 class="main-banner__title --white">Оформление заказа</h1>
            <?php
            if (Cart::getCartCount() > 0) {
                ?>
                <div class="main-banner__steps main-banner__steps--desktop">
                    <div class="main-banner__step active">
                        <div class="main-banner__step-circle"></div>
                        <div class="main-banner__step-text">Отправитель</div>
                    </div>
                    <div class="main-banner__step">
                        <div class="main-banner__step-circle"></div>
                        <div class="main-banner__step-text">Адрес доставки</div>
                    </div>
                    <div class="main-banner__step">
                        <div class="main-banner__step-circle"></div>
                        <div class="main-banner__step-text">Получатель</div>
                    </div>
                    <div class="main-banner__step">
                        <div class="main-banner__step-circle"></div>
                        <div class="main-banner__step-text">Оплата заказа</div>
                    </div>
                </div>
                <?php
            }
            ?>
        </div>
    </section>
    <section class="steps-section">
        <div class="container">
            <?php
            if (Cart::getCartCount() === 0) {
                ?>
                <p>Корзина пуста</p>
                <?php
            } else {
                ?>
                <h2 class="step__title">Детали заказа</h2>
                <div class="steps__list">
                    <form name="checkout" method="post" class="checkout woocommerce-checkout form" action="<?php echo esc_url( wc_get_checkout_url() ); ?>" enctype="multipart/form-data">

                        <?php if ( $checkout->get_checkout_fields() ) : ?>


                            <?php do_action( 'woocommerce_checkout_billing' ); ?>

                        <?php endif; ?>
                    </form>

                    <div class="steps__basket">
                        <h4 class="steps__basket-title">Ваш заказ</h4>

                        <?php
                        get_template_part('template', 'cart');
                        ?>
                    </div>
                </div>
                <?php
            }
            ?>
        </div>
    </section>
    <section class="offers-section">
        <div class="container">
            <h2>Интересные предложения</h2>
            <div class="carts__wrap carts-list carts-list-4">

                <?php
                $query = new WP_Query('post_type=product&posts_per_page=4');

                while($query->have_posts()){
                    $query->the_post();


                    do_action('woocommerce_shop_loop');
                    wc_get_template_part('content', 'product');
                }
                ?>
            </div>
        </div>
    </section>
</div>

