import $ from 'jquery';
import wpAjax from './wp-ajax';

const like = {

    init() {
        $('.cart__like, .product__like').on('click', function () {
            wpAjax.like($(this).data('id')).then(function(count) {
              $('.feature__number').text(count);
            });
            $(this).toggleClass('active');
        });
    },
};


export default like;
