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
import Routing from '../../vendor/friendsofsymfony/jsrouting-bundle/Resources/public/js/router.min.js';
require('./Chart.bundle.min');
require('bootstrap-datepicker');
require('./mui.min');
require('./jquery.slimscroll');
require('./pcoded.min');
var bootbox = require('bootbox');
dt(window, $);

const routes = require('../../public/js/fos_js_routes.json');
require('../images/logo.png');
require('../images/logoEcosup.png');
Routing.setRoutingData(routes);


////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

window.validSelection = validSelection;
window.selectGrade = selectGrade;
window.toggleFullScreen = toggleFullScreen;
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

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

$.fn.pcodedmenu = function(e) {
    var s = (this.attr("id"), {
            themelayout: "vertical",
            MenuTrigger: "click",
            SubMenuTrigger: "click"
        }),
        e = $.extend({}, s, e),
        d = {
            PcodedMenuInit: function() {
                d.HandleMenuTrigger(), d.HandleSubMenuTrigger(), d.HandleOffset()
            },
            HandleSubMenuTrigger: function() {
                var s = $(window),
                    d = s.width();
                if (1 == $(".pcoded-navbar").hasClass("theme-horizontal"))
                    if (d >= 768) {
                        var i = $(".pcoded-inner-navbar .pcoded-submenu > li.pcoded-hasmenu");
                        i.off("click").off("mouseenter mouseleave").hover(function() {
                            $(this).addClass("pcoded-trigger")
                        }, function() {
                            $(this).removeClass("pcoded-trigger")
                        })
                    } else {
                        var i = $(".pcoded-inner-navbar .pcoded-submenu > li > .pcoded-submenu > li");
                        i.off("mouseenter mouseleave").off("click").on("click", function() {
                            0 === $(this).closest(".pcoded-submenu").length ? $(this).hasClass("pcoded-trigger") ? ($(this).removeClass("pcoded-trigger"), $(this).children(".pcoded-submenu").slideUp()) : ($(".pcoded-submenu > li > .pcoded-submenu > li.pcoded-trigger").children(".pcoded-submenu").slideUp(), $(this).closest(".pcoded-inner-navbar").find("li.pcoded-trigger").removeClass("pcoded-trigger"), $(this).addClass("pcoded-trigger"), $(this).children(".pcoded-submenu").slideDown()) : $(this).hasClass("pcoded-trigger") ? ($(this).removeClass("pcoded-trigger"), $(this).children(".pcoded-submenu").slideUp()) : ($(".pcoded-submenu > li > .pcoded-submenu > li.pcoded-trigger").children(".pcoded-submenu").slideUp(), $(this).closest(".pcoded-submenu").find("li.pcoded-trigger").removeClass("pcoded-trigger"), $(this).addClass("pcoded-trigger"), $(this).children(".pcoded-submenu").slideDown())
                        }), $(".pcoded-inner-navbar .pcoded-submenu > li > .pcoded-submenu > li").on("click", function(e) {
                            e.stopPropagation(), alert("click call"), 0 === $(this).closest(".pcoded-submenu").length ? $(this).hasClass("pcoded-trigger") ? ($(this).removeClass("pcoded-trigger"), $(this).children(".pcoded-submenu").slideUp()) : ($(".pcoded-hasmenu li.pcoded-trigger").children(".pcoded-submenu").slideUp(), $(this).closest(".pcoded-inner-navbar").find("li.pcoded-trigger").removeClass("pcoded-trigger"), $(this).addClass("pcoded-trigger"), $(this).children(".pcoded-submenu").slideDown()) : $(this).hasClass("pcoded-trigger") ? ($(this).removeClass("pcoded-trigger"), $(this).children(".pcoded-submenu").slideUp()) : ($(".pcoded-hasmenu li.pcoded-trigger").children(".pcoded-submenu").slideUp(), $(this).closest(".pcoded-submenu").find("li.pcoded-trigger").removeClass("pcoded-trigger"), $(this).addClass("pcoded-trigger"), $(this).children(".pcoded-submenu").slideDown())
                        })
                    }
                switch (e.SubMenuTrigger) {
                    case "click":
                        $(".pcoded-navbar .pcoded-hasmenu").removeClass("is-hover"), $(".pcoded-inner-navbar .pcoded-submenu > li > .pcoded-submenu > li").on("click", function(e) {
                            e.stopPropagation(), 0 === $(this).closest(".pcoded-submenu").length ? $(this).hasClass("pcoded-trigger") ? ($(this).removeClass("pcoded-trigger"), $(this).children(".pcoded-submenu").slideUp()) : ($(".pcoded-submenu > li > .pcoded-submenu > li.pcoded-trigger").children(".pcoded-submenu").slideUp(), $(this).closest(".pcoded-inner-navbar").find("li.pcoded-trigger").removeClass("pcoded-trigger"), $(this).addClass("pcoded-trigger"), $(this).children(".pcoded-submenu").slideDown()) : $(this).hasClass("pcoded-trigger") ? ($(this).removeClass("pcoded-trigger"), $(this).children(".pcoded-submenu").slideUp()) : ($(".pcoded-submenu > li > .pcoded-submenu > li.pcoded-trigger").children(".pcoded-submenu").slideUp(), $(this).closest(".pcoded-submenu").find("li.pcoded-trigger").removeClass("pcoded-trigger"), $(this).addClass("pcoded-trigger"), $(this).children(".pcoded-submenu").slideDown())
                        }), $(".pcoded-submenu > li").on("click", function(e) {
                            e.stopPropagation(), 0 === $(this).closest(".pcoded-submenu").length ? $(this).hasClass("pcoded-trigger") ? ($(this).removeClass("pcoded-trigger"), $(this).children(".pcoded-submenu").slideUp()) : ($(".pcoded-hasmenu li.pcoded-trigger").children(".pcoded-submenu").slideUp(), $(this).closest(".pcoded-inner-navbar").find("li.pcoded-trigger").removeClass("pcoded-trigger"), $(this).addClass("pcoded-trigger"), $(this).children(".pcoded-submenu").slideDown()) : $(this).hasClass("pcoded-trigger") ? ($(this).removeClass("pcoded-trigger"), $(this).children(".pcoded-submenu").slideUp()) : ($(".pcoded-hasmenu li.pcoded-trigger").children(".pcoded-submenu").slideUp(), $(this).closest(".pcoded-submenu").find("li.pcoded-trigger").removeClass("pcoded-trigger"), $(this).addClass("pcoded-trigger"), $(this).children(".pcoded-submenu").slideDown())
                        })
                }
            },
            HandleMenuTrigger: function() {
                var s = $(window),
                    d = s.width();
                if (1 == $(".pcoded-navbar").hasClass("theme-horizontal")) {
                    var i = $(".pcoded-inner-navbar > li");
                    d >= 768 ? i.off("click").off("mouseenter mouseleave").hover(function() {
                        if ($(this).addClass("pcoded-trigger"), $(".pcoded-submenu", this).length) {
                            var e = $(".pcoded-submenu:first", this),
                                s = e.offset(),
                                d = s.left,
                                i = e.width();
                            $(window).height();
                            if (d + i <= $(window).width()) $(this).removeClass("edge");
                            else {
                                var o = $(".sidenav-inner").attr("style");
                                $(".sidenav-inner").css({
                                    "margin-left": parseInt(o.slice(12, o.length - 3)) - 80
                                }), $(".sidenav-horizontal-prev").removeClass("disabled")
                            }
                        }
                    }, function() {
                        $(this).removeClass("pcoded-trigger")
                    }) : i.off("mouseenter mouseleave").off("click").on("click", function() {
                        $(this).hasClass("pcoded-trigger") ? ($(this).removeClass("pcoded-trigger"), $(this).children(".pcoded-submenu").slideUp()) : ($("li.pcoded-trigger").children(".pcoded-submenu").slideUp(), $(this).closest(".pcoded-inner-navbar").find("li.pcoded-trigger").removeClass("pcoded-trigger"), $(this).addClass("pcoded-trigger"), $(this).children(".pcoded-submenu").slideDown())
                    })
                }
                switch (e.MenuTrigger) {
                    case "click":
                        $(".pcoded-navbar").removeClass("is-hover"), $(".pcoded-inner-navbar > li:not(.pcoded-menu-caption) ").on("click", function() {
                            $(this).hasClass("pcoded-trigger") ? ($(this).removeClass("pcoded-trigger"), $(this).children(".pcoded-submenu").slideUp()) : ($("li.pcoded-trigger").children(".pcoded-submenu").slideUp(), $(this).closest(".pcoded-inner-navbar").find("li.pcoded-trigger").removeClass("pcoded-trigger"), $(this).addClass("pcoded-trigger"), $(this).children(".pcoded-submenu").slideDown())
                        })
                }
            },
            HandleOffset: function() {
                switch (e.themelayout) {
                    case "horizontal":
                        "hover" === e.SubMenuTrigger ? $("li.pcoded-hasmenu").on("mouseenter mouseleave", function(e) {
                            if ($(".pcoded-submenu", this).length) {
                                var s = $(".pcoded-submenu:first", this),
                                    d = s.offset(),
                                    i = d.left,
                                    o = s.width();
                                $(window).height();
                                i + o <= $(window).width() ? $(this).removeClass("edge") : $(this).addClass("edge")
                            }
                        }) : $("li.pcoded-hasmenu").on("click", function(e) {
                            if (e.preventDefault(), $(".pcoded-submenu", this).length) {
                                var s = $(".pcoded-submenu:first", this),
                                    d = s.offset(),
                                    i = d.left,
                                    o = s.width();
                                $(window).height();
                                i + o <= $(window).width() || $(this).toggleClass("edge")
                            }
                        })
                }
            }
        };
    d.PcodedMenuInit()
}

$.fn.moveToListAndDelete = function (sourceList, destinationList) {
    var opts = $(sourceList + ' option:selected');
    if (opts.length == 0) {
        bootbox.alert("Aucune donnée sélectionnée!");
    }
    $(opts).remove().appendTo($(destinationList));
};

//Moves all items from sourceList to destinationList and deleting
// all items from the source list
$.fn.moveAllToListAndDelete = function (sourceList, destinationList) {
    var opts = $(sourceList + ' option');
    $(opts).remove();
    $(destinationList).append($(opts));
};

$(document).ready(function () {
    $("#pcoded").pcodedmenu({
        MenuTrigger: "click",
        SubMenuTrigger: "click"
    });
    $('.ajaxtable').DataTable({
        language: {
            "decimal": "",
            "emptyTable": "Aucune donnée disponible",
            "info": "Afficher _START_ à _END_ sur _TOTAL_ enregistrements",
            "infoEmpty": "Showing 0 to 0 of 0 entries",
            "infoFiltered": "(filtered from _MAX_ total entries)",
            "infoPostFix": "",
            "thousands": ",",
            "lengthMenu": "Afficher _MENU_ enregistrements",
            "loadingRecords": "Chargement...",
            "processing": "Processing...",
            "search": "Rechercher:",
            "zeroRecords": "Aucun enregistrement",
            "paginate": {
                "first": "Premier",
                "last": "Dernier",
                "next": "Suivant",
                "previous": "Précédent"
            },
            "aria": {
                "sortAscending": ": activate to sort column ascending",
                "sortDescending": ": activate to sort column descending"
            }
        }
    });

    $('#sidebarCollapse').on('click', function () {
        $('#sidebar').toggleClass('active');
    });


    $('#btnRight').on('click', function (e) {
        $('select').moveToListAndDelete('#source', '#destination');
        e.preventDefault();
    });

    $('#btnAllRight').on('click', function (e) {
        $('select').moveAllToListAndDelete('#source', '#destination');
        e.preventDefault();
    });

    $('#btnLeft').on('click', function (e) {
        $('select').moveToListAndDelete('#destination', '#source');
        e.preventDefault();
    });

    $('#btnAllLeft').on('click', function (e) {
        $('select').moveAllToListAndDelete('#destination', '#source');
        e.preventDefault();
    });

    window.setTimeout(function () {
        $(".alert").fadeTo(500, 0).slideUp(500, function () {
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
    ajaxStart: function () {
        $('.spinner-border').show();
    },
    ajaxStop: function () {
        $('.spinner-border').hide();
    },
});

////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
function validSelection(url, max, group_id) {
    //Use $option (with the "$") to see that the variable is a jQuery object
    var $option = $("#destination>option").map(function () {
        return $(this).val()
    }).get();

    if ($option.length > max) {
        bootbox.alert("Vous avez dépassé l'effectif maximum autorisé pour ce groupe (" + max + " étudiants). Veuillez retirer des étudiants ou augmenter la capacité d'accueil du groupe.");
        return false;
    }


    var dialog = bootbox.dialog({
        title: 'Inscription Groupe',
        message: '<p><i class="icon-spinner"></i> Traitement en cours...</p>'
    });

    dialog.init(function () {
        $.ajax({
            url: url,
            type: 'GET',
            data: "list=" + $option.join() + '&group_id=' + group_id,
            success: function (result) {
                if (result.status == "OK") {
                    location.reload();
                } else {
                    dialog.find('.bootbox-body').html(result.message);
                }
            },
            error: function (err) {
                dialog.find('.bootbox-body').html(err);
            }
        });
    });
}

function selectGrade(url, grade_id, group_id) {
    var box = $('#' + grade_id).is(':checked');
    $.ajax({
        url: url,
        type: 'GET',
        data: "grade_id=" + grade_id + "&group_id=" + group_id,
        success: function (result) {
            if (result.status == "OK") {
                var options = $('#source option');
                var values = $.map(options, function (option) {
                    return parseInt(option.value);
                });
                if (box === true) {
                    // populate select
                    $.each(result.message, function (key, value) {
                        var obj = JSON.parse(value);
                        if (!values.includes(obj.id)) {
                            $("#source").append('<option value="' + obj.id + '">' + obj.name + '</option>');
                        }
                    });
                } else {
                    $.each(result.message, function (key, value) {
                        var obj = JSON.parse(value);
                        if (values.includes(obj.id)) {
                            $("select#source option[value='" + obj.id + "']").remove();
                        }
                    });
                }

            } else {
                bootbox.alert(result.message);
            }
        },
        error: function (err) {
            bootbox.alert(err);
        }
    })

}

function toggleFullScreen() {
    $(window).height();
    document.fullscreenElement
    ||document.mozFullScreenElement
    ||document.webkitFullscreenElement
        ?document.cancelFullScreen
        ?document.cancelFullScreen():document.mozCancelFullScreen
            ?document.mozCancelFullScreen():document.webkitCancelFullScreen
            &&document.webkitCancelFullScreen():document.documentElement.requestFullscreen
        ?document.documentElement.requestFullscreen():document.documentElement.mozRequestFullScreen
            ?document.documentElement.mozRequestFullScreen():document.documentElement.webkitRequestFullscreen
            &&document.documentElement.webkitRequestFullscreen(Element.ALLOW_KEYBOARD_INPUT),$(".full-screen > i")
        .toggleClass("icon-maximize"),$(".full-screen > i").toggleClass("icon-minimize")
}

