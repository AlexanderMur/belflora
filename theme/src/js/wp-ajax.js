import $ from 'jquery';

const wpAjax = {
  init() {
    this.ajaxUrl = window.woocommerce_params.ajax_url;
  },
  post: function (action, data) {
    return $.post(this.ajaxUrl, {
      action: action,
      ...data,
    });
  },
  get: function (action, data) {
    return $.get(this.ajaxUrl, {
      action: action,
      ...data,
    });
  },
  like: function (postId) {
    return this.get('like', {id: postId});
  },
  removeFromCart(key, is_checkout) {
    let wcAjaxUrl = window.woocommerce_params.wc_ajax_url.replace('%%endpoint%%', 'remove_from_cart');
    return $.post(wcAjaxUrl, {
      cart_item_key: key,
      is_checkout: is_checkout,
    });
  },
  addToCart(id) {
    return this.post('add_to_cart', {
      id: id,
    });
  },
  updateQty(key, qty, is_checkout) {
    return this.post('update_qty', {
      key: key,
      qty: qty,
      is_checkout,
    });
  },
  updateRajon(rajon) {
    return this.post('update_rajon', {
      rajon: rajon,
      is_checkout: true,
    });
  },
  getCart(isCheckout = false) {
    return this.post('get_cart', {
      is_checkout: isCheckout,
    });
  },
  addNabor(state, is_checkout) {
    return this.post('add_nabor', {
      add_nabor: state,
      is_checkout
    });
  }
};

export default wpAjax;
