import $ from 'jquery';


const search = {
  init() {
    $('.-js-searchopen').on('click', function (e) {
      if (!$(this).parents('.search').hasClass('active')) {
        $(this).parents('.search').addClass('active');
        e.preventDefault();
      }
    })
    $('.-js-searchclose').on('click', function (e) {
        e.preventDefault();
      $(this).parents('.search').removeClass('active');
    })
  }
}


export default search;
