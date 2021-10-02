<?php
/**
 * Product quantity inputs
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/global/quantity-input.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 4.0.0
 */

defined( 'ABSPATH' ) || exit;

/** @var string $max_value */
/** @var string $min_value */
/** @var string $input_id */
/** @var string $input_name */
/** @var string $step */
/** @var string $input_value */
/** @var string $placeholder */
/** @var string $inputmode */
/** @var string $key */

if ( $max_value && $min_value === $max_value ) {
	?>
	<div class="quantity hidden">
		<input type="hidden" id="<?php echo esc_attr( $input_id ); ?>" class="qty" name="<?php echo esc_attr( $input_name ); ?>" value="<?php echo esc_attr( $min_value ); ?>" />
	</div>
	<?php
} else {

	/* translators: %s: Quantity. */
	?>
        <div class="counter ">
            <div class="counter__minus">
                <svg class="svgsprite _minus">
                    <use xlink:href="<?php echo get_theme_file_uri('dist/assets/img/sprites/svgsprites.svg#minus') ?>"></use>
                </svg>
            </div>
            <input
                    class="counter__input"
                    type="number"
                    id="<?php echo esc_attr( $input_id ); ?>"
                    step="<?php echo esc_attr( $step ); ?>"
                    min="<?php echo esc_attr( $min_value ); ?>"
                    max="<?php echo esc_attr( 0 < $max_value ? $max_value : '' ); ?>"
                    name="<?php echo esc_attr( $input_name ); ?>"
                    value="<?php echo esc_attr( $input_value ); ?>"
                    title="<?php echo esc_attr_x( 'Qty', 'Product quantity input tooltip', 'woocommerce' ); ?>"
                    size="4"
                    placeholder="<?php echo esc_attr( $placeholder ); ?>"
                    inputmode="<?php echo esc_attr( $inputmode ); ?>"
                    data-key="<?php echo isset($key) ? esc_attr($key) : '' ?>"
            >
            <div class="counter__plus">
                <svg class="svgsprite _plus">
                    <use xlink:href="<?php echo get_theme_file_uri('dist/assets/img/sprites/svgsprites.svg#plus') ?>"></use>
                </svg>
            </div>
        </div>
	<?php
}
