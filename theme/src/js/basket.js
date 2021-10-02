import $ from 'jquery';

const basket = {
  init() {
    $(document).on('click', '.-js-fadeoutbasket', function (e) {
      e.preventDefault();
      $('body').removeClass('--frozen');
      $('.basket').fadeOut();
    });

    $(document).on('click', '.-js-fadeinbasket', function () {
      $('body').addClass('--frozen');
      $('.basket').fadeIn();
    });

  }
}


export default basket;
