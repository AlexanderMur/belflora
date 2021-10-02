import wNumb from 'wnumb';
import noUiSlider from 'nouislider';
import $ from 'jquery';

const filter = {
  init() {
    $(window).on('load', function () {
      $('.main-banner__tooltip .checkbox').on('click', function () {
        var parent = $(this).parents('.main-banner__main');
        var length = parent.find('input:checked').length;
        if (length > 0) {
          parent.find('.main-banner__main-number').text('(' + length + ')')
        } else {
          parent.find('.main-banner__main-number').empty();
        }
      })

      var rangeContainer;
      if ($(window).width() < 981) {
        rangeContainer = document.querySelector('.main__banner-filter--mobile');
      } else {
        rangeContainer = document.querySelector('.main__banner-filter--desktop');
      }

      if (rangeContainer) {
        var rangeFilter = rangeContainer.querySelector('#range-bar');
        var marginMin = rangeContainer.querySelector('#range__from');
        var marginMax = rangeContainer.querySelector('#range__to');
        var minSumm = 0;
        var maxSumm = 80000;

        noUiSlider.create(rangeFilter, {
          start: [marginMin.value, marginMax.value],
          connect: true,
          range: {
            'min': minSumm,
            'max': maxSumm
          },
          format: wNumb({
            decimals: 0
          }),
        });

        rangeFilter.noUiSlider.on('update', function (values, handle) {
          if (handle) {
            marginMax.value = values[handle];
          } else {
            marginMin.value = values[handle];
          }
        });

        $('.filter__reset').on('click', function () {
          $('.main-banner__tooltip .checkbox input').prop('checked', false);
          $('.main-banner__main').find('.main-banner__main-number').empty();
          rangeFilter.noUiSlider.updateOptions({
            start: [minSumm, maxSumm],
          });
        })
      }
    })



  }
}


export default filter;
