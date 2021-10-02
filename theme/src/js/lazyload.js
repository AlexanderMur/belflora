import $ from 'jquery';


const lazyLoadImg = {
  init() {
    function lazy() {
      $('.lazy').each(function () {
        let windowHeight = $(window).innerHeight();
        let windowScrollTop = $(window).scrollTop() + windowHeight + 50;
        let elemetOfssetTop = $(this).offset().top;
        let src = $(this).data('src');
        if (!$(this).hasClass('lazyloaded') && elemetOfssetTop < windowScrollTop) {

          let img = new Image();
          img.src = src;
          img.onload = () => {
            let $parents = $(this).parents('.lazycontainer');
            if ($parents.length) {
              $parents.addClass('lazyloaded');
            } else {
              $(this).addClass('lazyloaded');
            }
          };
          $(this).css({
            'background': `url('${src}') no-repeat center / cover`,
          });

        }
      });
    }

    $(window).on('scroll', function () {
      lazy();
    });
    $(document).ready(function () {
      lazy();
    });
  },
};


export default lazyLoadImg;
