/*
 * Welcome to your app's main JavaScript file!
 *
 * We recommend including the built version of this JavaScript file
 * (and its CSS file) in your base layout (base.html.twig).
 */

// any CSS you require will output into a single css file (app.css in this case)
require('../css/app.scss');

// Need jQuery? Install it with "yarn add jquery", then uncomment to require it.
const $ = require('jquery');
global.$ = global.jQuery = $;
require('bootstrap');
import dt from 'datatables.net-dt';
require('bootstrap-datepicker')
require('./mui.min');
dt(window, $);

const routes = require('../../public/js/fos_js_routes.json');
import Routing from '../../vendor/friendsofsymfony/jsrouting-bundle/Resources/public/js/router.min.js';
require('../images/logo.png');
require('../images/logoEcosup.png');
Routing.setRoutingData(routes);

$.fn.datepicker.dates['fr'] = {
    days: ["Dimanche", "Lundi", "Mardi", "Mercredi", "Jeudi", "Vendredi", "Samedi"],
    daysShort: ["Dim", "Lun", "Mar", "Mer", "Jeu", "Ven", "Sam"],
    daysMin: ["Di", "Lu", "Ma", "Me", "Je", "Ve", "Sa"],
    months: ["Janvier", "Février", "Mars", "Avril", "Mai", "Juin", "Juillet", "Août", "Septembre", "Octobre", "Novembre", "Decembre"],
    monthsShort: ["Jan", "Fev", "Mar", "Avr", "Mai", "Jun", "Jul", "Aout", "Sep", "Oct", "Nov", "Dec"],
    today: "Aujourd'hui",
    clear: "Effacer",
    format: "yyyy/mm/dd",
    titleFormat: "MM yyyy", /* Leverages same syntax as 'format' */
    weekStart: 0
};

$(document).ready(function () {
    $('.ajaxtable').DataTable({
        language:{
            "decimal":        "",
            "emptyTable":     "Aucune donnée disponible",
            "info":           "Afficher _START_ à _END_ sur _TOTAL_ enregistrements",
            "infoEmpty":      "Showing 0 to 0 of 0 entries",
            "infoFiltered":   "(filtered from _MAX_ total entries)",
            "infoPostFix":    "",
            "thousands":      ",",
            "lengthMenu":     "Afficher _MENU_ enregistrements",
            "loadingRecords": "Chargement...",
            "processing":     "Processing...",
            "search":         "Rechercher:",
            "zeroRecords":    "Aucun enregistrement",
            "paginate": {
                "first":      "Premier",
                "last":       "Dernier",
                "next":       "Suivant",
                "previous":   "Précédent"
            },
            "aria": {
                "sortAscending":  ": activate to sort column ascending",
                "sortDescending": ": activate to sort column descending"
            }
        }
    });

    $('#sidebarCollapse').on('click', function () {
        $('#sidebar').toggleClass('active');
    });

    window.setTimeout(function() {
        $(".alert").fadeTo(500, 0).slideUp(500, function(){
            $(this).remove();
        });
    }, 3000);

    /**
     * Calendar plugin
     */
    $('.js-datepicker').datepicker({
        language: 'fr',
        format: 'yyyy-mm-dd',
        todayBtn: true,
        todayHighlight: true,
        templates: {
            leftArrow: '<i class="fas fa-arrow-alt-circle-left"></i>',
            rightArrow: '<i class="fas fa-arrow-alt-circle-right"></i>'
        }

    });

    /**
     * collapse effect
     */
    $('.collapseblock').collapse();


});

$(document).on({
    ajaxStart: function() {
        $('.loading').removeClass('invisible');
    },
    ajaxStop: function() {
        $('.loading').addClass('invisible');
    },
});
