import $ from 'jquery';
import Popper from 'popper.js/dist/umd/popper';
import intlTelInput from 'intl-tel-input';

window.bootstrap = require('bootstrap');

window.$ = window.jQuery = $;

window.Popper = Popper;

window.currency = require('currency.js');
require('jquery-raty-js');

require('./partials/scripts');
require('./partials/starrating');
