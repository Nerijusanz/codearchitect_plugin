import 'jquery';

import 'bootstrap-sass/assets/javascripts/bootstrap';

//import modules
import Contactform from './plugin_front/contactform.js';
import Gmap from './plugin_front/gmap.js';

window.$ = window.jQuery = require("jquery");

//initialize modules



$(document).ready(function(){

    const contactform = new Contactform();
    const gmap = new Gmap();

});
