$(window).on("load", function () {

    $(".loader-backdrop").fadeOut();

    if ($(".modal").length) {
        $(".modal").each(function () {
            var currentModal = $(this);

            if ((currentModal.attr("data-open-onload")) == "true") {    // Checks Each Modal
                setTimeout(function () {
                    currentModal.modal();
                }, currentModal.attr("data-open-delay"));
            }

        });
    }
});


/*************************************/
/*********** Function Calls **********/
/*************************************/

$(document).ready(function () {

    if ($(".parallax").length && $(window).width() > 960) {
        backgroundParallax();			// Call to  background parallax
    }

    if ($(".logo-slider").length) {
        logoSlider();					// Call to Logo Slider 
    }

    if ($(".news-slider").length) {
        $(".news-slider").each(function () {
            newsSlider(this);			// Call to News slider
        });
    }

    if ($(".testimonial-slider").length) {
        testimonialSlider();			// Call to Testimonial Slider
    }

    if ($(".department-slider").length) {
        departmentSlider();				// Call to Mini Department Slider
    }

    if ($(".anything-slider").length) {
        anythingSlider();				// Call to Anything slider
    }

    if ($(".circle").length) {
        $(".circle").each(function () {
            $(this).appear(function () {        // Call function circleProgressBar() only when the Element is in viewport
                circleProgressBar(this);       // Call to Progress Bar
            });
        });
    }

//    if ($("select").length) {
//        bootstrapSelect();				// Call to Bootstrap Select Dropdown
//    }

//    if ($(".date-select").length) {
//        dateSelect();					// Call to Date Picker
//    }

    if ($(".widget-testimonial").length) {
        testimonialWidgetSlider();		// Call to Testimonial Widget
    }

    if ($("#fixed-appointment").length) {
        fixedAppointment();				// Call to Fixed Appointment Form
    }

    if ($(".timer").length) {
        $(".timer").each(function () {
            countdownTimer(this);        // Call to Event Countdown Timer (Coming Soon Page)
        });
    }

    if ($(".fact-count").length) {
        $(".fact-count").each(function () {
            $(this).appear(function () {        // Call to function countTo() only when the Element is in viewport
                countToNumber(this);
            });
        });
    }

    if ($("#back").length) {              // Back To Top Icon
        backToTop();
    }

    if ($("#slider").length) {
        sliderRevolution();				// Call to Slider Revolution with Image
    }

    if ($("#slider-video").length) {
        sliderRevolutionVideo();		// Call to Slider Revolution with Video Background
    }

    if ($(".youtube").length) {
        $(".youtube").each(function () {
            youtubeVideo(this);         // Style each video found on page
        });
    }

    if ($(".gmap").length) {

        $(".gmap").each(function () {

            var lat = $(this).attr("data-lat");            // Latitude of the place to be marked

            var long = $(this).attr("data-long");          // Longitude of the place to be marked

            var infoWin = $(this).attr("data-info-win");   // Content to be shown in Info Window on Marker

            googleMapStyle(lat, long, infoWin, this);    // Call to Google Map Styler  
        });
    }

    if ($("a[data-gal^='prettyPhoto']").length) {
        callPrettyPhoto();                              // Pretty Photo
    }

});


/*************************************/
/******** Function Definitions *******/
/*************************************/

function backgroundParallax() {

    var $fwindow = $(window);
    var scrollTop = window.pageYOffset || document.documentElement.scrollTop;

    $fwindow.on('scroll resize', function () {
        scrollTop = window.pageYOffset || document.documentElement.scrollTop;
    });

    $('[data-type="content"]').each(function (index, e) {
        var $contentObj = $(this);
        var fgOffset = parseInt($contentObj.offset().top);
        var yPos;
        var speed = ($contentObj.data('speed') || 1);

        $fwindow.on('scroll resize', function () {
            yPos = fgOffset - scrollTop / speed;

            $contentObj.css('top', yPos);
        });
    });

    $(".parallax").each(function () {
        var $backgroundObj = $(this);
        var bgOffset = parseInt($backgroundObj.offset().top);
        var yPos;
        var coords;
        var speed = ($backgroundObj.data('speed') || 0);

        $fwindow.on('scroll resize', function () {
            yPos = -((scrollTop - bgOffset) / speed);
            coords = '50% ' + yPos + 'px';

            $backgroundObj.css({backgroundPosition: coords});
        });
    });

    $fwindow.trigger('scroll');
}

function logoSlider() {

    var logoSliderVar = $('.logo-slider .slider-items');

    $('.logo-slider .left').click(function () {
        logoSliderVar.trigger('prev.owl.carousel');
    })

    $('.logo-slider .right').click(function () {
        logoSliderVar.trigger('next.owl.carousel');
    })

    logoSliderVar.owlCarousel({
        items: "1",
        loop: "true",
        autoplay: "true",
        autoplayTimeout: "2000",
        autoplaySpeed: "1500",
        smartSpeed: "1500",
        margin: 30,
        center: "true",
        responsive: {
            468: {
                items: 3
            },
            1024: {
                items: 5
            }
        }
    });
}

function newsSlider(currentNews) {

    var newsSliderVar = $('.slider-items', currentNews);

    $('.left', currentNews).click(function () {
        newsSliderVar.trigger('prev.owl.carousel');
    })

    $('.right', currentNews).click(function () {
        newsSliderVar.trigger('next.owl.carousel');
    })

    newsSliderVar.owlCarousel({
        items: "1",
        loop: "true",
        autoplay: "true",
        autoplayTimeout: "2000",
        autoplaySpeed: "1500",
        smartSpeed: "1500",
        margin: 30,
        center: "true"
    });
}

function testimonialSlider() {

    var testimonialSliderVar = $('.testimonial-slider .slider-items');

    $('.testimonial-slider .left').click(function () {
        testimonialSliderVar.trigger('prev.owl.carousel');
    })

    $('.testimonial-slider .right').click(function () {
        testimonialSliderVar.trigger('next.owl.carousel');
    })

    testimonialSliderVar.owlCarousel({
        items: "1",
        loop: "true",
        autoplay: "true",
        autoplayTimeout: "3000",
        autoplaySpeed: "1500",
        smartSpeed: "1500",
        margin: 30,
        center: "true"
    });
}

function departmentSlider() {

    var departmentSliderVar = $('.department-slider .slider-items');

    $('.department-slider .left').click(function () {
        departmentSliderVar.trigger('prev.owl.carousel');
    })

    $('.department-slider .right').click(function () {
        departmentSliderVar.trigger('next.owl.carousel');
    })

    departmentSliderVar.owlCarousel({
        items: 1,
        loop: "true",
        autoplay: "true",
        autoplayHoverPause: "true",
        autoplayTimeout: "1000",
        autoplaySpeed: "1500",
        smartSpeed: "1500",
        responsive: {
            768: {
                items: 3
            },
            1024: {
                items: 6
            }
        }
    });
}

function anythingSlider() {

    var anythingSliderVar = $('.anything-slider .slider-items');

    $('.anything-slider .left').click(function () {
        anythingSliderVar.trigger('prev.owl.carousel');
    })

    $('.anything-slider .right').click(function () {
        anythingSliderVar.trigger('next.owl.carousel');
    })

    anythingSliderVar.owlCarousel({
        items: 1,
        margin: 30,
        loop: "true",
        autoplay: "true",
        autoplayTimeout: "3000",
        autoplaySpeed: "1500",
        smartSpeed: "1500"
    });
}

function circleProgressBar(thisProgressBar) {
    $(thisProgressBar).circleProgress({
        fill: {color: "#1696e7"},
        thickness: "9",
        lineCap: "round",
        size: "150",
        emptyFill: "rgba(0, 0, 0, 0.07)",
        animation: {duration: 1750}
    })
            .on('circle-animation-progress', function (event, progress, stepValue) {
                $(this).find('strong').html(parseInt(100 * stepValue) + '<i>%</i>');
            });
}

//function bootstrapSelect() {
//    $('select').selectpicker();
//}

//function dateSelect() {
//    $('.date-select').datepicker({
//        showOn: "button",
//        buttonImage: "/default/images/datepicker/calendar.png"
//    }
//    );
//}

function testimonialWidgetSlider() {

    var widgetTestimonialSliderVar = $('.widget-testimonial .slider-items');

    $('.widget-testimonial .left').click(function () {
        widgetTestimonialSliderVar.trigger('prev.owl.carousel');
    })

    $('.widget-testimonial .right').click(function () {
        widgetTestimonialSliderVar.trigger('next.owl.carousel');
    })

    widgetTestimonialSliderVar.owlCarousel({
        items: "1",
        loop: "true",
        autoplay: "true",
        autoplayTimeout: "3000",
        autoplaySpeed: "1500",
        smartSpeed: "1500",
        margin: 30,
        center: "true"
    });
}

function fixedAppointment() {
    $("#open-form").click(function () {
        $("#fixed-appointment .form-body").toggle("linear");
    });
}

function countdownTimer(thisTimer)
{
    var date = $(thisTimer).attr("data-date");
    $(thisTimer).countdown(date, function (event) {
        $(this).find(".days").html(event.strftime("%D"));              // Days Left
        $(this).find(".hours").html(event.strftime("%H"));             // Hours Left
        $(this).find(".minutes").html(event.strftime("%M"));           // Minutes Left
        $(this).find(".seconds").html(event.strftime("%S"));           // Seconds Left
    });
}

function countToNumber(thisCounter) {
    $(thisCounter).countTo();
}

function backToTop()
{
    var offset = 250;                          // Offset after which Back To Top button will be visible 
    var duration = 1000;                       // Time duration in which the page scrolls back up.

    jQuery(window).scroll(function () {
        if (jQuery(this).scrollTop() > offset) {
            $('#back').fadeIn(500);
        } else {
            $('#back').fadeOut(500);
        }
    });

    jQuery('#back').click(function (event) {
        event.preventDefault();
        jQuery('html, body').animate({scrollTop: 0}, duration);
        return false;
    });
}

function sliderRevolution()
{
    jQuery("#slider").revolution({
        sliderType: "standard",
        sliderLayout: "fullwidth",
        delay: 5000, // Delay in Transition from one slide to another in milliseconds
        responsiveLevels: [1200, 1024, 778, 480],
        gridwidth: [1200, 1024, 778, 480],
        gridheight: [850, 768, 650, 500],
        navigation: {
            arrows: {enable: true}
        },
        lazyLoad: "on",
        parallax: {
            type: "scroll"
        }
    });
}

function sliderRevolutionVideo()
{
    jQuery("#slider-video").revolution({
        sliderType: "standard",
        sliderLayout: "fullwidth",
        navigation: {
            arrows: {enable: false}
        },
        lazyLoad: "on",
        gridwidth: 1200,
        gridheight: 700,
        parallax: {
            type: "scroll"
        }
    });
}

function youtubeVideo(currentVideo)
{
    var videoId = $(currentVideo).attr("data-video-id");                                    // Get Video ID from data attributes

    var thumbnail = 'url(https://img.youtube.com/vi/' + videoId + '/sddefault.jpg)';         // Get Thumbail image of the video

    $(currentVideo).css("background-image", thumbnail);                                     // Set thmbnail image as the background

    var videoUrl = "https://www.youtube.com/embed/" + videoId + "?autoplay=1&autohide=1";    // Framing Video URL from video ID

    $(currentVideo).find(".btn-play").click(function () {                                     // If play button is clicked, load Video within IFrame
        var videoFrame = $('<iframe/>', {
            'frameborder': '0',
            'src': videoUrl,
            'width': "100%",
            'height': "500px"
        });
        $("#video-container").append(videoFrame);                                            // Finally replace the div with IFrame
        $("#modal-video").modal("show");                                                     // Show modal once ready with Video
    });

    $("#modal-video").on('hidden.bs.modal', function () {                                      // Delete iFrame after Modal hides
        $(this).find("iframe").remove();
    });

}

function googleMapStyle(lat, long, infoWin, currentMap)
{
    var styles = [
        {
            "featureType": "administrative",
            "elementType": "labels.text.fill",
            "stylers": [
                {
                    "color": "#444444"
                }
            ]
        },
        {
            "featureType": "landscape",
            "elementType": "all",
            "stylers": [
                {
                    "color": "#f2f2f2"
                }
            ]
        },
        {
            "featureType": "poi",
            "elementType": "all",
            "stylers": [
                {
                    "visibility": "off"
                }
            ]
        },
        {
            "featureType": "road",
            "elementType": "all",
            "stylers": [
                {
                    "saturation": -100
                },
                {
                    "lightness": 45
                }
            ]
        },
        {
            "featureType": "road.highway",
            "elementType": "all",
            "stylers": [
                {
                    "visibility": "simplified"
                }
            ]
        },
        {
            "featureType": "road.arterial",
            "elementType": "labels.icon",
            "stylers": [
                {
                    "visibility": "off"
                }
            ]
        },
        {
            "featureType": "transit",
            "elementType": "all",
            "stylers": [
                {
                    "visibility": "off"
                }
            ]
        },
        {
            "featureType": "water",
            "elementType": "all",
            "stylers": [
                {
                    "color": "#46bcec"
                },
                {
                    "visibility": "on"
                }
            ]
        },
        {
            "featureType": "water",
            "elementType": "geometry.fill",
            "stylers": [
                {
                    "color": "#1696e7"
                },
                {
                    "saturation": "0"
                },
                {
                    "lightness": "0"
                }
            ]
        }
    ];

    var options = {
        mapTypeControlOptions: {
            mapTypeIds: ['Styled']
        },
        center: new google.maps.LatLng(lat, long),
        zoom: 14,
        disableDefaultUI: true,
        mapTypeId: 'Styled'
    };

    var div = currentMap;

    var map = new google.maps.Map(div, options);

    var styledMapType = new google.maps.StyledMapType(styles, {name: 'Styled'});

    map.mapTypes.set('Styled', styledMapType);

    var marker = new google.maps.Marker({
        map: map,
        position: new google.maps.LatLng(lat, long)             // Set Marker Position of the place
    });

    marker['infowindow'] = new google.maps.InfoWindow({
        content: infoWin                                        // Set Content of the Info Window of the Marker
    });

    new google.maps.event.addListener(marker, 'mouseover', function () {
        this['infowindow'].open(map, this);                     // On Marker Hover, show Info Window
    });
}

function callPrettyPhoto()
{
    $("a[data-gal^='prettyPhoto']").prettyPhoto({social_tools: ''});
}