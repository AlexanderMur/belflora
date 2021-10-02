import $ from 'jquery';


const counter = {
  init() {
    const maxValue = 99;
    const minValue = 1;

    $(document).on('click', '.counter__plus', function () {
      const input = $(this).siblings('.counter__input');
      let value = +input.val();
      if (value <= maxValue) {
          input.val(value + 1)
          input.trigger('change');
      }
    });

    $(document).on('click', '.counter__minus', function () {
      const input = $(this).siblings('.counter__input');
      let value = +input.val();
      if (value >= minValue) {
          input.val(value - 1);
          input.trigger('change')
      }
    });
  }
}


export default counter;
