import Swiper from 'swiper';
import $ from 'jquery';

const sliders = {

  init() {
    const mainSlider = new Swiper('.main-slider', {
      loop: true,
      slidesPerView: 1,
      loopedSlides: 10,
      spaceBetween: 12,
      breakpoints: {
        980: {
          slidesPerView: 2,
          loopedSlides: 10,
          spaceBetween: 34,
        }
      }
    });

    $('.main-slider .slider-next').on('click', function () {
      mainSlider.slideNext();
    });

    $('.main-slider .slider-prev').on('click', function () {
      mainSlider.slidePrev();
    });


    const productSlider = new Swiper('.product__slider .swiper-container', {
      loop: false,
      slidesPerView: 1,
      768: {
        slidesPerView: 1,
        loop: true,
      }
    });

    $('.product__slider .slider-next').on('click', function () {
      productSlider.slideNext();
    });

    $('.product__slider .slider-prev').on('click', function () {
      productSlider.slidePrev();
    });

    $('.product__slider-item').on('click', function () {
      var index = $(this).index();
      productSlider.slideTo(index);
      $(this).addClass('active').siblings().removeClass('active');
    })

    productSlider.on('slideChange', function () {
      var active = productSlider.activeIndex;
      $('.product__slider-item:eq(' + active + ')').addClass('active').siblings().removeClass('active');
    });
  }
}


export default sliders;
