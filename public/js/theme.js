(function ($) {
  "use strict";

  var nav_offset_top = $("header").height() + 50;
  /*-------------------------------------------------------------------------------
	  Navbar 
	-------------------------------------------------------------------------------*/
  $(".carousel-item:first").addClass('active');
  //* Navbar Fixed
  /*---------------- change number to month -----------------------*/
  var months = [
    'Janvier', 'Février', 'Mars', 'Avril', 'Mai',
    'Juin', 'Juillet', 'Août', 'Septembre',
    'Octobre', 'Novembre', 'Decembere'
  ];


  document.querySelectorAll('[id=month]').forEach(element =>
    element.replaceWith(monthNumToName(element.innerHTML)));

  function monthNumToName(number) {
    return months[number - 1] || '';
  }
  /*------------------------------------------------------------*/
  /**
   * Take an RFC 3339 or ISO 8601 date and returns
   * the date in human readable form.
   *
   * Will return undefined if lacks browser support
   * or it cannot parse the date.
   *
   * @param  {string} time
   * @param  {object} [lang] Optional language object
   * @return {string|undefined}
   * @license MIT
   * @author Sam Clarke <sam@samclarke.com>
   */
  function timeToWords(time, lang) {
    lang = lang || {
      postfixes: {
        '<': ' depuis',
        '>': ' à partir de maintenant'
      },
      1000: {
        singular: 'quelques instants',
        plural: 'quelques instants'
      },
      60000: {
        singular: 'environ une minute',
        plural: '# minutes'
      },
      3600000: {
        singular: 'about une heure',
        plural: '# hours'
      },
      86400000: {
        singular: 'un jour',
        plural: '# jours'
      },
      31540000000: {
        singular: 'un an',
        plural: '# ans'
      }
    };

    var timespans = [1000, 60000, 3600000, 86400000, 31540000000];
    var parsedTime = Date.parse(time.replace(/\-00:?00$/, ''));

    if (parsedTime && Date.now) {
      var timeAgo = parsedTime - Date.now();
      var diff = Math.abs(timeAgo);

      var postfix = lang.postfixes[(timeAgo < 0) ? '<' : '>'];
      var timespan = timespans[0];
      var timeAgo = parsedTime - Date.now();

      for (var i = 1; i < timespans.length; i++) {
        if (diff > timespans[i]) {
          timespan = timespans[i];
        }
      }

      var n = Math.round(diff / timespan);

      return lang[timespan][n > 1 ? 'plural' : 'singular']
        .replace('#', n) + postfix;
    }
  }
  document.addEventListener('DOMContentLoaded', function () {
    var elements = document.getElementsByTagName('time');
    for (var i = 0; i < elements.length; i++) {
      var time = elements[i];
      // The date should be either in the datetime attribute
      // or in the text contents if no datetime attribute
      var date = time.getAttribute('datetime') || time.textContent;
      var lang = null;
      var dateInWords = timeToWords(date, lang);
      if (dateInWords) {
        time.textContent = dateInWords;
      }
    }
  });

  /*----------------------------------------------------------------*/
  function navbarFixed() {
    if ($(".header_area").length) {
      $(window).scroll(function () {
        var scroll = $(window).scrollTop();
        if (scroll >= nav_offset_top) {

          $(".header_area").addClass("navbar_fixed");
        } else {
          $(".header_area").removeClass("navbar_fixed");
        }
      });
    }
  }
  navbarFixed();

  // Search Toggle
  $("#search_input_box").hide();
  $("#search").on("click", function () {
    $("#search_input_box").slideToggle("slow");
    $("#search_input").focus();
  });
  $("#close_search").on("click", function () {
    $("#search_input_box").slideUp("slow");
  });

  /*----------------------------------------------------*/
  /*  Course Slider
    /*----------------------------------------------------*/
  function active_course() {
    if ($(".active_course").length) {
      $(".active_course").owlCarousel({
        loop: true,
        margin: 20,
        items: 3,
        nav: true,
        autoplay: 2500,
        smartSpeed: 1500,
        dots: false,
        responsiveClass: true,
        thumbs: true,
        thumbsPrerendered: true,
        navText: ["<img src='img/prev.png'>", "<img src='img/next.png'>"],
        responsive: {
          0: {
            items: 1,
            margin: 0
          },
          991: {
            items: 2,
            margin: 30
          },
          1200: {
            items: 3,
            margin: 30
          }
        }
      });
    }
  }
  active_course();

  /*----------------------------------------------------*/
  /*  Event Slider
    /*----------------------------------------------------*/
  function active_event() {
    if ($(".active_event").length) {
      $(".active_event").owlCarousel({
        loop: true,
        margin: 30,
        items: 2,
        nav: false,
        autoplay: 2500,
        smartSpeed: 1500,
        dots: false,
        responsiveClass: true,
        thumbs: true,
        thumbsPrerendered: true
      });
    }
  }
  active_event();

  /*----------------------------------------------------*/
  /*  Testimonials Slider
    /*----------------------------------------------------*/
  function testimonials_slider() {
    if ($(".testi_slider").length) {
      $(".testi_slider").owlCarousel({
        loop: true,
        margin: 30,
        items: 2,
        autoplay: 2500,
        smartSpeed: 2500,
        dots: true,
        responsiveClass: true,
        responsive: {
          0: {
            items: 1
          },
          991: {
            items: 2
          }
        }
      });
    }
  }
  testimonials_slider();

  /*----------------------------------------------------*/
  /*  MailChimp Slider
    /*----------------------------------------------------*/
  function mailChimp() {
    $("#mc_embed_signup")
      .find("form")
      .ajaxChimp();
  }
  mailChimp();

  $("select").niceSelect();

  /*----------------------------------------------------*/
  /*  Google map js
    /*----------------------------------------------------*/

  if ($("#mapBox").length) {
    var $lat = $("#mapBox").data("lat");
    var $lon = $("#mapBox").data("lon");
    var $zoom = $("#mapBox").data("zoom");
    var $marker = $("#mapBox").data("marker");
    var $info = $("#mapBox").data("info");
    var $markerLat = $("#mapBox").data("mlat");
    var $markerLon = $("#mapBox").data("mlon");
    var map = new GMaps({
      el: "#mapBox",
      lat: $lat,
      lng: $lon,
      scrollwheel: false,
      scaleControl: true,
      streetViewControl: false,
      panControl: true,
      disableDoubleClickZoom: true,
      mapTypeControl: false,
      zoom: $zoom,
      styles: [{
          featureType: "water",
          elementType: "geometry.fill",
          stylers: [{
            color: "#dcdfe6"
          }]
        },
        {
          featureType: "transit",
          stylers: [{
              color: "#808080"
            },
            {
              visibility: "off"
            }
          ]
        },
        {
          featureType: "road.highway",
          elementType: "geometry.stroke",
          stylers: [{
              visibility: "on"
            },
            {
              color: "#dcdfe6"
            }
          ]
        },
        {
          featureType: "road.highway",
          elementType: "geometry.fill",
          stylers: [{
            color: "#ffffff"
          }]
        },
        {
          featureType: "road.local",
          elementType: "geometry.fill",
          stylers: [{
              visibility: "on"
            },
            {
              color: "#ffffff"
            },
            {
              weight: 1.8
            }
          ]
        },
        {
          featureType: "road.local",
          elementType: "geometry.stroke",
          stylers: [{
            color: "#d7d7d7"
          }]
        },
        {
          featureType: "poi",
          elementType: "geometry.fill",
          stylers: [{
              visibility: "on"
            },
            {
              color: "#ebebeb"
            }
          ]
        },
        {
          featureType: "administrative",
          elementType: "geometry",
          stylers: [{
            color: "#a7a7a7"
          }]
        },
        {
          featureType: "road.arterial",
          elementType: "geometry.fill",
          stylers: [{
            color: "#ffffff"
          }]
        },
        {
          featureType: "road.arterial",
          elementType: "geometry.fill",
          stylers: [{
            color: "#ffffff"
          }]
        },
        {
          featureType: "landscape",
          elementType: "geometry.fill",
          stylers: [{
              visibility: "on"
            },
            {
              color: "#efefef"
            }
          ]
        },
        {
          featureType: "road",
          elementType: "labels.text.fill",
          stylers: [{
            color: "#696969"
          }]
        },
        {
          featureType: "administrative",
          elementType: "labels.text.fill",
          stylers: [{
              visibility: "on"
            },
            {
              color: "#737373"
            }
          ]
        },
        {
          featureType: "poi",
          elementType: "labels.icon",
          stylers: [{
            visibility: "off"
          }]
        },
        {
          featureType: "poi",
          elementType: "labels",
          stylers: [{
            visibility: "off"
          }]
        },
        {
          featureType: "road.arterial",
          elementType: "geometry.stroke",
          stylers: [{
            color: "#d6d6d6"
          }]
        },
        {
          featureType: "road",
          elementType: "labels.icon",
          stylers: [{
            visibility: "off"
          }]
        },
        {},
        {
          featureType: "poi",
          elementType: "geometry.fill",
          stylers: [{
            color: "#dadada"
          }]
        }
      ]
    });
  }
})(jQuery);



function detectmob() {
  if (navigator.userAgent.match(/Android/i) ||
    navigator.userAgent.match(/webOS/i) ||
    navigator.userAgent.match(/iPhone/i) ||
    navigator.userAgent.match(/iPad/i) ||
    navigator.userAgent.match(/iPod/i) ||
    navigator.userAgent.match(/BlackBerry/i) ||
    navigator.userAgent.match(/Windows Phone/i)
  ) {
    document.getElementById("imageid").src = "img/logo31.png";
  }
}
detectmob();