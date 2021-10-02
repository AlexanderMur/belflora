import $ from 'jquery';
import Inputmask from 'inputmask';



const form = {
  init() {
    $('.-js-starclick').find('.star').on('click', function () {
      let num = $(this).index() + 1;
      $(this).parent().find('input').val(num);
      $(this).addClass('active').nextAll().removeClass('active');
      $(this).addClass('active').prevAll().addClass('active');
    });
    $('.-js-starclick').find('.star').on('mouseover', function () {
      $(this).addClass('hover');
      $(this).siblings().removeClass('hover');
      $(this).prevAll().addClass('hover');
    });
    $('.-js-starclick').find('.star').on('mouseout', function () {
      $(this).removeClass('hover');
      $(this).siblings().removeClass('hover');
    });


    $('.select__main').on('click', function () {
      if (!$(this).hasClass('active')) {
        $(this).addClass('active');
        $(this).siblings('.select__drop').fadeIn();
      } else {
        $(this).removeClass('active');
        $(this).siblings('.select__drop').fadeOut();
      }
    });

    $(document).on('click', function (e) {
      let select = $('.select');
      if (!select.is(e.target) && select.has(e.target).length === 0) {
        $('.select__main').removeClass('active');
        $('.select__drop').fadeOut();
      }
    });

    $('.select__item').on('click', function () {
      let text = $(this).text();
      $(this).siblings().removeClass('active');
      $(this).addClass('active');
      $(this).parents('.select').find('.select__main').empty().text(text);
      $(this).parents('.select').find('select').val(text).trigger('change');
      $('.select__main').removeClass('active');
      $('.select__drop').fadeOut();
    });

    let selector = document.querySelectorAll('.mask-tel');
    Inputmask({
      mask: '+7 999 999 99 99',
      showMaskOnHover: false,
    }).mask(selector);

    $('.air-datepicker').datepicker();


    $('.calendar__input .form__input').on('blur', function () {
      if ($(this).val().length > 0) {
        $(this).siblings('.calendar__input-text').fadeOut(0);
      } else {
        $(this).siblings('.calendar__input-text').fadeIn();
      }
    });

    function showStep(step) {
      let $formSteps = $('.form__step');
      let totalSteps = $formSteps.length - 1;

      $formSteps.each(function (i) {
        if (i === step) {
          $(this).show();
        } else {
          $(this).hide();
        }
      });

      if (step <= totalSteps) {
        $('.js-prev-step').hide();
        $('.js-next-step').show();
        $('.js-form-submit').hide();
      }
      if (step >= 1 && step < totalSteps) {
        $('.js-prev-step').show();
        $('.js-next-step').show();
        $('.js-form-submit').hide();
      }
      if (step >= totalSteps) {
        $('.js-prev-step').show();
        $('.js-next-step').hide();
        $('.js-form-submit').show();
      }
      $('.main-banner__step').each(function (i) {
        $(this).toggleClass('active', i <= step);
      });
    }

    function isTermsChecked(element) {

      if (!element.checked) {
        $(element).parents('.form__block, .form__checkbox').removeClass('block--succes').addClass('block--error');
        return false;
      } else {
        $(element).parents('.form__block, .form__checkbox').removeClass('block--error').addClass('block--succes');
        return true;
      }
    }

    $('input[name="terms"]').on('change', function () {
      isTermsChecked(this);
    });

    function validateStep(step) {
      let $formStep = $('.form__step').eq(step);
      let valid = true;
      $formStep.find('input').each(function () {
        if (!validator.element(this)) {
          valid = false;
        }

        if (this.type === 'checkbox' && this.required) {
          if (!isTermsChecked(this)) {
            valid = false;
          }
        }

      });

      return valid;
    }

    function refreshCart() {

    }

    let validator = $('.form').validate({
      rules: {
        billing_phone: {
          phoneRU: true,
        },
      },
      highlight: function (element) {
        $(element).parents('.form__block, .form__checkbox').removeClass('block--succes').addClass('block--error');
      },
      unhighlight: function (element) {
        $(element).parents('.form__block, .form__checkbox').removeClass('block--error').addClass('block--succes');
      },
      errorPlacement: () => {
      },
    });

    $.validator.addMethod('phoneRU', function (phone_number) {
      let pattern = new RegExp(/[\s\#0-9_\-\+\/\(\)\.]/g);

      return phone_number.replace(pattern, '').length <= 0;

    });

    $('input[name="shipping_method[0]"]').on('change', function () {
      if (this.value.includes('local')) {
        $('.js-delivery').hide();
      } else {
        $('.js-delivery').show();
      }
    });
    $(document)
      .on('click', '.js-next-step', function (e) {
        e.preventDefault();
        let step = $('.form__step:visible').index();
        if (validateStep(step)) {
          showStep(step + 1);
        }
      })
      .on('click', '.js-prev-step', function (e) {
        e.preventDefault();
        let step = $('.form__step:visible').index();
        showStep(step - 1);
      });
    $('.wpcf7-form')
      .on('submit', function () {
        $(this).find('input[type="submit"]').addClass('--loading');
      })
      .on('wpcf7submit', function () {
        $(this).find('input[type="submit"]').removeClass('--loading');
      });


  },

};


export default form;
