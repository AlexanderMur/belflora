import $ from 'jquery';
import wpAjax from './wp-ajax';
console.log($, "AAA");
const cart = {
  init() {

    let that = this;
    let is_checkout = location.pathname.includes('/checkout');

    $(document).on('click', '.js-add-to-cart', function (e) {
      let id = e.target.dataset.id;
      wpAjax.addToCart(id).then((data) => {
        that.updateFragments(data);
      });
      let picToDrag = $(this).parents('.cart').find('.cart__pic').eq(0);
      if (picToDrag.length) {
        let cart = $('.circle__button--basket');
        let width = picToDrag.width();
        let height = picToDrag.height();
        let top = picToDrag.offset().top;
        let left = picToDrag.offset().left;

        let destinationTop = cart.offset().top;
        let destinationLeft = cart.offset().left + cart.width() / 2;
        let picClone = picToDrag.clone()
          .css({
            height,
            width,
            top,
            left,
            position: 'absolute',
            zIndex: 501,
            opacity: 0.7,
          })
          .appendTo($(document.body))
          .animate({
            top: destinationTop,
            left: destinationLeft,
            width: 0,
            height: 0,
          }, function () {
            cart.addClass('shake');
            setTimeout(function () {
              cart.removeClass('shake');
            }, 400);
          });


      }

    });

    $(document).on('click', '.basket-cart__close', function (e) {
      e.preventDefault();
      that.loading();
      wpAjax.removeFromCart($(this).data('key'), is_checkout).then(function (data) {
        that.updateFragments(data);
        that.loaded();
      });

      $(this).parents('.basket-cart').fadeOut(300, function () {
        $(this).remove();
      });
    });

    let timeout;
    $(document).on('change', '.basket .counter__input, .steps__basket .counter__input', function () {
      clearTimeout(timeout);
      timeout = setTimeout(() => {
        let key = $(this).data('key');
        let qty = $(this).val();
        that.loading();
        wpAjax.updateQty(key, qty, is_checkout)
          .then((data) => {
            that.updateFragments(data);
            that.loaded();
          });
      }, 400);
    });
    $(document)
      .on('update_checkout', function () {
        that.loading();
      })
      .on('updated_checkout', function () {
        that.loaded();
      });

    $('.checkbox-button input').on('change', function (e) {
      let newAttr = e.target.value;
      $('.variations_form .variations select')
        .val(newAttr)
        .trigger('change');

    });
    $('.product input[name="quantity"]').on('change', function() {
      $('#_quantity').val(this.value);
    });
    $('.variations_form').on('found_variation', function (e, data) {
      $('.product__price').html(data.price_html);
      for (let taxonomy in data.attributes) {
        let value = data.attributes[taxonomy];
        taxonomy = decodeURIComponent(taxonomy).replace('attribute_', '');
        let input = $('.checkbox-button input[data-taxonomy="' + taxonomy + '"][value="' + value + '"]');
        input.attr('checked','checked');
        let name = input.parent().text().trim();
        $('#_variation').val(name);
      }
      if (data.ingredients_html) {
        $('.catalog__structure').html(data.ingredients_html);
      }
    });


    $(document).on('change', 'input[name="add_nabor"]', function() {
      that.loading();
      wpAjax.addNabor(this.value, is_checkout).then(function(fragments) {
        that.updateFragments(fragments);
        that.loaded();
      });
    });

    $(document).on('change', '#shipping_rajon', function() {
      that.loading();
      console.log(this.value);
      wpAjax.updateRajon(this.value).then(function (data) {
        that.loaded(data);
      });
    });
  },
  loading() {
    $('.basket__wrap').addClass('basket-loading');
    $('.template-cart').addClass('--loading');
  },
  loaded(data) {
    if (data) {
      this.updateFragments(data);
    }
    $('.basket__wrap').removeClass('basket-loading');
    $('.template-cart').removeClass('--loading');
  },
  updateFragments(data) {
    if (data.fragments) {
      data = data.fragments;
    }
    $('.basket__number').text(data.cart_count);
    $('.basket__wrap')[0].outerHTML = data.sidebar;
    $('.template-cart').replaceWith(data['.template-cart']);
  },
  refreshCart(isCheckout = false) {
    this.loading();
    let that = this;
    wpAjax.getCart(isCheckout)
      .then((data) => {
        that.updateFragments(data);
        that.loaded();
      });
  },
};


export default cart;
