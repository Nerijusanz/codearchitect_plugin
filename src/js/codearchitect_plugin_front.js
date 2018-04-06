import 'jquery';

import 'bootstrap-sass/assets/javascripts/bootstrap';

//import modules
import Contactform from './plugin_front/contactform.js';

window.$ = window.jQuery = require("jquery");

//initialize modules



$(document).ready(function(){

    const contactform = new Contactform();

});
