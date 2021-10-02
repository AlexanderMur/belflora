import printJS from 'print-js';
import $ from 'jquery';

const orders = {
  init() {
    $(document).on('click', '.printOrdersBtn', function () {
      let css = [
        $('#main-css').attr('href'),
        $('#woocommerce-general-css').attr('href'),
      ];

      printJS({
        printable: 'printOrders',
        type: 'html',
        css: css,
        targetStyle: ['clear', 'display', 'width', 'min-width', 'min-height', 'font-size'],
        font_size: '',
      });
    });

    $(document).on('click', '.js-print-order', function() {
      let id = $(this).data('order')
      $.get(location.href, {
        order: id,
      }).then(function(data) {
        console.log(data)
        let dom = new DOMParser().parseFromString(data, 'text/html');
        let print = $(dom).find('#printOrders').html();
        console.log(print)
        let css = [
          $('#main-css').attr('href'),
          $('#woocommerce-general-css').attr('href'),
        ];
        printJS({
          printable: print,
          type: 'raw-html',
          css: css,
          targetStyle: ['clear', 'display', 'width', 'min-width', 'min-height', 'font-size'],
          font_size: '',
        });
      });
    });

  }
};

export default orders;
