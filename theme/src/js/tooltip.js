import $ from 'jquery';


const tooltip = {
  init() {
    $('.-js-fadeintooltip').on('mousedown', function () {
      if (!$(this).hasClass('active')) {
        $('.-js-fadeintooltip').removeClass('active');
        $('.tooltip').fadeOut();
        $(this).addClass('active');
        $(this).find('.tooltip').fadeIn();
      }
    });


    $('.filter__buttom-close').on('click', function (e) {
      e.preventDefault();
      $('.tooltip').fadeOut(300);
      $('.-js-fadeintooltip').removeClass('active');
    });


    // $(window).on('scroll', function () {
    //   $('.tooltip').fadeOut();
    //   $('.-js-fadeintooltip').removeClass('active');
    // })

    $(document).on('click', function (e) {
      var tooltip = $('.-js-fadeintooltip');
      if (!tooltip.is(e.target) && tooltip.has(e.target).length === 0) {
        tooltip.find('.tooltip').fadeOut();
        $('.-js-fadeintooltip').removeClass('active');
      }
    })
  }
}

export default tooltip;