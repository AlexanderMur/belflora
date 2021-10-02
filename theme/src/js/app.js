
import lazyLoadImg from 'lazyload';
import tooltip from 'tooltip';
import counter from 'counter';
import basket from 'basket';
import search from 'search';
import like from 'like';
import cart from 'cart';
import sliders from 'sliders';
import accardeon from 'accardeon';
import mobileBar from 'mobile-bar';
import filter from 'filter';
import header from 'header';
import mapBlock from 'map';
import form from 'form';
import wpAjax from './wp-ajax';
import 'jquery-validation';
import 'magnific-popup';
import orders from './orders';
import popup from './popup';
import jQuery from 'jquery';

window.$ = jQuery;
require('air-datepicker');
let app = {
    init() {
        wpAjax.init();
        lazyLoadImg.init();
        tooltip.init();
        counter.init();
        cart.init();
        search.init();
        like.init();
        sliders.init();
        accardeon.init();
        mapBlock.init();
        mobileBar.init();
        basket.init();
        filter.init();
        header.init();
        form.init();
        orders.init();
        new popup();
    }
};
app.init();
