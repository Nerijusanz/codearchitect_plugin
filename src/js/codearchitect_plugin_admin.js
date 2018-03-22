//import libraries
//import $ from '../../bower_components/jquery/dist/jquery.min.js';
//import '../../bower_components/bootstrap-sass/assets/javascripts/bootstrap.js';

import 'jquery';

import 'jquery-ui';
import 'jquery-ui/ui/widgets/datepicker';

//import modules
//import Codearchitect from'./modules/codearchitect.js';
//import Cpt from './modules/cpt.js';

window.$ = window.jQuery = require("jquery");

//initialize modules
//const codearchitect = new Codearchitect();
//const cpt = new Cpt();


$("#datepicker").datepicker();
$("#datepicker").datepicker("option", "showAnim","slideDown");

